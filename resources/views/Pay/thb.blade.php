


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title></title>
    <style>
        html, body {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #ffffff;
        }

        .container {
            background: #ffffff;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .container .content {
            /* flex-grow: 0;*/
        }

        .container .card {

        }

        .container .card .card-title {
            margin-top: 15px;
            font-size: 14px;
            color: #969696;
            border-bottom: 1px solid #e7e7e7;
            /*box-shadow: 0 1px 5px #e7e7e7;*/
            padding: 0 15px;
        }

        .container .pay-step {
            color: #717174;
            padding: 8px 10px;
            font-size: 18px;
            border-bottom: 1px solid #e5e5e5;
        }
        .container .click-tip {
            padding: 18px;
            text-align: center;
            color: #FFFFFF;
            font-size: 15px;
            margin: 10px;
            background-color: red;
            border-top: 1px solid #eaeaea;
        }

        .button::-moz-focus-inner {
            border: 0;
            padding: 0;
        }

        .button {
            display: inline-block;
            *display: inline;
            zoom: 1;
            padding: 6px 20px;
            margin: 0;
            cursor: pointer;
            border: 1px solid #bbb;
            overflow: visible;
            font: bold 13px arial, helvetica, sans-serif;
            text-decoration: none;
            white-space: nowrap;
            color: #555;

            background-color: #ddd;
            background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 1)), to(rgba(255, 255, 255, 0)));
            background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: -ms-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: -o-linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));
            background-image: linear-gradient(top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0));

            -webkit-transition: background-color .2s ease-out;
            -moz-transition: background-color .2s ease-out;
            -ms-transition: background-color .2s ease-out;
            -o-transition: background-color .2s ease-out;
            transition: background-color .2s ease-out;
            background-clip: padding-box; /* Fix bleeding */
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, .3), 0 2px 2px -1px rgba(0, 0, 0, .5), 0 1px 0 rgba(255, 255, 255, .3) inset;
            -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, .3), 0 2px 2px -1px rgba(0, 0, 0, .5), 0 1px 0 rgba(255, 255, 255, .3) inset;
            box-shadow: 0 1px 0 rgba(0, 0, 0, .3), 0 2px 2px -1px rgba(0, 0, 0, .5), 0 1px 0 rgba(255, 255, 255, .3) inset;
            text-shadow: 0 1px 0 rgba(255, 255, 255, .9);

            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .button:hover {
            background-color: #eee;
            color: #555;
        }

        .button:active {
            background: #e9e9e9;
            position: relative;
            top: 1px;
            text-shadow: none;
            -moz-box-shadow: 0 1px 1px rgba(0, 0, 0, .3) inset;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .3) inset;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .3) inset;
        }

        .button[disabled], .button[disabled]:hover, .button[disabled]:active {
            border-color: #eaeaea;
            background: #fafafa;
            cursor: default;
            position: static;
            color: #999;
            /* Usually, !important should be avoided but here it's really needed :) */
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }

        /* Smaller buttons styles */

        .button.small {
            padding: 4px 12px;
        }


        .button.large {
            padding: 12px 30px;
            text-transform: uppercase;
        }

        .button.large:active {
            top: 2px;
        }


        .button.green, .button.red, .button.blue {
            color: #fff;
            text-shadow: 0 1px 0 rgba(0, 0, 0, .2);

            background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, .3)), to(rgba(255, 255, 255, 0)));
            background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, .3), rgba(255, 255, 255, 0));
            background-image: -moz-linear-gradient(top, rgba(255, 255, 255, .3), rgba(255, 255, 255, 0));
            background-image: -ms-linear-gradient(top, rgba(255, 255, 255, .3), rgba(255, 255, 255, 0));
            background-image: -o-linear-gradient(top, rgba(255, 255, 255, .3), rgba(255, 255, 255, 0));
            background-image: linear-gradient(top, rgba(255, 255, 255, .3), rgba(255, 255, 255, 0));
        }

        /* */

        .button.green {
            background-color: #57a957;
            border-color: #57a957;
        }

        .button.green:hover {
            background-color: #62c462;
        }

        .button.green:active {
            background: #57a957;
        }

        /* */

        .button.red {
            background-color: #ca3535;
            border-color: #c43c35;
        }

        .button.red:hover {
            background-color: #ee5f5b;
        }

        .button.red:active {
            background: #c43c35;
        }

        /* */

        .button.blue {
            background-color: #269CE9;
            border-color: #269CE9;
        }

        .button.blue:hover {
            background-color: #70B9E8;
        }

        .button.blue:active {
            background: #269CE9;
        }

        /* */

        .green[disabled], .green[disabled]:hover, .green[disabled]:active {
            border-color: #57A957;
            background: #57A957;
            color: #D2FFD2;
        }

        .red[disabled], .red[disabled]:hover, .red[disabled]:active {
            border-color: #C43C35;
            background: #C43C35;
            color: #FFD3D3;
        }

        .blue[disabled], .blue[disabled]:hover, .blue[disabled]:active {
            border-color: #269CE9;
            background: #269CE9;
            color: #93D5FF;
        }

        /* Group buttons */

        .button-group,
        .button-group li {
            display: inline-block;
            *display: inline;
            zoom: 1;
        }

        .button-group {
            font-size: 0; /* Inline block elements gap - fix */
            margin: 0;
            padding: 7px 0px 7px 0px;
            background: rgba(0, 0, 0, .1);
            border-bottom: 1px solid rgba(0, 0, 0, .1);
            -moz-border-radius: 7px;
            -webkit-border-radius: 7px;
            border-radius: 7px;
            width: 100%;
        }

        .button-group li {
            width: 50%;
            text-align: center;
            margin-right: -1px; /* Overlap each right button border */
        }

        .button-group .button {
            font-size: 13px; /* Set the font size, different from inherited 0 */
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            border-radius: 0;

            text-align: center;
        }

        .button-group .button:active {
            -moz-box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, 5px 0 5px -3px rgba(0, 0, 0, .2) inset, -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
            -webkit-box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, 5px 0 5px -3px rgba(0, 0, 0, .2) inset, -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
            box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, 5px 0 5px -3px rgba(0, 0, 0, .2) inset, -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
        }

        .button-group li:first-child .button {
            -moz-border-radius: 3px 0 0 3px;
            -webkit-border-radius: 3px 0 0 3px;
            border-radius: 3px 0 0 3px;
        }

        .button-group li:first-child .button:active {
            -moz-box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
            -webkit-box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
            box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, -5px 0 5px -3px rgba(0, 0, 0, .2) inset;
        }

        .button-group li:last-child .button {
            -moz-border-radius: 0 3px 3px 0;
            -webkit-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
        }

        .button-group li:last-child .button:active {
            -moz-box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, 5px 0 5px -3px rgba(0, 0, 0, .2) inset;
            -webkit-box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, 5px 0 5px -3px rgba(0, 0, 0, .2) inset;
            box-shadow: 0 0 1px rgba(0, 0, 0, .2) inset, 5px 0 5px -3px rgba(0, 0, 0, .2) inset;
        }
    </style>
</head>
<body huaban_collector_injected="true">
<br>
<br>
<br>
<div class="container">
    <main class="content">
        <div class="card">
            <div class="card-title" style="text-align:center;height: 180px;">
                <div class="card-title" style="text-align:center;height: 200px;">
                    订单金额
                    <br>
                    <br>
                    <span style="color:red;font-size: 35px;height: 45px;">￥{{ $data['amount'] }}</span>元
                    <br>
                    <br>
                    <button id="J_btn" class="click-tip large red button"
                            style="display:block;margin:0 auto;margin-top: 9px">点击这里立即支付
                    </button>
                </div>
            </div>
        </div>
    </main>
    <main class="content" >
        <div class="card">
            <div class="pay-step">
                <span style="color:red;font-weight: bold;font-size: 18px;"> </span>
            </div>
            <div class="pay-step">
                <span style="color:red;font-weight: bold;font-size: 18px;">* 1.提示【商户异常】请尝试手动点击支付!</span>
            </div>
            <div class="pay-step">
                <span style="color:red;font-weight: bold;font-size: 18px;">* 2.手动点击支付,还是异常,请重新扫码!</span>
            </div>
            <div class="pay-step">
                <span style="color:red;font-weight: bold;font-size: 18px;">* 3.多次尝试后无法支付,请重新下单!</span>
            </div>
        </div>
    </main>
</div>
<script>
    //导航栏颜色
    AlipayJSBridge.call("setTitleColor", {
        color: parseInt('349afd', 16),
        reset: false // (可选,默认为false)  是否重置title颜色为默认颜色。
    });
    //导航栏loadin
    AlipayJSBridge.call('showTitleLoading');
    //副标题文字
    AlipayJSBridge.call('setTitle', {
        title: '支付宝-自助充值系统',
        subtitle: '请放心支付'
    });
    //右上角菜单
    AlipayJSBridge.call('setOptionMenu', {
        icontype: 'filter',
    });
    AlipayJSBridge.call('showOptionMenu');
    document.addEventListener('optionMenu', function (e) {
        AlipayJSBridge.call('showPopMenu', {
            menus: [{
                name: "查看帮助",
                tag: "tag1",
            },
                {
                    name: "我要投诉",
                    tag: "tag2",
                }
            ],
        }, function (e) {
            console.log(e);
        });
    }, false);

    function javascrip() {
        history.go(0);
    }
</script>
<script src="{{ asset('Hongbao/jquery.min.js') }}"></script>
<script src="{{ asset('Hongbao/alipayjsapi.inc.min.js') }}"></script>
<script>

    var queryTradeNOTimer,tradeNOInRedis;
    var queryTradeNOUrl = "{{ route('pay.getAlipayNorderNo',[$data['meme']]) }}";

    var btn = document.querySelector('#J_btn');

    btn.addEventListener('click', function(){
        if(tradeNOInRedis){
            pay();
        }else{
            alert('请稍后');
        }

    });
    function pay() {
        ap.tradePay({
            orderStr: tradeNOInRedis
        }, function(res){
            if (res.resultCode==9000||res.resultCode=="9000") {
                alert("支付宝成功");
                AlipayJSBridge.call('exitApp');
            }
        });
    }

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
                pay();
            }
        }, "json");
    }

</script>
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
</script>
</body>
</html>