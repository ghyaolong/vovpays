<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Support\Facades\Redis;

class GetWechatQrcode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wechatQrcode:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get phone status';

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
        Redis::select(1);
        $queue = 'qrImgback';
        $connection = AMQPStreamConnection::create_connection([
            ['host' => env('MQ_Local_HOST'), 'port' => env('MQ_PORT'), 'user' => env('MQ_USER'), 'password' => env('MQ_PWD'), 'vhost' => env('MQ_VHOST')],
        ],
            ['read_write_timeout'=>60,'heartbeat'=>30]);
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $callback = function ($msg) {
            echo $msg->body."\n";
            $this->phoneStatusCheck($msg->body);
        };
        $channel->basic_consume($queue, '', false, true, false, false, $callback);
        while ($channel->callbacks) {
            $channel->wait();
        }
    }

    protected function phoneStatusCheck($json_str)
    {
        if(stripos($json_str,'alipay.fund.stdtrustee.order.create.pay')){

            $param = explode("||",$json_str);
            Redis::set($param[1]."thb","'".$param[0]."'");
            Redis::expire($param[1]."thb",180);
        }else {
            $data = json_decode($json_str, true);
            Redis::set($data['mark']."order",$json_str);
            Redis::expire($data['mark']."order",180);
        }
    }
}
