@extends("User.Commons.layout")
@section('title','API管理')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')

    <div class="row" style="margin: 10px 100px">

        {{--我的钱包--}}
        <div class="" style="margin: 50px;width: 370px;height: 479px;background:#ffffff;float: left">
            <p style="font-size: 18px;margin: 15px;display: inline-block">
                API设置
            </p>
            <a href=""><i class="glyphicon glyphicon-cog" style="color: #999999;float: right;margin: 15px"></i></a>

            <div class="row">

                <p class="col-md-8 col-sm-8 col-xs-8" style="margin-left: 15px;">
                    API对接参数
                </p>

                <div style="border-bottom: #cccccc solid 1px;height: 25px;width:350px;margin: auto 20px">
                </div>

                <p class="col-md-8 col-sm-8 col-xs-8" style="margin-left: 15px;margin-top: 19px">
                    商户号
                </p>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="10009"
                       style="width: 300px;margin-left: 30px">

                <p class="col-md-8 col-sm-8 col-xs-8" style="margin-left: 15px; margin-top: 19px">
                    网关地址
                </p>
                <input type="text" class="form-control" id="exampleInputEmail1"
                       placeholder="http://103.45.104.115/Pay_Index.html" style="width: 300px;margin-left: 30px">

                <p class="col-md-8 col-sm-8 col-xs-8" style="margin-left: 15px; margin-top: 19px">
                    APIkey
                </p>
                <input type="text" class="form-control" id="exampleInputEmail1"
                       placeholder="lly0hdcy7dmujtumwy7t15e3nhhboqlm" style="width: 300px;margin-left: 30px">
            </div>


            <div class="row">
                <div style=" width: 460px;margin: 0 20px;padding-top: 20px">
                    <a href="/demo/免签支付接口文档v1.1.docx" download="免签支付接口文档v1.1.docx" style="margin-left: 15px">API对接文档下载</a>
                    <hr style="border-top:none ;border-bottom: #cccccc solid 1px;margin-right: 110px;height: 0px">
                </div>
                <a class="btn btn-default" type="button" href="/demo/免签支付接口文档v1.1.docx" download="免签支付接口文档v1.1.docx"
                   style="color: #3B86FF;border: #3B86FF solid 1px;height: 50px;width: 180px;background: #ffffff;margin: auto 100px;font-size: 15px;line-height: 38px">下载</a>
            </div>

        </div>


        {{--商户费率--}}
        <div class="" style="margin: 50px;width: 370px;height: 479px;background:#ffffff;float: left">
            <p style="font-size: 18px;margin: 15px;">通道费率</p>
            <div class="row" style="text-align: center">
                <img src="{{ asset('AdminLTE/dist/img/agent/t0.png') }}" alt="" style="margin-top: 20px">
            </div>
            <table class="table" style="width: 340px;margin: 60px 10px 0 10px;font-size: 13px">
                <tr style="color: #999999;background: #f5f6f9">
                    <th>编码</th>
                    <th>通道名称</th>
                    <th>通道费率</th>
                    <th>通道状态</th>
                </tr>
                <tr>
                    <td>1049</td>
                    <td>支付宝直通</td>
                    <td>0‰</td>
                    <td>开通</td>
                </tr>
                <tr>
                    <td>1050</td>
                    <td>京东PC</td>
                    <td>25‰</td>
                    <td>开通</td>
                </tr>

            </table>
        </div>


    </div>

@endsection