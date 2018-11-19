@extends("Admin.User.commons.layout")
@section('title','银行卡管理')
@section("css")
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')

    @if(!empty($lists[0]))
    <div class="row" style="margin: 70px 0px">
        <div class="col-xs-12 col-md-12">
            <div class="box">
                <div class="box-header">
                    <input type="button" class="btn btn-primary" onclick="showModel('添加银行卡')" value="添加银行卡">
                    <a href="{{ route('user.bankCard',Auth::user()->id) }}" class="btn pull-right"><i class="fa fa-undo"></i>刷新</a>
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-condensed table-bordered table-hover">
                        <thead>
                        <tr style="font-size: 15px;height: 38px">
                            <th>ID</th>
                            <th>银行名称</th>
                            <th>支行名称</th>
                            <th>开户名</th>
                            <th>银行卡号</th>
                            <th>状态</th>
                            <th>备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list->id}}</td>
                                <td>中国银行</td>
                                <td>{{$list->branchName}}</td>
                                <td>{{$list->accountName}}</td>
                                <td>{{$list->bankCardNo}}</td>
                                <td>
                                    <input class="switch-state" data-id="{{ $list['id'] }}" type="checkbox" @if($list['status'] == 1) checked @endif >
                                </td>
                                <td>上次修改:{{$list->updated_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm" onclick="edit('编辑',{{$list->id}})">编辑
                                        </button>
                                        <button class="btn btn-primary btn-sm" onclick="del($(this),{{$list->id}})">
                                            删除
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   @else
    <div style="margin: 100px 200px;width: 800px;height: 300px">
        <div class="">
            <div style="margin-top:150px;margin-left: 450px">
                <img src="/AdminLTE/dist/img/addcard.png">
            </div>
            <div class="" style="margin-top:50px;margin-left: 430px;font-size: 20px;color: #999999">
                您还没有提款银行卡,添加一张吧
            </div>

            <div class="box-header">
                <button type="button" class="btn btn-primary" onclick="showModel('添加银行卡')"
                        style="margin-left: 510px">添加银行卡
                </button>
            </div>
        </div>
    </div>
    @endif


    <section>
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
                                <label for="" class="col-xs-3 control-label">状态:</label>
                                <div class="col-xs-9">
                                    <input class="switch-state" data-id="{{ $list['id'] }}" type="checkbox" @if($list['status'] == 1) checked @endif >
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
    </section>

    <script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>

        $(function () {
            // formValidator();

            // 状态修改
            $('.switch-state').bootstrapSwitch({
                onText:'启用',
                offText:'禁用' ,
                onColor:"primary",
                offColor:"danger",
                size:"small",
                onSwitchChange:function(event,state) {
                    var id =  $(event.currentTarget).data('id');
                    $.ajax({
                        type: 'POST',
                        url: 'user/saveStatus',
                        data:{'status':state,'id':id},
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(result){
                            if(result.status)
                            {
                                toastr.success(result.msg);
                            }else{
                                $('#addModel').modal('hide');
                                toastr.error(result.msg);
                            }
                        },
                        error:function(XMLHttpRequest,textStatus){
                            toastr.error('通信失败');
                        }
                    })
                }
            })

            // 模态关闭
            $('#addModel').on('hidden.bs.modal', function() {
                $("#usersForm").data('bootstrapValidator').destroy();
                $('#usersForm').data('bootstrapValidator', null);
                $('#usersForm').get(0).reset();
                formValidator();
            });

        })

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
                            regexp:{
                                regexp:/^([1-9]{1})(\d{14}|\d{18})$/,
                                message:'请输入正确的银行卡号！'
                            }
                        },
                    },
                }
            })
        });

        /**
         * 提交
         */
        function save(_this){
            // formValidator();
            $('#bankForm').data('bootstrapValidator').validate();
            if(!$('#bankForm').data('bootstrapValidator').isValid()){
                return ;
            }
            _this.removeAttr('onclick');

            var $form = $('#bankForm');
            $.post($form.attr('action'), $form.serialize(), function(result) {
                if(result.status)
                {
                    $('#addModel').modal('hide');
                    setInterval(function(){
                        window.location.reload();
                    },1000);

                    toastr.success(result.msg);
                }else{
                    $('#addModel').modal('hide');
                    _this.attr("onclick","save($(this))");
                    toastr.error(result.msg);
                }
            }, 'json');

        }


        /**
         * 显示模态框
         * @param title
         */
        function showModel(title) {
            $('.modal-title').html(title);
            $('#addModel').modal('show');
        }

        /**
         * 编辑
         * @param id
         * @param title
         */
        function edit(title, id)
        {
            $.ajax({
                type: 'get',
                url: '/user/'+id+'/edit',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(result){
                    if(result.status == 1)
                    {
                        $("select[name='branchName']").val(result.data['branchName']);
                        $("input[name='bankCardNo']").val(result.data['bankCardNo']);
                        $("input[name='accountName']").val(result.data['accountName']);
                        $("select[name='status']").val(result.data['status']);
                        $("input[name='id']").val(result.data['id']);
                        $('.modal-title').html(title);
                        $('#addModel').modal('show');
                    }
                },
                error:function(XMLHttpRequest,textStatus){
                    toastr.error('通信失败');
                }
            })
        }

        function del(_this,id){
            swal({
                title: "您确定要删除吗？",
                text: "删除后不能恢复！",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function(){
                $.ajax({
                    type: 'delete',
                    url: '/user/del',
                    data:{'id':id},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result){
                        if(result.status)
                        {
                            _this.parents('tr').empty();
                            swal(result.msg, "银行卡已删除。","success")
                        }else{
                            swal(result.msg, "银行卡未删除。","error")
                        }

                    },
                    error:function(XMLHttpRequest,textStatus){
                        toastr.error('通信失败');
                    }
                })
            });
        }

    </script>
@endsection