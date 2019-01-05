<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/17
 * Time: 13:56
 */

namespace App\Repositories;


use App\Models\Bank_card;

class BankCardRepository
{
    protected $bankCard;

    public function __construct(Bank_card $bank_card)
    {
        $this->bankCard=$bank_card;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */

    public function add(array $data)
    {
        return $this->bankCard->create($data);
    }

    /**
     * 查询列表，不分页
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function search(int $id)
    {
        return $this->bankCard->whereUserId($uid)->get();
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id)
    {
        return $this->bankCard->whereId($id)->delete();
    }

    /**
     * 获取一条数据
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->bankCard->whereId($id)->first();
    }

    /**
     * 获取状态
     * @param int $user_id
     * @return mixed
     */
    public function findStatus(int $user_id)
    {
        return $this->bankCard->whereUserId($user_id)->whereStatus('1')->first();
    }

    /**
     * 编辑
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id,array $data)
    {
        return $this->bankCard->whereId($id)->update($data);
    }

    /**
     * 修改用户所有银行卡状态
     * @param int $id
     * @param array $data
     */
    public function updateStatus(int $id,array $data)
    {
        $this->bankCard->whereUserId($id)->update($data);
    }

}