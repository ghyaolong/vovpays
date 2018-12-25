<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/12/20
 * Time: 13:35
 */
namespace App\Services\Pay;

use App\Models\Channel;
use App\Models\Channel_payment;
use App\Models\User;
use App\Models\User_rates;
use Illuminate\Http\Request;
use App\Jobs\SendOrderAsyncNotify;

class TestService implements PayInterface
{
    public function pay(User $user, Channel $channel, Channel_payment $Channel_payment, User_rates $user_rates, Request $request )
    {

    }

    public function queryOrder()
    {
        // TODO: Implement queryOrder() method.
    }

    public function notifyCallback()
    {
        // TODO: Implement notifyCallback() method.

        // 订单异步通知
        SendOrderAsyncNotify::dispatch(11)->onQueue('orderNotify');
    }

    public function successCallback()
    {
        // TODO: Implement successCallback() method.
    }
}