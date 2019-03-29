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

            if($data['sweep_num'] >= 1){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }

            $accountUpperService = app(AccountUpperService::class);
            $account_list = $accountUpperService->findChannelId(1);
            if(!$account_list){
                return json_encode('系统未配置',JSON_UNESCAPED_UNICODE);
            }

            $account_array = $account_list->toArray();

            $rank_key  = array_rand($account_array);
            $redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/pay/alipayauth/'.$request->orderNo.'?type=alipay'; //授权回调地址
            $url ="https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$account_array[$rank_key]['account']}&scope=auth_base&redirect_uri={$redirect_uri}";
            $data['url'] = $url;
            header("Location:".$url);

//            return view('Pay.android',compact('data'));
            //$data['url'] = "taobao://render.alipay.com/p/s/i?scheme=".urlencode('alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "'.$data['userID'].'","a": "'.$data['amount'].'","m": "'.$data['meme'].'"}');
//            $data['url'] = "taobao://render.alipay.com/p/s/i?scheme=".urlencode("alipays://platformapi/startapp?appId=20000116&actionType=toAccount&goBack=NO&amount={$data['amount']}&userId={$data['userID']}&memo={$data['meme']}");
//            return view('Pay.h5alipay_bank',compact('data'));




        }else if($data['type'] == 'alipay_bank2'){

            if($data['sweep_num'] >= 2){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }
            $num = $data['sweep_num']+1;
            Redis::hset($request->orderNo, 'sweep_num',$num);
//            header('Location:'. "https://www.alipay.com/?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$data['account']}&bankAccount={$data['bank_account_name']}&money={$data['amount']}&amount={$data['amount']}&bankMark={$data['bank_code']}&bankName={$data['bank_name']}&cardIndex={$data['chard_index']}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from");
            if($request->type == 'taobao'){
                $data['url'] = "taobao://render.alipay.com/p/s/i?scheme=".urlencode("alipays://platformapi/startapp?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$data['account']}&bankAccount={$data['bank_account_name']}&money={$data['amount']}&amount={$data['amount']}&bankMark={$data['bank_code']}&cardIndex={$data['chard_index']}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from");
                $data['type']= 'taobao';
            }else{
                $data['type']= 'header';
                $data['url'] = "alipays://platformapi/startapp?appId=09999988&actionType=toCard&sourceId=bill&cardNo={$data['account']}&bankAccount={$data['bank_account_name']}&money={$data['amount']}&amount={$data['amount']}&bankMark={$data['bank_code']}&cardIndex={$data['chard_index']}&cardNoHidden=true&cardChannel=HISTORY_CARD&orderSource=from";
            }
            return view('Pay.h5alipay_bank',compact('data'));
        }else if($data['type'] == 'alipay_receipt'){
            if($data['sweep_num'] >= 1){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }
            $num = $data['sweep_num']+1;
            Redis::hset($request->orderNo, 'sweep_num',$num);

            $accountUpperService = app(AccountUpperService::class);
            $account_list = $accountUpperService->findChannelId(1);

            if(!$account_list){
                return json_encode('系统未配置',JSON_UNESCAPED_UNICODE);
            }
            $account_array = $account_list->toArray();

            $rank_key  = array_rand($account_array);
            $redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/pay/alipayauth/'.$request->orderNo; //授权回调地址
            $url ="https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$account_array[$rank_key]['account']}&scope=auth_base&redirect_uri={$redirect_uri}";
            $data['url'] = $url;
            return view('Pay.alipay_receipt',compact('data'));
        }else if($data['type'] == 'ddc'){
            if($data['sweep_num'] >= 1){
                return json_encode('二维码已使用，请重新发起支付！',JSON_UNESCAPED_UNICODE);
            }

            // token不存在，发送获取token
            if(!Redis::exists($data['phone_id'].'token'))
            {
                try{
                    $msg = json_encode([
                        'amount' => $data['amount'],
                        'mark'   => $data['meme'],
                        'type'   => 'ddc',
                        'sendtime' => TimeMicroTime(),
                        'uid'    => '',
                    ]);

                    $rabbitMqService = app(RabbitMqService::class);
                    $rabbitMqService->send('qr_'.$data['phone_id'].'test',$msg);
                }catch ( \Exception $e){
                    return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
                }

                return json_encode('app不在线！',JSON_UNESCAPED_UNICODE);
            }

            $token_array = json_decode(Redis::get($data['phone_id'].'token'),true);
            $sender      = explode('_',$token_array['payurl']);

            $param = array(
                'size'          => '1',
                'appkey'        => '21603258',
                'congratulations'=> '恭喜发财',
                'amount'        => $data['amount'],
                '_v_'           => '3',
                't'             => time(),
                'imei'          => time(),
                'type'          => '0',
                'imsi'          => time(),
                'sender'        => $sender[1],
                'access_token'  => $token_array['payurl'],
            );

            $url = 'https://redenvelop.laiwang.com/v2/redenvelop/send/doGenerate';
            $ddc_result = json_decode(sendCurl($url,$param),true);
            if(isset($ddc_result['error'])) {
                // token 过期重新发送
                if($ddc_result['error'] == 'expired_token'){
                    try{
                        $msg = json_encode([
                            'amount' => $data['amount'],
                            'mark'   => $data['meme'],
                            'type'   => 'ddc',
                            'sendtime' => TimeMicroTime(),
                            'uid'    => '',
                        ]);

                        $rabbitMqService = app(RabbitMqService::class);
                        $rabbitMqService->send('qr_'.$data['phone_id'].'test',$msg);
                    }catch ( \Exception $e){
                        return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
                }
            }

            try{
                $msg = json_encode([
                    'amount' => $data['amount'],
                    'mark'   => $data['meme'],
                    'type'   => 'ddc',
                    'clusterId'=> $ddc_result['clusterId'],
                    'sendtime' => TimeMicroTime(),
                    'uid'    => '',
                ]);

                $rabbitMqService = app(RabbitMqService::class);
                $rabbitMqService->send('qr_'.$data['phone_id'].'test',$msg);
            }catch ( \Exception $e){
                return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
            }

            $get_pay_url = "http://api.laiwang.com/v2/internal/act/alipaygift/getPayParams?tradeNo={$ddc_result['businessId']}&bizType=biz_account_transfer&access_token={$param['access_token']}";
            $ddc_pay_server = json_decode(sendCurl($get_pay_url),true);
            if(!$ddc_pay_server){
                // token 过期重新发送
                if($ddc_result['error'] == 'expired_token'){
                    try{
                        $msg = json_encode([
                            'amount' => $data['amount'],
                            'mark'   => $data['meme'],
                            'type'   => 'ddc',
                            'sendtime' => TimeMicroTime(),
                            'uid'    => '',
                        ]);

                        $rabbitMqService = app(RabbitMqService::class);
                        $rabbitMqService->send('qr_'.$data['phone_id'].'test',$msg);
                    }catch ( \Exception $e){
                        return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    return json_encode('系统错误',JSON_UNESCAPED_UNICODE);
                }
            }

            $data['server'] = $ddc_pay_server['value'];
            return view('Pay.ddc',compact('data'));
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

        if($data['sweep_num'] >= 2){
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
        $requests = new AlipaySystemOauthTokenRequest();
        $requests->setGrantType("authorization_code");
        $requests->setCode($code);

        $result = $aop->execute($requests);

        $responseNode = str_replace(".", "_", $requests->getApiMethodName()) . "_response";
        $resultData = (array) $result->$responseNode;
        if (empty($resultData['access_token'])) {
            return json_encode('获取access_token失败',JSON_UNESCAPED_UNICODE);
        }

        if(!$resultData['user_id']){
            return json_encode('无法获取授权',JSON_UNESCAPED_UNICODE);
        }

        try{
            $msg = [
                'amount' => $data['amount'],
                'mark'   => $data['meme'],
                'type'   => 'alipay_order',
                'uid'    => $resultData['user_id'],
                'sendtime' => TimeMicroTime(),
            ];

            if($request->type == 'alipay'){
                $msg['type'] = 'alipay_qr';
                $rabbitMqService = app(RabbitMqService::class);
                $rabbitMqService->send('qr_'.$data['phone_id'].'test',json_encode($msg));
                $url = 'alipays://platformapi/startapp?appId=09999988&actionType=toAccount&goBack=NO&userId='.$data['userID'].'&amount='.$data['amount'];
                return view('Pay.android', compact('url'));
            }else{
                $rabbitMqService = app(RabbitMqService::class);
                $rabbitMqService->send('qr_'.$data['phone_id'].'test',json_encode($msg));
                return view('Pay.alipay_receipt_1', compact('data'));
            }
        }catch ( \Exception $e){
            return json_encode($e->getMessage(),JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 查询支付宝收款返回的订单
     * @param Request $request
     * @return array
     */
    public function getAlipayNorderNo(Request $request)
    {
        Redis::select(1);
        $orders = Redis::get($request->orderNo."order");
        if(!$orders) return json_encode(array('tradeNo'=>''));
        $orders = json_decode($orders, true);
        return json_encode(array('tradeNo'=>$orders['payurl']));
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
