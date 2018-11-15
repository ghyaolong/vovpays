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

                                <form id="ruleForm" action="{{ route('user') }}" class="form-horizontal" role="form">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">开户行:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="title" placeholder="请输入银行名称">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">支行名称:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="uri" placeholder="请输入支行名称">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">开户名:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="rule" placeholder="请输入开户名">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">银行卡号:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="icon" placeholder="请输入银行卡号">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">所属省:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="sort" placeholder="所属省份">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-xs-3 control-label">所属市:</label>
                                        <div class="col-xs-9">
                                            <input type="text" class="form-control" name="sort" placeholder="所属城市">
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
        </div>
    </div>


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