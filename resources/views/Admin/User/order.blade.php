@extends("Admin.User.commons.layout")
@section('title','订单管理')
@section('content')
    <table class="table">
        <tr>
            <td>
            </td>
        </tr>

        <tr style="background: #ffffff">
            <th style="color: #999999">
                交易总额:<b style="color: red">&emsp;986.36 元</b>
                &emsp;&emsp;&emsp;总手续费:<b style="color: coral">&emsp;36 元</b>
                &emsp;&emsp;&emsp;支付金额:<b style="color: coral">&emsp;950.36 元</b>
                &emsp;&emsp;&emsp;平台收入:<b style="color: darkviolet">&emsp;15 元</b>
                &emsp;&emsp;&emsp;代理收入:<b style="color: darkviolet">&emsp;0.00 元</b>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                共条18000订单，本页显示{{count($orders)}}1条
            </th>
        </tr>
    </table>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid">
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <form class="navbar-form navbar-left" action="">
                                    {{--{{ csrf_field() }}--}}
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pay_memberid" placeholder="请输入商户号">
                                    </div>&nbsp;&nbsp;

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="pay_orderid" placeholder="请输入商户订单号">
                                    </div>&nbsp;&nbsp;

                                    <div class="form-group">
                                        <input type="date" class="form-control" name="pay_applydate" placeholder="创建起始时间">
                                    </div>
                                    --
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="pay_applydate1" placeholder="创建起始时间">
                                    </div>&nbsp;&nbsp;

                                    <div class="form-group">
                                        <select name="pay_bankname" id="" class="form-control">
                                            <option value="">全部银行</option>
                                            {{--<option value="中国银行">中国银行</option>--}}
                                            {{--<option value="农业银行">农业银行</option>--}}
                                            {{--<option value="工商银行">工商银行</option>--}}
                                            {{--<option value="建设银行">建设银行</option>--}}
                                            {{--<option value="招商银行">招商银行</option>--}}
                                            {{--<option value="支付宝H5">支付宝H5</option>--}}
                                        </select>
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
                                    <button type="submit" class="btn btn-info glyphicon glyphicon-search ">搜索</button>&nbsp;&nbsp;
                                    <button type="submit" class="btn btn-danger glyphicon glyphicon-export ">导出数据</button>
                                </form>

                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                        <br>
                        <table id="example2" class="table table-condensed table-bordered table-hover">
                            {{--<tr style="background:#dddddd;color: #777777">--}}
                            <tr>
                                <th>#</th>
                                <th>订单类型</th>
                                <th>商户订单号</th>
                                <th>商户编号</th>
                                <th>交易金额</th>
                                <th>手续费</th>
                                <th>实际金额</th>
                                <th>代理收入</th>
                                <th>提交时间</th>
                                <th>成功时间</th>
                                <th>支付通道</th>
                                <th>支付产品</th>
                                <th>来源地址</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->id}}</td>
                                    <td>{{$order->pay_status?'充值':'收款'}}</td>
                                    <td style="color:saddlebrown">{{$order->pay_orderid}}</td>
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
                                <td style="color:saddlebrown">20180665225855222222</td>
                                <td>10009</td>
                                <td style="color: green">15.00</td>
                                <td>0.90</td>
                                <td style="color: red">14.10</td>
                                <td>0</td>
                                <td>2018-11-5 16:15:13</td>
                                <td>___</td>
                                <td>中天e支付</td>
                                <td>微信</td>
                                <td>www.baidu.com</td>
                                <td style="color: orange">未处理</td>
                                <td>
                                    {{--<a href="{{route('')}}">查看</a>--}}
                                    <a href="https://www.bilibili.com">查看</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--{{$orders->appends($data)->links()}}--}}
@endsection