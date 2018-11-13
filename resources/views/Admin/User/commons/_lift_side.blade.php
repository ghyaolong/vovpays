<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">商户管理</li>
            <li class="active treeview">
                <ul class="treeview-menu">
                    <li style="margin: 10px auto"><a href="{{route('user')}}"><i class="fa fa-circle-o"></i> 后台主页</a></li>
                    <li style="margin: 10px auto"><a href="{{route('user.user')}}"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                    {{--<li style="margin: 10px auto"><a href="#"><i class="fa fa-circle-o"></i> 下级商户管理</a></li>--}}
                </ul>
            </li>

            <li class="header">交易管理</li>
            <li class="active treeview">
                <ul class="treeview-menu">
                    <li style="margin: 10px auto"><a href="{{route('user.order')}}"><i class="fa fa-circle-o"></i> 交易明细查询</a></li>
                    <li style="margin: 10px auto"><a href="{{route('user.settlement')}}"><i class="fa fa-circle-o"></i> 提现结算</a></li>
                    <li style="margin: 10px auto"><a href="{{route('user.record')}}"><i class="fa fa-circle-o"></i> 提现记录</a></li>
                </ul>
            </li>

            <li class="header">信息管理</li>
            <li class="active treeview">
                <ul class="treeview-menu">
                    {{--<li style="margin: 10px auto"><a href="{{route('user.index')}}"><i class="fa fa-circle-o"></i> 基本信息</a></li>--}}
                    <li style="margin: 10px auto"><a href="{{route('user.bank')}}"><i class="fa fa-circle-o"></i> 银行卡管理</a></li>
                </ul>
            </li>

            <li class="header">账号轮询</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>支付宝账户</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>微信账户</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>百度钱包账户</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>