<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;
use App\Models\Channel;

class ChannelsRepository
{

    protected $channel;

    /**
     * UsersRepository constructor.
     * @param Channel $channel
     */
    public function __construct( Channel $channel)
    {
        $this->channel = $channel;
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
        return $this->channel->whereRaw($sql, $where)->paginate($page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data){
        return $this->channel->create($data);
    }

    /**
     * 查询列表，不分页
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function search(string $sql, array $where)
    {
        return $this->channel->whereRaw($sql, $where)->get();
    }

    /**
     * 查询单条
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function searchOne(string $sql, array $where)
    {
        return $this->channel->whereRaw($sql, $where)->first();
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data){
        return $this->channel->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id){
        return $this->channel->whereId($id)->delete();
    }

    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->channel->whereId($id)->first();
    }
}