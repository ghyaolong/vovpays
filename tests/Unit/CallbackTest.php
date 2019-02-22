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
        $info='{"phoneid": "862859038280802","type": "bankmsg","no": "95533","money": "0.01","mark": "您注册的商户收到客户付款1.00元，该款项将于次日到账。详细信息如下，商户名称：河南先迈电子科技有限公司，付款方式：微信支付，付款金额：1.00元。[建设银行]","dt": "1549078532623","sign": "9ff4a983d8f1718e9fc2021a3cca04a7"}';


        $getOrderCallback=new getOrderCallback();
        $res=$getOrderCallback->orderCallback($info);

        $this->assertTrue($res);
    }
}
