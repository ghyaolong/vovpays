<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">推广管理</li>

            <li class="active treeview">
            <li><a href="{{route('agent.extension')}}"><i class="fa fa-circle-o text-aqua"></i> <span>推广地址</span></a></li>
            </li>

            <li class="header">商户管理</li>

            <li class="active treeview">
            <li><a href="{{route('agent.user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>下级商户管理</span></a></li>
            <li><a href="{{route('agent.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易明细查询</span></a></li>
            </li>

            <li class="header">结算管理</li>

            <li class="active treeview">
            <li><a href="{{route('agent.clearing')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>提现结算</span></a></li>
            <li><a href="{{route('agent.withdraws')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>结算记录</span></a></li>
            </li>

            <li class="header">信息管理</li>

            <li class="active treeview">
            <li><a href="{{route('agent.info')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>个人信息</span></a></li>
            <li><a href="{{route('agent.bankCard')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>银行卡信息</span></a></li>
            <li><a href="{{route('agent.rate')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>商户费率</span></a></li>
            </li>

            <li class="header">账号轮询</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>开发者</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>微信账户</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>百度钱包账户</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>