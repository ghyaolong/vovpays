<?php

namespace App\Http\Pay\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\UserRateService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Common\RespCode;
use App\Tool\AES;

class PayController extends Controller
{

    protected $AES;
    protected $userService;
    protected $channelPaymentsService;
    protected $channelService;
    protected $userRateService;
    protected $return_type; // 返回类型true:json，false:页面
    protected $content;     // 解密后的数据

    public function __construct(AES $AES, UserService $userService,
                                ChannelPaymentsService $channelPaymentsService, ChannelService $channelService,
                                UserRateService $userRateService)
    {
        parent::__construct();
        $this->AES = $AES;
        $this->userService = $userService;
        $this->channelPaymentsService = $channelPaymentsService;
        $this->channelService = $channelService;
        $this->userRateService= $userRateService;
    }

    public function index(Request $request)
    {
        if( isset($request->json) && $request->json == 'json'){
            $this->return_type = true;
        }else{
            $this->return_type = false;
        }

        if(!$request->cipherData || $request->cipherData == '')
        {
            return json_encode(RespCode::PARAMETER_ERROR);
        }

        // 测试串：R4YuWygi/yWivAtmCwrsyDOMteNxbls4OHQ3/h+xjOAn9DPnC4PUvlf7PCy0HpHomyrKHrk0cnAjp0MZRvzAh5SLBZxIo7Y3/Y+Aq7xryjOgpumPoducA95mZqf9UXTlRDj0DQTpjUFv3NFM3p0d7Q9wZmmVbuVYV4BdgF4g9IS0CA4NjY1ph0VHpoOb2dCnxj/3T06x/JcqMQzRzExIg69tqXsnpUgE8SM7wY2PMvheCd8tPVuV4bDYtWbNrgtCOVAdpYj6JQgl84CT480y+aad5o9CsdyVPrrf/hFPHVA=
        // AES数据解密
        $sign_str = $this->AES->decrypt($request->cipherData,env('AES_KEY'));
        if(!$sign_str)
        {
            return json_encode(RespCode::DECRYPT_FAILED);
        }
        $this->content = json_decode($sign_str, true);
        // 获取用户
        $user = $this->getUser($this->content['uid']);
        if(!$user)
        {
            return json_encode(RespCode::MERCHANT_NOT_EXIST);
        }
        // 数据验签
        $verification = $this->verification($this->content, $user->apiKey);
        if(!$verification)
        {
            return json_encode(RespCode::CHECK_SIGN_FAILED);
        }

        if(strlen($this->content['orderNo']) != 20)
        {
            return json_encode(RespCode::CHECK_SIGN_FAILED);
        }

        // 获取支付方式
        $channelPayment = $this->getChannelPayment($this->content['paytype']);
        if(!$channelPayment)
        {
            return json_encode(RespCode::TRADE_BIZ_NOT_OPEN);
        }

        //获取通道
        $channel = $this->getChannel($channelPayment->channel_id);
        if(!$channel)
        {
            return json_encode(RespCode::CHANNEL_NOT_EXIST);
        }

        //获取商户支付方式
        $userPayment = $this->getUserPayment($user->id, $channelPayment->id);
        if(!$userPayment)
        {
            return json_encode(RespCode::MCH_BIZ_NOT_OPEN);
        }
        try{
            $class = '\App\Services\Pay\TestService';
            if(!class_exists($class))
            {
                throw new \Exception('');
            }
            $app = new $class;
            $app->pay(['a'=>1]);
        }catch ( \Exception $e){

            return json_encode(RespCode::RESOURCE_NOT_FOUND);
        }

    }

    /**
     * 获取用户
     * @param string $merchant
     * @return mixed
     */
    protected function getUser(string $merchant)
    {
        $user = $this->userService->findMerchant($merchant);
        return $user;
    }

    /**
     * 根据编码获取启用的支付方式
     * @param string $paycode
     * @return mixed
     */
    protected function getChannelPayment(string $paycode)
    {
        return $this->channelPaymentsService->findPaymentCode($paycode);
    }

    /**
     * 根据id获取启用的通道
     * @param int $id
     * @return array
     */
    protected function getChannel(int $id)
    {
        return $this->channelService->findIdStatus($id);
    }

    protected function getUserPayment(int $uid, int $pay_id)
    {
        return $this->userRateService->getFindUidPayId($uid, $pay_id);
    }

    /**
     * md5加密验证
     * @param array $data
     * @param string $key
     * @return bool
     */
    protected function verification(array $data, string $key)
    {
        $rawSign = $data['sign'];
        unset($data['sign']);
        ksort($data);

        $sign_str = '';
        foreach ($data as $k=>$v)
        {
            $sign_str .= $k.'='.$v.'&';
        }

        $sign = md5($sign_str.'key='.$key);
        if($sign == $rawSign)
        {
            return true;
        }else{
            return false;
        }
    }
}
