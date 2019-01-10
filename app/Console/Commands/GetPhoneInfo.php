<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Illuminate\Support\Facades\Redis;

class GetPhoneInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phone:get';

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
     * @throws \ErrorException
     */
    public function handle()
    {
        Redis::select(1);
        $queue = 'appStatus';
        $connection = new AMQPStreamConnection(env('MQ_Local_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PWD'),env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, false, false, false);
        $callback = function ($msg) {
            echo $msg->body."\n";
            $this->phoneStatusCheck($msg->body);
        };
        $channel->basic_consume($queue, '', false, true, false, false, $callback);
        while (count($channel->callbacks)) {
            $channel->wait();
        }
    }

    protected function phoneStatusCheck($json_str)
    {
        $data = json_decode($json_str, true);
        $key  = $data['phoneid'].$data['type'];
        if(Redis::exists($key))
        {
            Redis::hset($key, 'status', $data['status']);
            Redis::hset($key, 'update', date('Y-m-d H:i:s', time()));
            Redis::hset($key, 'comment', $data['comment']);
        }else{
            $params = array(
                'phoneid' => $data['phoneid'],
                'amount'  => 0,
                'weight'  => 1,
                'update'  => date('Y-m-d H:i:s', time()),
                'comment' => $data['comment'],
                'type'    => $data['type'],
                'account' => $data['account'],
                'status'  => $data['status'],
            );
            Redis::hmset($key,$params);
        }
    }
}