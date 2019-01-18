@extends('Court.Commons.layout')
@section('title','我的账户')
@section("css")
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="content-wrapper" style="padding: 0;margin: 0">
                    <section class="content">


                        <div class="row" style="margin-top: 20px">

                            <div class="col-md-4">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">个人信息</h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">


                                        <form class="form-horizontal">
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">用户名</label>
                                                    <div class="col-sm-8">
                                                        <label class="control-label"
                                                               style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                            {{ $court['username'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">商户号</label>
                                                    <div class="col-sm-8">
                                                        <label class="control-label"
                                                               style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                            {{ $court['merchant'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">剩余分数</label>
                                                    <div class="col-sm-8">
                                                        <label class="control-label"
                                                               style="color:red;word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                            {{ $court['quota'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">Email</label>
                                                    <div class="col-sm-8">
                                                        <label class="control-label"
                                                               style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                            {{ $court['email'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-4 control-label">电话</label>
                                                    <div class="col-sm-8">
                                                        <label class="control-label"
                                                               style="word-wrap:break-word; word-break:break-all; text-align:left;font-weight: 400;">
                                                            {{ $court['phone'] }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="box box-primary box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">上分记录</h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <table class="table table-bordered table-hover">
                                            <tr style="color: #999999;background:#f5f6f9">
                                                <th>#</th>
                                                <th>操作分数</th>
                                                <th>上分类型</th>
                                                <th>操作类型</th>
                                                <th>操作时间</th>
                                            </tr>
                                            @foreach($list as $v)
                                            <tr>
                                                <td>#</td>
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
                                        </table>
                                        {{$list->links()}}
                                    </div>
                                </div>
                            </div>


                            <!-- /.box -->
                        </div>
                        <!-- /.col -->

                    </section>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>


@endsection('content')




