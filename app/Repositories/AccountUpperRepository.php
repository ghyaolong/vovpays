<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:35
 */

namespace App\Repositories;


use App\Models\Account_upper;
use App\Models\Channel_payment;

class AccountUpperRepository
{
    protected $account_upper;
    protected $channel_payment;

    public function __construct(Account_upper $account_upper, Channel_payment $channel_payment)
    {
        $this->account_upper = $account_upper;
        $this->channel_payment=$channel_payment;
    }

    /**
     * 获取所有，分页
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        return $this->account_upper->orderBy('id', 'desc')->paginate($page);
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function del(int $id)
    {
        return $this->account_upper->whereId($id)->delete();
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->account_upper->whereId($id)->update($data);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->account_upper->create($data);
    }


    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->account_upper->whereId($id)->first();
    }

    /**
     * @param int $status
     * @param $type
     * @return mixed
     */
    public function getStatusAndAccountType(int $status, $type)
    {
        $channel_payment_id=$this->channel_payment->wherePaymentcode($type)->select('id')->first()->id;
        return $this->account_upper->whereStatus($status)->whereChannelPaymentId($channel_payment_id)->get();
    }

}