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
use App\Services\ChooseAccountService;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use App\Jobs\SendOrderAsyncNotify;
use App\Common\RespCode;
use Illuminate\Support\Facades\Redis;

class TestService implements PayInterface
{
    public function pay(User $user, Channel $channel, Channel_payment $Channel_payment, User_rates $user_rates, Request $request )
    {
        // 随机选号
        $ChooseAccountService = app(ChooseAccountService::class);
        $account_array        = $ChooseAccountService->getAccount($request->pay_code, 1, $request->amount);
        if(!$account_array)
        {
            return json_encode(RespCode::APP_ERROR);
        }

        // 订单添加
        $ordersService  = app(OrdersService::class);
        $result         = $ordersService->add($user, $channel, $Channel_payment, $request, $user_rates, $account_array);
        if(!$result)
        {
            return json_encode(RespCode::FAILED);
        }
        $data = [
            'type'    => $request->pay_code,
            'username'=> $account_array['username'],
            'money'   => sprintf('%0.2f',$result->amount),
            'orderNo' => $result->orderNo,
            'qrurl'  => 'alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "'.$account_array['userId'].'","a": "'.$result->amount.'","m": "'.$result->orderNo.'"}',
            'payurl'   => 'alipays://platformapi/startapp?appId=20000067&url='. 'http://'.$_SERVER['HTTP_HOST'].'/pay/h5pay/'. $result->orderNo,
        ];

        Redis::select(2);
        $order_date = array(
            'amount'  => $result->amount,
            'meme'    => $result->orderNo,
            'userID'  => $account_array['userId'],
            'status'  => 0,
        );

        Redis::hmset($result->orderNo,$order_date);
        Redis::expire($result->orderNo,180);
        return view('Pay.pay',compact('data'));
    }

    public function queryOrder()
    {
        // TODO: Implement queryOrder() method.
    }

    public function notifyCallback()
    {
        // TODO: Implement notifyCallback() method.

        // 订单异步通知
        $ordersService = app(OrdersService::class);
        $orders = $ordersService->findId(6,'collection');
        SendOrderAsyncNotify::dispatch($orders)->onQueue('orderNotify');
    }

    public function successCallback()
    {
        // TODO: Implement successCallback() method.
    }
}