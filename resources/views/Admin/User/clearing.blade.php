@extends("Admin.User.commons.layout")
@section('title','结算管理')
@section('content')
    <div class="row">

        {{--结算申请--}}
        <div class="col-md-4">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">结算申请</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body" id="bank">
                    <form class="form-horizontal" id="form1">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">提现金额</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="withdrawAmount" placeholder="请输入提现金额"
                                       value="0.00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">银行卡</label>
                            <div class="col-sm-9">
                                <a class="btn btn-info" id="choseCard" onclick="bankModel('选择银行卡')">选择银行卡</a>&nbsp;
                                <a class="btn btn-info" id="addCard" onclick="showModel('添加银行卡')">添加银行卡</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">持卡人</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="accountName" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">银行名称</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="bankName" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">银行卡号</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="bankCardNo" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">提款密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="applyPws">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <a class="btn btn-danger pull-right" id="applyBtn">&nbsp;申&nbsp;请&nbsp;</a>
                            </div>
                            <div class="col-xs-6">
                                <input type="reset" class="btn btn-warning" value="&nbsp;重&nbsp;置&nbsp;">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        {{--结算申请--}}
        <div class="col-md-8">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">结算记录</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <tr style="color: #999999;background:#f5f6f9">
                            <th>银行名称</th>
                            <th>银行卡号</th>
                            <th>提现额度</th>
                            <th>提现手续费</th>
                            <th>到账金额</th>
                            <th>状态</th>
                            <th>提现时间</th>
                        </tr>
                        <tr>
                            <td colspan="7">没有找到匹配的记录</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>

    </div>

    {{--银行卡表单模态框--}}
    <div class="modal fade" id="bankModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" style="margin-top: 123px;width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="overflow: auto;">
                    <table class="table table-hover">
                        <tr style="background: #f5f6f9;color: #999999">
                            <th>序号</th>
                            <th>银行名称</th>
                            <th>银行卡号</th>
                            <th>持卡人</th>
                            <th>状态</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach($list as $v)
                            <tr>
                                <td>
                                    <input type="radio" onclick="edit('编辑',{{$v->id}})" data-dismiss="modal">
                                </td>
                                <td>{{$v->branchName}}</td>
                                <td>{{$v->bankCardNo}}</td>
                                <td>{{$v->accountName}}</td>
                                <td>{{$v->status?'启用':'禁用'}}</td>
                                <td>{{$v->created_at}}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm"
                                            onclick="del($(this),{{$v->id}})">删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="save($(this))">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--添加银行卡模态框--}}
    <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" style="margin-top: 123px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="overflow: auto;">
                    <form id="bankForm" action="{{ route('user.store') }}" class="form-horizontal" role="form"
                          method="post">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="id">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">持卡人:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="accountName" placeholder="请输入开户名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">支行名称:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="branchName" placeholder="请输入支行名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">银行卡号:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="bankCardNo" placeholder="请输入银行卡号">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" onclick="save($(this))">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>

        /**
         * 提交
         */
        function save(_this) {
            // formValidator();
            $('#bankForm').data('bootstrapValidator').validate();
            if (!$('#bankForm').data('bootstrapValidator').isValid()) {
                return;
            }
            _this.removeAttr('onclick');

            var $form = $('#bankForm');
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if (result.status) {
                    $('#addModel').modal('hide');
                    setInterval(function () {
                        window.location.reload();
                    }, 1000);

                    toastr.success(result.msg);
                } else {
                    $('#addModel').modal('hide');
                    _this.attr("onclick", "save($(this))");
                    toastr.error(result.msg);
                }
            }, 'json');

        }


        $().ready(function () {
            $('#bankForm').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    branchName: {
                        validators: {
                            notEmpty: {
                                message: '支行名称不能为空!'
                            },
                        }
                    },
                    accountName: {
                        validators: {
                            notEmpty: {
                                message: '开户名不能为空!'
                            },
                        }
                    },
                    bankCardNo: {
                        validators: {
                            notEmpty: {
                                message: '银行卡号不能为空!'
                            },
                            regexp: {
                                regexp: /^([1-9]{1})(\d{14}|\d{18})$/,
                                message: '请输入正确的银行卡号！'
                            }
                        },
                    },
                }
            })
        });


        /**
         * 显示模态框
         * @param title
         */
        function showModel(title) {
            $('#addModel .modal-title').html(title);
            $('#addModel').modal('show');
        }

        function bankModel(title) {
            $('#bankModel .modal-title').html(title);
            $('#bankModel').modal('show');
        }

        /**
         * 编辑
         * @param id
         * @param title
         */
        function edit(title, id) {
            $.ajax({
                type: 'get',
                url: '/user/' + id + '/edit',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result.status == 1) {
                        $("input[id='bankName']").val(result.data['branchName']);
                        $("input[id='bankCardNo']").val(result.data['bankCardNo']);
                        $("input[id='accountName']").val(result.data['accountName']);
                        // $("input[name='status']").val(result.data['status']);
                        // $("input[name='id']").val(result.data['id']);
                        // $('.modal-title').html(title);
                        // $('#bank').modal('show');
                    }
                },
                error: function (XMLHttpRequest, textStatus) {
                    toastr.error('通信失败');
                }
            })
        }


        function del(_this, id) {
            swal({
                title: "您确定要删除吗？",
                text: "删除后不能恢复！",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                $.ajax({
                    type: 'delete',
                    url: '/user/del',
                    data: {'id': id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.status) {
                            _this.parents('tr').empty();
                            swal(result.msg, "银行卡已删除。", "success")
                        } else {
                            swal(result.msg, "银行卡未删除。", "error")
                        }

                    },
                    error: function (XMLHttpRequest, textStatus) {
                        toastr.error('通信失败');
                    }
                })
            });
        }

    </script>
@endsection