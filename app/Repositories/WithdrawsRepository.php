<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 10:13
 */

namespace App\Repositories;


use App\Models\Withdraw;

class WithdrawsRepository
{
    protected $withdraw;

    public function __construct(Withdraw $withdraw)
    {
        $this->withdraw = $withdraw;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->withdraw->create($data);
    }

    /**
     * 查询带分页
     * @param string $sql
     * @param array $where
     * @param int $page
     * @return mixed
     */
    public function searchPage(string $sql, array $where, int $page)
    {
        return $this->withdraw->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }
}