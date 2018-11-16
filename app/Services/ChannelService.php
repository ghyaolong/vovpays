<?php

namespace App\Services;

use App\Repositories\ChannelsRepository;
use App\Exceptions\CustomServiceException;

class ChannelService
{
    protected $channelsRepository;

    public function __construct(ChannelsRepository $channelsRepository)
    {
        $this->channelsRepository = $channelsRepository;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        // 去掉无用数据
        $data = array_except($data, ['id','_token']);
        return $this->channelsRepository->add($data);
    }

    /**
     * 根据id获取
     * @param string $id
     * @return array
     */
    public function findId(string $id)
    {
        $channels = $this->channelsRepository->findId($id);
        return $channels->toArray();
    }


    public function findIdStatus(int $id)
    {
        $sql = 'id=? and status=1';
        $where['id'] = $id;
        return $this->channelsRepository->searchOne($sql,$where);
    }

    /**
     *
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        $sql   = '1=1';
        $where = [];

        return $this->channelsRepository->searchPage($sql, $where, $page);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $data = array_except($data, ['id','_token','password_confirmation']);

        return $this->channelsRepository->update($id, $data);
    }

    /**
     * 获取所有不带分页,
     * @return mixed
     */
    public function getAll()
    {
        $sql   = '1=1';
        $where = [];
        return $this->channelsRepository->search($sql, $where);
    }

    /**
     * 状态变更
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStatus(int $id, array $data){

        return $this->channelsRepository->update($id, $data);
    }

    /**
     * 伪删除
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->channelsRepository->del($id);
    }
}