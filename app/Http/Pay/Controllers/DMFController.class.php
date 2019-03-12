<?php
/**
 * Created by PhpStorm.
 * User: yyk
 * Date: 2018-12-24
 * Time: 12:39
 */

namespace App\Http\Pay\Controllers;



class  DMFController extends PayController
{

    /**
     * redis链接
     * @param $index
     * @return \Redis
     */
    protected function redis_connect($index)
    {
        $redis = new \Redis();
        $redis->connect(C('REDIS_HOST'), C('REDIS_PORT'));
        $redis->auth(C('REDIS_PWD'));
        $redis->select($index);
        return $redis;
    }

    //应用ID
    protected $appId = "";
    //回调地址
    protected $notifyUrl = "http://www.cn887.com/Pay_DMF_notifyUrl.html"; //string $notifyUrl 支付结果通知url 不要有问号
    //私钥值
    protected $rsaPrivateKey = "";
    //支付宝公钥，账户中心->密钥管理->开放平台密钥，找到添加了支付功能的应用，根据你的加密类型，查看支付宝公钥
    protected $alipayPublicKey = "";
    protected $charset = 'utf8';

    //支付
    public function pay($array)
    {

        $paytongdao = array(
            'code' => 'DMF',
            'title' => '当面付',
            'exchange' => 100, // 金额比例
            'gateway' => '',
            'orderid' => get_requestord(),
            'out_trade_id' => I("request.pay_orderid"),
            'body' => I('request.pay_productname'),
            'channel' => $array
        );

        $orderaddResult = $this->orderadd($paytongdao);

        $this->rsaPrivateKey = $orderaddResult['privatekey'];
        $this->alipayPublicKey = $orderaddResult['publickey'];
        //string $orderName 订单名称
        $orderName = "中原";
        //float $totalFee 收款总费用 单位元
        $totalFee = $orderaddResult['amount'];
        //string $outTradeNo 订单号
        $outTradeNo = $orderaddResult['orderid'];

        //请求参数
        $requestConfigs = array(
            'out_trade_no' => $outTradeNo,
            'total_amount' => $totalFee, //单位 元
            'subject' => $orderName, //订单标题
        );
        $commonConfigs = array(
            //公共参数
            'app_id' => $orderaddResult['mch_id'],
            'method' => 'alipay.trade.precreate', //接口名称
            'format' => 'JSON',
            'charset' => $this->charset,
            'sign_type' => 'RSA2',
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'notify_url' => $this->notifyUrl,
            'biz_content' => json_encode($requestConfigs),
        );
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        $result = $this->curlPost($orderaddResult['gateway'], $commonConfigs);
        $json = json_decode($result, true);
        $json = $json['alipay_trade_precreate_response'];
        if ($json['code'] && $json['code'] == '10000') {
            M('order')->where(['pay_orderid' => $orderaddResult['orderid']])->save(['pay_status' => 2]);
            $redis = $this->redis_connect(3);
            $redis_date = array(
                'status' => 2,
            );
            $redis->hmset($orderaddResult['orderid'], $redis_date);
            $redis->expire($orderaddResult['orderid'], 180);
            $data['payurl'] = $json['qr_code'];
            $data['money'] = $orderaddResult['amount'];
            $data['orderNo'] = $orderaddResult['orderid'];
            $this->assign('data', $data);
            $this->assign('type', 1);
            $this->display('dmf');
            exit;
        }


        $this->showmessage('通道异常，请稍后再试！');
    }

    // 同步通知
    public function successNotify()
    {
        $msg = '非法操作';
        if (IS_AJAX) {
            $order_no = I('post.trade_no');
            $type = I('post.type');

            $redis = $this->redis_connect(3);
            if (!$redis->hexists($order_no, 'status')) {
                $this->ajaxReturn(array('msg' => '', 'status' => 'expired'));
            }

            $data = $redis->hmGet($order_no, array('amount', 'meme', 'userID', 'status'));
            if ($data['status'] == '2') {
                $this->ajaxReturn(array('msg' => '', 'status' => 'inprogress'));
            } else if ($data['status'] == '4') {
                $this->ajaxReturn(array('msg' => '', 'status' => 'success'));
            }
        }

        $this->ajaxReturn(array('msg' => $msg));
    }

    // 异步通知
    public function notifyUrl()
    {
        $params = $_POST;
        $sign = $params['sign'];
        $signType = $params['sign_type'];

        if ($params['trade_status'] != 'TRADE_SUCCESS') {
            exit('交易未完成');
        }

        $order = M('order')->where(['pay_orderid' => $params['out_trade_no']])->find();
        if (!$order) {
            exit('订单不存在');
        }

        $amount = floatval($order['pay_amount']);
        $amount1 = floatval($params['total_amount']);

        if (abs($amount - $amount1) > 0.01) {
            $this->log("\r\n" . '返回金额错误' . $amount1 . '--订单：' . $params['out_trade_no'] . '接收时间' . date('Y-m-d H:i:s') . "\r\n", UPDATELOG_PATH . 'error.log');
            exit('金额错误');
        }

        $channelAccount = M('channelAccount')->where(['account' => $order['memberid']])->find();
        if (!$channelAccount) {
            exit('账户不存在');
        }
        $this->alipayPublicKey = $channelAccount['signkey3'];
        unset($params['sign_type']);
        unset($params['sign']);
        $result = $this->verify($this->getSignContent($params), $sign, $signType);
        if ($result === true) {
            //处理你的逻辑，例如获取订单号$_POST['out_trade_no']，订单金额$_POST['total_amount']等
            //程序执行完后必须打印输出“success”（不包含引号）。如果商户反馈给支付宝的字符不是success这7个字符，支付宝服务器会不断重发通知，直到超过24小时22分钟。一般情况下，25小时以内完成8次通知（通知的间隔频率一般是：4m,10m,10m,1h,2h,6h,15h）；
            $redis = $this->redis_connect(3);
            $data = $redis->hmGet($order['pay_orderid'], array('status'));
            if ($data) {
                $data['status'] = 4;
                $redis->hmset($order['pay_orderid'], $data);
                $redis->expire($order['pay_orderid'], 180);

            }

            $result = $this->EditMoney($order['pay_orderid'], $params['trade_no'], 0);
            echo 'success';
            exit();
        }
    }

    // 查询
    public function UpQuerryOrder()
    {

        //内部ID 转换为阿里云订单id
        $orderid = I('post.orderid');
        $orderInfo = M('order')->where(['pay_orderid' => $orderid])->find();
        if (!$orderInfo) {
            return $this->sendMessage(['status' => 'warn', 'msg' => ''], 1);
        }
        $channelInfo = M('channelAccount')->where(['account' => $orderInfo['memberid']])->find();
        $this->rsaPrivateKey = $channelInfo['signkey2'];

        // $alipayOrderId 支付宝转账单据号（商户转账唯一订单号、支付宝转账单据号 至少填一个）
        $requestConfigs = array(
            'out_trade_no' => $orderInfo['pay_orderid'],
        );
        $commonConfigs = array(
            //公共参数
            'app_id' => $orderInfo['memberid'],
            'method' => 'alipay.trade.query',             //接口名称
            'format' => 'JSON',
            'charset' => $this->charset,
            'sign_type' => 'RSA2',
            'timestamp' => date('Y-m-d H:i:s', time()),
            'version' => '1.0',
            'biz_content' => json_encode($requestConfigs),
        );
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        $result = $this->curlPost('https://openapi.alipay.com/gateway.do', $commonConfigs);

        $result = json_decode($result, true);

        if ($result['alipay_trade_query_response']['trade_status'] == 'TRADE_SUCCESS') {
            return $this->sendMessage(['status' => 'success', 'msg' => '支付成功，订单金额:' . $result['alipay_trade_query_response']['total_amount']], 1);
        } else {
            return $this->sendMessage(['status' => 'warn', 'msg' => '未支付'], 1);
        }
    }


    //私有


    function verify($data, $sign, $signType = 'RSA')
    {
        $pubKey = $this->alipayPublicKey;
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');
        //调用openssl内置方法验签，返回bool值
        if ("RSA2" == $signType) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res, version_compare(PHP_VERSION, '5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }
//        if(!$this->checkEmpty($this->alipayPublicKey)) {
//            //释放资源
//            openssl_free_key($res);
//        }
        return $result;
    }

    protected function generateSign($params, $signType = "RSA")
    {
        return $this->sign($this->getSignContent($params), $signType);
    }

    protected function sign($data, $signType = "RSA")
    {
        $priKey = $this->rsaPrivateKey;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION, '5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256); //OPENSSL_ALGO_SHA256是php5.4.8以上版本才支持
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }

    protected function getSignContent($params)
    {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, $this->charset);
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset($k, $v);
        return $stringToBeSigned;
    }

    protected function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }

    protected function curlPost($url = '', $postData = '', $options = array())
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    protected function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }
        if ($value === null) {
            return true;
        }
        if (trim($value) === "") {
            return true;
        }
        return false;
    }


}

