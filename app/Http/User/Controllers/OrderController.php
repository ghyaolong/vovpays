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
    public function index(Request $request)
    {
        $query = $request->input();

        if (count($query)) {
            $query['user_id'] = Auth::user()->id;
            $orders = $this->ordersService->searchPage($query, 10);
            //订单金额
            $orderInfoSum = $this->ordersService->orderInfoSum($query);
        } else {
            $data['user_id'] = Auth::user()->id;
            $orders = $this->ordersService->getAllPage($data,10);
            //订单金额
            $orderInfoSum = $this->ordersService->orderInfoSum($query);
        }

        $chanel_list = $this->channelService->getAll();
        $payments_list = $this->channelPaymentsService->getAll();

        return view('User.Order.order', compact('orders', 'query', 'chanel_list', 'payments_list', 'orderInfoSum'));
    }

    /**
     * 详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $rule = $this->ordersService->findId($id);
        return ajaxSuccess('获取成功', $rule);
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
