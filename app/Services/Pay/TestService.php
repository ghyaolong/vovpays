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
use App\Services\AccountPhoneService;
use App\Repositories\AccountPhoneRepository;
use App\Services\OrderRateService;
use Illuminate\Http\Request;
use App\Models\Account_phone;
use App\Jobs\SendOrderAsyncNotify;
use App\Common\RespCode;

class TestService implements PayInterface
{

    public function pay(User $user, Channel $channel, Channel_payment $Channel_payment, User_rates $user_rates, Request $request )
    {
        $chooseAccountService = new ChooseAccountService(1, $request->price , new AccountPhoneService(  new AccountPhoneRepository( new Account_phone() ) ));
        $account_array = $chooseAccountService->getAccount('alipay',1);

        if(!$account_array)
        {
            return json_encode(RespCode::APP_ERROR);
        }

        $orderRateService = new OrderRateService();
        $orderRateService->orderFee($user, $Channel_payment, $user_rates, $request->price);
        return redirect('pay/213213');
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