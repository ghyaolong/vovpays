<?php

namespace App\Http\Pay\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\UserRateService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Common\RespCode;
use App\Tool\AES;
use App\Tool\Md5Verify;

class PayController extends Controller
{
    protected $AES;
    protected $userService;
    protected $channelPaymentsService;
    protected $channelService;
    protected $userRateService;
    protected $md5Verify;
    protected $return_type; // 返回类型true:json，false:页面
    protected $content;     // 解密后的数据
    protected $md5_key;
    protected $verify_param_key = ['uid'=>'','order_no'=>'','price'=>'','tm'=>'','pay_code'=>'','notify_url'=>'','return_url'=>'','note'=>'','cuid'=>'','sign'=>''];

    public function __construct(AES $AES, UserService $userService,
                                ChannelPaymentsService $channelPaymentsService, ChannelService $channelService,
                                UserRateService $userRateService, Md5Verify $md5Verify)
    {
        parent::__construct();
        $this->AES                    = $AES;
        $this->userService            = $userService;
        $this->channelPaymentsService = $channelPaymentsService;
        $this->channelService         = $channelService;
        $this->userRateService        = $userRateService;
        $this->md5Verify              = $md5Verify;
    }

    public function index(Request $request)
    {
        if( isset($request->json) && $request->json == 'json'){
            $this->return_type = true;
        }else{
            $this->return_type = false;
        }

//        if(!$request->cipherData || $request->cipherData == '')
//        {
//            return json_encode(RespCode::PARAMETER_ERROR);
//        }

        // 测试串：R4YuWygi/yWivAtmCwrsyDOMteNxbls4OHQ3/h+xjOAn9DPnC4PUvlf7PCy0HpHomyrKHrk0cnAjp0MZRvzAh5SLBZxIo7Y3/Y+Aq7xryjOgpumPoducA95mZqf9UXTlRDj0DQTpjUFv3NFM3p0d7Q9wZmmVbuVYV4BdgF4g9IS0CA4NjY1ph0VHpoOb2dCnxj/3T06x/JcqMQzRzExIg69tqXsnpUgE8SM7wY2PMvheCd8tPVuV4bDYtWbNrgtCOVAdpYj6JQgl84CT480y+aad5o9CsdyVPrrf/hFPHVA=
        // AES数据解密
//        $aes_str = $this->AES->decrypt($request->cipherData,env('AES_KEY'));
//        if(!$aes_str)
//        {
//            return json_encode(RespCode::DECRYPT_FAILED);
//        }
//        $this->content = explode('&', $aes_str);

        $this->content = $request->input();

        $paramVerify = $this->paramVerify();
        if($paramVerify !== 'true')
        {
            return json_encode($paramVerify);
        }
        // 获取用户
        $user = $this->getUser($this->content['uid']);
        if(!$user)
        {
            return json_encode(RespCode::MERCHANT_NOT_EXIST);
        }

        $this->md5_key = $user->apiKey;
        // 数据验签
        $sign = $this->md5Verify->getSign($this->content, $this->md5_key);

        if($sign != $this->content['sign'])
        {
            return json_encode(RespCode::CHECK_SIGN_FAILED);
        }

        // 获取支付方式
        $channelPayment = $this->getChannelPayment($this->content['pay_code']);
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
        dd($channel);
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

    /**
     * 获取用户支付方式
     * @param int $uid
     * @param int $pay_id
     * @return mixed
     */
    protected function getUserPayment(int $uid, int $pay_id)
    {
        return $this->userRateService->getFindUidPayId($uid, $pay_id);
    }

    /**
     * 检测参数是否合法
     * @return array|string
     */
    protected function paramVerify()
    {
        foreach ($this->content as $key=>$val)
        {
            if (!array_key_exists($key,$this->verify_param_key))
            {
                return RespCode::PARAMETER_ERROR;
            }

            if($key != 'note' && $key != 'cuid' )
            {
                if(empty($this->content[$key]))return RespCode::PARAMETER_ERROR_TYPE;
            }
        }

        if( !preg_match("/^[a-z\d]*$/i",$this->content['order_no']) || strlen($this->content['order_no']) > 20 ){
            return RespCode::PARAMETER_ERROR_TYPE;
        }

        if( !is_numeric($this->content['price']) || $this->content['price'] == 0 )
        {
            return RespCode::PARAMETER_ERROR_TYPE;
        }

        if(!strtotime($this->content['tm']))
        {
            return RespCode::PARAMETER_ERROR_TYPE;
        }

        return 'true';
    }

}
