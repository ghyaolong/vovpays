@extends("Agent.Commons.layout")
@section('title','银行卡号')
@section("css")
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">账号列表</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" class="col-md-12">
                    <!-- ./col -->
                    <form class="navbar-form navbar-left" action="{{route('user.accountBank')}}" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="bank_account" placeholder="账号">
                        </div>
                        <button type="submit" class="btn btn-info">搜索</button>
                        <a onclick="showModel('添加账号')" class="btn btn-info">添加账号</a>
                    </form>
                    <div class="box-body" style="margin-top: 45px">
                        <table id="example2" class="table table-bordered table-hover">
                            <tr style="color: #666666;background: #f5f6f9">
                                <th>手机标识</th>
                                <th>账号</th>
                                <th>账号类型</th>
                                <th>单日交易额</th>
                                <th>今日订单量</th>
                                <th>今日成功订单量</th>
                                <th>今日成功率</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            @if(!isset($list[0]))
                                <tr>
                                    <td colspan="10" style="text-align: center">没有找到匹配数据</td>
                                </tr>
                            @else
                                @foreach($list as $v)
                                    <tr>
                                        <td>{{ $v->phone_id }}</td>
                                        <td style="color: red">{{ $v->bank_account }}</td>
                                        <td style="color: #00c0ef">{{ $v->accountType }}</td>
                                        <td><span style="color: green">{{$v->account_amount}}</span></td>
                                        <td><span style="color: green">{{$v->account_order_count}}</span></td>
                                        <td><span style="color: green">{{$v->account_order_suc_count}}</span></td>
                                        <td><span style="color: green">{{$v->success_rate?$v->success_rate.'%':'---'}}</span></td>
                                        <td>
                                            <input class="switch-state" data-id="{{ $v['id'] }}" type="checkbox"
                                                   @if($v['status'] == 1) checked @endif />
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                    onclick="edit('编辑',{{$v->id}})">编辑
                                            </button>
                                            <button class="btn btn-primary btn-sm"
                                                    onclick="del($(this),{{$v->id}})">
                                                删除
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        {{$list->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--模态框--}}
    <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" style="margin-top: 123px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body" style="overflow: auto;">
                    <form id="addForm" action="{{ route('user.accountBankAdd') }}" class="form-horizontal" role="form">
                        <input type="hidden" id="id" name="id">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">卡号实名:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="bank_account" placeholder="请输入账号实名">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">银行名称:</label>
                            <div class="col-xs-9">
                                <select class="form-control" id="channelId" name="bank_name">
                                    <option value="">选择银行</option>
                                    <option value="中国银行,BOC">中国银行</option>
                                    <option value="中国工商银行,ICBC">中国工商银行</option>
                                    <option value="中国建设银行,CCB">中国建设银行</option>
                                    <option value="中国农业银行,ABC">中国农业银行</option>
                                    <option value="中国光大银行,CEB">中国光大银行</option>
                                    <option value="招商银行,CMBC">招商银行</option>
                                    <option value="广发银行,GDB">广发银行</option>
                                    <option value="华夏银行,HXB">华夏银行</option>
                                    <option value="交通银行,BCM">交通银行</option>
                                    <option value="中国民生银行,CMSB">中国民生银行</option>
                                    <option value="北京银行,BOB">北京银行</option>
                                    <option value="东亚银行,BEA">东亚银行</option>
                                    <option value="南京银行,NJCB">南京银行</option>
                                    <option value="宁波银行,NBCB">宁波银行</option>
                                    <option value="平安银行,PAB">平安银行</option>
                                    <option value="上海银行,BOS">上海银行</option>
                                    <option value="上海浦东发展银行,SPDB">上海浦东发展银行</option>
                                    <option value="兴业银行,CIB">兴业银行</option>
                                    <option value="中国邮政储蓄银行,PSBC">中国邮政储蓄银行</option>
                                    <option value="网商银行,ANTBANK">网商银行</option>
                                    <option value="中信银行,CNCB">中信银行</option>
                                    <option value="支付宝,ALIPAY">支付宝</option>
                                    <option value="微信,WECHAT">微信</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">银行卡号:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="cardNo"
                                       placeholder="请输入银行卡号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">手机标识:</label>
                            <div class="col-xs-9">
                                <select class="form-control" id="phone_id" name="phone_id">
                                    <option value="">选择手机标识</option>
                                    @foreach($alist as $v)
                                        <option value="{{$v->phone_id}}">{{$v->phone_id}}</option>
                                    @endforeach
                                </select>
                                <p style="margin-bottom: -8px;color: red">必须先配置支付宝账号</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">索引:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="chard_index"
                                       placeholder="请输入索引">
                                <a href="https://www.showdoc.cc/258628029269764" target="_blank">索引获取说明</a> 密码：000000
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">限额:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="dayQuota" placeholder="请输入当日限额">
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

        $(function () {
            formValidator();
            // 状态修改
            $('.switch-state').bootstrapSwitch({
                onText: '启用',
                offText: '禁用',
                onColor: "primary",
                offColor: "danger",
                size: "small",
                onSwitchChange: function (event, state) {
                    var id = $(event.currentTarget).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '/agent/accountBank/saveStatus',
                        data: {'status': state, 'id': id},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if (result.status) {
                                toastr.success(result.msg);
                            } else {
                                $('#addModel').modal('hide');
                                toastr.error(result.msg);
                                window.location.href = window.location.href;
                            }
                        },
                        error: function (XMLHttpRequest, textStatus) {
                            toastr.error('通信失败');
                        }
                    })
                }
            })

            // 模态关闭
            $('#addModel').on('hidden.bs.modal', function () {
                $("#addForm").data('bootstrapValidator').destroy();
                $('#addForm').data('bootstrapValidator', null);
                $('#addForm').get(0).reset();
                $('#id').val('');
                formValidator();
            });

        })


        /**
         *提交
         */
        function save(_this) {
            // formValidator();
            $('#addForm').data('bootstrapValidator').validate();
            if (!$('#addForm').data('bootstrapValidator').isValid()) {
                return;
            }
            _this.removeAttr('onclick');

            var $form = $('#addForm');
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


        /*
         *表单验证
         */
        function formValidator() {
            $('#addForm').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    bank_account: {
                        validators: {
                            notEmpty: {
                                message: '请输入账号!'
                            },
                        }
                    },
                    accountType: {
                        validators: {
                            notEmpty: {
                                message: '请输入账户类型!'
                            },
                        }
                    },
                    bank_name: {
                        validators: {
                            notEmpty: {
                                message: '请选择银行!'
                            },
                        },
                    },
                    cardNo: {
                        validators: {
                            notEmpty: {
                                message: '请输入银行卡号!'
                            },
                            {{--regexp: {--}}
                                {{--regexp: /^([1-9]{1})(\d{14}|\d{18})$/,--}}
                                {{--message: '请输入正确的银行卡号！'--}}
                            {{--},--}}
                            {{--remote: {--}}
                                {{--url: "{{route('agent.checkBank')}}",--}}
                                {{--message: "该卡号已存在!",--}}
                                {{--type: "post",--}}
                                {{--data: function () { // 额外的数据，默认为当前校验字段,不需要的话去掉即可--}}
                                    {{--return {--}}
                                        {{--"value": $("input[name='cardNo']").val().trim(),--}}
                                        {{--"type": 'cardNo',--}}
                                        {{--"_token": $('meta[name="csrf-token"]').attr('content'),--}}
                                        {{--"id": $('#id').val(),--}}
                                    {{--};--}}
                                {{--},--}}
                                {{--delay: 500,--}}
                            {{--},--}}
                        },
                    },
                    phone_id: {
                        validators: {
                            notEmpty: {
                                message: '请输入手机标识!'
                            },
                        },
                    },
                    dayQuota: {
                        validators: {
                            notEmpty: {
                                message: '请输入当日限额!'
                            },
                            regexp: {
                                regexp: /^[1-9]\d*$/,
                                message: '请输入正确的数字限额'
                            }
                        },
                    },
                }
            })
        }

        /**
         * 显示模态框
         * @param title
         */
        function showModel(title) {
            $('#addModel .modal-title').html(title);
            $('#addModel').modal('show');
        }

        function aliid(title) {
            $('#aliidModel .modal-title').html(title);
            $('#aliidModel').modal('show');
        }

        /**
         * 编辑
         * @param id
         * @param title
         */
        function edit(title, id) {
            $.ajax({
                type: 'get',
                url: '/agent/accountBank/' + id + '/edit',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result.status == 1) {
                        $("input[name='bank_account']").val(result.data['bank_account']);
                        $("input[name='accountType']").val(result.data['accountType']);
                        $("input[name='bank_name']").val(result.data['bank_name']);
                        $("input[name='cardNo']").val(result.data['cardNo']);
                        $("select[name='phone_id']").val(result.data['phone_id']);
                        $("input[name='dayQuota']").val(result.data['dayQuota']);
                        $("input[name='chard_index']").val(result.data['chard_index']);
                        $("input[name='id']").val(result.data['id']);
                        $('.modal-title').html(title);
                        $('#addModel').modal('show');
                    }
                },
                error: function (XMLHttpRequest, textStatus) {
                    toastr.error('通信失败');
                }
            })
        }

        /**
         * 删除
         * @param _this
         * @param id
         */
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
                    url: '/agent/accountBank',
                    data: {'id': id},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.status) {
                            _this.parents('tr').empty();
                            swal(result.msg, "账号已删除。", "success")
                        } else {
                            swal(result.msg, "账号未删除。", "error")
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