<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Console\Commands\getOrderCallback;

class CallbackTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public  function testCallback()
    {
        $data='{"phoneid": "862904037079985","type": "bankmsg","no": "95588","money": "","mark": "您尾号9769卡1月30日11:34快捷支付收入(郑华支付宝转账支付宝)1元，余额44.98元。【工商银行】","dt": "2019-01-30 11:34:35","sign": "718ea3fbc3de818c6fe915c218e030a7"}';
        $Callback=new getOrderCallback();
        $res=$Callback->orderCallback($data);

        $this->assertTrue($res);
    }
}


