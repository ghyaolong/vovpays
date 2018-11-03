@include('Admin.Layouts.header')
    <div class="row">
        <div class="col-md-12">
            <div class="ibox float-e-margins">
                <!--条件查询-->
                <div class="ibox-title">
                    <h5>用户管理</h5>
                    <div class="ibox-tools">
                        <i class="layui-icon" onclick="location.replace(location.href);" title="刷新"
                           style="cursor:pointer;">ဂ</i>
                    </div>
                </div>
                <!--条件查询-->
                <div class="ibox-content">
                    <form class="layui-form" action="" method="get" autocomplete="off">
                        <input type="hidden" name="m" value="Viphouwei">
                        <input type="hidden" name="c" value="User">
                        <input type="hidden" name="a" value="index">
                        <div class="layui-form-item">
                            <div class="layui-inline text-css">
                                <div class="layui-input-inline">
                                    <input type="text" name="memberid" autocomplete="off" placeholder="商户号"
                                           class="layui-input" value="">
                                    <input type="hidden"  name="issearch"  value="1">
                                </div>
                            </div>

                            <div class="layui-inline text-css">
                                <div class="layui-input-inline">
                                    <input type="text" name="username" autocomplete="off" placeholder="用户名"
                                           class="layui-input" value="">
                                </div>
                            </div>

                            <div class="layui-inline text-css">
                                <div class="layui-input-inline ">
                                    <select name="status"  id="memberstatus" multiple="multiple">
                                        <option   value="">状态</option>
                                        <option    value="1">已激活</option>
                                        <option    value="0">未激活</option>
                                        <option  value="2">禁用</option>
                                    </select>
                                </div>
                            </div>

                            <div class="layui-inline text-css">
                                <div class="layui-input-inline  ">
                                    <select name="authorized"  id="authorized" multiple="multiple">
                                        <option value="">认证</option>
                                        <option   value="0">未认证</option>
                                        <option   value="2">等待审核</option>
                                        <option    value="1">认证用户</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-inline text-css">
                                <div class="layui-input-inline ">
                                    <input type="text" class="layui-input" name="regdatetime" id="regtime"
                                           placeholder="起始时间"  value="">
                                </div>
                            </div>
                            <div class="layui-inline">
                                <button type="submit" class="layui-btn lineblud">
                                    {{--<span class="glyphicon glyphicon-search"></span> --}}搜索
                                </button>
                                <a href="javascript:;" id="export"
                                   class="layui-btn btn-css">
                                    {{--<span class="glyphicon glyphicon-export pink"></span>--}} 导出数据</a>
                            </div>
                        </div>
                    </form>
                    <!--用户列表-->
                    <table class="layui-table table-list" lay-data="{width:'100%',height:'550',id:'userData'}">
                        <thead>
                        <tr>
                            <th lay-data="{field:'id',fixed: true,width:60,style:'color:rgb(102,102,102)'}"></th>
                            <th lay-data="{field:'memberid', width:80, sort: true, fixed: true,style:'color:rgb(102,102,102)'}">商户号</th>
                            <th lay-data="{field:'username', width:120,style:'color:rgb(102,102,102)'}">用户名</th>
                            <th lay-data="{field:'groupid', width:110,style:'color:rgb(119,119,119)'}">用户类型</th>
                            <th lay-data="{field:'parentid', width:120,style:'color:rgb(85,85,85)'}">上级用户</th>
                            <th lay-data="{field:'status', width:80}">状态</th>
                            <th lay-data="{field:'authorized', width:100}">认证</th>
                            <th lay-data="{field:'money', width:240,style:'color: rgb(102,102,102);cursor: pointer;'}">账户总额</th>
                            <!--<th lay-data="{field:'earnestmoney', width:80,style:'color: rgb(200,102,0);cursor: pointer;'}">定金</th>-->
                            <th lay-data="{field:'regdatetime', width:120}">注册时间</th>
                            <th lay-data="{field:'op',width:300,style:'background-color: #74bedc;'}">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>9</td>
                            <td><a href="{{ route('user') }}" target="_blank">10009</a></td>
                            <td>zhpay</td>
                            <td>普通商户</td>
                            <td>总管理员</td>
                            <td><a href="javascript:;" style="display:block;margin-top:3px;">
                                    <input type="checkbox"
                                           data-uid="9"
                                           name="open"
                                           lay-skin="switch"
                                           lay-filter="switchStatus"
                                           lay-text="正常|禁用">
                                </a>
                            </td>
                            <td><a style="display:block;" href="javascript:member_auth('用户认证','#','',320)">
                                    <span class="label label-success deepblud">已认证</span>                                </a></td>
                            <td><div title="用户资金管理" onclick="member_money('商户：zhpay','#',800,600)">可提现：<span class="tixian">1000</span> 冻结：<span class="dongjie">0.4</span> </div></td>
                            <!--<td> </td>-->
                            <td>2018-10-17</td>
                            <td>
                                <div class="layui-btn-group btn-a">
                                    <!--<button class="layui-btn layui-btn-small  layui-btn-a" onclick="member_paid('代付','/Viphouwei_Users_paid_uid_9.html')">代付</button>-->
                                    <button class="layui-btn layui-btn-small" onclick="member_withdrawal('提现设置','#')">提现</button>
                                    <button class="layui-btn layui-btn-small" onclick="member_edit('编辑通道','#',800)">通道</button>
                                    <button class="layui-btn layui-btn-small" onclick="member_rate('编辑费率','#',640,480)">费率</button>
                                    <button class="layui-btn layui-btn-small" onclick="member_edit('编辑','#',800,540)">密码</button>
                                    <button class="layui-btn layui-btn-small" onclick="member_edit('编辑','#',800,600)">编辑</button>
                                    <button class="layui-btn layui-btn-small" onclick="member_del(this,'9')">删除</button>
                                    <!--<button class="layui-btn layui-btn-small" onclick="member_peizhi('指派通道','#',800,600)">指定通道配置</button>-->
                                </div>
                            </td>
                        </tr>                        </tbody>
                    </table>
                    <!--用户列表-->
                    <div class="page"><div  class="layui-box layui-laypage layui-laypage-default" id="layui-laypage-0">    </div></div>
                </div>
            </div>
        </div>

    </div>
@include('Admin.Layouts.footer')
<script>
    layui.use(['form','table',  'laydate', 'layer'], function () {
        var form = layui.form
            ,table = layui.table
            , layer = layui.layer
            , laydate = layui.laydate
            ,$= layui.jquery;
        layui.selMeltiple($);

        //日期时间范围
        laydate.render({
            elem: '#regtime'
            ,type: 'datetime'
            , range: '|'
        });
        //监听表格复选框选择
        table.on('checkbox(userData)', function(obj){
            var child = $(data.elem).parents('table').find('tbody input[lay-filter="ids"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
        //监听工具条
        table.on('tool(test1)', function(obj){
            var data = obj.data;
            if(obj.event === 'detail'){
                layer.msg('ID：'+ data.id + ' 的查看操作');
            } else if(obj.event === 'del'){
                layer.confirm('真的删除行么', function(index){
                    obj.del();
                    layer.close(index);
                });
            } else if(obj.event === 'edit'){
                layer.alert('编辑行：<br>'+ JSON.stringify(data))
            }
        });
        //全选
        form.on('checkbox(allChoose)', function (data) {
            var child = $(data.elem).parents('table').find('tbody input[lay-filter="ids"]');
            child.each(function (index, item) {
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
        //监听用户状态
        form.on('switch(switchStatus)', function (data) {
            var isopen = this.checked ? 1 : 0,
                uid = $(this).attr('data-uid');
            $.ajax({
                url: "<{:U('User/editStatus')}>",
                type: 'post',
                data: "uid=" + uid + "&isopen=" + isopen,
                success: function (res) {
                    if (res.status) {
                        layer.tips('温馨提示：开启成功', data.othis);
                    } else {
                        layer.tips('温馨提示：关闭成功', data.othis);
                    }
                }
            });
        });
    });

    //批量删除提交
    function delAll() {
        layer.confirm('确认要删除吗？', function (index) {
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
        });
    }

    /*用户-认证*/
    function member_auth(title, url, w, h) {
        x_admin_show(title, url, w, h);
    }

    /*用户-费率*/
    function member_rate(title, url, w, h) {
        x_admin_show(title, url, w, h);
    }

    // 用户-编辑
    function member_edit(title, url, id, w, h) {
        x_admin_show(title, url, w, h);
    }

    // 用户-提现
    function member_withdrawal(title, url, id, w, h) {
        x_admin_show(title, url, w, h);
    }
    // 用户-提现
    function member_money(title, url, id, w, h) {
        x_admin_show(title, url, w, h);
    }

    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $.ajax({
                url:"<{:U('User/delUser')}>",
                type:'post',
                data:'uid='+id,
                success:function(res){
                    if(res.status){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                }
            });
        });
    }
    /*用户-配置*/
    function member_peizhi(title, url, id, w, h){
        x_admin_show(title, url, w, h);
    }

    //代付
    function member_paid(title, url, id, w, h){
        x_admin_show(title, url, w, h);
    }

    $('#export').on('click',function(){
        window.location.href
            ="<{:U('index',array('isExport'=>'export','username'=>trim($_GET['username']),'memberid'=>trim($_GET['memberid']),'parentid'=>trim($_GET['parentid']),'status'=>$_GET['status'],'authorized'=>$_GET['authorized'],'groupid'=>'4','regdatetime'=>$_GET[regdatetime]))}>";
    });
</script>
</body>
</html>