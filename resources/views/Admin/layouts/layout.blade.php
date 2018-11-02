<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">
    @yield('css')
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper" style="padding: 0px;">
            <!-- 顶部内容 -->
            @include('Admin.commons._header')
            <!-- 左侧导航 -->
            @include('Admin.commons._left')
            <!-- 右侧内容 -->
            <div class="content-wrapper">
                <!-- 内容导航 -->
                <section class="content-header">
                    <h1>{{ $title }}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ route('admin') }}"><i class="fa fa-dashboard"></i> 主页</a></li>
                        <li class="active">{{ $title }}</li>
                    </ol>
                </section>
                <!-- 内容导航结束 -->
                <!-- 主内容 -->
                <section class="content">
                @yield('content')
                </section>
                <!-- /.主内容结束 -->
            </div>
            <!--右侧内容结束-->
            <!--底部-->
            @include('Admin.commons._footer')
        </div>

        <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
        @yield('scripts')
    </body>
</html>
