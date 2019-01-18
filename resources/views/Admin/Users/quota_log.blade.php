@extends('Admin.Layouts.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <button onclick="javascript:history.back(-1);" class="btn btn-primary"><i class="fa fa-undo"></i>返回上一页</button>
                </div>
                <!-- /.box-header -->
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="{{ route('users.quotaLog',array('id'=>$uid)) }}" method="get">
                            <div class="form-inline">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="时间" name="merchant"
                                           @if(isset($query['merchant'])) value="{{ $query['merchant'] }}" @endif />
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnSearch">查询</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-condensed table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>商户名</th>
                            <th>操作分数</th>
                            <th>上分类型</th>
                            <th>操作类型</th>
                            <th>操作时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $v)
                            <tr>
                                <td>{{ $v->user->username }}</td>
                                <td>{{ $v['quota'] }}</td>
                                <td>
                                    @if($v['quota_type'] == 0)
                                        <span class="btn btn-success btn-sm">增加</span>
                                    @else
                                        <span class="btn btn-danger btn-sm">减少</span>
                                    @endif
                                </td>
                                <td>
                                    @if($v['action_type'] == 0)
                                        <span class="btn btn-success btn-sm">手动</span>
                                    @else
                                        <span class="btn btn-primary btn-sm">订单</span>
                                    @endif
                                </td>
                                <td>{{ $v['created_at'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @include('Admin.Commons._page')
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection('content')



