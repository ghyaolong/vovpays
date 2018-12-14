@extends("User.Commons.layout")
@section('title','交易管理')
@section("css")
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')

    {{--<div class="row" style="margin-top: 20px">--}}
        {{--<!-- ./col -->--}}
        {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="info-box bg-aqua">--}}
                {{--<span class="info-box-icon"><i class="fa fa-rmb"></i></span>--}}

                {{--<div class="info-box-content">--}}

						{{--<span class="progress-description" style="padding-top: 10px;">--}}
							{{--订单金额 </span>--}}
                    {{--<div class="progress">--}}
                        {{--<div class="progress-bar" style="width: 100%"></div>--}}
                    {{--</div>--}}
                    {{--<span class="info-box-number">0.00 元</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="info-box bg-aqua">--}}
                {{--<span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>--}}

                {{--<div class="info-box-content">--}}

						{{--<span class="progress-description" style="padding-top: 10px;">--}}
							{{--手续费 </span>--}}
                    {{--<div class="progress">--}}
                        {{--<div class="progress-bar" style="width: 100%"></div>--}}
                    {{--</div>--}}
                    {{--<span class="info-box-number">0.00 元</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="info-box bg-aqua">--}}
                {{--<span class="info-box-icon"><i class="fa fa-rmb"></i></span>--}}

                {{--<div class="info-box-content">--}}

						{{--<span class="progress-description" style="padding-top: 10px;">--}}
							{{--平台收入 </span>--}}
                    {{--<div class="progress">--}}
                        {{--<div class="progress-bar" style="width: 100%"></div>--}}
                    {{--</div>--}}
                    {{--<span class="info-box-number">0 笔</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-md-3 col-sm-6 col-xs-12">--}}
            {{--<div class="info-box bg-aqua">--}}
                {{--<span class="info-box-icon"><i class="fa fa-rmb"></i></span>--}}

                {{--<div class="info-box-content">--}}

						{{--<span class="progress-description" style="padding-top: 10px;">--}}
							{{--代理收入 </span>--}}
                    {{--<div class="progress">--}}
                        {{--<div class="progress-bar" style="width: 100%"></div>--}}
                    {{--</div>--}}
                    {{--<span class="info-box-number">0 笔</span>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="col-md-12">--}}
            {{--<div class="box box-primary box-solid">--}}
                {{--<div class="box-header with-border">--}}
                    {{--<h3 class="box-title">订单记录</h3>--}}

                    {{--<div class="box-tools pull-right">--}}
                        {{--<button type="button" class="btn btn-box-tool" data-widget="collapse">--}}
                            {{--<i class="fa fa-minus"></i>--}}
                        {{--</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="box-body">--}}
                    {{--<!-- ./col -->--}}
                    {{--<form class="navbar-form navbar-left" action="">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" class="form-control" style="min-width:300px;" id="daterange-btn"--}}
                                   {{--placeholder="订单时间" name="orderTime"--}}
                                   {{--@if(isset($query['orderTime'])) value="{{ $query['orderTime'] }}" @endif />--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<select class="form-control" id="channelId" name="channelId">--}}
                                {{--<option value="-1">选着通道</option>--}}
                                {{--@foreach($chanel_list as $v )--}}
                                    {{--<option value="{{ $v['id'] }}">{{ $v['channelName'] }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<select class="form-control" id="paymentId" name="paymentId">--}}
                                {{--<option value="-1">选着支付方式</option>--}}
                                {{--@foreach($payments_list as $v )--}}
                                    {{--<option value="{{ $v['id'] }}">{{ $v['paymentName'] }}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<select class="form-control" id="status" name="status">--}}
                                {{--<option value="-1"--}}
                                        {{--@if(!isset($query['status']) || $query['status'] =='-1') selected @endif >--}}
                                    {{--订单状态--}}
                                {{--</option>--}}
                                {{--<option value="0"--}}
                                        {{--@if(isset($query['status']) && $query['status'] =='0') selected @endif>--}}
                                    {{--发起支付--}}
                                {{--</option>--}}
                                {{--<option value="1"--}}
                                        {{--@if(isset($query['status']) && $query['status'] =='1') selected @endif >--}}
                                    {{--发起失败--}}
                                {{--</option>--}}
                                {{--<option value="2"--}}
                                        {{--@if(isset($query['status']) && $query['status'] =='2') selected @endif>--}}
                                    {{--未支付--}}
                                {{--</option>--}}
                                {{--<option value="3"--}}
                                        {{--@if(isset($query['status']) && $query['status'] =='3') selected @endif>--}}
                                    {{--支付成功--}}
                                {{--</option>--}}
                                {{--<option value="4"--}}
                                        {{--@if(isset($query['status']) && $query['status'] =='4') selected @endif>--}}
                                    {{--支付异常--}}
                                {{--</option>--}}
                                {{--<option value="5"--}}
                                        {{--@if(isset($query['status']) && $query['status'] =='5') selected @endif>--}}
                                    {{--已删除--}}
                                {{--</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" class="form-control" name="orderNo" placeholder="系统订单">--}}
                        {{--</div>&nbsp;&nbsp;--}}

                        {{--<button type="submit" class="btn btn-info">搜索</button>&nbsp;&nbsp;--}}
                    {{--</form>--}}
                    {{--<div class="box-body" style="margin-top: 45px">--}}
                        {{--<table id="example2" class="table table-condensed table-bordered table-hover">--}}
                            {{--<tr style="color: #999999">--}}
                                {{--<th>通道名称</th>--}}
                                {{--<th>支付方式</th>--}}
                                {{--<th>商户号</th>--}}
                                {{--<th>系统订单号</th>--}}
                                {{--<th>订单金额</th>--}}
                                {{--<th>手续费</th>--}}
                                {{--<th>支付时间</th>--}}
                                {{--<th>订单状态</th>--}}
                                {{--<th>操作</th>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<td colspan="10" style="text-align: center">没有找到匹配数据</td>--}}
                            {{--</tr>--}}
                            {{--<tbody>--}}
                            {{--@foreach($orders as $v)--}}
                                {{--<tr>--}}
                                    {{--<td>{{ $v['username'] }}</td>--}}
                                    {{--<td>{{ $v['orderNo'] }}</td>--}}
                                    {{--<td>{{ $v['underOrderNo'] }}</td>--}}
                                    {{--<td>{{ $v['orderRate'] }}</td>--}}
                                    {{--<td>{{ $v['sysAmount'] }}</td>--}}
                                    {{--<td>{{ $v['agentAmount'] }}</td>--}}
                                    {{--<td>{{ $v['userAmount'] }}</td>--}}
                                    {{--<td>{{ $v['orderRate'] }}</td>--}}
                                    {{--<td>--}}
                                        {{--<button type="button" class="btn btn-success btn-sm"--}}
                                                {{--onclick="info('订单详情',{{ $v['id'] }})">详情--}}
                                        {{--</button>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                            {{--</tbody>--}}

                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--{{$orders->appends($data)->links()}}--}}

    <div class="row" style="">
        <div class="col-md-offset-1 col-md-3 col-lg-3 col-xs-offset-1 col-xs-10" style="background: #ffffff;margin-top: 30px">
            <div style="height: 85px;padding-top: 20px">
                <span class="col-md-3">
                    <img src="{{ asset('AdminLTE/dist/img/agent/Icon1.png') }}" alt="">
                    </span>
                <span class="col-md-4" style="margin-left: -40px">
                <b style="font-size: 18px;color: #56D9FE;">$163858.35</b>
                    <br>
                    交易总金额
                </span>
            </div>
        </div>

        <div class="col-md-offset-1 col-md-3 col-lg-3 col-xs-10" style="background: #ffffff;margin-left: 70px;margin-top: 30px">
            <div style="height: 85px;padding-top: 20px">
                <span class="col-md-3">
                    <img src="{{ asset('AdminLTE/dist/img/agent/Icon2.png') }}" alt="">
                    </span>
                <span class="col-md-4" style="margin-left: -40px">
                <b style="font-size: 18px;color: #A3A0FB;">$163858.35</b>
                    <br>
                    实际支付金额
                </span>
            </div>
        </div>

        <div class="col-md-offset-1 col-md-3 col-lg-3 col-xs-10" style="background: #ffffff;margin-left: 70px;margin-top: 30px">
            <div class="col-md-11" style="height: 85px;padding-top: 20px;margin-left: -15px">
                <span class="col-md-3">
                    <img src="{{ asset('AdminLTE/dist/img/agent/Icon3.png') }}" alt="">
                </span>
                <span class="col-md-6" style="margin-left: -40px">
                <span style="font-size: 16px;color: #4AD991;">11:36 早上<br>
                    2018年10月13日</span>
                </span>
                <span style="font-size: 25px;color: #4AD991;">星期五</span>
            </div>
            <a href="#" id="daterange-btn">
                <div class="col-md-1"
                     style="background: #4AD991;margin: 0px;height: 85px;line-height: 85px;width: 45px">
                    <img src="{{ asset('AdminLTE/dist/img/agent/282.png') }}" alt="" style="margin-left: -5px">
                </div>
            </a>
        </div>

        <div class="col-md-offset-1 col-md-10 col-xs-12" style="background: #ffffff;margin-top: 30px">
            <p style="font-size: 16px;margin: 15px;color: #999999">项目
                &emsp;&emsp;<input type="text" style="font-size: 13px" placeholder="🔍搜索交易、发票或帮助"></p>

            <table class="table table-hover">
                <tr style="background: #f5f6f9">
                    <th>#</th>
                    <th>类型</th>
                    <th>商户编号</th>
                    <th>订单号</th>
                    <th>交易金额</th>
                    <th>支付通道</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>收款</td>
                    <td>1009</td>
                    <td>201807091436439767</td>
                    <td>200</td>
                    <td>支付宝直通</td>
                    <td>未处理</td>
                    <td><a href="#">查看</a></td>
                </tr>
            </table>

        </div>

    </div>
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