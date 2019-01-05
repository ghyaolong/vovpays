<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;

use App\Models\Order;

class OrdersRepository
{

    protected $order;

    /**
     * UsersRepository constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * 获取所有，分页
     * @param int $page
     * @return mixed
     */
    public function getAllPage($userId, int $page)
    {
        if (isset($userId)) {
            $sql = " user_id = ?";
            $where['user_id'] = $userId;
        } else {
            $sql = " 1=1 ";
            $where = [];
        }

        return $this->order->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }

    /**
     * 获取所有订单信息
     * @return mixed
     */
    public function getAll($userId)
    {
        if (isset($userId)) {
            $sql = " user_id = ?";
            $where['user_id'] = $userId;
        } else {
            $sql = " 1=1 ";
            $where = [];
        }

        return $this->order->whereRaw($sql, $where)->get();
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->order->create($data);
    }

    /**
     * 查询单条
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->order->whereId($id)->first();
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->order->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id)
    {
        return $this->order->whereId($id)->delete();
    }

    public function searchPage(array $data, int $page)
    {
        $sql = ' 1=1 ';
        $where = [];

        if (isset($data['merchant']) && $data['merchant']) {
            $sql .= 'and merchant = ?';
            $where['merchant'] = $data['merchant'];
        }

        if (isset($data['orderNo']) && $data['orderNo']) {
            $sql .= ' and orderNo = ?';
            $where['orderNo'] = $data['orderNo'];
        }

        if (isset($data['underOrderNo']) && $data['underOrderNo']) {
            $sql .= ' and underOrderNo = ?';
            $where['underOrderNo'] = $data['underOrderNo'];
        }

        if (isset($data['status']) && $data['status'] != '-1') {
            $sql .= ' and status = ?';
            $where['status'] = $data['status'];
        }

        if (isset($data['channel_id']) && $data['channel_id'] != '-1') {
            $sql .= ' and channel_id = ?';
            $where['channel_id'] = $data['channel_id'];
        }

        if (isset($data['user_id']) && $data['user_id'] != '-1') {
            $sql .= ' and user_id = ?';
            $where['user_id'] = $data['user_id'];
        }

        if (isset($data['channel_payment_id']) && $data['channel_payment_id'] != '-1') {
            $sql .= ' and channel_payment_id = ?';
            $where['channel_payment_id'] = $data['channel_payment_id'];
        }

        if (isset($data['orderTime']) && $data['orderTime']) {
            $time = explode(" - ", $data['orderTime']);
            $sql .= ' and created_at >= ?';
            $where['created_at'] = $time[0];
        }

        if (isset($data['orderTime']) && $data['orderTime']) {
            $time = explode(" - ", $data['orderTime']);
            $sql .= ' and updated_at <= ?';
            $where['updated_at'] = $time[1];
        }


        return $this->order->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }
}