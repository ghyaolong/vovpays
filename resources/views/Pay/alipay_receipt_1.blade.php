<!DOCTYPE html>
<html>
<head>
    <title>安全支付</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <script src="{{ asset('Hongbao/jquery.min.js') }}"></script>
    <script src="{{ asset('Hongbao/alipayjsapi.inc.min.js') }}"></script>
    <style type="text/css">
        body{padding: 0;margin:0;background-color:#1e9fff;font-family: "microsoft yahei";}
        .pay-main{background-color: #1E9FFF;padding-top: 20px;padding-left: 20px;padding-bottom: 20px;}
        .pay-main img{margin: 0 auto;display: block;}
        .pay-main .lines{margin: 0 auto;text-align: center;color:#54ff00;font-size:12pt;margin-top: 10px;}
        .tips .img{margin: 20px;}
        .tips .img img{width:20px;}
        .tips span{vertical-align: top;color:#1e9fff;padding-left: 10px;padding-top:0px;}
        .action{background:#15d447;padding: 10px 0;color:#ffffff;text-align: center;font-size:14pt;border-radius: 10px 10px; margin: 15px;}
        .action:focus{background:#4cb131;}
        .action.disabled{background-color:#FF0000;}
        .footer{position: absolute;bottom:0;left:0;right:0;text-align: center;padding-bottom: 20px;font-size:10pt;color:#aeaeae;}
        .footer .ct-if{margin-top:6px;font-size:8pt;}
        .jieguo{top:20px;line-height:26px;max-width: 260px;padding:8px 20px;   margin: 0 auto;position: relative;border: 1px #ddd dashed;box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);}
        .text{font-size: 16px;font-weight:bold;color: #f9f900;}
        .jieguo {top: 20px;line-height: 26px;max-width: 260px;padding: 8px 20px;margin: 0 auto;position: relative;border: 1px #ddd dashed;box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);}
    </style>
</head>
<body>
<div class="conainer">
    <div class="pay-main">
        <img src="http://qr.lioo.top/Mobile/pay_logo.png"/>
        <div class="lines"><span id="tips">正在授权中</span></div>
    </div>
    <div id="jieguo" class="jieguo">
        订单： <span style="color: #ffffff"> {{ $data['meme'] }}</span> <br>金额： <span color="#ffffff" id="trdno">{{ $data['amount'] }}</span>
    </div>
    <div class="tips">
        <div class="img">
            <p></p>
        </div>
    </div>
    <br><br>
    <div id='okpay' class='action '>确认支付</div><div class='footer'><div class='ct-if'></div></div>
    <div id='appexit' class='action disabled' style="display:none;">关闭页面</div>
    <div class='footer'>
        <div class='ct-if'></div>
    </div>
</div>
</body>
<script>
    var okpay = document.getElementById('okpay');
    var appexit = document.getElementById('appexit');
    var tradeNOInRedis;
    var queryTradeNOTimer,queryTradeSucTimer;
    var queryTradeNOUrl = "{{ route('pay.getAlipayNorderNo',[$data['meme']]) }}";
    var flag = false;
    $(document).ready(function() {
        //查支付
        function queryTradeSuc() {
            AlipayJSBridge.call('hideLoading');

            $.ajax({
                url: '{{ route('pay.success','exempt') }}',
                data: {"trade_no": "{{$data['meme']}}"},
                type:'get',
                dataType:'json',
                success: function (data) {
                    console.log(data.status );
                    if (data.status == 'success'){
                        window.clearInterval(queryTradeSucTimer);
                        $("#payzt").html("<font color='#48d603'>支付成功</font> ");
                        $("#tips").html("恭喜您,支付成功!")
                        $("#okpay").hide();
                        $("#appexit").show();
                        clearInterval(myTimer);
                    }else{
                        AlipayJSBridge.call('hideLoading');
                    }
                }
            });
        }

        var out = 15;
        setInterval(function(){
            if(out == 0){
                $("#appexit").show();
            }else{
                out--;
            }
        },1000);

        //查订单号

        function queryTradeNO() {
            $.get(queryTradeNOUrl, function (result) {
                if (result.tradeNo) {
                    clearTimeout(queryTradeNOTimer);
                    //alert("拿到订单号："+JSON.stringify(result));
                    tradeNOInRedis = result.tradeNo;
                    flag = true;
                    //alert("拿到订单号："+tradeNOInRedis);
                    $("#tips").html(tradeNOInRedis)
                    $("#okpay").show();
                    AlipayJSBridge.call("tradePay", {
                        tradeNO: tradeNOInRedis,
                        bizType: "biz_account_transfer",
                        bizSubType: "",
                        bizContext: "{\"business_scene\":\"qrpay\"}"
                    }, function (result) {
                        AlipayJSBridge.call('hideLoading');
                    });
                    if (tradeNOInRedis) {
                        //开始查支付状态
                        queryTradeNOTimer = setInterval(queryTradeSuc, 1000);
                    }

                }
            }, "json");
        }

        //查订单号
        queryTradeNOTimer = setInterval(queryTradeNO, 1000);

        appexit.onclick = function () {
            AlipayJSBridge.call('exitApp');
        }


        okpay.onclick = function() {
            if(tradeNOInRedis){
                var  gopayUrl= 'alipays://platformapi/startapp?appId=20000003&actionType=toBillDetails&tradeNO=' + tradeNOInRedis;
                AlipayJSBridge.call('pushWindow', {
                    url : gopayUrl
                });
            }
        }
    });

    function ready(a) {
        window.AlipayJSBridge ? a && a() : document
            .addEventListener("AlipayJSBridgeReady", a, !1)
    }

    //导航栏颜色
    AlipayJSBridge.call("setTitleColor", {
        color : parseInt('1E9FFF', 16),
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