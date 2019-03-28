<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>安全支付</title>
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
<body>
<div>
    <a href="javascript: void(0);" class="aui-button" style="top: 40px">
        <button id="gopay">立即支付</button>
    </a>
</div>
<script>
    var type = "{{ $data['type'] }}";
    function ready(a) {
        window.AlipayJSBridge ? a && a() : document.addEventListener("AlipayJSBridgeReady", a, !1)
    }

    ready(function () {
        if(type == 'taobao'){
            goTaobao();
        }else{
            intervalID = window.setInterval(flashText, 1000);
        }

    });
    
    function gopay() {
        ap .pushWindow({url:"{!! $data['url'] !!}"});
    }
    
    function goTaobao() {
        var u = window.navigator.userAgent;
        if (/iphone|iPhone|ipad|iPad|ipod|iPod/.test(u)) {
            location.href = "{{ $data['url'] }}";
        } else {
            AlipayJSBridge.call('pushWindow', {
                url: "{{ $data['url'] }}",
                param: { readTitle: true, showOptionMenu: false }
            });
        }
    }
    var nowcount=60;
    function flashText() {
        $("#gopay").text(nowcount+'秒内自动启动支付'); // 只支持修改文本
        nowcount=nowcount-1;
        if(nowcount<=0){
            clearInterval(intervalID);
            gopay();
        }
    }

    ap.onAppResume(function(event) {
        AlipayJSBridge.call( "exitApp");
    });
</script>
</body>
</html>