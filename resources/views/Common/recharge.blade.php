@extends($module.".Commons.layout")
@section('title','账户充值')
@section('css')
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
<div class="row" style="margin-top: 20px">
    <div class="col-md-3">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">充值</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div>预存手续费余额：{{ auth()->user()->Statistical->balance }}</div>
                <form class="form-horizontal" id="form" action="{{ route(strtolower($module).'.addrecharge') }}" style="margin: auto 60px" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-xs-5 control-label">充值金额:</label>
                        <div class="col-xs-7">
                            <input type="text" class="form-control" name="money" value="0">
                        </div>
                    </div>
                    <br>
                    <div class="form-group" style="margin-left: 50px">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="button" onclick="save($(this))" class="btn btn-reddit">立即支付</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-9">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">充值记录</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form class="navbar-form navbar-left" action="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control"  @if(isset($query['order_no'])) value="{{ $query['order_no'] }}" @endif name="order_no" placeholder="订单号">
                    </div>
                    <button type="submit" class="btn btn-info">搜索</button>&nbsp;&nbsp;
                </form>
                <br>
                <br>
                <br>

                <div class="container-fluid">
                    <table id="example2" class="table table-condensed table-bordered table-hover">
                        <tr style="color: #999999">
                            <th>订单号</th>
                            <th>实付金额</th>
                            <th>支付时间</th>
                            <th>订单状态</th>
                        </tr>
                        @if(count($list))
                            @foreach($list as $k=>$v)
                            <tr>
                                <td>{{ $v->orderNo }}</td>
                                <td>{{ $v->actual_amount }}</td>
                                <td>{{ $v['updated_at'] }}</td>
                                <td>
                                    @if($v['pay_status'] == 2)
                                        <span style="color:#dd4b39;font-weight: bold">异常</span>
                                    @elseif($v['pay_status'] == 0)
                                        <span style="color:orange;font-weight: bold">未支付</span>
                                    @elseif($v['pay_status'] == 1)
                                        <span style="color:#008d4c;font-weight: bold">已支付</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="7" style="text-align: center">没有找到匹配数据</td>
                        </tr>
                        @endif
                    </table>
                    @include($module.'.Commons._page')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AvatarModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true"
     data-backdrop="static" style="height: auto;">
    <div class="modal-dialog" style="width: 400px;margin: 30px auto;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel" style="text-align: center;"></h4>
            </div>
            <div class="modal-body iqrcode" style="overflow-y: auto; text-align: center; background-color: #01a9f4;">
                <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
                    <div class="row">
                        <div class="col-md-12" style="overflow: hidden;">
                            <img id="show_qrcode" src="/image/pay/app.png" style=" padding: 20px; margin:0px; background-color: #fff;">
                            <div id="qrcode"></div>
                        </div>
                    </div>
                </div>
                <div class="time-item">
                    <div class="time-item" id="msg">付款即时到账 未到账可联系我们</div>
                    <strong id="hour_show"><s id="h"></s>0时</strong>
                    <strong id="minute_show"><s></s>0分</strong>
                    <strong id="second_show"><s></s>0秒</strong>
                    <input type="hidden" name="orderNo" id="orderNo">
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">关闭对话框</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section("scripts")
    <script src="{{ asset('AdminLTE/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.qrcode.min.js') }}"></script>
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
         *提交
         */
        function save(_this) {
            _this.removeAttr('onclick');

            var m = $("input[name='money']").val();
            if(m < 100){
                toastr.error('充值金额最小100');
                _this.attr("onclick", "save($(this))");
                return false;
            }

            var $form = $('#form');
            $.post($form.attr('action'), $form.serialize(), function (result) {
                if (result.status) {
                    showAvatar(result.data.payurl);
                    $('#addModalLabel').html('订单金额：'+result.data.money);
                    $('#orderNo').val(result.data.orderNo);
                    _this.attr("onclick", "save($(this))");
                    timer(180);
                } else {
                    _this.attr("onclick", "save($(this))");
                    toastr.error(result.msg);
                }
            }, 'json');

        }

        // 模态关闭
        $('#AvatarModal').on('hidden.bs.modal', function () {
            $('#addModalLabel').html('');
            $("#orderNo").val('');
            $("#msg").html('');
        });

        function showAvatar(strcode) {
            if (strcode) {
                qrshow(strcode);
            }
            $('#AvatarModal').modal('show');
        }

        function qrshow(strcode) {
            var qrcode = $('#qrcode').qrcode({ text: strcode }).hide();
            var canvas = qrcode.find('canvas').get(0);
            $('#show_qrcode').attr('src', canvas.toDataURL('image/jpg'));
            canvas.remove();
        }

        function timer(intDiff) {
            var i = 0;
            myTimer = window.setInterval(function () {
                i++;
                var day = 0,
                    hour = 0,
                    minute = 0,
                    second = 0;//时间默认值
                if (intDiff > 0) {
                    day = Math.floor(intDiff / (60 * 60 * 24));
                    hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
                    minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
                    second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
                }
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                $('#hour_show').html('<s id="h"></s>' + hour + '时');
                $('#minute_show').html('<s></s>' + minute + '分');
                $('#second_show').html('<s></s>' + second + '秒');
                if (hour <= 0 && minute <= 0 && second <= 0) {
                    qrcode_timeout()
                    clearInterval(myTimer);
                }
                intDiff--;
                checkdata();
            }, 1000);
        }

        function checkdata(){
            $.ajax({
                url: '{{ route(strtolower($module).'.callback') }}',
                data: {"trade_no": $("#orderNo").val()},
                type:'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType:'json',
                success: function (data) {
                    if (data.status == 'success'){
                        window.clearInterval(timer);
                        $("#show_qrcode").attr("src","{{ asset('images/Pay/pay_ok.png') }}");
                        $("#money").text("支付成功");
                        $("#msg").html("<h1>订单已支付成功</h1>");
                        $(".paybtn").hide();
                        clearInterval(myTimer);
                    }
                }
            })
        }

        function qrcode_timeout(){
            $('#show_qrcode').attr("src","{{ asset('images/Pay/qrcode_timeout.png') }}");
            $('.paybtn').hide();
            $('#msg').html("<h1>订单已过期,请重新支付</h1>");
        }

    </script>
@endsection