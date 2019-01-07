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
use App\Services\OrderRateService;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use App\Jobs\SendOrderAsyncNotify;
use App\Common\RespCode;

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
        // 收益计算
        $orderRateService   = app( OrderRateService::class);
        $order_amount_array = $orderRateService->orderFee($user, $Channel_payment, $user_rates, $request->amount);

        // 订单添加
        $ordersService  = app(OrdersService::class);
        $result         = $ordersService->add($user, $channel, $Channel_payment, $request, $order_amount_array, $account_array);

        return redirect('Pay/213213');
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