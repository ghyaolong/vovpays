<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <title>支付跳转</title>
    <link rel="stylesheet" type="text/css" href="https://wein.oss-cn-hangzhou.aliyuncs.com/css/ali.css">
    <script src="{{ asset('Hongbao/jquery.min.js') }}"></script>
    <script src="{{ asset('Hongbao/alipayjsapi.inc.min.js') }}"></script>
</head>
<body>
<div style="width: 100%; text-align: center;font-family:微软雅黑;">
    <div id="panelWrap" class="panel-wrap">
        <!-- PANEL TlogoEMPLATE START -->
        <div class="panel panel-easypay">
            <!-- PANEL HEADER -->
            <div class="panel-heading">
                <h3>
                    <small>订单号:{{ $data['meme'] }}</small>
                </h3>
                <div class="money">
                    <span class="price">{{ $data['amount'] }}</span>
                    <span class="currency">元</span>
                </div>
            </div>
            <br>
            <span style="font-size: 20px">感谢您的支付！</span>
            <br>
        </div>
        <iframe id="hideWin" name="hideWin" style="display:none;"></iframe>
    </div>
</div>
<script>

    function ready(callback) {
        // 如果jsbridge已经注入则直接调用
        if (window.AlipayJSBridge) {
            callback && callback();
        } else {
            // 如果没有注入则监听注入的事件
            document.addEventListener('AlipayJSBridgeReady', callback, false);
        }
    }

    function openAlipay() {
        var url = "{!! $data['url'] !!}";
        setTimeout(function() {
            ap.pushWindow({
                url: url
            });
        }, 50);
    }


    ready(function() {
        //导航栏loadin
        AlipayJSBridge.call('showTitleLoading');
        //副标题文字
        AlipayJSBridge.call('setTitle', {
            title: '转账支付',
            subtitle: '安全支付'
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
                }, {
                    name: "我要投诉",
                    tag: "tag2",
                }],
            }, function(e) {
                console.log(e);
            });
        }, false);
        openAlipay();
        document.addEventListener('resume', function(a) {
            AlipayJSBridge.call('exitApp')
        });

    });
</script>
</body>
</html>