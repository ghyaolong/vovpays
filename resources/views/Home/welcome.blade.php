<!DOCTYPE html>
<!-- saved from url=(0060)http://bank.iswoole.com/gateway/pay/automaticBank.do?id=1884 -->
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title>在线支付 - 支付宝 - 网上支付 安全快速！</title>
    <link rel="stylesheet" type="text/css" href="http://bank.iswoole.com/run/gateway/view/static/css/mobile/QRCode.css">
    <script type="text/javascript" src="http://bank.iswoole.com/run/gateway/view/static/css/alipay/jquery.min.js"></script><style type="text/css" abt="234"></style>
    <script type="text/javascript" src="http://bank.iswoole.com/run/gateway/view/static/js/qrcode.js"></script>
    <script type="text/javascript" src="http://bank.iswoole.com/run/gateway/view/static/js/layer/layer.js"></script>
    <link rel="stylesheet" href="http://bank.iswoole.com/run/gateway/view/static/js/layer/theme/default/layer.css" id="layuicss-layer">
    <script type="text/javascript" src="http://bank.iswoole.com/static//js/qqapi.js"></script>
</head>
<body>
<div style="width: 100%; text-align: center;font-family:微软雅黑;">
    <div id="panelWrap" class="panel-wrap">
        <!-- CUSTOM LOGO -->
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="http://bank.iswoole.com/run/gateway/view/static/css/mobile/T1HHFgXXVeXXXXXXXX.png" alt="Logo-QQPay" class="img-responsive center-block">
                </div>

            </div>
        </div>
        <!-- PANEL TlogoEMPLATE START -->
        <div class="panel panel-easypay">
            <!-- PANEL HEADER -->
            <div class="panel-heading">
                <h3>
                    <small>订单号：160792019012448564848<br>重复扫码不到帐，请只支付一次</small>

                </h3>
                <div class="money">
                    <span class="price">0.99</span>
                    <span class="currency">元</span>
                </div>
            </div>
            <div class="panel-footer">
                <input type="button" id="btnDL" onclick="pay('http://bank.iswoole.com/gateway/pay/automaticBank.do?id=1884')" value="立即支付(0时02分45秒)" class="btn  btn-primary btn-lg btn-block">
            </div>

            <div class="qrcode-warp">
                <div id="qrcode">

                    <canvas width="256" height="256" style="display: none;"></canvas><img alt="Scan me!" src="data:image/png;base64,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" style="display: block;"></div>
            </div>
            <div class="panel-footer">
                <!-- SYSTEM MESSAGE -->
                <span id="Span1" class="warning" style="color:red;font-size:50px"><b><small>如果不能启动启动宝APP，请按下面步骤 <br> 1.请先截屏保存二维码到手机 <br> 2.打开支付宝，扫一扫本地图片</small></b></span>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    var u = navigator.userAgent;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端

</script>
<script type="text/javascript">
    var intDiff = parseInt('216');//倒计时总秒数量
    function timer(intDiff) {
        window.setInterval(function () {
            var day = 0,
                hour = 0,
                minute = 0,
                second = 0;//时间默认值
            if (intDiff > 0) {
                day = Math.floor(intDiff / (60 * 60 * 24));
                hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
            }
            //if (minute == 00 && second == 00) document.getElementById('qrcode').innerHTML='<br/><br/><br/><br/><br/><br/><br/><h2>二维码超时 请重新发起交易</h2><br/>';
            if (minute <= 9) minute = '0' + minute;
            if (second <= 9) second = '0' + second;
            //$('#day_show').html(day+"天");
            //$('#hour_show').html('<s id="h"></s>'+hour+'时');
            //$('#minute_show').html('<s></s>'+minute+'分');
            //$('#btnDL').valu('<s></s>'+second+'秒');
            $('#btnDL').val("立即支付(" + hour + '时' + minute + '分' + second + '秒' + ')');
            intDiff--;
        }, 1000);
    }

    $(function () {
        timer(intDiff);
    });


    var updateQrImg = 0;
    var is_new_version = 0;

    //订单监控  {订单监控}
    function order() {
        $.get("http://bank.iswoole.com/gateway/pay/automatiBankQuery.do?id=1884", function (result) {
            //成功
            if (result.code == '200') {
                play(['FILE_CACHE/download/sound/当前订单支付成功1.mp3']);
                //回调页面
                window.clearInterval(orderlst);
                layer.confirm(result.msg, {
                    icon: 1,
                    title: '支付成功',
                    btn: ['我知道了'] //按钮
                }, function () {
                    location.href = "bank.iswoole.com/php";
                });
                setTimeout(function () {
                    location.href = "bank.iswoole.com/php";
                }, 5000);
            }
            //支付二维码
            if (result.code == '100' && updateQrImg == 0) {
                play(['FILE_CACHE/download/sound/处理完成打开支付宝1.mp3']);
                $('#qrcode_load').remove();
                $('#btnDL').attr('onclick', 'pay("' + result.data.qrcode + '")');
                $('#btnDL').attr('disabled', false);
                //设置参数方式
                var qrcode = new QRCode('qrcode', {
                    text: result.data.qrcode,
                    width: 256,
                    height: 256,
                    colorDark: '#000000',
                    colorLight: '#ffffff',
                    correctLevel: QRCode.CorrectLevel.H
                });

                window.location.href = "alipays://platformapi/startapp?saId=10000007&clientVersion=3.7.0.0718&qrcode=" + encodeURI(result.data.qrcode);


                updateQrImg = 1;
            }
            //订单已经超时
            if (result.code == '-1' || result.code == '-2') {
                play(['FILE_CACHE/download/sound/订单超时1.mp3']);
                window.clearInterval(orderlst);
                layer.confirm(result.msg, {
                    icon: 2,
                    title: '支付失败',
                    btn: ['确认'] //按钮
                }, function () {
                    location.href = "bank.iswoole.com/php";
                });
            }
        });
    }

    //周期监听
    var orderlst = setInterval("order()", 1000);
    function pay(url) {
        window.location.href = "alipays://platformapi/startapp?saId=10000007&clientVersion=3.7.0.0718&qrcode=" + encodeURI(url);
    }

</script>
<script type="text/javascript" src="http://bank.iswoole.com/static//js/jike.js"></script>
<script type="text/javascript">play(['FILE_CACHE/download/sound/请稍等1.mp3']);</script>
<span style="padding: 0px; margin: 0px;"><audio id="sound" src="FILE_CACHE/download/sound/处理完成打开支付宝1.mp3" preload="" style="width:0px;height:0px;display:none;"></audio></span></body></html>