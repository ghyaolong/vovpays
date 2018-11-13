<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;
use App\Models\User_rates;

class UserRateRepository
{

    protected $user_rates;

    /**
     * UsersRepository constructor.
     * @param User_rates $user_rates
     */
    public function __construct( User_rates $user_rates)
    {
        $this->user_rates = $user_rates;
    }

    /**
     * 根据用户id获取指定字段
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function search(string $sql, array $where)
    {
        return $this->user_rates->whereRaw($sql , $where)
            ->select('channel_payment_id', 'rate', 'status', 'channel_id')
            ->get();
    }

    /**
     * 获取单条
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function searchOne(string $sql, array $where)
    {
        return $this->user_rates->whereRaw($sql , $where)
            ->select('id','channel_payment_id', 'rate', 'status', 'channel_id')
            ->first();
    }

    public function add(array $data)
    {
        return $this->user_rates->create($data);
    }
}