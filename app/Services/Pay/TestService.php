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

class TestService extends PayServiceInterface
{
    public function pay(User $user, Channel $channel, Channel_payment $Channel_payment, User_rates $user_rates )
    {
        dd($user);
    }

    public function queryOrder()
    {
        // TODO: Implement queryOrder() method.
    }

    public function notifyCallback()
    {
        // TODO: Implement notifyCallback() method.
    }

    public function successCallback()
    {
        // TODO: Implement successCallback() method.
    }
}