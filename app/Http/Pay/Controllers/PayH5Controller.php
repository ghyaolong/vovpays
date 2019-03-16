<?php

namespace App\Http\Pay\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Redis;
use App\Services\AccountUpperService;
use App\Tool\Sk\AopClient;
use App\Tool\Sk\AlipaySystemOauthTokenRequest;
use App\Services\RabbitMqService;

class PayH5Controller extends Controller
{
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


        Redis::select(1);
        if(!Redis::exists($request->orderNo))
        {
            return json_encode('订单不存在或者已过期！',JSON_UNESCAPED_UNICODE);
        }

        $data = Redis::hGetAll($request->orderNo);
        $data['orderNo'] = $request->orderNo;

        if($data['type'] == 'alipay_packets'){

            if($data['sweep_num'] >= 1){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }
            $num = $data['sweep_num']+1;
            Redis::hset($request->orderNo, 'sweep_num',$num);
            return view('Pay.hbh5',compact('data'));

        }else if($data['type'] == 'alipay'){
            $data['url'] = "taobao://render.alipay.com/p/s/i?scheme=".urlencode('alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "'.$data['userID'].'","a": "'.$data['amount'].'","m": "'.$data['meme'].'"}');
            return view('Pay.h5alipay_bank',compact('data'));
        }else if($data['type'] == 'alipay_bank2'){

            if($data['sweep_num'] >= 2){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }
            $num = $data['sweep_num']+1;
            Redis::hset($request->orderNo, 'sweep_num',$num);
//            header('Location:'. "https://www.alipay.com/?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$data['account']}&bankAccount={$data['bank_account_name']}&money={$data['amount']}&amount={$data['amount']}&bankMark={$data['bank_code']}&bankName={$data['bank_name']}&cardIndex={$data['chard_index']}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from");
            $data['url'] = "taobao://render.alipay.com/p/s/i?scheme=".urlencode("alipays://platformapi/startapp?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$data['account']}&bankAccount={$data['bank_account_name']}&money={$data['amount']}&amount={$data['amount']}&bankMark={$data['bank_code']}&cardIndex={$data['chard_index']}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from");

            return view('Pay.h5alipay_bank',compact('data'));
        }else if($data['type'] == 'alipay'){

            if($data['sweep_num'] >= 1){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }
            $num = $data['sweep_num']+1;
            Redis::hset($request->orderNo, 'sweep_num',$num);
            return view('Pay.android',compact('data'));

        }else if($data['type'] == 'alipay_receipt'){
            if($data['sweep_num'] >= 1){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }
            $num = $data['sweep_num']+1;
            Redis::hset($request->orderNo, 'sweep_num',$num);
            try{
                $msg = json_encode([
                    'amount' => $data['amount'],
                    'mark'   => $data['meme'],
                    'type'   => 'alipay_receipt',
                    'uid'  => $request->useraccount,
                    'sendtime' => TimeMicroTime(),
                ]);
                $rabbitMqService = app(RabbitMqService::class);
                $rabbitMqService->send('qr_'.$data['phone_id'].'test',$msg);
            }catch ( \Exception $e){
                return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
            }
//            $accountUpperService = app(AccountUpperService::class);
//            $account_list = $accountUpperService->findChannelId(1);
//
//            if(!$account_list){
//                return json_encode('系统未配置',JSON_UNESCAPED_UNICODE);
//            }
//            $account_array = $account_list->toArray();

//            $rank_key  = array_rand($account_array);
//            $redirect_uri = urlencode ('http://'.$_SERVER['HTTP_HOST'].'/pay/alipayauth/'.$request->orderNo); //授权回调地址
//            $url ="https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$account_array[$rank_key]['account']}&scope=auth_base&redirect_uri={$redirect_uri}";
//            $data['url'] = $url;
            return view('Pay.alipay_receipt',compact('data'));
        }
    }

    // 支付宝收款发起预下单
    public function alipayAuthNotify(Request $request)
    {

        Redis::select(1);
        if(!Redis::exists($request->orderNo))
        {
            return json_encode('订单不存在或者已过期',JSON_UNESCAPED_UNICODE);
        }

        $data = Redis::hGetAll($request->orderNo);

        if($data['sweep_num'] >= 1){
            return json_encode('二维码已使用，请重新发起支付',JSON_UNESCAPED_UNICODE);
        }

        $num = $data['sweep_num']+1;
        Redis::hset($request->orderNo, 'sweep_num',$num);


        $code = $request->auth_code;
        if (empty($code)) {
            return json_encode('缺少参数',JSON_UNESCAPED_UNICODE);
        }

        $accountUpperService = app(AccountUpperService::class);
        $account_list = $accountUpperService->findChannelId(1);
        if(!$account_list){
            return json_encode('系统未配置',JSON_UNESCAPED_UNICODE);
        }
        $account_array = $account_list->toArray();
        $rank_key = array_rand($account_array);


        $aop = new AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $account_array[$rank_key]['account']; //APPID
        $aop->rsaPrivateKey = $account_array[$rank_key]['privatekey'];
        $aop->alipayrsaPublicKey = $account_array[$rank_key]['publikey'];
        $aop->format = 'json';
        $aop->charset = 'UTF-8';
        $aop->signType = 'RSA2';
        $aop->apiVersion = '1.0';
        $request = new AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($code);

        $result = $aop->execute($request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultData = (array) $result->$responseNode;
        if (empty($resultData['access_token'])) {
            return json_encode('获取access_token失败',JSON_UNESCAPED_UNICODE);
        }

        $uid= $resultData['user_id'];

        try{
            $msg = json_encode([
                'amount' => $data['amount'],
                'mark'   => $data['meme'],
                'type'   => 'alipay_receipt',
                'uid'    => $uid,
                'sendtime' => TimeMicroTime(),
            ]);
            $rabbitMqService = app(RabbitMqService::class);
            $rabbitMqService->send('qr_'.$data['phone_id'].'test',$msg);
            return view('Pay.alipay_receipt_1', compact('data'));
        }catch ( \Exception $e){
            return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
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
}
