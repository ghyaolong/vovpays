<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/8
 * Time: 17:58
 */

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Common\RespCode;

class ThreePartyService
{
    protected $accountUpperService;
    protected $price;
    protected $pay_code;

    public function __construct(AccountUpperService $accountUpperService)
    {
        $this->accountUpperService=$accountUpperService;
    }

    public function getAccount(User $user, string $type, float $price)
    {
        $valid_account = [];
        $this->price = $price;
        $this->pay_code = $type;

        if ($this->pay_code == 'sand_quick') {
            $account_list = $this->accountUpperService->getStatusAndAccountType(1, $type);
        }

        if (!count($account_list)) {
            return RespCode::ACCOUNT_NOT_START;
        }

        //根据编码选择对应的账号
        if ($this->pay_code == 'sand_quick') {
            $valid_account = $this->getValidUpperAccount($account_list);
        }

        if (!count($valid_account)) {

            return RespCode::APP_ERROR;
        }

        return $valid_account;

    }

    /**
     * 选择当面付账号
     * @param Collection $account_list
     * @return array
     */
    protected function getValidUpperAccount(Collection $account_list)
    {
//        Redis::select(1);
        $valid_account_list = [];
        foreach ($account_list as $k => $account) {
//            if (Redis::exists($account->phone_id . 'bankmsg')) {
//                $get_account = Redis::hGetAll($account->phone_id . 'bankmsg');
//                // 验证手机心跳是否正常
//                if ((time() > (strtotime($get_account['update']) + 60) && $get_account['status'] == 1)) {
//                    continue;
//                }
                // 验证账号是否限额
//                if ($account->dayQuota && bcadd($this->price, $get_account['amount'], 2) > $account->dayQuota) {
//                    continue;
//                }


                $valid_account_list[$k] = [
                    'type' => $this->pay_code,
                    'account' => $account->account,
                    'privatekey' => $account->phone_id,
                    'publikey' => $account->bank_account,
                    'cardNo' => $account->cardNo,
                    'qrcode' => $account->qrcode,
                ];
//            }
        }

        if (!count($valid_account_list)) return [];
        $rank_key = array_rand($valid_account_list);
        $valid_account = $valid_account_list[$rank_key];

        if (!$valid_account) return [];


        // 实现金额唯一;
        $flag = false;
        for ($i = 10; $i >= 0; $i--) {
            $key = $this->pay_code . '_' . sprintf('%0.2f', $this->price);
            if ($this->existsAmount($key)) {
                $flag = true;
                break;
            } else {
                $this->price = bcsub($this->price, 0.01, 2);
            }
        }
        if (!$flag) {
            return [];
        }
        $valid_account['realPrice'] = $this->price;

        return $valid_account;
    }

    /**
     * 检测金额是否唯一
     * @param string $key
     * @return bool
     */
    protected function existsAmount(string $key)
    {
        if (Redis::exists($key)) {
            return false;
        } else {

            Redis::set($key, $this->price);
            Redis::expire($key, 600);
            return true;
        }
    }

}