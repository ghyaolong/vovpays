@extends("Admin.User.commons.layout")
@section('title','首页管理')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper" style="padding: 0;margin: 0">



            <div class="row" style="margin-top: 20px;">
                <div class="col-md-3 col-sm-10" style="height: 133px;background: #ffffff;margin-left: 130px;margin-top: 20px">
                    <p style="font-size: 15px;margin: 15px;color: #999999">今日收益</p>
                    {{--<div class="row">--}}
                    <b class="col-md-6" style="font-size: 28px;display: inline-block">
                        32541.66RMB
                    </b>

                    <img src="/AdminLte/dist/img/agent/ltjt.png" alt="" style="margin-top:auto;float: right;margin-right: 30px">

                    <span class="glyphicon glyphicon-arrow-up"
                          style="font-size: 11px;margin:38px -180px;color: #3CC480">13.8%</span>
                    {{--</div>--}}
                </div>


                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-3 col-sm-10" style="height: 133px;background: #ffffff;margin-left: 35px">
                        <p style="font-size: 15px;margin: 15px;color: #999999">待提现金额</p>
                        {{--<div class="row">--}}
                        <b class="col-md-6" style="font-size: 28px;display: inline-block">
                            2541.66RMB
                        </b>

                        <img src="/AdminLte/dist/img/agent/ztjt.png" alt="" style="margin-top:auto;float: right;margin-right: 30px">

                        <span class="glyphicon glyphicon-arrow-up"
                              style="font-size: 11px;margin:38px -183px;color: #3CC480">13.8%</span>
                        {{--</div>--}}
                    </div>



                    <div class="row">
                        <div class="col-md-3 col-sm-10" style="height: 133px;background: #ffffff;margin-left: 35px">
                            <p style="font-size: 15px;margin: 15px;color: #999999">冻结金额</p>
                            {{--<div class="row">--}}
                            <b class="col-md-6" style="font-size: 28px;display: inline-block">
                                41.66RMB
                            </b>

                            <img src="/AdminLte/dist/img/agent/lvtjt.png" alt="" style="margin-top:auto;float: right;margin-right: 30px">

                            <span class="glyphicon glyphicon-arrow-up"
                                  style="font-size: 11px;margin:38px -185px;color: #3CC480">13.8%</span>
                            {{--</div>--}}
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-9 col-sm-9" style="width:1350px;background: #ffffff;margin:50px 160px">
                            <p style="font-size: 16px;margin: 15px;color: #999999">最近订单</p>

                            <table class="table table-hover">
                                <tr style="background: #f5f6f9">
                                    <th>#</th>
                                    <th>商户号</th>
                                    <th>订单号</th>
                                    <th>订单时间</th>
                                    <th>所走通道</th>
                                    <th>订单金额</th>
                                    <th>平台流水</th>
                                    <th>返回状态</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1009</td>
                                    <td>201807091436439767</td>
                                    <td>2018-07-09 14:36:48</td>
                                    <td>支付宝直通</td>
                                    <td>2.00</td>
                                    <td>20180709143648484857</td>
                                    <td>未处理</td>
                                </tr>
                            </table>

                            <a href="{{route('user.order')}}" style="margin: 15px">查看更多</a>
                            <br>
                            <br>

                        </div>

                    </div>

    </div>
@endsection