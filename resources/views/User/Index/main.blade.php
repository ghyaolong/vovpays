@extends("User.Commons.layout")
@section('title','开发者')
@section("css")
    <link rel="stylesheet"
          href="{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection
@section('content')
    <div class="row" style="margin-top: 20px">

        {{--接口文档--}}
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">接口文档</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body" style="padding:20px auto;font-size: 15px">
                    <table class="table table-bordered" style="margin: 10px auto">
                        <tr>
                            <th style="width: 30px">#</th>
                            <th style="width: 500px">必要前提</th>
                            <th style="width: 1200px">说明</th>
                            <th style="width: 30px"></th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>已有商户ID和Token。</td>
                            <td>注册账号，在“我的”-“基本资料”中获取。</td>
                            <td><span class="glyphicon glyphicon-ok"></span></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>已上传支付宝、微信不设金额收款码各一张</td>
                            <td>可能用到的固定金额收款码多多益善。在“账号轮询”-“支付宝或微信账号”中上传“任意金额码”和“固定金额码”。</td>
                            <td><span class="glyphicon glyphicon-ok"></span></td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>已挂载网关程序，并按要求设置完毕。</td>
                            <td>打开网关程序，配置商户ID、Token、收款账号，配置完成后登陆微信或支付宝并保持在线状态。</td>
                            <td><span class="glyphicon glyphicon-ok"></span></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>


        {{--发起付款--}}
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">发起付款</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div style="height: 150px;background: #F5F5F5;margin:15px 10px;padding: 15px 20px;line-height: 30px">
                        <b>方式一：跳转我方平台支付网关支付</b><br>
                        <b>跳转支付页接口URL：</b> https://www.***.com/pay<br>
                        <b>传参方式：</b> Post<br>
                        <b>使用方法：</b> 用表单post的方式，post参数并跳转到此网址，显示我们的支付页<br>
                    </div>

                    <div style="height: 150px;background: #F5F5F5;margin:15px 10px;padding: 15px 20px;line-height: 30px">
                        <b>方式二：自定义支付页</b><br>
                        <b>获取支付JSON数据接口URL：</b> https://www.***.com/pay/json<br>
                        <b>传参方式：</b> Post (Content-Type: application/json;charset=utf-8)<br>
                        <b>使用方法：</b> 用curl的post方式传参数，并直接获取JSON返回值，显示在您自定义的支付页上。<br>
                    </div>

                    <div class="box-body" style="padding:20px auto;font-size: 15px">
                        <table class="table table-bordered" style="margin: 10px auto">
                            <tr bgcolor="#DEEFD7">
                                <th style="width: 30px">#</th>
                                <th>参数名</th>
                                <th>含义</th>
                                <th>类型</th>
                                <th style="width: 900px">说明</th>
                                <th style="width: 90px;">参与加密</th>
                                <th style="width: 70px;">必填</th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>uid</td>
                                <td>商户ID</td>
                                <td>string(50)</td>
                                <td>您的商户唯一标识，注册后在基本资料里获得</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>price</td>
                                <td>金额</td>
                                <td>float</td>
                                <td> 单位：元。精确小数点后2位</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>paytype</td>
                                <td>支付渠道</td>
                                <td>int</td>
                                <td>1：支付宝；2：微信支付</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>notify_url</td>
                                <td>异步回调地址</td>
                                <td>string(255)</td>
                                <td>
                                    用户支付成功后，我们服务器会主动发送一个post消息到这个网址。由您自定义。不要urlencode并且不带任何参数。例：http://www.xxx.com/notify_url
                                </td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>return_url</td>
                                <td>同步跳转地址</td>
                                <td>string(255)</td>
                                <td>用户支付成功后，我们会让用户浏览器自动跳转到这个网址。由您自定义。不要urlencode并且不带任何参数。例：http://www.xxx.com/return_url
                                </td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td> user_order_no</td>
                                <td>商户自定义订单号</td>
                                <td>string(50)</td>
                                <td>我们会据此判别是同一笔订单还是新订单。我们回调时，会带上这个参数。例：201810110922</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>note</td>
                                <td>附加内容</td>
                                <td>string(1000)</td>
                                <td> 回调时将会根据传入内容原样返回（为防止乱码情况，请尽量不填写中文）</td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td> cuid</td>
                                <td>商户自定义用户唯一标识</td>
                                <td> string(50)</td>
                                <td>我们会显示在您后台的订单列表中，方便您看到是哪个用户的付款，方便后台对账。强烈建议填写。可以填用户名、邮箱、主键</td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                            </tr>
                            <tr>
                                <td>9.</td>
                                <td>tm</td>
                                <td>日期时间</td>
                                <td>string(50)</td>
                                <td>请求时间yyyy-mm-dd hh:mi:ss</td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>10.</td>
                                <td>sign</td>
                                <td>签名</td>
                                <td>string(32)</td>
                                <td>将参数1至6按顺序连Token一起，做md5-32位加密，取字符串小写。网址类型的参数值不要urlencode（例：uid + price + paytype +
                                    notify_url + return_url + user_order_no + token）
                                </td>
                                <td></td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                        </table>
                        <br>
                        <b>注意：Token在安全上非常重要，一定不要显示在任何网页代码、网址参数中。只可以放在服务端。计算sign时，先在服务端计算好，把计算出来的sign传出来。严禁在客户端计算、存储Token。</b>
                    </div>

                    <div style="background: #F5F5F5;margin:15px 10px;">
                    <pre>   <b>JSON请求的返回值：</b><br>                 {
		    //0失败 1成功
		    "Code": 1,
		    //返回消息
		    "Msg": "success",
		    //支付渠道 1支付宝 2微信
		    "PayType": 1,
		    //收款码解析路径
		    "QRCodeLink": "HTTPS://QR.ALIPAY.COM/XXXXXXXX",
		    //实际支付金额(一定要把这个价格显示在支付页上，而不是订单金额)
		    "RealPrice": 0.01,
		    //订单有效期（秒），订单创建时间 + 有效期 小于当前时间则此单失效
		    "TimeOut": 180,
		    //订单创建时间
		    "CreateTime": "2018-10-30 09:22:33"
		}
                    </pre>
                    </div>

                </div>
            </div>
        </div>


        {{--同步跳转--}}
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">同步跳转</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div style="height: 80px;background: #F5F5F5;margin:15px 10px;padding: 15px 20px;line-height: 30px">
                        <b>传参方式：</b> Get<br>
                        <b></b> 用户付款成功后，我们会先进行同步回调，跳转到您在发起付款接口传入的return_url网址 ，附带参数user_order_no，再过1-3秒后将发出异步通知(三)<br>
                    </div>


                    <div class="box-body" style="padding:20px auto;font-size: 15px">
                        <table class="table table-bordered" style="margin: 10px auto">
                            <tr bgcolor="#DEEFD7">
                                <th style="width: 30px">#</th>
                                <th>参数名</th>
                                <th>含义</th>
                                <th>类型</th>
                                <th style="width: 1100px">说明</th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>user_order_no</td>
                                <td>您的自定义订单号</td>
                                <td>string(50)</td>
                                <td>一定存在。您可以通过此参数在您后台查询到付款确实成功后，给用户一个付款成功的展示</td>
                            </tr>
                        </table>
                        <br>
                        <b>注意：请不要将此跳转认为是用户付款成功的判断条件，此行为极不安全。请根据我们的付款成功异步回调通知是否送到，来判断交易是否成功。</b>
                    </div>
                </div>
            </div>
        </div>

        {{--异步通知--}}
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">异步通知</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div style="height: 80px;background: #F5F5F5;margin:15px 10px;padding: 15px 20px;line-height: 30px">
                        <b>传参方式：</b> Get<br>
                        <b></b>
                        用户付款成功后，我们会向您在发起付款接口传入的notify_url网址发送通知(POST)。您的服务器只要返回小写字符串“success”（不包括引号），就表示回调成功。通知内容(json)如下:<br>
                    </div>


                    <div class="box-body" style="padding:20px auto;font-size: 15px">
                        <table class="table table-bordered" style="margin: 10px auto">
                            <tr bgcolor="#DEEFD7">
                                <th style="width: 30px">#</th>
                                <th>参数名</th>
                                <th>含义</th>
                                <th>类型</th>
                                <th style="width: 1010px">说明</th>
                                <th style="width: 90px">参与加密</th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>user_order_no</td>
                                <td>您的自定义订单号</td>
                                <td>string(50)</td>
                                <td>一定存在。是您在发起付款接口传入的您的自定义订单号</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>orderno</td>
                                <td>平台生成的订单号</td>
                                <td>string(50)</td>
                                <td>一定存在。是此订单在本服务器上的唯一编号</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>tradeno</td>
                                <td>支付流水号</td>
                                <td>string(50)</td>
                                <td>一定存在。支付宝支付或微信支付的流水订单号</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>price</td>
                                <td>订单定价</td>
                                <td>float</td>
                                <td>一定存在。是您在发起付款接口传入的订单价格</td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>realprice</td>
                                <td> 实际支付金额</td>
                                <td>float</td>
                                <td>
                                    一定存在。表示用户实际支付的金额。一般会和price值一致，如果同时存在多个用户支付同一金额，就会和price存在一定差额，差额一般在1-2分钱上下，越多人同时付款，差额越大
                                </td>
                                <td><span class="glyphicon glyphicon-ok"></span></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>cuid</td>
                                <td> 您的自定义用户唯一标识</td>
                                <td>string(50)</td>
                                <td>如果您在发起付款接口带入此参数，我们会原封不动传回</td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>note</td>
                                <td>附加内容</td>
                                <td>string(1000)</td>
                                <td>如果您在发起付款接口带入此参数，我们会原封不动传回</td>
                                <td><span class="glyphicon glyphicon-remove"></span></td>
                            </tr>
                            <tr>
                                <td>8.</td>
                                <td>sign</td>
                                <td>签名</td>
                                <td>string(32)</td>
                                <td>
                                    将参数1至5按顺序连Token一起，做md5-32位加密，取字符串小写。您需要在您的服务端按照同样的算法，自己验证此sign是否正确。只在正确时，执行您自己逻辑中支付成功代码。（拼接顺序：user_order_no
                                    + orderno + tradeno + price + realprice + token）
                                </td>
                                <td></td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>


        {{--demo下载--}}
        <div class="col-md-6">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">demo下载</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body" style="padding:20px auto;font-size: 15px;height: 200px">
                    <table class="table table-bordered" style="margin: 10px auto">
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>开发语言</th>
                            <th>文件</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>php demo</td>
                            <td><a class="glyphicon glyphicon-download-alt btn btn-primary" href="/demo/pay-php.rar"
                                   download="pay-php.rar"> 下载</a></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>java demo</td>
                            <td><a class="glyphicon glyphicon-download-alt btn btn-primary" href="/demo/java-php.rar"
                                   download="java-php.rar"> 下载</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">资源下载</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body" style="padding:20px auto;font-size: 15px;height: 200px">
                    <table class="table table-bordered" style="margin: 10px auto">
                        <tr>
                            <th style="width: 30px">#</th>
                            <th>说明</th>
                            <th>文件</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>API文档</td>
                            <td><a class="glyphicon glyphicon-download-alt btn btn-primary"
                                   href="/demo/免签支付接口文档v1.1.docx" download="免签支付接口文档v1.1.docx"> 下载</a></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>


    </div>

@endsection