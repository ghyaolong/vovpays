<?php

namespace App\Http\Pay\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\UserRateService;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Common\RespCode;
use App\Tool\Md5Verify;
use App;
use Illuminate\Support\Facades\Redis;

class PayController extends Controller
{
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

    public function __construct(UserService $userService,
                                ChannelPaymentsService $channelPaymentsService, ChannelService $channelService,
                                UserRateService $userRateService, Md5Verify $md5Verify)
    {
        parent::__construct();
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
        $this->user = $this->userService->findMerchant($this->content['merchant']);
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
        $this->channelPayment = $this->channelPaymentsService->findPaymentCode($this->content['pay_code']);
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
        $this->channel = $this->channelService->findIdStatus($this->channelPayment->channel_id);

        if(!$this->channel)
        {
            return json_encode(RespCode::CHANNEL_NOT_EXIST);
        }
        //获取商户支付方式
        $this->userPayment = $this->userRateService->getFindUidPayIdStatus($this->user->id, $this->channelPayment->id);
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
    {  dd(22);
//        $objRabbitMQ = \App\Services\RabbitMqService::getInstance();
//        $objRabbitMQ->send('test','测试信息');
        exit;
    }

    /**
     * 异步通知入口
     * @param Request $request
     * @throws \Exception
     * @return json
     */
    public function notifyCallback(Request $request)
    {
        try{
            if(!$pay = App::make(strtolower($request->action)) )
            {
                throw new \Exception('');
            }
            return $pay->successCallback($request);

        }catch ( \Exception $e){

            return json_encode(RespCode::RESOURCE_NOT_FOUND);
        }
    }

    /**
     * 同步通知入口
     * @param Request $request
     * @throws \Exception
     * @return json
     */
    public function successCallback(Request $request)
    {
        try{
            if(!$pay = App::make(strtolower($request->action)) )
            {
                throw new \Exception('');
            }
            return $pay->successCallback($request);

        }catch ( \Exception $e){

            return json_encode(RespCode::RESOURCE_NOT_FOUND);
        }

    }


    /**
     * 支付宝免签H5跳转页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|void
     */
    public function h5pay(Request $request)
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos( $userAgent, 'AlipayClient' ) === false) return ;
        if(!$request->orderNo) return ;

        Redis::select(2);
        if(!Redis::exists($request->orderNo))
        {
            return ajaxError('订单不存在或者已过期！');
        }

        $data = Redis::hGetAll($request->orderNo);
        $data['orderNo'] = $request->orderNo;

        if($this->get_device_type()!='ios')
        {
            return view('Pay.android',compact('data'));
        }else{
            return view('Pay.ios',compact('data'));
        }

    }

    /**
     * 检测手机系统
     * @return string
     */
    protected function get_device_type()
    {
        //全部变成小写字母
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $type = 'other';
        //分别进行判断
        if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
        {
            $type = 'ios';
        }

        if(strpos($agent, 'android'))
        {
            $type = 'android';
        }
        return $type;
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
