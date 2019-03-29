<html>
<head>
    <meta charset="utf-8" />
    <title>会员</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Pay/alipay.css') }}" />
    <link rel="stylesheet" href="https://gw.alipayobjects.com/os/s/prod/i/index-bd57f.css">
    <style>
        .divid{text-align: center;margin-top: 70px}
        .divid a{padding:15px 30px; background: #00a8f2;border-radius: 3px;color:#fff;font-size: 16px}
    </style>
</head>
<body>
<script src="{{ asset('js/alipay.js') }}"></script>
<script>
   function openAlipay() {
        var url = "{!! $url !!}";
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //g
        var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        setTimeout(function () {
            ap .pushWindow({ url : url });
        },50);


    }
    openAlipay();
    ap.onAppResume(function(event) {
        AlipayJSBridge.call("exitApp");
    });

</script>
</body>
</html>
