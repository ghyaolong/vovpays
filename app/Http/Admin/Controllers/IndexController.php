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


        if(!Cache::has('systems')){
            Cache::rememberForever('systems', function () {
                $system = DB::table('systems')->select('name','value')->get();
                $system_array = [];
                foreach ($system as $k=>$v){
                    $system_array[$v->name] = $v;
                }
                return $system_array;
            });
        }
    }

    public function index()
    {

        $title = '主页';
        $description = '今日统计数据有10分钟延迟,想看实时的请使用订单查询';
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getSevenDaysCount(),'tm'));
        return view('Admin.Index.index', compact('title', 'description','order_day_count'));
    }

}
