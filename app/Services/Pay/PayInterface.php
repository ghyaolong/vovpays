<?php

namespace App\Services\Pay;

use App\Models\Channel;
use App\Models\Channel_payment;
use App\Models\User;
use App\Models\User_rates;

interface PayInterface
{

    /**
     * @param string $url
     * @param array $data
     * @return mixed
     */
    public function sendHttpPost(string $url, array $data);


    /**
     * @param string $url
     * @param array $data
     * @param array $header
     * @param string $referer
     * @return mixed
     */
    public function sendCurl(string $url, array $data = [], array $header = [], string $referer = '');

    /**
     * @param User $user
     * @param Channel $channel
     * @param Channel_payment $Channel_payment
     * @param User_rates $user_rates
     * @return mixed
     */
    public function pay(User $user, Channel $channel, Channel_payment $Channel_payment, User_rates $user_rates );

    /**
     * 同步回调
     * @return mixed
     */
    public function successCallback();

    /**
     * 异步回调
     * @return mixed
     */
    public function notifyCallback();

    /**
     * 订单查询
     * @return mixed
     */
    public function queryOrder();
}