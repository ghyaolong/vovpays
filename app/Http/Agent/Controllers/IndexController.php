<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 10:54
 */

namespace App\Http\Agent\Controllers;


use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderDayCountService;
use App\Services\StatisticalService;
use App\Services\SystemsService;

class IndexController extends Controller
{
    protected $ordersService;
    protected $userService;
    protected $orderDayCountService;
    protected $statisticalService;
    protected $systemsService;

    /**
     * IndexController constructor.
     * @param OrdersService $ordersService
     * @param OrderDayCountService $orderDayCountService
     */
    public function __construct(SystemsService $systemsService, OrdersService $ordersService, OrderDayCountService $orderDayCountService, StatisticalService $statisticalService)
    {
        $this->ordersService = $ordersService;
        $this->orderDayCountService = $orderDayCountService;
        $this->statisticalService = $statisticalService;
        $this->systemsService = $systemsService;
    }


    /**
     * 后台主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $query = $request->input();
        $agentId = Auth::user()->id;
        //订单金额
        $orderInfoSum = $this->ordersService->orderInfoSum($query);

        //账户信息
        $agentAccount = $this->statisticalService->findUserId($agentId);

        //当日统计
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getAgentSevenDaysCount($agentId), 'tm'));
        //是否代理商挂号
        $type = $this->systemsService->findId(1);
        $type = json_decode($type, true);
        $type = $type['value'];
        return view('Agent.Index.index', compact('orderInfoSum', 'order_day_count', 'agentAccount', 'type'));
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