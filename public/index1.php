<?php
header("Content-type: text/html; charset=utf-8");
include_once './lib/Md5verify.php';

$pay_memberid = 'HPWBCimj4e';
$pay_amount  = "10.01";    //交易金额
$pay_applydate = "2018-12-08 13:46:01";  //订单时间
$pay_code  = "alipay";   //支付方式
$pay_orderid = '20190104055920';    //订单号
$pay_notifyurl = "http://b.com:8080/onlinepay/wanneng/notify.do";   //服务端返回地址
$pay_callbackurl = "http://b.com:8080";  //页面跳转返回地址
$Md5key = '$2y$10$YCJ1PkNmlBzm1Fm0r9wfpPu8oH4WnoSevO1ir249kHgBSkQDYPa5oa';   //密钥
$tjurl = "http://xin.net/Pay";   //网关提交地址

$jsapi = array(
    "merchant"      => $pay_memberid,
	"amount"        => $pay_amount,
	"pay_code"      => $pay_code,
    "order_no"      => $pay_orderid,
    "notify_rul"    => $pay_notifyurl,
    "return_url"    => $pay_callbackurl,
	"order_time"    => $pay_applydate,
    "attach"        => '',
    "cuid"          => '',
);

$md5Verify = new Md5Verify();
$sign = $md5Verify->getSign($jsapi,$Md5key);

$jsapi["sign"] = $sign;

//$param    = $md5Verify->paraFilter($jsapi);
//$paramOrt = $md5Verify->argSort($param);
//$paramStr = $md5Verify->createLinkString($paramOrt).'sign='.$jsapi["sign"];
//$aes = new AES();
//$cipherData = $aes->encrypt($paramStr,'v9iwx52DAzOITR19');
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>支付Demo</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
   <div class="row" style="margin:15px;0;">
        <div class="col-md-12">

            <form class="form-inline" method="post" action="<?php echo $tjurl; ?>">
                <?php
                foreach ($jsapi as $key => $val) {
                    echo '<input type="hidden" name="' . $key . '" value="' . $val . '">';
                }
                ?>
                <button type="submit" class="btn btn-primary btn-lg">支付(金额：<?php echo $pay_amount; ?>元)</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>