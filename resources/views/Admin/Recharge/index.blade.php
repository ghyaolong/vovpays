@extends("Admin.Commons.layout")    @section('title',$title)

@section("css")
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
    <div class="row">


        <div class="col-xs-12">
            <div class="box">

                <a href="{{ route('recharge.index') }}" class="btn pull-right"><i class="fa fa-undo"></i>刷新</a>
                <div class="box-body">
                    <form action="{{ route('recharge.index') }}" method="get">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="充值订单号" name="orderNo"
                                       @if(isset($query['orderNo'])) value="{{ $query['orderNo'] }}" @endif />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="商户号" name="merchant"
                                       @if(isset($query['merchant'])) value="{{ $query['merchant'] }}" @endif />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" style="min-width:300px;" id="daterange-btn"
                                       placeholder="创建时间" name="created_at"
                                       @if(isset($query['created_at'])) value="{{ $query['created_at'] }}" @endif />
                            </div>


                            <div class="form-group">
                                <select class="form-control" id="status" name="pay_status">
                                    <option value="-1"
                                            @if(!isset($query['pay_status']) || $query['pay_status'] =='-1') selected @endif >
                                        充值状态
                                    </option>
                                    <option value="0"
                                            @if(isset($query['pay_status']) && $query['pay_status'] =='0') selected @endif>未支付
                                    </option>
                                    <option value="1"
                                            @if(isset($query['pay_status']) && $query['pay_status'] =='1') selected @endif >已支付
                                    </option>
                                    <option value="3"
                                            @if(isset($query['pay_status']) && $query['pay_status'] =='3') selected @endif>支付异常
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" id="btnSearch">查询</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
                <div class="box-body">
                    <table id="example2"
                           class="table table-striped table-condensed table-bordered table-hover dataTable">
                        <thead>
                        <tr>
                            <th>商户名</th>
                            <th>商户号</th>
                            <th>充值订单号</th>
                            {{--<th>实付金额 </th>--}}
                            <th>充值金额</th>
                            <th>充值状态</th>
                            <th>处理时间</th>
                            <th>充值备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $v)
                            <tr>
                                <td>{{ $v->user->username }}</td>
                                <td>{{ $v->merchant }}</td>
                                <td>{{ $v['orderNo'] }}</td>
                                <td><span style="color: #e56c69">{{ $v['actual_amount'] }}</span></td>
                                {{--<td><span style="color: #f2aa25">{{ $v['recharge_amount'] }}</span></td>--}}
                                <td>{{ $v->status }}</td>
                                <td>{{ $v['created_at'] }}</td>
                                <td><span style="color: green">{{ $v['orderMk'] }}</span></td>
                                <td>
                                    @if($v['pay_status']=='')

                                        <button type="button" class="btn btn-warning btn-sm"
                                                onclick="changeStatus({{ $v['id'] }},this)">改为成功
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @include('Admin.Commons._page')
                </div>

            </div>

        </div>

    </div>


@endsection('content')
@section("scripts")
    <script src="{{ asset('AdminLTE/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(function () {


            /**
             * 充值操作提交
             */

            $('#daterange-btn').val();
            // moment().startOf('day').format('YYYY-MM-DD HH:mm:ss') + ' - ' + moment().format('YYYY-MM-DD HH:mm:ss')

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

        function changeStatus(id,that) {
            swal({
                title: "您确定要改为成功吗？",
                text: "修改后不能恢复！",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                showLoaderOnConfirm: true,
            }, function(){
                $.ajax({
                    type: 'post',
                    url: '{{ route('recharge.saveStatus') }}',
                    dataType: 'json',
                    data: {'id': id},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.status == 1) {
                            toastr.success(result.msg);
                            $(that).remove();
                        } else {
                            toastr.error(result.msg);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus) {
                        toastr.error('通信失败');
                    }
                })
            });
        }



    </script>
@endsection



