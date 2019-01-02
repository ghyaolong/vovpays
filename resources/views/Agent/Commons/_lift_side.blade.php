<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">账户管理</li>

            <li class="active treeview">
            {{--<li><a href="{{route('agent.extension')}}"><i class="fa fa-circle-o text-aqua"></i> <span>推广地址</span></a></li>--}}
            <li><a href="{{route('agent.index')}}"><i class="fa fa-circle-o text-aqua"></i> <span>账户管理</span></a></li>
            </li>

            <li class="header">商户管理</li>

            <li class="active treeview">
            <li><a href="{{route('agent.user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>商户管理</span></a></li>
            <li><a href="{{route('agent.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易管理</span></a></li>
            </li>

            <li class="header">结算管理</li>

            <li class="active treeview">
            <li><a href="{{route('agent.clearing')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>结算管理</span></a></li>
            {{--<li><a href="{{route('agent.withdraws')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>结算记录</span></a></li>--}}
            </li>

            <li class="header">信息管理</li>

            <li class="active treeview">
            {{--<li><a href="{{route('agent.info')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>个人信息</span></a></li>--}}
            <li><a href="{{route('agent.bankCard')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>银行卡信息</span></a></li>
            {{--<li><a href="{{route('agent.rate')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>商户费率</span></a></li>--}}
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>