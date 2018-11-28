@extends("Admin.Agent.commons.layout")
@section('title','推广地址')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper" style="padding: 0;margin: 0">
        <section class="content">


            <div class="row">

                <div class="col-md-12">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">推广地址</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <p style="color: #666666;font-size: 15px; line-height: 35px">
                            推广地址链接: http://vovpay.net/Agent_Login_register.html?pid={{Auth::user()->id}} <br>
                            把推广地址链接发送给你的下级注册,注册之后成为你的下级用户
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>


@endsection