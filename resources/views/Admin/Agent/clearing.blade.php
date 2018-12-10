@extends("Admin.Agent.commons.layout")
@section('title','结算管理')
@section('content')
    {{--<div class="row" style="margin-top: 20px">--}}

    {{--结算申请--}}
    {{--<div class="col-md-4">--}}
    {{--<div class="box box-primary box-solid">--}}
    {{--<div class="box-header with-border">--}}
    {{--<h3 class="box-title">结算申请</h3>--}}

    {{--<div class="box-tools pull-right">--}}
    {{--<button type="button" class="btn btn-box-tool" data-widget="collapse">--}}
    {{--<i class="fa fa-minus"></i>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="box-body" id="bank">--}}
    {{--<form class="form-horizontal" id="form1" method="post" action="{{route('user.apply')}}">--}}
    {{--{{ csrf_field() }}--}}
    {{--<input type="hidden" id="user_id" name="user_id">--}}
    {{--<div class="form-group">--}}
    {{--<label for="" class="col-sm-3 control-label">提现金额</label>--}}
    {{--<div class="col-sm-9">--}}
    {{--<input type="text" class="form-control" id="withdrawAmount" placeholder="0.00"--}}
    {{--name="withdrawAmount" value="0.00">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label for="" class="col-sm-3 control-label">银行卡</label>--}}
    {{--<div class="col-sm-9">--}}
    {{--<a class="btn btn-info" id="choseCard" onclick="bankModel('选择银行卡')">选择银行卡</a>&nbsp;--}}
    {{--<a class="btn btn-info" id="addCard" onclick="showModel('添加银行卡')">添加银行卡</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label class="col-xs-3 control-label">持卡人</label>--}}
    {{--<div class="col-xs-9">--}}
    {{--<input type="text" class="form-control" id="accountName" name="accountName1"--}}
    {{--disabled="disabled">--}}
    {{--<input type="hidden" class="form-control" id="accountName" name="accountName">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label class="col-xs-3 control-label">银行名称</label>--}}
    {{--<div class="col-xs-9">--}}
    {{--<input type="text" class="form-control" id="bankName" name="branchName1"--}}
    {{--disabled="disabled">--}}
    {{--<input type="hidden" class="form-control" id="bankName" name="bankName">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label class="col-xs-3 control-label">银行卡号</label>--}}
    {{--<div class="col-xs-9">--}}
    {{--<input type="text" class="form-control" id="bankCardNo" name="bankCardNo1"--}}
    {{--disabled="disabled">--}}
    {{--<input type="hidden" class="form-control" id="bankCardNo" name="bankCardNo">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<label class="col-xs-3 control-label">提款密码</label>--}}
    {{--<div class="col-xs-9">--}}
    {{--<input type="password" class="form-control" id="applyPws" name="payPassword">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="form-group">--}}
    {{--<div class="col-xs-6">--}}
    {{--<a class="btn btn-danger pull-right" id="applyBtn" onclick="save1($(this))">&nbsp;申&nbsp;请&nbsp;</a>--}}
    {{--</div>--}}
    {{--<div class="col-xs-6">--}}
    {{--<input type="reset" class="btn btn-warning" value="&nbsp;重&nbsp;置&nbsp;">--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--</div>--}}


    {{--结算记录--}}
    {{--<div class="col-md-8">--}}
    {{--<div class="box box-primary box-solid">--}}
    {{--<div class="box-header with-border">--}}
    {{--<h3 class="box-title">结算记录</h3>--}}

    {{--<div class="box-tools pull-right">--}}
    {{--<button type="button" class="btn btn-box-tool" data-widget="collapse">--}}
    {{--<i class="fa fa-minus"></i>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="box-body">--}}
    {{--<table class="table table-bordered table-hover">--}}
    {{--<tr style="color: #999999;background:#f5f6f9">--}}
    {{--<th>银行名称</th>--}}
    {{--<th>银行卡号</th>--}}
    {{--<th>提现额度</th>--}}
    {{--<th>提现手续费</th>--}}
    {{--<th>到账金额</th>--}}
    {{--<th>状态</th>--}}
    {{--<th>提现时间</th>--}}
    {{--</tr>--}}
    {{--@foreach($clearings as $vv)--}}
    {{--<tr>--}}
    {{--<th>{{$vv->bankName}}</th>--}}
    {{--<th>4114698698569856</th>--}}
    {{--<th>{{$vv->withdrawAmount}}</th>--}}
    {{--<th>{{$vv->withdrawRate}}</th>--}}
    {{--<th>{{$vv->toAmount}}</th>--}}
    {{--<th>{{$vv->status?'未处理':'处理中'}}</th>--}}
    {{--<th>{{$vv->created_at}}</th>--}}
    {{--</tr>--}}
    {{--@endforeach--}}
    {{--</table>--}}
    {{--{{$clearings->links()}}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--</div>--}}








    <div class="content-wrapper" style="padding: 0;margin: 0">

        <div class="row" style="margin-top: 20px;">

            <div class="col-md-3" style="height: 133px;background: #ffffff;margin-left: 55px;">
                <div style="margin-bottom: 20px">
                    <p style="font-size: 15px;margin: 15px;">提现余额</p>
                    <b class="col-md-6" style="font-size: 28px;display: inline-block">
                        35465.60RMB
                    </b>

                    <img src="/AdminLte/dist/img/agent/ztjt.png" alt=""
                         style="margin-top:auto;float: right;margin-right: 30px">

                    <span class="glyphicon glyphicon-arrow-up"
                          style="font-size: 11px;margin:38px -183px;color: #3CC480">13.8%</span>
                </div>

                <div style="height: 592px;width:418px;background: #ffffff;margin-left: -15px">
                    <div class="col-md-12" style="font-size: 15px;margin: 15px;">
                        申请结算
                    </div>

                    <p style="margin-left: 30px;color: #999999">提现金额</p>
                    <input type="text" style="margin-left: 30px;width: 355px;height: 40px;font-size: 15px"
                           placeholder="￥35465.60  ">
                    <p style="margin-left: 30px;color: #cccccc;width: 360px">注：提现金额最小203.00元，最大3.15，含提现手续费，直接
                        在金额中扣除.</p>

                    <span style="color: #999999;margin-left: 30px;">到账金额    </span>
                    <b style="font-size: 18px;margin-left: 18px">￥35000.00</b>
                    <span style="color: #999999;margin-left: 50px;">手续费</span>
                    <b style="font-size: 18px;margin-left: 18px">￥465.60</b>

                    <div class="col-md-9"
                         style="background:linear-gradient(#74A8FF,#72A8FF);border-radius: 6px;height: 137px;margin-left:45px;margin-top: 35px">
                        <ul>
                            <li style="font-size: 16px;color: #FFFFFF;margin-top: 15px;margin-left: -15px">中国银行</li>
                        </ul>
                        <ul class="list-inline" style="text-align: center;margin-top: 30px">
                            <li style="font-size: 19px;color: #FFFFFF;">6565 **** **** **** 88</li>
                        </ul>
                    </div>
                    <div class="col-md-12" style="margin-top: 25px">
                        <span style="color: #999999;margin: 15px;">提款密码    </span>
                    </div>
                    <form action="">
                        <div class="col-md-12" style="margin: 5px 8px">
                            <input type="password" name="check1"
                                   style="border:none;border-bottom: black solid 1px;width: 50px;height: 50px;text-align: center;font-size: 30px;margin: auto 5px"
                                   maxlength="1">
                            <input type="password" name="check2"
                                   style="border:none;border-bottom: black solid 1px;width: 50px;height: 50px;text-align: center;font-size: 30px;margin: auto 5px"
                                   maxlength="1">
                            <input type="password" name="check3"
                                   style="border:none;border-bottom: black solid 1px;width: 50px;height: 50px;text-align: center;font-size: 30px;margin: auto 5px"
                                   maxlength="1">
                            <input type="password" name="check4"
                                   style="border:none;border-bottom: black solid 1px;width: 50px;height: 50px;text-align: center;font-size: 30px;margin: auto 5px"
                                   maxlength="1">
                            <input type="password" name="check5"
                                   style="border:none;border-bottom: black solid 1px;width: 50px;height: 50px;text-align: center;font-size: 30px;margin: auto 5px"
                                   maxlength="1">
                            <input type="password" name="check6"
                                   style="border:none;border-bottom: black solid 1px;width: 50px;height: 50px;text-align: center;font-size: 30px;margin: auto 5px"
                                   maxlength="1">
                        </div>
                        <input class="btn btn-default" type="button" value="提交申请"
                               style="color: #ffffff;border: #3B86FF solid 1px;height: 50px;width: 185px;background:#3B86FF;margin: 25px 25px;font-size: 15px"/>
                        <input class="btn btn-default" type="reset" value="重置"
                               style="color: #3B86FF;border: #3B86FF solid 1px;height: 50px;width: 133px;background: #ffffff;margin: 25px auto;font-size: 15px"/>
                    </form>
                </div>
            </div>

            <div class="col-md-7 col-xs-7" style="background: #ffffff;margin: auto 60px">
                <p style="font-size: 16px;margin: 15px;color: #999999">最近订单</p>

                <table class="table table-hover" style="height: 680px">
                    <tr style="background: #f5f6f9">
                        <th>#</th>
                        <th>商户号</th>
                        <th>订单号</th>
                        <th>订单时间</th>
                        <th>所走通道</th>
                        <th>订单金额</th>
                        <th>平台流水</th>
                        <th>返回状态</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1009</td>
                        <td>201807091436439767</td>
                        <td>2018-07-09 14:36:48</td>
                        <td>支付宝直通</td>
                        <td>2.00</td>
                        <td>20180709143648484857</td>
                        <td>未处理</td>
                    </tr>
                </table>

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
                                    <input type="radio" onclick="edit('编辑',{{$v->id}})"
                                           @if($v->status==0) disabled="disabled" @endif data-dismiss="modal">
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

        function save1(_this) {
            // formValidator();
            $('#form1').data('bootstrapValidator').validate();
            if (!$('#form1').data('bootstrapValidator').isValid()) {
                return;
            }
            _this.removeAttr('onclick');

            var $form = $('#form1');
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if (result.status) {
                    setInterval(function () {
                        window.location.reload();
                    }, 1000);

                    toastr.success(result.msg);
                } else {
                    _this.attr("onclick", "save1($(this))");
                    toastr.error(result.msg);
                }
            }, 'json');

        }

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
         * 结算申请，条件控制
         */
        $().ready(function () {
            $('#form1').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    withdrawAmount: {
                        validators: {
                            notEmpty: {
                                message: '提现金额不能为空'
                            },
                            regexp: {
                                regexp: /^[1-9]\d{2,}[\.]?\d*/,
                                message: '提现金额最小100'
                            }

                        }
                    },
                    bankName1: {
                        validators: {
                            notEmpty: {
                                message: '您未选择银行卡！'
                            },
                        }
                    },
                    accountName1: {
                        validators: {
                            notEmpty: {
                                message: '您未选择银行卡！'
                            },
                        }
                    },
                    bankCardNo1: {
                        validators: {
                            notEmpty: {
                                message: '您未选择银行卡！'
                            }
                        },
                    },
                    payPassword: {
                        validators: {
                            notEmpty: {
                                message: '提款密码不能为空！'
                            }
                        }
                    }
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
                        $("input[id='user_id']").val(result.data['user_id']);
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