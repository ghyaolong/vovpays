@extends("Admin.User.commons.layout")
@section('title','用户主页')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper" style="padding: 0;margin: 0">
        <section class="content">


            <div class="row" style="margin-top: 20px">

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
                                <div class="box-body">
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
                        <div class="box-body">
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

                <div class="col-md-4" id="editPwdModel">
                    <div class="box box-primary box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">修改密码</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="pwdForm" action="{{route('user.editPassword')}}" class="form-horizontal" role="form" method="post">
                                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                                {{ csrf_field() }}
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">原密码</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="UserPwd" name="password" placeholder="请输入原密码">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">新密码</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="UserPwd2" name="newPassword" placeholder="请输入新密码">
                                        </div>
                                    </div>


                                    <div class="form-group" style="margin-top: 25px">
                                        <label for="" class="col-sm-4 control-label">确认新密码</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" id="UserPwd3" name="rpassword" placeholder="请再次输入新密码">
                                        </div>
                                    </div>
                                    <br>

                                </div>
                                <div class="box-footer">
                                    <button type="button" class="btn btn-primary pull-right"  onclick="save($(this))">提交</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

{{--@endsection--}}

{{--@section('scripts')--}}

    <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $().ready(function () {
            $('#pwdForm').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    newPassword: {
                        validators: {
                            notEmpty: {
                                message: '密码不能为空!'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: '密码长度必须大于6位，小于30位<br>'
                            },
                            identical: {
                                field: 'rpassword',
                                message: '两次输入的密码不相符<br>'
                            },
                        }
                    },
                    rpassword: {
                        validators: {
                            notEmpty: {
                                message: '密码不能为空!'
                            },
                            stringLength: {
                                min: 6,
                                max: 30,
                                message: '密码长度必须大于6位，小于30位<br>'
                            },
                            identical: {
                                field: 'newPassword',
                                message: '两次输入的密码不相符<br>'
                            },
                        }
                    },
                }
            })
        });
        /**
         * 提交
         */
        function save(_this) {
            // formValidator();
            $('#pwdForm').data('bootstrapValidator').validate();
            if (!$('#pwdForm').data('bootstrapValidator').isValid()) {
                return;
            }
            _this.removeAttr('onclick');

            var $form = $('#pwdForm');
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if (result.status) {
                    $('#editPwdModel').modal('hide');
                    setInterval(function () {
                        window.location.reload();
                    }, 1000);

                    toastr.success(result.msg);
                } else {
                    $('#editPwdModel').modal('hide');
                    _this.attr("onclick", "save($(this))");
                    toastr.error(result.msg);
                }
            }, 'json');

        }
    </script>

@endsection