<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <script src="{{ asset('Hongbao/jquery.min.js') }}"></script>
    <style type="text/css" abt="234"></style>
    <link href="{{ asset('Hongbao/hipay.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('Hongbao/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('Hongbao/alipayjsapi.inc.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
</head>
<style type="text/css">
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background: #c14443;
        overflow: hidden;
    }
</style>
<style>
    .demo {
        margin: 1em 0;
        padding: 1em 1em 2em;
        background: #fff;
    }

    .demo h1 {
        padding-left: 8px;
        font-size: 24px;
        line-height: 1.2;
        border-left: 3px solid #108EE9;
    }

    .demo h1,
    .demo p {
        margin: 1em 0;
    }

    .demo .am-button + .am-button,
    .demo .btn + .btn,
    .demo .btn:first-child {
        margin-top: 10px;
    }

    .fn-hide {
        display: none !important;
    }

    input {
        display: block;
        padding: 4px 10px;
        margin: 10px 0;
        line-height: 28px;
        width: 100%;
        box-sizing: border-box;
    }
    .aui-free-head{
        height: 333px;
    }

    *{margin: 0;padding: 0;box-sizing: border-box;}
    ul{padding:0.5rem .2rem;margin:0;}ul li{padding:0 .25rem .2rem .25rem;font-size: .33rem;}ul li span{color:#fff;display: inline-block;width: 100%;height: .5rem;line-height: .5rem;}
    ul li i{font-style: normal;color:#fff;display: inline-block;width: 100%;height: .5rem;line-height: .5rem;}

</style>
<body>
@if(isset($flag))

@else
    <div class="aui-free-head">
        <div class="aui-flex b-line">
            <div class="aui-user-img">
                <img src="{{ asset('Hongbao/tx.jpeg') }}" alt="">
            </div>

            <div class="aui-flex-box">
                <p>自动收款</p>
                <p id="xxxx">付款成功后将自动充值到账</p>
            </div>
        </div>
        <div id="xxx" class="aui-flex aui-flex-text">
            <div class="aui-flex-box">
                <h2>充值金额</h2>
                <h3>￥{{ $data['amount'] }}</h3>
                <p>充单号：{{ $data['meme'] }}</p>
            </div>
        </div>
        <a href="javascript:add();" class="aui-button">
            <button id="gopay">立即支付</button>
        </a>
    </div>
    <div class="am-process">
        <div class="am-process-item pay"><i class="am-icon process pay" aria-hidden="true"></i>
            <div class="am-process-content">
                <div class="am-process-main">①立即支付</div>
                <div class="am-process-brief">进入聊天界面，等待收款人发送付款链接给你</div>
            </div>
            <div class="am-process-down-border"></div>
        </div>
        <div class="am-process-item pay"><i class="am-icon process success" aria-hidden="true"></i>
            <div class="am-process-content">
                <div class="am-process-main">②点击向你收款</div>
                <div class="am-process-brief">支付</div>
            </div>
            <div class="am-process-up-border"></div>
            <div class="am-process-down-border"></div>
        </div>
        <div class="am-process-item success"><i class="am-icon process success" aria-hidden="true"></i>
            <div class="am-process-content">
                <div class="am-process-main">③支付成功</div>
            </div>
            <div class="am-process-up-border"></div>
        </div>
        <footer class="am-footer am-fixed am-fixed-bottom">
            <div class="am-footer-copyright">Copyright © 2008-2016 AliPay</div>
        </footer>
    </div>
@endif


<script>
    var userAgent = navigator.userAgent.toLowerCase();

    //导航栏颜色
    AlipayJSBridge.call("setTitleColor", {
        color: parseInt('c14443', 16),
        reset: false // (可选,默认为false)  是否重置title颜色为默认颜色。
    });
    //导航栏loadin
    AlipayJSBridge.call('showTitleLoading');
    //副标题文字
    AlipayJSBridge.call('setTitle', {
        title: '支付完成后，请点击此处退出',
        subtitle: '支付完成后，请点击此处退出'
    });
    //右上角菜单
    AlipayJSBridge.call('setOptionMenu', {
        icontype: 'filter',
        redDot: '01', // -1表示不显示，0表示显示红点，1-99表示在红点上显示的数字
    });
    AlipayJSBridge.call('showOptionMenu');
    document.addEventListener('optionMenu', function(e) {
        AlipayJSBridge.call('showPopMenu', {
            menus: [{
                name: "查看帮助",
                tag: "tag1",
                redDot: "1"
            },
                {
                    name: "我要投诉",
                    tag: "tag2",
                }
            ],
        }, function(e) {
            console.log(e);
        });
    }, false);


    var can_pay = false;
    var count   = 3;

    window.setInterval(function () {
        if(count<=0){
            can_pay = true;
            $('#gopay').disabled=false;
            $('#gopay').text("立即支付");
            return true;
        }
        can_pay = false;
        $('#gopay').disabled=true;
        $('#gopay').text("支付宝授权中,请稍后("+count+")");
        count--;
    }, 1000);

    var u = "{{ $data['userID']  }}";
    var a = "{{ $data['account'] }}";

    var url2 ='alipays://platformapi/startapp?appId=20000167&forceRequest=0&returnAppId=recent&tLoginId='+a+'&tUnreadCount=0&tUserId='+u+'&tUserType=1';
    function add() {
        if(can_pay==false){
            ap.showToast('请稍后');
            return false;
        }
        tz();
    }

    function tz() {
        //跳聊天
        AlipayJSBridge.call('pushWindow', { url: url2 });
    }

</script>
</body>
</html>