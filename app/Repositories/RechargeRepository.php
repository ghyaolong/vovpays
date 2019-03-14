<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;

use App\Models\Recharge;

class RechargeRepository
{

    protected $recharge;

    public function __construct(Recharge $recharge)
    {
        $this->recharge = $recharge;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->recharge->create($data);
    }

    /**
     * 根据平台订单查询
     * @param string $order_no
     * @return mixed
     */
    public function findOrderNo(string $order_no)
    {
        return $this->recharge->whereOrderno($order_no)->first();
    }

    public function findUserIdAndOrderNo(int $uid,string $order_no)
    {
        return $this->recharge->whereOrderno($order_no)->whereUserId($uid)->paginate(15);
    }

    public function findUserIdAll(int $uid, int $page)
    {
        return $this->recharge->whereUserId($uid)->orderBy('id','desc')->paginate($page);
    }

    public function findId(int $id)
    {
        return $this->recharge->whereId($id)->first();
    }

    public function update(int $id, array $data)
    {
        return $this->recharge->whereId($id)->update($data);
    }

    public function getAllPage($sql, $where,$page){

        return $this->recharge->whereRaw($sql,$where)->orderBy('id','desc')->paginate($page);
    }
}