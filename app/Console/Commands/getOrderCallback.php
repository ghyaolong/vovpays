<?php

namespace App\Console\Commands;

use App\Services\OrdersService;
use App\Services\StatisticalService;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Jobs\SendOrderAsyncNotify;

class getOrderCallback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:callback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get exemption order callback';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $queue = 'orderback';
        $connection = AMQPStreamConnection::create_connection([
            ['host' => env('MQ_Local_HOST'), 'port' => env('MQ_PORT'), 'user' => env('MQ_USER'), 'password' => env('MQ_PWD'), 'vhost' => env('MQ_VHOST')],
        ],
            ['read_write_timeout'=>60,'heartbeat'=>30]);
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $callback = function ($msg) {

            echo $msg->body."\n";
            echo $this->orderCallback($msg->body)."\n";
        };
        $channel->basic_consume($queue, '', false, true, false, false, $callback);
        while ($channel->callbacks) {
            $channel->wait();
        }
    }


    /**
     * @param $json_str
     * @return int
     */
    protected function orderCallback($json_str)
    {
        Redis::select(1);
        Log::info('orderCallback:',[$json_str]);
        $data = json_decode($json_str, true);
        if(!$data) return;
        if($data['type'] == 'alipay_bank')
        {
            $key = $data['phoneid']."_".$data['type'].'_'.$data['money'];
            if(Redis::exists($key))
            {
                $order_id = Redis::get($key);
            }else{
                return 1;
            }
        }else{
            $order_id = $data['mark'];
        }

        $ordersService = app(OrdersService::class);
        $order = $ordersService->findOrderNo($order_id);
        if(!$order) return 2;
        if($order->status != 0 ) return 3;
        if(floatval($order->amount) != floatval($data['money'])) return 4;

        $userService = app(UserService::class);
        $user = $userService->findId($order->user_id);
        if(!$user) return 5;

        if(!$this->checkSign($data,$user->apiKey)) Log::info('orderCallback_sign_error:',[$json_str]);

        $params = array(
            'status'    => 1,
            'onOrderNo' => $data['no']
        );
        $result = $ordersService->update($order->id,$params);
        if(!$result) return 6;
        // 商户收益增加
        $statisticalService = app(StatisticalService::class);
        $statisticalService->updateUseridHandlingFeeBalanceIncrement($user->id,$order->amount);
        // 代理收益增加
        if($order->agentAmount > 0)
        {
            $statisticalService->updateUseridHandlingFeeBalanceIncrement($order->agent_id,$order->agentAmount);
        }
        // 更新订单状态
        if(Redis::exists($order->orderNo)){
            Redis::hmset($order->orderNo,['status'=>1]);
            Redis::expire($order->orderNo,180);
        }

        // 更新账号交易额
        if($data['type'] == 'alipay_bank'){
            if(Redis::exists($data['phoneid'].'alipay'))
            {
                $pahone_info = Redis::hGetAll($data['phoneid'].'alipay');
                $pahone_info['bankamount'] = bcadd($pahone_info['bankamount'], $order->amount ,2);
                Redis::hmset($data['phoneid'].'alipay',$pahone_info);
            }
            if(isset($key))
            {
                Redis::del($key);
            }

        }else{
            if( Redis::exists($data['phoneid'].$data['type']) )
            {
                $pahone_info = Redis::hGetAll($data['phoneid'].$data['type']);
                $pahone_info['amount'] = bcadd($pahone_info['amount'], $order->amount ,2);
                Redis::hmset( $data['phoneid'].$data['type'], $pahone_info);
            }
        }
        Redis::select(0);
        SendOrderAsyncNotify::dispatch($order)->onQueue('orderNotify');
    }

    /**
     * @param $data
     * @param $key
     * @return bool
     */
    protected function checkSign($data,$key)
    {
        $sign = md5($data['dt'].$data['mark'].$data['money'].$data['no'].$data['type'].$key);
        if($sign == $data['sign'])
        {
            return true;
        }else{
            return false;
        }
    }
}
