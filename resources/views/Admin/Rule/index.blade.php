@extends('Admin.Layouts.layout')

@section("css")
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <button type="button" class="btn btn-primary" onclick="showModel('添加菜单')">添加菜单</button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-condensed table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>菜单名称</th>
                                <th>菜单路由</th>
                                <th>菜单动作</th>
                                <th>是否验证</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $v)
                                <tr>
                                    <td>{{ $v['id'] }}</td>
                                    <td>{{ $v['ltitle'] }}</td>
                                    <td>{{ $v['uri'] }}</td>
                                    <td>{{ $v['rule'] }}</td>
                                    <td>
                                        <input class="switch-state" data-id="{{ $v['id'] }}" type="checkbox" @if($v['is_check'] == 1) checked @endif >
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm">编辑</button>
                                        <button type="button" class="btn btn-danger btn-sm">删除</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <section>
        <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-top: 123px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="overflow: auto;">
                        <form id="ruleForm" action="{{ route('rules.store') }}" class="form-horizontal" role="form">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">父级菜单</label>
                                <div class="col-xs-9">
                                    <select class="form-control selectpicker" name="pid">
                                        <option value="0">ROOT</option>
                                        @foreach($list as $v)
                                            <option value="{{ $v['id'] }}">{{ $v['ltitle'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">菜单名称</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="title" placeholder="菜单名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">菜单路由</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="uri" placeholder="菜单路由">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">菜单动作</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="rule" placeholder="菜单动作">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">菜单图标</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="icon" placeholder="菜单图标">
                                    <span class="help-block">
                                    <i class="fa fa-info-circle"></i>图标地址
                                    <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons</a>
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">排序</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" name="sort" placeholder="排序">
                                    <span class="help-block"><i class="fa fa-info-circle"></i>值越大排名越靠前</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-xs-3 control-label">是否验证</label>
                                <div class="col-xs-9">

                                    <select class="form-control" name="is_check">
                                        <option value="0">否</option>
                                        <option value="1" selected="selected">是</option>
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
@endsection('content')
@section("scripts")
    <script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script>
        $(function () {
            formValidator();
            $('.switch-state').bootstrapSwitch({
                onText:'是',
                offText:'否' ,
                onColor:"primary",
                offColor:"danger",
                size:"small",
                onSwitchChange:function(event,state) {
                    var id =  $(event.currentTarget).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '/admin/rules/saveCheck',
                        data:{'status':state,'id':id},
                        dataType:'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(data){
                            if(data.status)
                            {
                                toastr.success(data.msg);
                            }else{
                                $('#addModel').modal('hide');
                                toastr.error(data.msg);
                            }
                        },
                        error:function(XMLHttpRequest,textStatus){
                            toastr.error('系统错误');
                        }
                    })
                }
            })

            $('#addModel').on('hidden.bs.modal', function() {
                $("#ruleForm").data('bootstrapValidator').destroy();
                $('#ruleForm').data('bootstrapValidator', null);
                $('#ruleForm').get(0).reset();
                formValidator();
            });

        })

        function save(_this){
            //开启验证
            $('#ruleForm').data('bootstrapValidator').validate();
            if(!$('#ruleForm').data('bootstrapValidator').isValid()){
                return ;
            }
            _this.removeAttr('onclick');

            var $form = $('#ruleForm');
            $.post($form.attr('action'), $form.serialize(), function(result) {
                if(result.status)
                {
                    $('#addModel').modal('hide');
                    setInterval(function(){
                        window.location.reload();
                    },500);

                    toastr.success(result.msg);
                }else{
                    $('#addModel').modal('hide');
                    _this.attr("onclick","save($(this))");
                    toastr.error(result.msg);
                }
            }, 'json');

        }

        function formValidator()
        {
            $('#ruleForm').bootstrapValidator({
                message: '输入值不合法',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    title: {
                        message: '菜单名称不合法',
                        validators: {
                            notEmpty: {
                                message: '菜单名称不能为空！'
                            },
                        }
                    },
                    uri: {
                        validators: {
                            notEmpty: {
                                message: '菜单路由不能为空!'
                            }
                        }
                    }
                }
            });
        }

        function showModel(title)
        {
            $('.modal-title').html(title);
            $('#addModel').modal('show');
        }

    </script>
@endsection



