<?php

namespace App\Services;

use App\Repositories\OrdersRepository;

class OrdersService
{
    protected $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {

        return $this->ordersRepository->add($data);
    }

    /**
     * 订单查询，带分页
     * @param array $data
     * @param int $page
     * @return mixed
     */
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

        return $this->ordersRepository->searchPage($sql, $where, $page);
    }


    /**
     * 根据id获取
     * @param string $id
     * @return array
     */
    public function findId(string $id)
    {
        $sql         = 'id=?';
        $where['id'] = $id;
        $channels = $this->ordersRepository->searchOne($sql,$where);
        return $channels->toArray();
    }

    /**
     * 获取所有，分页
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        $sql   = ' status <> 5 ';
        $where = [];
        return $this->ordersRepository->searchPage($sql, $where, $page);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {


        return $this->ordersRepository->update($id, $data);
    }

    /**
     * 获取所有不带分页
     * @return mixed
     */
    public function getAll()
    {
        $sql   = ' 1=1 ';
        $where = [];
        return $this->ordersRepository->search($sql, $where);
    }

    /**
     * 状态变更
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStatus(int $id, array $data){

        return $this->ordersRepository->update($id, $data);
    }


    /**
     * 伪删除
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->ordersRepository->update($id,['status'=>5]);
    }
}