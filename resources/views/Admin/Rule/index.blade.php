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
                        <h3 class="box-title">{{ $description }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-condensed table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>菜单名称</th>
                                <th>路由</th>
                                <th>动作</th>
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
                                    <button type="button" class="btn btn-primary btn-sm">添加子菜单</button>
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
@endsection('content')
@section("scripts")
<script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
<script>
    $(function () {
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
                            toastr.error(data.msg);
                        }
                    },
                    error:function(XMLHttpRequest,textStatus){
                        toastr.error('系统错误');
                    }
                })
            }
        })
    })
</script>
@endsection
