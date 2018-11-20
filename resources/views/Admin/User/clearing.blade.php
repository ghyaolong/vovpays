@extends("Admin.User.commons.layout")
@section('title','结算管理')
@section('content')
    <div class="row">

        {{--结算申请--}}
        <div class="col-md-4">
            <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">结算申请</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                <div class="box-body">
                    <form class="form-horizontal" id="form1">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">提现金额</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="withdrawAmount" placeholder="请输入提现金额" value="0.00">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">银行卡</label>
                            <div class="col-sm-9">
                                <a class="btn btn-info" id="choseCard">选择银行卡</a>&nbsp;
                                <a class="btn btn-info" id="addCard">选择银行卡</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">持卡人</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="accountName" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">银行名称</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="bankName" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">银行卡号</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" id="bankCardNo" disabled="disabled">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-3 control-label">提款密码</label>
                            <div class="col-xs-9">
                                <input type="password" class="form-control" id="applyPws">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <a class="btn btn-danger pull-right" id="applyBtn">&nbsp;申&nbsp;请&nbsp;</a>
                            </div>
                            <div class="col-xs-6">
                                <input type="reset" class="btn btn-warning" value="&nbsp;重&nbsp;置&nbsp;">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>


        {{--结算申请--}}
        <div class="col-md-8">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">结算记录</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <tr style="color: #999999;background:#f5f6f9">
                            <th>银行名称</th>
                            <th>银行卡号</th>
                            <th>提现额度</th>
                            <th>提现手续费</th>
                            <th>到账金额</th>
                            <th>状态</th>
                            <th>提现时间</th>
                        </tr>
                        <tr>
                            <td colspan="7">没有找到匹配的记录</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>




    </div>
@endsection