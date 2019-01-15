<?php

namespace App\Http\Admin\Controllers;

use App\Services\OrderDayCountService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    protected $orderDayCountService;
    public function __construct(OrderDayCountService $orderDayCountService)
    {
        $this->orderDayCountService = $orderDayCountService;
        Cache::rememberForever('systems', function () {
            return DB::table('systems')->select('name','value')->get();
        });

    }

    public function index()
    {
        $title = '主页';
        $description = '今日统计数据有10分钟延迟,想看实时的请使用订单查询';
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getSevenDaysCount(),'tm'));
        return view('Admin.Index.index', compact('title', 'description','order_day_count'));
    }

}
