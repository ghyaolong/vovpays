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
     * 查询列表，分页
     * @param string $sql
     * @param array $where
     * @param int $page
     * @return mixed
     */
    public function searchPage(string $sql, array $where, int $page)
    {
        return $this->order->whereRaw($sql, $where)->paginate($page);
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
     * 查询列表，不分页
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function search(string $sql, array $where)
    {
        return $this->order->whereRaw($sql, $where)->get();
    }

    /**
     * 查询单条
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function searchOne(string $sql, array $where)
    {
        return $this->order->whereRaw($sql, $where)->first();
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
}