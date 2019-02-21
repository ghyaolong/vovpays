<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\getOrderCallback;

class CallbackTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCallback()
    {
        $info='{"phoneid": "862859038280802","type": "wechat","no": "heQnhF8coddhpLS3ADo4h3OvwG0cPv6OPkPgX06lgJi1IBh9baqqj6nqFgE69TnuAlDCQMXF2Rfj7vMUIUkBzA","money": "0.01","mark": "今日第3笔收款，共计￥0.03","dt": "1549078532623","sign": "9ff4a983d8f1718e9fc2021a3cca04a7"}';


        $getOrderCallback=new getOrderCallback();
        $res=$getOrderCallback->orderCallback($info);
        $this->assertTrue($res);
    }
}
