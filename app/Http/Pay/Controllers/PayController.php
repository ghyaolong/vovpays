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
use App;

class PayController extends Controller
{
    protected $AES;
    protected $userService;
    protected $channelPaymentsService;
    protected $channelService;
    protected $userRateService;
    protected $md5Verify;
    protected $return_type;     // 返回类型true:json，false:页面
    protected $content;         // 解密后的数据
    protected $userPayment;     // 用户支付方式
    protected $user;            // 用户信息
    protected $channel;         // 通道信息
    protected $channelPayment;  // 支付方式信息

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

    /**
     * 订单提交入口
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        if( isset($request->json) && $request->json == 'json'){
            $this->return_type = true;
        }else{
            $this->return_type = false;
        }

        $this->content = $request->input();

        $this->paramVerify($request);

        // 获取用户
        $this->user = $this->getUser($this->content['merchant']);
        if(!$this->user)
        {
            return json_encode(RespCode::MERCHANT_NOT_EXIST);
        }

        // 数据验签
        $sign = $this->md5Verify->getSign($this->content, $this->user->apiKey);

        if($sign != $this->content['sign'])
        {
            return json_encode(RespCode::CHECK_SIGN_FAILED);
        }

        // 获取支付方式
        $this->channelPayment = $this->getChannelPayment($this->content['pay_code']);
        if(!$this->channelPayment)
        {
            return json_encode(RespCode::TRADE_BIZ_NOT_OPEN);
        }

        // 验证单笔限额
        if($this->channelPayment->minAmount > $this->content['amount'] || $this->channelPayment->maxAmount < $this->content['amount'])
        {
            return json_encode(RespCode::PARAMETER_ERROR_PRICE);
        }

        //获取通道
        $this->channel = $this->getChannel($this->channelPayment->channel_id);

        if(!$this->channel)
        {
            return json_encode(RespCode::CHANNEL_NOT_EXIST);
        }
        //获取商户支付方式
        $this->userPayment = $this->getFindUidPayIdStatus($this->user->id, $this->channelPayment->id);
        if(!$this->userPayment)
        {
            return json_encode(RespCode::MCH_BIZ_NOT_OPEN);
        }

        try{
            if(!$pay = App::make(strtolower($this->channel->channelCode)) )
            {
                throw new \Exception('');
            }
            return $pay->pay($this->user, $this->channel, $this->channelPayment, $this->userPayment, $request);

        }catch ( \Exception $e){

            return json_encode(RespCode::RESOURCE_NOT_FOUND);
        }
    }


    /**
     * 订单查询入口
     * @param Request $request
     */
    public function queryOrder(Request $request)
    {
        dd(11);
    }

    public function show(Request $request)
    {
        return view('Pay.Pay.pay');
    }

    /**
     * 获取用户
     * @param string $merchant
     * @return mixed
     */
    protected function getUser(string $merchant)
    {
        return $this->userService->findMerchant($merchant);

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
    protected function getFindUidPayIdStatus(int $uid, int $pay_id)
    {
        return $this->userRateService->getFindUidPayIdStatus($uid, $pay_id);
    }

    /**
     * 检测参数是否合法
     * @param Request $request
     * @return array|string
     */
    protected function paramVerify(Request $request)
    {
        $this->validate($request, [
            'merchant'        => 'required',
            'amount'          => 'required|numeric',
            'pay_code'        => 'required',
            'order_no'        => 'required|max:50',
            'notify_rul'      => 'required',
            'return_url'      => 'required',
            'order_time'      => 'date_format:Y-m-d H:i:s',
        ],[
            'merchant.required' => '商户号错误！',
            'amount.required'   => '订单金额错误！',
            'amount.numeric'    => '订单金额错误！',
            'pay_code.required' => '支付方式错误！',
            'order_no.required' => '订单号错误！',
            'order_no.max'      => '订单号最大50位！',
            'notify_rul.required' => '回调地址错误！',
            'return_url.required' => '同步地址错误！',
            'order_time.date_format' => '订单时间格式错误',
        ]);
    }

}
