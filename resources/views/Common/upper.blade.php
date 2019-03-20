@extends($module.".Commons.layout")
@section('title','通道商户池')
@section("css")
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="row" style="margin-top: 20px">
        <div class="col-xs-12 col-md-12">
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
                    <form class="navbar-form navbar-left" action="" method="get">
                        <a onclick="showModel('添加账号')" class="btn btn-info">添加账号</a>
                    </form>
                    <div class="box-body" style="margin-top: 45px">
                        <table id="example2" class="table table-condensed table-bordered table-hover">
                            <tr style="color: #666666;background: #f5f6f9">
                                <th>#</th>
                                <th>通道商户名</th>
                                <th>通道秘钥</th>
                                <th>通道名称</th>
                                <th>支付方式</th>
                                <th>今日订单量</th>
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
                                        <td>{{ $v->id }}</td>
                                        <td>{{ $v->account }}</td>
                                        <td style="color: red">{{ $v->signkey }}</td>
                                        <td>{{ @$v->Channel()->pluck('channelName')[0] }}</td>
                                        <td>{{ @$v->Channel_payment()->pluck('paymentName')[0] }}</td>
                                        <td>{{ $v['num'] }}</td>
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
                    <form id="addForm" action="{{ route('admin.accountUpperAdd') }}" class="form-horizontal" role="form">
                        <input type="hidden" id="id" name="id">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">账户名:</label>
                            <div class="col-xs-9">
                                <input type="text" id="account" class="form-control" name="account" placeholder="请输入账号" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">账户密匙:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="signkey" placeholder="账户密匙">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">账户私匙:</label>
                            <div class="col-xs-9">
                                <textarea name="privatekey" class="form-control" rows="8"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">账户公匙:</label>
                            <div class="col-xs-9">
                                <textarea name="publikey" class="form-control" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">支付方式:</label>
                            <div class="col-xs-5">
                                <select class="form-control" id="channel_id" name="channel_id" onchange="channel_payment(this.value)">
                                    <option value="">选择支付方式</option>
                                    @foreach($channel as $payment)
                                        <option value="{{$payment->id}}" >{{$payment->channelName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <select class="form-control" id="channel_payment_id" name="channel_payment_id">
                                    <option value="" ></option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="" class="col-xs-3 control-label">限额:</label>
                            <div class="col-xs-9" >
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
                        url: '{{route('admin.accountUpperStatus')}}',
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
                    account: {
                        validators: {
                            notEmpty: {
                                message: '请输入账号!'
                            },
                        }
                    },
                    channel_id: {
                        validators: {
                            notEmpty: {
                                message: '请选择通道类型!'
                            },
                        }
                    },
                    channel_payment_id: {
                        validators: {
                            notEmpty: {
                                message: '请选择支付类型!'
                            },
                        }
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


        /**
         * 编辑
         * @param id
         * @param title
         */
        function edit(title, id) {
            $.ajax({
                type: 'get',
                url: '/admin/accountUpper/'+id+'/edit',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result.status == 1) {
                        $("#addForm input[name='account']").val(result.data['data']['account']);
                        $("input[name='signkey']").val(result.data['data']['signkey']);
                        $("textarea[name='privatekey']").val(result.data['data']['privatekey']);
                        $("textarea[name='publikey']").val(result.data['data']['publikey']);
                        $("select[name='channel_payment_id']").val(result.data['data']['channel_payment_id']);
                        $("input[name='dayQuota']").val(result.data['data']['dayQuota']);
                        $("input[name='id']").val(result.data['data']['id']);
                        $('.modal-title').html(title);
                        $('#channel_id option[value="'+result.data['data']['channel_id']+'"]').attr('selected','selected');
                        $('#channel_payment_id').html('<option value="'+result.data['payment']['id']+'">'+result.data['payment']['paymentName']+'</option>');
                        $('#channel_payment_id').removeClass('hidden');
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
                    url: '{{route('admin.accountUpperDel')}}',
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

        function channel_payment(id)
        {
            if(id){
                $.ajax({
                    type:'post',
                    url:'{{ route('admin.paymentget') }}',
                    data:{channid:id},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function (result) {
                        if(result.status){
                            var option = '';
                            $.each(result.data,function (index, data) {
                                option += '<option value="'+data.id+'">'+data.paymentName+'</option>';
                            });
                            $('#channel_payment_id').removeClass('hidden');
                            $('#channel_payment_id').html(option);
                        }
                    }
                });
            }
        }
    </script>
@endsection