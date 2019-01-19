@extends("User.Commons.layout")
@section('title','我的信息')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper" style="padding: 0;margin: 0">
        <br>
                    <div class="row">
                        <div class="col-md-9 col-lg-9 col-sm-6" style="background: #ffffff">

                            <table class="table table-hover table-bordered" style="margin-top: 10px">
                                <tr style="background: #f5f6f9">
                                    <th style="width: 200px">名称</th>
                                    <th>信息</th>
                                </tr>
                                <tr>
                                    <td>商户号</td>
                                    <td>{{$user->merchant}}</td>
                                </tr>
                                <tr>
                                    <td>用户名</td>
                                    <td style="color:green"><b>{{$user->username}}</b></td>
                                </tr>
                                <tr>
                                    <td>商户密钥</td>
                                    <td>{{$user->apiKey}}</td>
                                </tr>
                                <tr>
                                    <td>账户余额</td>
                                    <td style="color: red"><b>￥ @if(isset($statistical->handlingFeeBalance)) {{$statistical->handlingFeeBalance}} @else 0.00 @endif</b></td>
                                </tr>
                                <tr>
                                    <td>手机</td>
                                    <td>{{$user->phone}}</td>
                                </tr>
                                <tr>
                                    <td>邮箱</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <td>创建时间</td>
                                    <td>{{$user->created_at}}</td>
                                </tr>

                            </table>

                            {{--<a href="{{route('user.order')}}" style="margin: 15px">查看更多</a>--}}
                            <br>
                            <br>

                        </div>

                    </div>

    </div>
@endsection