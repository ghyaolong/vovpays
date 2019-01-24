<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Collection;
use App\Common\RespCode;

class ChooseAccountService{

    protected $accountPhoneService;
    protected $accountBankCardsService;
    protected $price;
    protected $pay_code;

    public function __construct(AccountPhoneService $accountPhoneService, AccountBankCardsService $accountBankCardsService)
    {
        $this->accountPhoneService = $accountPhoneService;
        $this->accountBankCardsService = $accountBankCardsService;
    }

    /**
     * 随机获取账号
     * @param User $user
     * @param string $type
     * @param float $price
     * @return mixed|void
     */
    public function getAccount(User $user, string $type, float $price)
    {
        $valid_account = [];
        $this->price    = $price;
        $this->pay_code = $type;
        // 获取挂号方式配置,确定选号
        $add_account_type  =  env('ADD_ACCOUNT_TYPE');

        // 根据挂号方式获取所有开启的账号:1商户后台挂号,2总后台挂号,3代理后台挂号,4三方挂号
        if( $add_account_type == 1 )
        {
            if($this->pay_code == 'alipay' || $this->pay_code == 'wechat')
            {
                $account_list = $this->accountPhoneService->getStatusAndAccountType($type,$user->id,1);
            }else if($this->pay_code == 'alipay_bank'){
                $account_list = $this->accountBankCardsService->getStatusAndUserId($user->id,1);
            }
        }else if( $add_account_type == 2 ){

            if($this->pay_code == 'alipay' || $this->pay_code == 'wechat')
            {
                $account_list = $this->accountPhoneService->getStatusAndAccountType($type,100000,1);
            }else if($this->pay_code == 'alipay_bank'){
                $account_list = $this->accountBankCardsService->getStatusAndUserId(100000,1);
            }
        }else if( $add_account_type == 3 ){

            if($this->pay_code == 'alipay' || $this->pay_code == 'wechat' ) {

                $account_list = $this->accountPhoneService->getStatusAndAccountType($type, $user->parentId, 1);
            }else if($this->pay_code == 'alipay_bank'){
                $account_list = $this->accountBankCardsService->getStatusAndUserId($user->parentId,1);
            }
        }else if( $add_account_type == 4 ){
            // 获取有分数，且开启的所有三方用户id
            $userservice = app(UserService::class);
            $user_id_array = array_flatten($userservice->getAllQuotaLargeAmount(1,$this->price )->toArray());
            if(!count($user_id_array))
            {
                return RespCode::PARAMETER_ERROR_STOP;
            }

            if($this->pay_code == 'alipay' || $this->pay_code == 'wechat')
            {
                $account_list = $this->accountPhoneService->getStatusAndAccountTypeAndUidarr($type,1,$user_id_array);
            }else if($this->pay_code == 'alipay_bank'){
                $account_list = $this->accountBankCardsService->getStatusAndUidarr(1,$user_id_array);
            }
        }

        if(!count($account_list))
        {
            return RespCode::APP_ERROR;
        }

        //根据编码选择对应的账号
        if($this->pay_code == "alipay")
        {
            $valid_account = $this->getValidAlipayAccount($account_list);
        }else if($this->pay_code == "wechat"){
            $valid_account = $this->getValidWechatAccount($account_list);
        }else if($this->pay_code == "alipay_bank"){
            $valid_account = $this->getValidBankcardAccount($account_list);
        }

        if(!count($valid_account))
        {
            return RespCode::APP_ERROR;
        }

        return $valid_account;
    }

    /**
     * 选择支付宝账号
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
                if($get_account['userid'] != $account->alipayuserid || (time() > (strtotime($get_account['update'])+35) && $get_account['status'] == 1 ) )
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
                    'phone_id'  => $account->phone_id,
                    'type'      => $this->pay_code,
                    'userId'    => $account->alipayuserid,
                    'username'  => $account->alipayusername,
                    'phone_uid' => $account->user_id
                ];
            }
        }
        $rank_key = array_rand($valid_account_list);
        return $valid_account_list[$rank_key];
    }

    /**
     * 选择实时微信
     */
    protected function getValidWechatAccount(Collection $account_list)
    {
        Redis::select(1);
        $valid_account_list = [];
        foreach ($account_list as $k=>$account)
        {
            if( Redis::exists($account->phone_id.'wechat') )
            {
                $get_account = Redis::hGetAll($account->phone_id.'wechat');
                // 验证账号是否一致
                if( $get_account['account'] != $account->account || (time() > (strtotime($get_account['update'])+35) && $get_account['status'] == 1 ) )
                {
                    continue;
                }
                // 验证账号是否限额
                if( $account->dayQuota && bcadd($this->price,$get_account['amount'],2) > $account->dayQuota )
                {
                    continue;
                }

                $valid_account_list[$k] = [
                    'type'              => $this->pay_code,
                    'account'           => $account->account,
                    'phone_id'          => $account->phone_id,
                    'phone_uid'         => $account->user_id
                ];
            }
        }
        if(!count($valid_account_list))return [];

        $rank_key = array_rand($valid_account_list);
        return $valid_account_list[$rank_key];
    }

    /**
     * 选择银行卡
     * @param Collection $account_list
     * @return array
     */
    protected function getValidBankcardAccount(Collection $account_list)
    {
        Redis::select(1);
        $valid_account_list = [];
        foreach ($account_list as $k=>$account)
        {
            if( Redis::exists($account->phone_id.'alipay') )
            {
                $get_account = Redis::hGetAll($account->phone_id.'alipay');
                // 验证手机和支付宝id是否一致
                if( (time() > (strtotime($get_account['update'])+35) && $get_account['status'] == 1 ) )
                {
                    continue;
                }
                // 验证账号是否限额
                if( $account->dayQuota && bcadd($this->price,$get_account['bankamount'],2) > $account->dayQuota )
                {
                    continue;
                }

                $valid_account_list[$k] = [
                    'type'              => $this->pay_code,
                    'account'           => $account->cardNo,
                    'phone_id'          => $account->phone_id,
                    'bank_account_name' => $account->bank_account,
                    'bank_name'         => $account->bank_name,
                    'bank_code'         => $account->bank_mark,
                    'chard_index'       => $account->chard_index,
                    'phone_uid'         => $account->user_id
                ];
            }
        }
        if(!count($valid_account_list))return [];

        $rank_key = array_rand($valid_account_list);
        $valid_account = $valid_account_list[$rank_key];

        if(!$valid_account)return [];


        // 实现金额唯一;
        $flag = false;
        for ($i=10;$i >= 0;$i--){
            $key = $valid_account['phone_id'].'_'.$this->pay_code.'_'.sprintf('%0.2f',$this->price);
            if( $this->existsAmount($key) )
            {
                $flag = true;
                break;
            }else{
                $this->price = bcsub($this->price,0.01,2);
            }
        }
        if(!$flag)
        {
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
    protected function existsAmount(string $key){
        if( Redis::exists($key) )
        {
            return false;
        }else{
            Redis::set($key,$this->price);
            Redis::expire($key,600);
            return true;
        }
    }
}