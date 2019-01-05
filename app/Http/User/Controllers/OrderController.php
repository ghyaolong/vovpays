<?php

namespace App\Http\User\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $ordersService;
    protected $channelService;
    protected $channelPaymentsService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrdersService $ordersService, ChannelService $channelService, ChannelPaymentsService $channelPaymentsService)
    {
        $this->ordersService = $ordersService;
        $this->channelService = $channelService;
        $this->channelPaymentsService = $channelPaymentsService;
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = $request->input();
        $userId = Auth::user()->id;

        if (count($data)) {
            $data['user_id'] = $userId;
            $orders = $this->ordersService->searchPage($data, 10);
        } else {
            $orders = $this->ordersService->getAllPage($userId,10);
        }
        //订单金额
        $amountSum = $this->ordersService->amountSum($userId);
        //手续费
        $orderRateSum = $this->ordersService->orderRateSum($userId);
        //订单数
        $orderSum = $this->ordersService->orderSum($userId);

        $chanel_list = $this->channelService->getAll();
        $payments_list = $this->channelPaymentsService->getAll();

        return view('User.Order.order', compact('orders', 'data', 'chanel_list', 'payments_list', 'amountSum', 'orderRateSum', 'orderSum'));
    }

    public function recharge()
    {
        return view('User.Recharge.recharge');
    }

    public function invoice()
    {
        return view('User.invoice');
    }
}
