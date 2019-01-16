<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 10:54
 */

namespace App\Http\Court\Controllers;


use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderDayCountService;

class IndexController extends Controller
{
    protected $ordersService;
    protected $userService;
    protected $orderDayCountService;

    /**
     * IndexController constructor.
     * @param OrdersService $ordersService
     * @param OrderDayCountService $orderDayCountService
     */
    public function __construct( OrdersService $ordersService,OrderDayCountService $orderDayCountService)
    {
        $this->ordersService  = $ordersService;
        $this->orderDayCountService = $orderDayCountService;
    }


    /**
     * 后台主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $query = $request->input();
        $agentId=Auth::user()->id;
        //订单金额
        $orderInfoSum = $this->ordersService->orderInfoSum($query);
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getAgentSevenDaysCount($agentId),'tm'));

        return view('Agent.Index.index',compact('orderInfoSum','order_day_count'));
    }


    /**
     * 商户费率
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rate()
    {
        return view('Agent.Index.memberRate');
    }

}