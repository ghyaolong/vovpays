<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;

class ChooseAccountService{

    protected $accountPhoneService;
    protected $price;

    public function __construct(AccountPhoneService $accountPhoneService)
    {
        $this->accountPhoneService = $accountPhoneService;
        Redis::select(1);
    }

    /**
     * @param string $type
     * @param int $status
     * @return mixed|void
     */
    public function getAccount(string $type,int $status, float $price)
    {
        $this->price = $price;
        $account_list = $this->accountPhoneService->searchAccountAll($type,$status);
        if(!count($account_list))
        {
            return;
        }
        $valid_account_list = $this->getValidAlipayAccount($account_list);

        if(!count($valid_account_list))
        {
            return;
        }
        $rank_key = array_rand($valid_account_list);

        return $valid_account_list[$rank_key];
    }

    /**
     * 支付宝选着有效的账号
     * @param Collection $account_list
     * @return array
     */
    protected function getValidAlipayAccount(Collection $account_list){
        $valid_account_list = [];
        foreach ($account_list as $k=>$account)
        {
            if( Redis::exists($account->phone_id.'alipay') )
            {
                $get_account = Redis::hGetAll($account->phone_id.'alipay');
                // 验证手机和支付宝id是否一致
                if($get_account['userid'] != $account->alipayuserid || time() > strtotime($get_account['update'])+60000000000)
                {
                    continue;
                }

                // 验证账号是否限额
                if( $account->dayQuota && bcadd($this->price,$get_account['amount'],2) > $account->dayQuota )
                {
                    continue;
                }

                $valid_account_list[$k] = [
                    'account'   => $account->account,
                    'phoneid'   => $account->phone_id,
                    'type'      => $account->accountType,
                    'userId'    => $account->alipayuserid,
                    'username'  => $account->alipayusername
                ];
            }

        }
        return $valid_account_list;
    }
}