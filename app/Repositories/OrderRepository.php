<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/6
 * Time: 9:26
 */

namespace App\Repositories;


use App\Models\Order;
use Illuminate\Http\Request;

class OrderRepository
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    public function getList(){
        return $this->order->orderBy('id','desc')->paginate(1);

//        $data = $request->input();
//
//        $orders = $this->order->where(function ($query) use ($data) {
//            if (isset($data['pay_memberid'])) {
//                $query->where('order' . '.pay_memberid', '=', $data['pay_memberid']);
//            }
//        })
//            ->where(function ($query) use ($data) {
//                if (isset($data['pay_orderid'])) {
//                    $query->where('order' . '.orderOn', '=', $data['pay_orderid']);
//                }
//            })
//            ->where(function ($query) use ($data) {
//                if (isset($data['pay_applydate'])) {
//                    $query->where('order' . '.pay_applydate', '>=', strtotime($data['pay_applydate']));
//                }
//            })
//            ->where(function ($query) use ($data) {
//                if (isset($data['pay_applydate1'])) {
//                    $query->where('order' . '.pay_applydate', '<=', strtotime($data['pay_applydate1']));
//                }
//            })
//            ->where(function ($query) use ($data) {
//                if (isset($data['pay_bankname'])) {
//                    $query->where('order' . '.pay_bankname', '=', $data['pay_bankname']);
//                }
//            })
//            ->where(function ($query) use ($data) {
//                if (isset($data['pay_zh_tongdao'])) {
//                    $query->where('order' . '.pay_zh_tongdao', '=', $data['pay_zh_tongdao']);
//                }
//            })
//            ->where(function ($query) use ($data) {
//                if (isset($data['queryed'])) {
//                    $query->where('order' . '.queryed', '=', $data['queryed']);
//                }
//            })
//            ->orderBy('id', 'desc')
//            ->paginate(10);
    }

}