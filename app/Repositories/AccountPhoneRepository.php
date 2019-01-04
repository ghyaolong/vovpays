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

    public function searchPage(array $data, int $page)
    {
        $sql = ' 1=1 ';
        $where = [];

        if (isset($data['account']) && $data['account']) {
            $sql .= 'and account = ?';
            $where['account'] = $data['account'];
        }
        if (isset($data['accountType']) && $data['accountType']) {
            if ($data['accountType'] == 'alipay') {
                $data['accountType'] = '支付宝';
            } elseif ($data['accountType'] == 'wechat') {
                $data['accountType'] = '微信';
            }
            $sql .= ' and accountType = ?';
            $where['accountType'] = $data['accountType'];
        }

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

    /**
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function searchOne(int $id, string $value)
    {
        if ($id) {

            $sql = "id <> $id and account = ?";
            $where['account'] = $value;

        } else {

            $sql = " account = ?";
            $where['account'] = $value;

        }
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

    /**
     * @param string $type
     * @param int $status
     * @return mixed
     */
    public function findStatusAndAccountType( string $type, int $status)
    {
        if($type == 'alipay'){
            $type = '支付宝';
        }elseif($type == 'wechat'){
            $type = '微信';
        }
        return $this->account_phone->whereStatus($status)->whereAccounttype($type)->get();
    }

}