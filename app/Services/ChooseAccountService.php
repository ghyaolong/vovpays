<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use App\Common\RespCode;

class ChooseAccountService{

    protected $accountPhoneService;
    protected $price;

    public function __construct(AccountPhoneService $accountPhoneService)
    {
        $this->accountPhoneService = $accountPhoneService;
    }

    /**
     * 随机获取账号
     * @param User $user
     * @param string $type
     * @param int $status
     * @param float $price
     * @return mixed|void
     */
    public function getAccount(User $user, string $type,int $status, float $price)
    {
        $valid_account_list = [];
        $this->price  = $price;
        // 获取挂号方式配置,确定选号
        $systems = Cache::get('systems');
        if(!$systems)
        {
            return RespCode::SYS_ERROR;
        }

        if(!isset($systems['add_account_type'])){
            return RespCode::SYS_ERROR;
        }
        // 根据挂号方式获取所有开启的账号
        if($systems['add_account_type']->value == 1 )
        {
            if($type == 'alipay')
            {
                $account_list = $this->accountPhoneService->getStatusAndAccountType($type,$user->id,$status);
            }else if($type == 'wechat'){
                $account_list = $this->accountPhoneService->getValidWechatAccount();
            }else if($type == 'bankcard'){
                $account_list = $this->accountPhoneService->getValidBankcardAccount();
            }

        }else if($systems['add_account_type']->value == 2 ){

            if($type == 'alipay')
            {
                $account_list = $this->accountPhoneService->getStatusAndAccountType($type,100000,$status);
            }else if($type == 'wechat'){
                $account_list = $this->accountPhoneService->getValidWechatAccount();
            }else if($type == 'bankcard'){
                $account_list = $this->accountPhoneService->getValidBankcardAccount();
            }
        }
        dd(22);
        if(!count($account_list))
        {
            return RespCode::APP_ERROR;
        }

        //根据编码选着对应的账号
        if($type == "alipay")
        {
            $valid_account_list = $this->getValidAlipayAccount($account_list);
        }else if($type == "wechat"){
            $valid_account_list = $this->getValidWechatAccount($account_list);
        }

        if(!count($valid_account_list))
        {
            return RespCode::APP_ERROR;
        }
        $rank_key = array_rand($valid_account_list);

        return $valid_account_list[$rank_key];
    }

    /**
     * 选着支付宝账号
     * @param Collection $account_list
     * @return array
     */
    protected function getValidAlipayAccount(Collection $account_list){
        Redis::select(1);
        $valid_account_list = [];
        foreach ($account_list as $k=>$account)
        {
            if( Redis::exists($account->phone_id.'alipay') )
            {
                $get_account = Redis::hGetAll($account->phone_id.'alipay');
                // 验证手机和支付宝id是否一致
                if($get_account['userid'] != $account->alipayuserid || time() > (strtotime($get_account['update'])+60000))
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

    /**
     * 选着微信
     */
    protected function getValidWechatAccount()
    {
        return;
    }

    /**
     * 选着银行卡
     */
    protected function getValidBankcardAccount()
    {

    }
}