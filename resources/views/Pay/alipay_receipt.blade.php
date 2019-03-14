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
<body>
<script>
    var userAgent = navigator.userAgent.toLowerCase();
    var url = "{!!  $data['url'] !!}";
    var u = "{{ $data['userID']  }}";
    var a = "{{ $data['account'] }}";

    if(userAgent.match(/Alipay/i)=="alipay") {
         setTimeout("tjhy()", 1);
         function tjhy() {
             window.location.href = "alipays://platformapi/startapp?appId=20000186&actionType=addfriend&userId="+u+"&loginId="+a+"&source=by_f_v&alert=true";
         }
         setTimeout("tz()", 80);
         function tz() {
             window.location.href = url;
         }
    }else{
         window.location.href = "https://render.alipay.com/p/s/i?scheme=";
    }
</script>
</body>
</html>