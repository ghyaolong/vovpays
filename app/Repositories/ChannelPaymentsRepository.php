<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;
use App\Models\Channel_payment;

class ChannelPaymentsRepository
{

    protected $channel_payment;

    /**
     * UsersRepository constructor.
     * @param Channel_payment $channel_payment
     */
    public function __construct( Channel_payment $channel_payment)
    {
        $this->channel_payment = $channel_payment;
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
        return $this->channel_payment->whereRaw($sql, $where)->paginate($page);
    }

    /**
     * 查询单条
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function searchOne(string $sql, array $where)
    {
        return $this->channel_payment->whereRaw($sql, $where)->first();
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data){
        return $this->channel_payment->create($data);
    }

    /**
     * 查询列表，不分页
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function searchAll(string $sql, array $where)
    {
        return $this->channel_payment->whereRaw($sql, $where)->get();
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data){
        return $this->channel_payment->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id){
        return $this->channel_payment->whereId($id)->delete();
    }

    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->channel_payment->find($id);
    }
}