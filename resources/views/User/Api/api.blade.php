@extends("User.Commons.layout")
@section('title','API管理')
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-switch/bootstrap-switch.min.css') }}">
@endsection
@section('content')
    <div class="row" style="margin: 10px 100px">
        {{--商户费率--}}
        <div class="" style="margin: 50px;width: 370px;height: 479px;background:#ffffff;float: left">
            <p style="font-size: 18px;margin: 15px;">通道费率</p>
            <div class="row" style="text-align: center">
                {{-- <img src="{{ asset('AdminLTE/dist/img/agent/t0.png') }}" alt="" style="margin-top: 20px"> --}}
            </div>
            <table class="table" style="width: 340px;margin: 60px 10px 0 10px;font-size: 13px">
                <tr style="color: #999999;background: #f5f6f9">
                    <th>编码</th>
                    <th>通道名称</th>
                    <th>通道费率</th>
                    <th>通道状态</th>
                </tr>
                @foreach ($list as $value)
                    
                    <tr>
                        <td>{{ $value['paymentCode'] }}</td>
                        <td>{{ $value['paymentName'] }}</td>
                        <td>{{ $value['runRate'] * 100 }}%</td>
                        <td> @if ($value['status'] == 1)开通 @else 关闭 @endif </td>
                    </tr>
                @endforeach

            </table>
        </div>


    </div>

@endsection