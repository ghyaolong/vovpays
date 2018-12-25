<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/21
 * Time: 17:13
 */

namespace App\Repositories;


use App\Models\Account_phone;

class AccountPhoneRepository
{
    protected $account_phone;

    /**
     * AccountPhoneRepository constructor.
     * @param Account_phone $account_phone
     */
    public function __construct(Account_phone $account_phone)
    {
        $this->account_phone = $account_phone;
    }

    public function searchPage(string $sql, array $where, int $page)
    {
        return $this->account_phone->whereRaw($sql, $where)->paginate($page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $string = strtolower(str_random(32));

        $result = $this->account_phone->where('signKey', '=', $string)->first();

        if (!isset($result)) {
            $data['signKey'] = $string;
        } else {
            return false;
        }
        return $this->account_phone->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->account_phone->whereId($id)->update($data);
    }

    public function searchOne(string $sql, array $where)
    {
        return $this->account_phone->whereRaw($sql, $where)->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->account_phone->whereId($id)->first();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function del(int $id)
    {
        return $this->account_phone->whereId($id)->delete();
    }

}