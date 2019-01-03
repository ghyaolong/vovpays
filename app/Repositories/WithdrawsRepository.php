<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 10:13
 */

namespace App\Repositories;


use App\Models\Withdraw;
use Illuminate\Support\Facades\Auth;

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
    public function searchPage(int $page)
    {
        $user_id=Auth::user()->id;
        $sql = " user_id = {$user_id} ";
        $where=[];
        return $this->withdraw->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }
}