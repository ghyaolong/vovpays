@section('css')
    <link rel="shortcut icon" href="favicon.ico">
    <link href="{{ asset('Front/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Front/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Front/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('Front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('Front/css/style1.css') }}" rel="stylesheet">
    <link href="{{ asset('Front/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('Front/css/layui.css') }}" rel="stylesheet">
@endsection('css')
<style>
    .layui-form-label {width:110px;padding:4px}
    .layui-form-item .layui-form-checkbox[lay-skin="primary"]{margin-top:0;}
    .layui-form-switch {width:54px;margin-top:0px;}
</style>
@extends('Admin.Layouts.layout')
@section('content')
    <div class="main" style="padding-left: 0px;">
        <div class="div-nav">
            <ul class="top-nav bigbox">
                <ul class="nav nav-second-level">
                    <a href="/Viphouwei_Users_order.html" target="iframe0" class="J_menuItem"><li class="top-title active">交易订单</li></a>
                    <a href="/Viphouwei_Users_withdrawal.html" target="iframe0" class="J_menuItem"><li class="top-title active">提款记录</li></a>
                    <a href="/Viphouwei_Users_changeRecord.html" target="iframe0" class="J_menuItem"><li class="top-title active">资金变动记录</li></a>
                    <a href="{{ url('admin/user/index') }}" target="iframe0" class="J_menuItem"><li class="top-title active">商户列表</li></a>
                </ul>
                <li class="line"></li>
                <li class="line"></li>
            </ul>
        </div>
        <div class="main-content" style="margin-left: 0px;">
            <iframe class="J_iframe" name="iframe0" src="{{ url('admin/user/index') }}" data-id="/Viphouwei_Users_order.html" seamless="" width="100%" height="700px" frameborder="0">
            </iframe>
        </div>
    </div>
@endsection('content')
@section('scripts')
    <script src="{{ asset('Front/js/jquery.min.js') }}"></script>
    <script src="{{ asset('Front/js/layui.all.js') }}" charset="utf-8"></script>
    <script src="{{ asset('Front/js/x-layui.js') }}"></script>
    <script>
        var width=$(".top-title").eq(0).width();
        $(".line").css("width",width);
        $(".top-title").click(function(){
            var left=$(this).position().left;
            $(".line").css("left",left);
            $(".top-title").removeClass("active");
            $(".top-title a").css("color","rgb(51,51,51)");
            $(this).find(".J_menuItem").css("color","rgb(1,182,255)").addClass("active");
            var length=$(this).width();
            $(".line").css('width',length);
        });


        function reset_pwd(title,url,w,h){
            x_admin_show(title,url,w,h);
        }

    </script>
@endsection('scripts')