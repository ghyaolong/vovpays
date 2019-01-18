<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 10:54
 */

namespace App\Http\Court\Controllers;

use App\Services\OrdersService;
use App\Services\OrderDayCountService;
use Illuminate\Support\Facades\Auth;


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
    public function show()
    {
        $query['user_id'] = Auth::user()->id;
        $query['today']=date('Y-m-d',time());
        $query['day']=date('Y-m-d',time()+24*60*60);
        $orderInfoSum = $this->ordersService->orderInfoSum($query);
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getOrderSevenDaysCount($query),'tm'));

        return view('Court.Index.index',compact('orderInfoSum','order_day_count'));
    }


    /**
     * 商户费率
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rate()
    {
        return view('Court.Index.memberRate');
    }

}