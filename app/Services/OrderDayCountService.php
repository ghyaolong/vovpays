<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/17
 * Time: 13:54
 */

namespace App\Services;


use App\Repositories\OrderDayCountRepository;

class OrderDayCountService
{
    protected $orderDayCountRepository;

    public function __construct(OrderDayCountRepository $orderDayCountRepository)
    {
        $this->orderDayCountRepository = $orderDayCountRepository;
    }

    /**
     * 统计7天数据
     * @return mixed
     */
    public function getSevenDaysCount()
    {
        return $this->orderDayCountRepository->getSevenDaysCount();
    }
}