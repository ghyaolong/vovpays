@extends("Admin.User.commons.layout")
@section('title','银行卡管理')
@section('content')

    <div style="margin: 100px 200px;width: 800px;height: 300px">
        <div class="">
            <div style="margin-top:150px;margin-left: 450px">
                <img src="/AdminLTE/dist/img/addcard.png">
            </div>
            <div class="" style="margin-top:50px;margin-left: 430px;font-size: 20px;color: #999999">
                您还没有提款银行卡,添加一张吧
            </div>

            <div class="box-header">
                <button type="button" class="btn btn-primary" onclick="showModel('添加银行卡')" style="margin-left: 510px">添加银行卡</button>
            </div>

            <section>
                <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog" style="margin-top: 123px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"></h4>
                            </div>
                            <div class="modal-body" style="overflow: auto;">

                                <form id="ruleForm" action="{{ route('user.addBankCard') }}" class="form-horizontal" role="form" method="post">
                                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">银行名称:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="" placeholder="请输入银行名称">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">支行名称:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="branchName" placeholder="请输入支行名称">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">开户名:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="accountName" placeholder="请输入开户名">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">银行卡号:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="bankCardNo" placeholder="请输入银行卡号">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">所属省:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="" placeholder="所属省份">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">所属市:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="" placeholder="所属城市">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>

        $().ready(function () {
            $('#ruleForm').bootstrapValidator({
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
            }).on('success.form.bv', function (e) {
                e.preventDefault();
                var $form = $(e.target);
                $.post($form.attr('action'), $form.serialize(), function (result) {
                    if (result.status) {
                        toastr.success(result.msg);
                        setInterval(function () {
                            window.location.href = '/user';
                        }, 500);
                    }
                }, 'json');
            });
        });

        function showModel(title)
        {
            $('.modal-title').html(title);
            $('#addModel').modal('show');
        }

    </script>
@endsection