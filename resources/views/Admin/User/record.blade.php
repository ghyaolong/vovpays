@extends("Admin.User.commons.layout")
@section('title','结算记录')
@section('content')
    <table class="table table-hover">
        <tr>
            <td>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <form class="navbar-form navbar-left" action="">
                                {{--{{ csrf_field() }}--}}

                                <div class="form-group">
                                    申请起始时间:<input type="date" class="form-control" name="pay_applydate"
                                                  placeholder="创建起始时间">
                                </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <div class="form-group">
                                    结算起始时间:<input type="date" class="form-control" name="pay_applydate1"
                                                  placeholder="创建起始时间">
                                </div>&nbsp;&nbsp;


                                <div class="form-group">
                                    <select name="pay_zh_tongdao" id="" class="form-control">
                                        <option value="">全部通道</option>
                                        <option value="同心支付">同心支付</option>
                                        <option value="中天e支付">中天e支付</option>
                                    </select>
                                </div>&nbsp;&nbsp;

                                <div class="form-group">
                                    <select name="queryed" id="" class="form-control">
                                        <option value="">全部状态</option>
                                        <option value="1">成功</option>
                                        <option value="0">未处理</option>
                                    </select>
                                </div>&nbsp;&nbsp;
                                <div class="form-group">
                                    <select name="pay_bankname" id="" class="form-control">
                                        <option value="">全部类型</option>
                                        {{--<option value="中国银行">中国银行</option>--}}
                                        {{--<option value="农业银行">农业银行</option>--}}
                                        {{--<option value="工商银行">工商银行</option>--}}
                                        {{--<option value="建设银行">建设银行</option>--}}
                                        {{--<option value="招商银行">招商银行</option>--}}
                                        {{--<option value="支付宝H5">支付宝H5</option>--}}
                                    </select>
                                </div>&nbsp;&nbsp;
                                <button type="submit" class="btn btn-info glyphicon glyphicon-search">搜索</button>
                                <button type="submit" class="btn btn-danger glyphicon glyphicon-export">导出记录</button>
                            </form>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                </nav>
            </td>
        </tr>

        <tr style="background: #ffffff">
            <th>
                交易总额:<b style="color: red">&emsp;986.36 元</b>
                &emsp;&emsp;&emsp;总手续费:<b style="color: coral">&emsp;36 元</b>
                &emsp;&emsp;&emsp;支付金额:<b style="color: coral">&emsp;950.36 元</b>
                &emsp;&emsp;&emsp;平台收入:<b style="color: darkviolet">&emsp;15 元</b>
                &emsp;&emsp;&emsp;代理收入:<b style="color: darkviolet">&emsp;0.00 元</b>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                共条18000记录，本页显示{{count($orders)}}1条
            </th>
        </tr>
    </table>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="example2" class="table table-condensed table-bordered table-hover">
                        <tr>
                            <th>#</th>
                            <th>类型</th>
                            <th>商户编号</th>
                            <th>结算金额</th>
                            <th>手续费</th>
                            <th>到账金额</th>
                            <th>银行名称</th>
                            <th>支行名称</th>
                            <th>银行卡号/开户名</th>
                            <th>所属省</th>
                            <th>所属市</th>
                            <th>通道</th>
                            <th>申请时间</th>
                            <th>处理时间</th>
                        </tr>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->id}}</td>
                                <td>{{$order->pay_status?'充值':'收款'}}</td>
                                <td>{{$order->pay_memberid}}</td>
                                <td style="color: green">{{$order->pay_amount}}</td>
                                <td>{{$order->pay_poundage}}</td>
                                <td style="color: red">{{$order->pay_actualamount}}</td>
                                <td>{{$order->num}}</td>
                                <td>{{date('Y-m-d H:i:s',$order->pay_applydate)}}</td>
                                <td>{{$order->pay_successdate?'':'___'}}</td>
                                <td>{{$order->pay_zh_tongdao}}</td>
                                <td>{{$order->pay_bankname}}</td>
                                <td>{{$order->pay_tjurl}}</td>
                                <td style="color: orange">{{$order->queryed?'成功':'未处理'}}</td>
                                <td>
                                    {{--<a href="{{route('')}}">查看</a>--}}
                                    <a href="https://www.bilibili.com">查看</a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>1</td>
                            <td>收款</td>
                            <td>10009</td>
                            <td style="color: green">15.00</td>
                            <td>0.90</td>
                            <td style="color: red">14.10</td>
                            <td>中国银行</td>
                            <td>太平路支行</td>
                            <td>刘大</td>
                            <td>重庆</td>
                            <td>巴南</td>
                            <td>www.baidu.com</td>
                            <td>2018-11-05</td>
                            <td>
                                2018-11-06
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection