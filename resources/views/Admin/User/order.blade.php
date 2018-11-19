@extends("Admin.User.commons.layout")
@section('title','订单管理')
@section("css")
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
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
                <div class="box-body">
                    <div class="container-fluid">
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <form class="navbar-form navbar-left" action="">
                                {{--{{ csrf_field() }}--}}
                                <div class="form-group">
                                    <input type="text" class="form-control" name="orderNo" placeholder="系统订单">
                                </div>&nbsp;&nbsp;

                                <div class="form-group">
                                    <input type="text" class="form-control" name="underOrderNo" placeholder="商户订单">
                                </div>&nbsp;&nbsp;

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="商户号" name="userNo"/>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" style="min-width:300px;" id="daterange-btn"
                                           placeholder="订单时间" name="orderTime"
                                           @if(isset($query['orderTime'])) value="{{ $query['orderTime'] }}" @endif />
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
                                        <option value="-1"
                                                @if(!isset($query['status']) || $query['status'] =='-1') selected @endif >
                                            订单状态
                                        </option>
                                        <option value="0"
                                                @if(isset($query['status']) && $query['status'] =='0') selected @endif>
                                            发起支付
                                        </option>
                                        <option value="1"
                                                @if(isset($query['status']) && $query['status'] =='1') selected @endif >
                                            发起失败
                                        </option>
                                        <option value="2"
                                                @if(isset($query['status']) && $query['status'] =='2') selected @endif>
                                            未支付
                                        </option>
                                        <option value="3"
                                                @if(isset($query['status']) && $query['status'] =='3') selected @endif>
                                            支付成功
                                        </option>
                                        <option value="4"
                                                @if(isset($query['status']) && $query['status'] =='4') selected @endif>
                                            支付异常
                                        </option>
                                        <option value="5"
                                                @if(isset($query['status']) && $query['status'] =='5') selected @endif>
                                            已删除
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info glyphicon glyphicon-search ">搜索</button>&nbsp;&nbsp;
                                <button type="submit" class="btn btn-danger glyphicon glyphicon-export ">导出数据</button>
                            </form>

                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                    <br>
                    <table id="example2" class="table table-condensed table-bordered table-hover">
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
                        <tr>
                            <td colspan="10" style="text-align: center">没有找到匹配数据</td>
                        </tr>
                        <tbody>
                        @foreach($orders as $v)
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
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="info('订单详情',{{ $v['id'] }})">详情
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--{{$orders->appends($data)->links()}}--}}
@endsection

@section("scripts")
    <script src="{{ asset('AdminLTE/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(function () {
            $('#daterange-btn').val(moment().startOf('day').format('YYYY-MM-DD HH:mm:ss') + ' - ' + moment().format('YYYY-MM-DD HH:mm:ss'));

            $('#daterange-btn').daterangepicker(
                {
                    dateLimit: {days: 30},
                    timePicker: false,
                    timePicker24Hour: false,
                    linkedCalendars: false,
                    autoUpdateInput: false,
                    ranges: {
                        '今日': [moment().startOf('day'), moment()],
                        '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '最近7天': [moment().subtract(6, 'days'), moment()],
                        '最近30天': [moment().subtract(29, 'days'), moment()],
                        '本月': [moment().startOf('month'), moment().endOf('month')],
                        '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    opens: 'right', //日期选择框的弹出位置
                    format: 'YYYY-MM-DD HH:mm:ss', //控件中from和to 显示的日期格式
                    locale: {
                        applyLabel: '确定',
                        cancelLabel: '取消',
                        fromLabel: '起始时间',
                        toLabel: '结束时间',
                        customRangeLabel: '自定义',
                        daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
                        monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                        firstDay: 1,
                        endDate: moment(),
                        format: 'YYYY-MM-DD HH:mm:ss',
                    },
                    startDate: moment().startOf('day'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#daterange-btn').val(start.format('YYYY-MM-DD HH:mm:ss') + ' - ' + end.format('YYYY-MM-DD HH:mm:ss'))
                });
        })


        /**
         * 详情
         * @param id
         * @param title
         */
        function info(title, id) {
            $.ajax({
                type: 'get',
                url: '/admin/users/' + id + '/edit',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    if (result.status == 1) {
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
                error: function (XMLHttpRequest, textStatus) {
                    toastr.error('通信失败');
                }
            })
        }
    </script>
@endsection