@extends("Admin.User.commons.layout")
@section('title','用户管理')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}"/>
@endsection
@section('content')
    <table id="example2" class="table table-condensed">
        <tr>
            <th>
            </th>
        </tr>
    </table>
    <br>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">

                        <div class="container-fluid">
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"
                                 style="background: #ffffff">
                                <form class="navbar-form navbar-left" action="{{route('user.user')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="merchant" placeholder="商户号">
                                    </div>&nbsp;&nbsp;

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" placeholder="用户名">
                                    </div>&nbsp;&nbsp;

                                    <div class="form-group">
                                        <select name="status" id="status" class="form-control">
                                            <option value="">状态</option>
                                            <option value="1">正常</option>
                                            <option value="0">禁用</option>
                                            <option value="2">已删除</option>
                                        </select>
                                    </div>&nbsp;&nbsp;

                                    <div class="form-group">
                                        <select name="queryed" id="" class="form-control">
                                            <option value="1">商户</option>
                                            <option value="0">代理商</option>
                                        </select>
                                    </div>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-info glyphicon glyphicon-search ">搜索</button>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-danger glyphicon glyphicon-export ">导出数据
                                    </button>
                                </form>

                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                        <br>
                        <table id="example2" class="table table-condensed table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>商户号</th>
                                <th>用户名</th>
                                <th>用户类型</th>
                                <th>上级用户</th>
                                <th>状态</th>
                                <th>认证</th>
                                <th>账户总额</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><a href="" target="_blank">{{$user->merchant}}</a></td>
                                    <td>{{$user->username}}</td>
                                    <td>普通商户</td>
                                    <td>总管理员</td>
                                    <td>
                                        <input class="switch-state" name="status" data-id="{{$user->id}}" type="checkbox"
                                               @if($user->status==1) checked @endif >
                                    </td>
                                    <td>
                                        <span class="label label-success">已认证</span>
                                    </td>
                                    <td>
                                        可提现：1000 冻结：0.4
                                    </td>
                                    <td>{{$user->created_at}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm" onclick="withdrawal('提现设置','#')">提现
                                            </button>
                                            <button class="btn btn-primary btn-sm" onclick="editTd('编辑通道','#',800)">通道
                                            </button>
                                            <button class="btn btn-primary btn-sm" onclick="rate('编辑费率')">费率</button>
                                            <button class="btn btn-primary btn-sm" onclick="editPwd('编辑密码')">密码</button>
                                            <button class="btn btn-primary btn-sm" onclick="edit('编辑',{{$user->id}})">编辑</button>
                                            <button class="btn btn-primary btn-sm" onclick="del($(this),{{$user->id}})">删除</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$users->appends($data)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--编辑模态--}}
    <section>
        <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-top: 123px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="overflow: auto;">
                        <form id="usersForm" action="{{ route('users.store') }}" class="form-horizontal" role="form">
                            <input type="hidden" name="id">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">用户名</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" id="username" name="username" placeholder="用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">密码</label>
                                <div class="col-xs-9">
                                    <input type="password" class="form-control" name="password" placeholder="密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">确认密码</label>
                                <div class="col-xs-9">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="确认密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">邮箱</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="email" placeholder="邮箱">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">电话</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="phone" placeholder="电话">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">用户组</label>
                                <div class="col-xs-9">

                                    <select class="form-control" name="groupType">
                                        <option value="1">商户</option>
                                        <option value="2">代理商</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">上级代理</label>
                                <div class="col-xs-9">
                                    <select class="form-control selectpicker" name="parentId">
                                        <option value="0">无</option>
                                        @foreach($agent_list as $v)
                                            <option value="{{ $v['id'] }}">{{ $v['username'] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block" style="color: #FF0000; font-size: 12px;">
                                <i class="fa fa-info-circle"></i>用户组为代理商，上级代理选着无
                            </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">状态</label>
                                <div class="col-xs-9">

                                    <select class="form-control" name="status">
                                        <option value="1">启用</option>
                                        <option value="0">禁用</option>
                                        <option value="2">删除</option>
                                    </select>
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

    {{--密码模态--}}
    <section>
        <div class="modal fade" id="editPwdModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-top: 123px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="overflow: auto;">
                        <form id="ruleForm" action="" class="form-horizontal" role="form">
                            <input type="hidden" name="id">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">登陆密码:</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-inline" name="title" placeholder="修改登陆密码"
                                           style="width: 150px;height: 35px;margin-right: 10px">
                                    <span style="color: #999999">不修改密码，请留空</span>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">支付密码:</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-inline" name="uri" placeholder="修改支付密码"
                                           style="width: 150px;height: 35px;margin-right: 10px">
                                    <span style="color: #999999">不修改密码，请留空</span>
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

    {{--费率--}}
    <section>
        <div class="modal fade" id="rateModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-top: 123px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="overflow: auto;">
                        <form id="ruleForm" action="" class="form-horizontal" role="form">
                            <input type="hidden" name="id">
                            {{ csrf_field() }}
                            <table class="table table-hover table-bordered">
                                <tr style="background: #eeeeee">
                                    <th>支付产品</th>
                                    <th>交易费率</th>
                                </tr>
                                <tr>
                                    <td>支付宝H5</td>
                                    <td><input type="text" class="form-control" placeholder="0.00" style="width: 90px">
                                    </td>
                                </tr>
                                <tr>
                                    <td>微信</td>
                                    <td><input type="text" class="form-control" placeholder="0.00" style="width: 90px">
                                    </td>
                                </tr>
                            </table>
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

    {{--通道--}}
    <section>
        <div class="modal fade" id="editTdModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-top: 123px">
                <div class="modal-content" style="width: 800px">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="overflow: auto;">
                        <form id="ruleForm" action="" class="form-horizontal" role="form">
                            <input type="hidden" name="id">
                            {{ csrf_field() }}
                            <table class="table table-hover">
                                <tr>
                                    <th>接口名称</th>
                                    <th>接口状态</th>
                                    <th>操作</th>
                                </tr>
                                <tr>
                                    <td>支付宝H5</td>
                                    <td><input class="switch-state" data-id="1" type="checkbox" checked></td>
                                    <td>
                                        <select name="" class="form-control" id="exampleInputAmount"
                                                style="width: 196px">
                                            <option value="">请选择</option>
                                            <option value="">XX支付</option>
                                            <option value="">XX支付</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>微信</td>
                                    <td>
                                        <input class="switch-state" data-id="1" type="checkbox" checked>
                                    </td>
                                    <td>
                                        <select name="" class="form-control" id="exampleInputAmount"
                                                style="width: 196px">
                                            <option value="">请选择</option>
                                            <option value="">XX支付</option>
                                            <option value="">XX支付</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>

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

    {{--提现--}}
    <section>
        <div class="modal fade" id="withdrawalModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-top: 123px">
                <div class="modal-content" style="width: 800px;height: 500px">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="overflow: auto;">
                        <form id="ruleForm" action="" class="form-inline" role="form">
                            <input type="hidden" name="id">
                            {{ csrf_field() }}
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">单笔最小金额:</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0.00">
                            </div>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">单笔最大金额:</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0.00">
                            </div>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">当日总金额:</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0.00">
                            </div>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">当日总次数:</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0">
                            </div>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px;border-right:1px">
                                    结算方式:
                                </div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0">
                                {{--<input type="radio" class="" id="exampleInputAmount">T+0--}}
                                {{--<input type="radio" class="" id="exampleInputAmount">T+1--}}
                            </div>
                            <br>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">手续费类型:</div>
                                <select name="" class="form-control" id="exampleInputAmount" style="width: 196px">
                                    <option value="" class="form-control" id="exampleInputAmount">请选择</option>
                                    <option value="" class="form-control" id="exampleInputAmount" selected>按比例结算
                                    </option>
                                    <option value="" class="form-control" id="exampleInputAmount">按单笔结算</option>
                                </select>
                            </div>
                            <br>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">提款比例(%):</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="%">
                            </div>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">单笔提款收取:</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0.00">
                            </div>
                            <div class="input-group" style="margin: 10px 5px">
                                <div class="input-group-addon" style="width: 120px;height: 34px">提款状态:</div>
                                <input type="text" class="form-control" id="exampleInputAmount" placeholder="0.00">
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
@endsection
@section("scripts")
    <script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>
        $(function () {
            // formValidator();

            // 状态修改
            $('.switch-state').bootstrapSwitch({
                onText: '正常',
                offText: '禁用',
                onColor: "primary",
                offColor: "danger",
                size: "small",
                onSwitchChange: function (event, state) {
                    var id = $(event.currentTarget).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '/admin/users/saveStatus',
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
                $("#ruleForm").data('bootstrapValidator').destroy();
                $('#ruleForm').data('bootstrapValidator', null);
                $('#ruleForm').get(0).reset();
                formValidator();
            });

        })


        /**
         * 显示模态框
         */
        // function edit(title) {
        //     $('.modal-title').html(title);
        //     $('#editModel').modal('show');
        // }

        function edit(title, id)
        {
            $.ajax({
                type: 'get',
                url: '/admin/users/'+id+'/edit',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(result){
                    if(result.status == 1)
                    {
                        $("#username").val(result.data['username']);
                        $("input[name='phone']").val(result.data['phone']);
                        $("input[name='email']").val(result.data['email']);
                        $("select[name='status']").val(result.data['status']);
                        $("select[name='groupType']").val(result.data['group_type']);
                        $("select[name='parentId']").val(result.data['parentId']);
                        $("input[name='id']").val(result.data['id']);
                        $("input[name='password']").val(result.data['password']);
                        $("input[name='password_confirmation']").val(result.data['password']);
                        $('.modal-title').html(title);
                        $('#addModel').modal('show');
                    }
                },
                error:function(XMLHttpRequest,textStatus){
                    toastr.error('通信失败');
                }
            })
        }

        function editPwd(title) {
            $('.modal-title').html(title);
            $('#editPwdModel').modal('show');
        }

        function rate(title) {
            $('.modal-title').html(title);
            $('#rateModel').modal('show');
        }

        function editTd(title) {
            $('.modal-title').html(title);
            $('#editTdModel').modal('show');
        }

        function withdrawal(title) {
            $('.modal-title').html(title);
            $('#withdrawalModel').modal('show');
        }

        /**
         * 提交
         */
        function save(_this) {
            //开启验证
            $('#ruleForm').data('bootstrapValidator').validate();
            if (!$('#ruleForm').data('bootstrapValidator').isValid()) {
                return;
            }
            _this.removeAttr('onclick');

            var $form = $('#ruleForm');
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
                    url: '/user/users',
                    data:{'id':id},
                    dataType:'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(result){
                        if(result.status)
                        {
                            _this.parents('tr').empty();
                            swal(result.msg, "会员已被删除。","success")
                        }else{
                            swal(result.msg, "会员没有被删除。","error")
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