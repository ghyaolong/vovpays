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
    public function __construct( Order $order)
    {
        $this->order = $order;
    }

    /**
     * 获取所有，分页
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        return $this->order->orderBy('id', 'desc')->paginate($page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data){
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
    public function update(int $id, array $data){
        return $this->order->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id){
        return $this->order->whereId($id)->delete();
    }

    public function searchPage(array $data, int $page)
    {
        $sql   = ' 1=1 ';
        $where = [];

        if( isset($data['merchant']) && $data['merchant'])
        {
            $sql .= 'and merchant = ?';
            $where['merchant'] = $data['merchant'];
        }

        if( isset($data['username']) && $data['username'])
        {
            $sql .= ' and username = ?';
            $where['username'] = $data['username'];
        }

        if( isset($data['groupType']) && $data['groupType'] != '-1')
        {
            $sql .= ' and group_type = ?';
            $where['group_type'] = $data['groupType'];
        }

        if( isset($data['status']) && $data['status'] != '-1')
        {
            $sql .= ' and status = ?';
            $where['status'] = $data['status'];
        }

        return $this->order->whereRaw($sql,$where)->orderBy('id', 'desc')->paginate($page);
    }
}