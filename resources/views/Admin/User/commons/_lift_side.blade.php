<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">商户管理</li>
            <li class="active treeview">
            <li><a href="{{route('user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>后台主页</span></a></li>
            <li><a href="{{route('user.recharge')}}"><i class="fa fa-circle-o text-aqua"></i> <span>账户充值</span></a></li>
            <li><a href="{{route('user.user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>用户管理</span></a></li>
            </li>

            <li class="header">交易管理</li>
            <li class="active treeview">

            <li><a href="{{route('user.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易明细查询</span></a></li>
            <li><a href="{{route('user.clearing',Auth::user()->id)}}"><i class="fa fa-circle-o text-aqua"></i> <span>提现结算</span></a>
            </li>
            <li><a href="{{route('user.withdraws',Auth::user()->id)}}"><i class="fa fa-circle-o text-aqua"></i> <span>提现记录</span></a></li>

            </li>

            <li class="header">信息管理</li>
            <li class="active treeview">


            <li><a href="{{route('user.bankCard',Auth::user()->id)}}"><i class="fa fa-circle-o  text-aqua"></i> <span>银行卡管理</span></a></li>

            </li>

            <li class="header">账号轮询</li>
            <li><a href="{{route('user.main')}}"><i class="fa fa-circle-o text-red"></i> <span>开发者</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>微信账户</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>百度钱包账户</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>