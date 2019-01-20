@extends("Admin.Layouts.layout")
@section("css")
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" class="col-md-12">
                    <!-- ./col -->
                    <form class="navbar-form navbar-left" action="{{route('account.all')}}" method="get">
                        <div class="form-group">
                            <select class="form-control" id="paymentId" name="accountType">
                                <option value="-1">支付方式</option>
                                    <option value="alipay" @if(isset($query['accountType']) && $query['accountType'] == 'alipay') selected @endif>支付宝</option>
                                    <option value="wechat" @if(isset($query['accountType']) && $query['accountType'] == 'wechat') selected @endif>微信</option>
                                    <option value="alipay_bank" @if(isset($query['accountType']) && $query['accountType'] == 'alipay_bank') selected @endif>银行卡</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">搜索</button>
                    </form>
                    <a href="{{ route('account.all') }}" class="btn pull-right"><i class="fa fa-undo"></i>刷新</a>
                    <div class="box-body" style="margin-top: 45px">
                        <table id="example2" class="table table-bordered table-hover">
                            <tr style="color: #666666;background: #f5f6f9">
                                <th>账号拥有者</th>
                                <th>手机标识</th>
                                <th>账号实名</th>
                                <th>账号</th>
                                <th>账号类型</th>
                                <th>单日交易额</th>
                                <th>今日订单量</th>
                                <th>今日成功订单量</th>
                                <th>今日成功率</th>
                                <th>状态</th>
                            </tr>
                            @if(!isset($account_list[0]))
                                <tr>
                                    <td colspan="10" style="text-align: center">没有找到匹配数据</td>
                                </tr>
                            @else
                                @foreach($account_list as $v)
                                    <tr>
                                        <td>@if(isset($v->user->username)){{ $v->user->username }} @else 总后台 @endif</td>
                                        <td>{{ $v->phone_id }}</td>
                                        <td>
                                            @if(isset($v->alipayusername))
                                                {{ $v->alipayusername }}
                                            @elseif(isset($v->bank_account))
                                                {{ $v->bank_account }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="color: red">
                                            @if(isset($v->account))
                                                {{ $v->account }}
                                            @elseif(isset($v->cardNo))
                                                {{ $v->cardNo }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td style="color: #00c0ef">{{ $v->accountType }}</td>
                                        <td><span style="color: green">{{$v->account_amount}}</span></td>
                                        <td><span style="color: green">{{$v->account_order_count}}</span></td>
                                        <td><span style="color: green">{{$v->account_order_suc_count}}</span></td>
                                        <td><span style="color: green">{{$v->success_rate?$v->success_rate.'%':'---'}}</span></td>
                                        <td>
                                            <input class="switch-state" data-id="{{ $v['id'] }}" type="checkbox"
                                                   @if($v['status'] == 1) checked @endif />
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        {{$account_list->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("scripts")
<script src="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
<script>
$(function () {
    // 状态修改
    $('.switch-state').bootstrapSwitch({
        onText: '启用',
        offText: '禁用',
        onColor: "primary",
        offColor: "danger",
        size: "small",
    })
})
</script>
@endsection