<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;

use App\Models\Order_day_count;
use Illuminate\Support\Facades\DB;

class OrderDayCountRepository
{

    protected $order_day_count;

    /**
     * @param Order_day_count $order_day_count
     */
    public function __construct(Order_day_count $order_day_count)
    {
        $this->order_day_count = $order_day_count;
    }

    /**
     * 统计7天数据
     * @return mixed
     */
    public function getSevenDaysCount()
    {
        return DB::select("select date(`updated_at`) as tm, sys_amount,sys_income, sys_order_suc_count FROM pay_order_day_counts where date(`updated_at`) <= date(NOW()) GROUP BY date(`updated_at`)");
    }

}