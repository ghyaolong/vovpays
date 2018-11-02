@extends('admin.layouts.layout')
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
                                <td></td>
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
