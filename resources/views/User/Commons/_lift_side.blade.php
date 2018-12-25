<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">商户管理</li>
            <li class="active treeview">
            <li><a href="{{route('user.index')}}"><i class="fa fa-circle-o text-aqua"></i> <span>首页</span></a></li>
            {{--<li><a href="{{route('user.user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>用户管理</span></a></li>--}}
            <li><a href="{{route('user.recharge')}}"><i class="fa fa-circle-o text-aqua"></i> <span>账户充值</span></a></li>
            </li>

            <li class="header">交易管理</li>
            <li class="active treeview">

            <li><a href="{{route('user.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易管理</span></a></li>
            <li><a href="{{route('user.clearing',Auth::user()->id)}}"><i class="fa fa-circle-o text-aqua"></i> <span>结算管理</span></a>
            </li>
            {{--<li><a href="{{route('user.withdraws')}}"><i class="fa fa-circle-o text-aqua"></i> <span>提现记录</span></a></li>--}}
            </li>

            <li class="header">信息管理</li>
            <li class="active treeview">


            <li><a href="{{route('user.bankCard',Auth::user()->id)}}"><i class="fa fa-circle-o  text-aqua"></i> <span>银行卡管理</span></a></li>
            <li><a href="{{route('user.api')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>API管理</span></a></li>
            <li><a href="{{route('user.wechat')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>微信管理</span></a></li>
            <li><a href="{{route('user.alipay')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>支付宝管理</span></a></li>

            </li>

            <li class="header">系统设置</li>
            <li><a href="{{route('user.main')}}"><i class="fa fa-circle-o text-red"></i> <span>开发者</span></a></li>
            <li><a href="{{route('user.validator')}}"><i class="fa fa-circle-o text-yellow"></i> <span>安全设置</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>