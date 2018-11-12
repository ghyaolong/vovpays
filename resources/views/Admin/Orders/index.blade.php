@extends('Admin.Layouts.layout')

@section("css")
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
<div class="row">
        <!-- ./col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-rmb"></i></span>

                <div class="info-box-content">

						<span class="progress-description" style="padding-top: 10px;">
							订单金额 </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="info-box-number">0.00 元</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>

                <div class="info-box-content">

						<span class="progress-description" style="padding-top: 10px;">
							手续费 </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="info-box-number">0.00 元</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-rmb"></i></span>

                <div class="info-box-content">

						<span class="progress-description" style="padding-top: 10px;">
							平台收入 </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="info-box-number">0 笔</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-rmb"></i></span>

                <div class="info-box-content">

						<span class="progress-description" style="padding-top: 10px;">
							代理收入 </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="info-box-number">0 笔</span>
                </div>
            </div>
        </div>

        <!-- ./col -->

    <div class="col-xs-12">
        <div class="box">
            <a href="{{ route('orders.index') }}" class="btn pull-right"><i class="fa fa-undo"></i>刷新</a>
            <div class="box-body">
                <form action="{{ route('orders.index') }}" method="get">
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="系统订单" name="orderNo" @if(isset($query['orderNo'])) value="{{ $query['orderNo'] }}" @endif  />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="商户订单" name="underOrderNo" @if(isset($query['underOrderNo'])) value="{{ $query['underOrderNo'] }}" @endif />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="商户号" name="userNo" @if(isset($query['underOrderNo'])) value="{{ $query['underOrderNo'] }}" @endif />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" style="min-width:300px;" id="daterange-btn" placeholder="订单时间" name="orderTime" @if(isset($query['orderTime'])) value="{{ $query['orderTime'] }}" @endif />
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="channelId" name="channelId">
                                <option value="-1">选着通道</option>
                                @foreach($chanel_list as $v )
                                    <option value="{{ $v['id'] }}">{{ $v['channelName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="paymentId" name="paymentId">
                                <option value="-1">选着支付方式</option>
                                @foreach($payments_list as $v )
                                    <option value="{{ $v['id'] }}">{{ $v['paymentName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="status" name="status">
                                <option value="-1" @if(!isset($query['status']) || $query['status'] =='-1') selected  @endif >订单状态</option>
                                <option value="0" @if(isset($query['status']) && $query['status'] =='0') selected  @endif>发起支付</option>
                                <option value="1" @if(isset($query['status']) && $query['status'] =='1') selected  @endif >发起失败</option>
                                <option value="2" @if(isset($query['status']) && $query['status'] =='2') selected  @endif>未支付</option>
                                <option value="3" @if(isset($query['status']) && $query['status'] =='3') selected  @endif>支付成功</option>
                                <option value="4" @if(isset($query['status']) && $query['status'] =='4') selected  @endif>支付异常</option>
                                <option value="5" @if(isset($query['status']) && $query['status'] =='5') selected  @endif>已删除</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" id="btnSearch">查询</button>
                    </div>
                </form>
            </div>
                <!-- /.box-body -->
            <div class="box-body">
                <table id="example2" class="table table-striped table-condensed table-bordered table-hover dataTable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>商户号</th>
                        <th>系统订单</th>
                        <th>商户订单</th>
                        <th>订单金额</th>
                        <th>手续费</th>
                        <th>平台收入</th>
                        <th>代理收入</th>
                        <th>商户收入</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $v)
                        <tr>
                            <td>{{ $v['id'] }}</td>
                            <td>{{ $v['username'] }}</td>
                            <td>{{ $v['orderNo'] }}</td>
                            <td>{{ $v['underOrderNo'] }}</td>
                            <td>{{ $v['orderRate'] }}</td>
                            <td>{{ $v['sysAmount'] }}</td>
                            <td>{{ $v['agentAmount'] }}</td>
                            <td>{{ $v['userAmount'] }}</td>
                            <td>{{ $v['orderRate'] }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" onclick="info('订单详情',{{ $v['id'] }})">详情</button>
                            </td>
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
@endsection('content')
@section("scripts")
    <script src="{{ asset('AdminLTE/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(function(){
            $('#daterange-btn').val(moment().startOf('day').format('YYYY-MM-DD HH:mm:ss') + ' - ' + moment().format('YYYY-MM-DD HH:mm:ss'));

            $('#daterange-btn').daterangepicker(
                    {
                        dateLimit:{days:30},
                        timePicker : false,
                        timePicker24Hour : false,
                        linkedCalendars : false,
                        autoUpdateInput : false,
                        ranges : {
                            '今日'    : [moment().startOf('day'), moment()],
                            '昨日'    : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            '最近7天' : [moment().subtract(6, 'days'), moment()],
                            '最近30天': [moment().subtract(29, 'days'), moment()],
                            '本月'    : [moment().startOf('month'), moment().endOf('month')],
                            '上月'    : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        },
                        opens : 'right', //日期选择框的弹出位置
                        format : 'YYYY-MM-DD HH:mm:ss', //控件中from和to 显示的日期格式
                        locale : {
                            applyLabel : '确定',
                            cancelLabel : '取消',
                            fromLabel : '起始时间',
                            toLabel : '结束时间',
                            customRangeLabel : '自定义',
                            daysOfWeek : [ '日', '一', '二', '三', '四', '五', '六' ],
                            monthNames : [ '一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月' ],
                            firstDay : 1,
                            endDate : moment(),
                            format : 'YYYY-MM-DD HH:mm:ss',
                        },
                        startDate: moment().startOf('day'),
                        endDate  : moment()
                    },
                    function(start, end) {
                        $('#daterange-btn').val(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'))
                    });
        })


        /**
         * 详情
         * @param id
         * @param title
         */
        function info(title, id)
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
    </script>
@endsection



