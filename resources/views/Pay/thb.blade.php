<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" name="viewport">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <script src="{{ asset('Hongbao/jquery.min.js') }}"></script>
    <script src="{{ asset('Hongbao/alipayjsapi.inc.min.js') }}"></script>
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

        .aui-flex{
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 25px;
        }
        .aui-user-img{
            margin-right: 25px;
        }
        .aui-user-img img{
            width: 50px;
            height: 50px;
        }
        .aui-flex-box{
            /*margin-left: 25px;*/
        }
        .aui-flex-box h5{
            margin: 0;
            margin-bottom: 5px;
            font-size: 16px;
        }
        .aui-flex-box p{
            margin: 0;
            color: white;
            padding-top: 3px;
            font-size: 18px;
        }
        .b-line{
            border-bottom: 1px solid #e4c1c1;
            padding-bottom: 15px;
            margin: 0 10px;
        }
        .aui-change-flex{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .aui-flex-change-box{
            text-align: center;
            color: white;
        }
        .aui-flex-change-box h2{
            font-size: 15px;
            font-weight: normal;
            color: e4c1c1;
        }
        .aui-flex-change-box h3{
            font-size: 2.1rem;
            font-weight: normal;
            margin: 0;
        }
        .aui-flex-change-box p{
            font-size: 12px;
            color: #e4c1c1;
        }
        .aui-button{
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .aui-button button{
            width: 70%;
            height: 48px;
            background: #E9CE99;
            border: 1px solid #E9CE99;
            border-radius: 10px;
            font-size: 16px;
            box-shadow: 0 0 10px #f7cb76;
        }

        .am-process-item {
            display: flex;
            margin: 0 15px;
        }

        .am-process{
            margin-top: 20px;
            padding-bottom: 16px;
        }
        .pay img{
            width: 30px;
            height: 135px;
            margin-right: 10px;
        }
        .success img{
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
        .am-fixed-bottom{
            margin-top: 50px;
            text-align: center;
            width: 100%;
        }

        .am-footer-copyright{
            color: white;
        }
        .am-process-brief{
            color: white;
            margin-top: 5px;
        }
        .am-footer-link{

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
    </style>
</head>
<div class="aui-free-head">
    <div class="aui-flex b-line">
        <div class="aui-flex-box">
            <p>请遵循以下条款</p>
        </div>
    </div>
    <div id="xxx" class="aui-flex aui-flex-text">
        <div class="aui-flex-box">
            <h5>充值金额: ￥{{ $data['amount'] }}</h5>
            <p>充单号：{{ $data['meme'] }}</p>
        </div>
    </div>
    <a class="aui-button">
        <button id="payBtn" onclick="goAliPay()" >获得官方支付授权..</button>
    </a>
    <div class="am-process">
        <div class="am-process-item pay">
            <div class="am-process-content">
                <div class="am-process-brief">提示【商户异常】请尝试手动点击支付</div>
            </div>
            <div class="am-process-down-border"></div>
        </div>
        <div class="am-process-item pay">
            <div class="am-process-content">
                <div class="am-process-brief">多次尝试后无法支付，请重新下单</div>
            </div>
            <div class="am-process-down-border"></div>
        </div>
    </div>
</div>
<script>
    var pageWidth = window.innerWidth;
    var pageHeight = window.innerHeight;

    if (typeof pageWidth != "number") {
        //在标准模式下面
        if (document.compatMode == "CSS1Compat") {
            pageWidth = document.documentElement.clientWidth;
            pageHeight = document.documentElement.clientHeight;
        } else {
            pageWidth = document.body.clientWidth;
            pageHeight = window.body.clientHeight;
        }
    }
    $('body').height(pageHeight);
</script>
<script>
    ap.allowPullDownRefresh(false);
    ap.onPullDownRefresh(function(res){
        if(!res.refreshAvailable){
            ap.alert({
                content: '刷新已禁止',
                buttonText: '恢复'
            }, function(){
                ap.allowPullDownRefresh(true);
                ap.showToast('刷新已恢复')
            });
        }
    });

    var queryTradeNOTimer,tradeNOInRedis;
    var queryTradeNOUrl = "{{ route('pay.getAlipayNorderNo',[$data['meme']]) }}";

    $(function () {
        $("#payBtn").attr("disabled",false);
        //  goAliPay();
    });

    //查订单号
    queryTradeNOTimer = setInterval(queryTradeNO, 1000);

    //查订单号
    function queryTradeNO() {
        $.get(queryTradeNOUrl, function (result) {
            if (result.tradeNo) {
                clearTimeout(queryTradeNOTimer);
                //alert("拿到订单号："+JSON.stringify(result));
                tradeNOInRedis = result.tradeNo;
                //alert("拿到订单号："+tradeNOInRedis);
                $("#payBtn").attr("disabled",true);
            }
        }, "json");
    }

    function goAliPay() {
        var orderStr = tradeNOInRedis;
        ap.tradePay({
            orderStr:orderStr
        }, function(result){
            if(result.resultCode==9000||result.resultCode=="9000"){
                alert("支付已完成");
                AlipayJSBridge.call('exitApp');
            }
        });
    }
    window.onload = function() {
        var msglist = new Array();
        msglist[0] = '主人等等我';
        msglist[1] = '我正在与马云联系中';
        msglist[2] = '客观别着急哦';
        msglist[3] = '我正卖力申请授权中';
        msglist[4] = '眼神相互确认中，请稍候。';
        msglist[5] = '小哥哥小姐姐马上就授权完';
        msglist[6] = '如果提示【商户异常】请尝试手动点击支付';
        var timecount = 1;
        var timenum = 40;
        timeid = window.setInterval(function () {
            if (timecount >= timenum) {
                $("#payBtn").attr("disabled",false);
                $("#payBtn").removeAttr("disabled");
                $('#payBtn').html('开始支付');
                window.clearInterval(timeid);
            } else {
                timecount++;
                $('#payBtn').html('预计 <span style="color:red;">' + (timenum - timecount) + '</span>秒后获得官方支付授权..');
            }


        }, 1500);
    }

    //导航栏颜色
    AlipayJSBridge.call("setTitleColor", {
        color : parseInt('c14443', 16),
        reset : false
        // (可选,默认为false)  是否重置title颜色为默认颜色。
    });
    //导航栏loadin
    AlipayJSBridge.call('showTitleLoading');
    //副标题文字
    AlipayJSBridge.call('setTitle', {
        title : '支付收银台',
        subtitle : '安全支付'
    });
    //右上角菜单
    AlipayJSBridge.call('setOptionMenu', {
        icontype : 'filter',
    });
    AlipayJSBridge.call('showOptionMenu');
    document.addEventListener('optionMenu', function(e) {
        AlipayJSBridge.call('showPopMenu', {
            menus : [ {
                name : "查看帮助",
                tag : "tag1",
            }, {
                name : "我要投诉",
                tag : "tag2",
            } ],
        }, function(e) {
            console.log(e);
        });
    }, false);
</script>
</html>
