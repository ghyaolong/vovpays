<?php

namespace App\Http\Admin\Controllers;

use App\Services\OrderDayCountService;

class IndexController extends Controller
{
    protected $orderDayCountService;
    public function __construct(OrderDayCountService $orderDayCountService)
    {
        $this->orderDayCountService = $orderDayCountService;
    }

    public function index()
    {
        $title = '主页';
        $description = '统计有10分钟延迟';
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getSevenDaysCount(),'tm'));
        return view('Admin.Index.index', compact('title', 'description','order_day_count'));
    }

}
