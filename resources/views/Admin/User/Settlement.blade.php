@extends("Admin.User.commons.layout")
@section('title','结算管理')
@section('content')
    <table class="table table-bordered" style="margin: 100px 100px;background: #ffffff">
        <tr>
            <th style="background: #dddddd">申请结算</th>
        </tr>
        <tr>
            <td>
                <spn style="font-size: 19px;color: #e56c69;margin: auto 30px">可提现：100 元</spn >
                <spn style="font-size: 19px;color: #999999; margin: auto 30px">冻结：0.00 元 </spn>
                <spn style="font-size: 19px;color: #f2aa25; margin: auto 30px">结算：T+1</spn>
            </td>
        </tr>
        <tr>
            <td>

                <form class="form-inline">
                    <div class="form-group">
                        <label for="exampleInputName1">提现金额:</label>&emsp;
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="0.00" style="width: 800px">
                    </div>
                    <br><br>

                    <div class="form-group">
                        <label for="exampleInputEmail1">到账金额:</label>&emsp;
                        <input type="text" class="form-control" id="exampleInputEmail3">
                    </div>&emsp;&emsp;&emsp;
                    <div class="form-group">
                        <label for="exampleInputEmail1">手续费:</label>
                        <input type="text" class="form-control" id="exampleInputPassword3">
                    </div><br><br>
                    <div class="form-group">
                        <label for="exampleInputEmail1">结算银行卡:</label>
                        <select class="form-control" style="width: 800px">
                            <option>请选择</option>
                        </select>
                    </div><br><br>

                    <div class="form-group">
                        <label for="exampleInputEmail1">验证码:</label>&emsp;&emsp;
                        <input type="text" class="form-control" id="exampleInputPassword3" placeholder="请输入验证码">&emsp;
                        <button type="submit" class="btn btn-primary">获取验证码</button>
                    </div><br><br>

                    <button type="submit" class="btn btn-info" style="margin-left: 78px">提交申请</button>&emsp;
                    <button type="reset" class="btn btn-default">重置</button>
                </form>
            </td>
        </tr>
    </table>
@endsection