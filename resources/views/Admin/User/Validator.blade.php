@extends("Admin.User.commons.layout")
@section('title','身份验证器')
@section("css")
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
    <div class="content-wrapper" style="padding: 0;margin: 0">
        <section class="content">


            <div class="row">

                <div class="col-md-5">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">身份验证器</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">

                            1.下载谷歌验证器
                            <br>-----------------------------------------------------------------------------<br>
                            <a href="" class="btn btn-primary" style="margin:auto 50px">Android下载</a>

                            <a href="" class="btn btn-primary">iOS下载</a>
                            <br>-----------------------------------------------------------------------------<br>
                            2.绑定手机号码
                            <br>-----------------------------------------------------------------------------<br>
                            <img src="" alt="二维码加载失败!">

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection