<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChannelPaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        DB::table('channel_payments')->insert([
            [
            'channel_id'   => '1',
            'paymentName'  => '支付宝',
            'paymentCode'  => 'alipay',
            'runRate'      => '0.03',
            'costRate'     => 0,
            'created_at'=> $now,
            'updated_at'=> $now
            ],
            [
                'channel_id'   => '1',
                'paymentName'  => '微信',
                'paymentCode'  => 'wechat',
                'runRate'      => '0.03',
                'costRate'     => 0,
                'created_at'=> $now,
                'updated_at'=> $now
            ],
            [
                'channel_id'   => '1',
                'paymentName'  => '转银行卡',
                'paymentCode'  => 'alipay_bank',
                'runRate'      => '0.03',
                'costRate'     => 0,
                'created_at'=> $now,
                'updated_at'=> $now
            ]
        ]);
    }
}
