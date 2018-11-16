@extends("Admin.User.commons.layout")
@section('title','用户主页')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper" style="padding: 0;margin: 0">
        <section class="content">


            <div class="row">

                <div class="col-md-4">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">个人信息</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">

                            <form class="form-horizontal">
                                <div class="box-body" style="height: 321px;">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">登录名</label>
                                        <div class="col-sm-8">
                                            <label class="control-label" style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                {{Auth::user()->username}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">商户ID</label>
                                        <div class="col-sm-8">
                                            <label class="control-label" style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                {{Auth::user()->merchant}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">APIKEY</label>
                                        <div class="col-sm-8">
                                            <label class="control-label" style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                {{Auth::user()->apiKey}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">费率</label>
                                        <div class="col-sm-8">
                                            <label class="control-label" style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                2.0%
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">余额</label>
                                        <div class="col-sm-8">
                                            <label class="control-label" style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
{{--                                                {{$member->balance}}--}}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">登陆时间</label>
                                        <div class="col-sm-8">
                                            <label class="control-label" style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">基本资料</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 340px;">
                            <form class="form-horizontal" id="info">
                                <input type="hidden" id="UserID2" name="UserID2" value="24508">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">真实姓名</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="UserRealName" name="UserRealName" value="重庆威付宝科技有限公司">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">收款名称</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="UserCompany" name="UserCompany" value="重庆威付宝科技有限公司">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">手机号码</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="UserMobile" name="UserMobile" value="13979898699">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">联系 QQ</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="UserQQ" name="UserQQ" value="920299697">
                                        </div>
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <button type="button" class="btn btn-primary pull-right" onclick="save();">保存</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">修改密码</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="height: 340px;">
                            <form class="form-horizontal" id="pwd">
                                <input type="hidden" id="UserID3" name="UserID3" value="24508">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">原密码</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="UserPwd" name="UserPwd" placeholder="请输入原密码">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">新密码</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="UserPwd2" name="UserPwd2" placeholder="请输入新密码">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">确认新密码</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="UserPwd3" name="UserPwd3" placeholder="请再次输入新密码">
                                        </div>
                                    </div>
                                    <br>

                                </div>
                                <div class="box-footer">
                                    <button type="button" class="btn btn-primary pull-right" onclick="editpwd();">提交</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection