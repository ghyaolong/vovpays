<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/21
 * Time: 17:13
 */

namespace App\Repositories;


use App\Models\Account_phone;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function searchPage(string $sql,array $where, int $page)
    {


        $sql .= ' and DATE(pay_account_day_counts.created_at) = ?';
        $where['created_at'] = date('Y-m-d');


        return $this->account_phone->whereRaw($sql, $where)
            ->leftjoin('account_day_counts', 'account_day_counts.account', '=', 'account_phones.account')
            ->selectRaw('*,cast(account_order_suc_count/account_order_count as decimal(10,2))*100 as success_rate')
            ->paginate($page);


    }
    /**
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function searchPhone(string $sql,array $where, int $page)
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
     * @param int $uid
     * @param array $data
     * @return mixed
     */
    public function update(int $id, int $uid, array $data)
    {
        return $this->account_phone->whereId($id)->whereUserId($uid)->update($data);
    }

    /**
     * @param int $id
     * @param string $value
     * @return mixed
     */
    public function searchCheck(int $id = null, string $value)
    {
        if ($id) {

            $sql = "id <> $id and phone_id = ?";
            $where['phone_id'] = $value;

        } else {

            $sql = " phone_id = ?";
            $where['phone_id'] = $value;

        }
        $data = $this->account_phone->whereRaw($sql, $where)->get();
        if (count($data) <= 1) {
            return false;
        } else {
            $account = [];
            foreach ($data as $v) {
                $account[] = $v['accountType'];
            }
            return $account;
        }

//        return $this->account_phone->whereRaw($sql, $where)->first();
    }
//    public function searchOne(int $id, string $value)
//    {
//        if ($id) {
//
//            $sql = "id <> $id and account = ?";
//            $where['account'] = $value;
//
//        } else {
//
//            $sql = " account = ?";
//            $where['account'] = $value;
//
//        }
//        return $this->account_phone->whereRaw($sql, $where)->first();
//    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function findIdAndUserId(int $id, int $uid)
    {
        return $this->account_phone->whereId($id)->whereUserId($uid)->first();
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function del(int $id, int $uid)
    {
        return $this->account_phone->whereId($id)->whereUserId($uid)->delete();
    }

    /**
     * @param string $type
     * @param int $uid
     * @param int $status
     * @return mixed
     */
    public function getStatusAndAccountType(string $type, int $uid, int $status)
    {
        if ($type == 'alipay') {
            $type = '支付宝';
        } elseif ($type == 'wechat') {
            $type = '微信';
        }
        return $this->account_phone->whereStatus($status)->whereUserId($uid)->whereAccounttype($type)->get();
    }

    /**
     * 查询账户指定用户名下的所有账户
     * @param string $type
     * @param int $status
     * @return mixed
     */
    public function getStatusAndAccountTypeAndUidarr(string $type, int $status, array $uid_arr)
    {
        if ($type == 'alipay') {
            $type = '支付宝';
        } elseif ($type == 'wechat') {
            $type = '微信';
        }
        return $this->account_phone->whereStatus($status)->whereIn('user_id', $uid_arr)->whereAccounttype($type)->get();
    }

    /**
     * @param string $phoneId
     * @param int $status
     * @param int $uid
     * @return mixed
     */
    public function getPhoneidAndStatusAndUserid(string $phoneId, int $status, int $uid)
    {
        return $this->account_phone->whereStatus($status)->wherePhoneId($phoneId)->whereUserId($uid)->get();
    }

}