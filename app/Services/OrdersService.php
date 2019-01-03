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
        return $this->ordersRepository->searchPage($data, $page);
    }


    /**
     * 根据id获取
     * @param int $id
     * @return array
     */
    public function findId(int $id)
    {
        $channels = $this->ordersRepository->findId($id);
        return $channels->toArray();
    }

    /**
     * 获取所有，分页
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        return $this->ordersRepository->getAllPage($page);
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
        return $this->ordersRepository->update($id,['status'=>2]);
    }
}