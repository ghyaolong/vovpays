<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- 侧边栏用户 -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE/dist/img/user3-128x128.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 欢迎登录</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">

            <li class="active treeview">
            <li><a href="{{route('user.index')}}"><i class="fa fa-circle-o text-aqua"></i> <span>首页</span></a></li>
            {{--<li><a href="{{route('user.user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>用户管理</span></a></li>--}}
            <li><a href="{{route('user.recharge')}}"><i class="fa fa-circle-o text-aqua"></i> <span>账户充值</span></a></li>
            </li>

            <li class="active treeview">

            <li><a href="{{route('user.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易管理</span></a></li>
            <li><a href="{{route('user.clearing')}}"><i class="fa fa-circle-o text-aqua"></i> <span>结算管理</span></a>
            </li>
            {{--<li><a href="{{route('user.withdraws')}}"><i class="fa fa-circle-o text-aqua"></i> <span>提现记录</span></a></li>--}}
            </li>

            <li class="active treeview">


            <li><a href="{{route('user.bankCard')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>银行卡管理</span></a></li>
            {{--<li><a href="{{route('user.api')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>API管理</span></a></li>--}}

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-paper-plane"></i>
                    <span>账号管理</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{route('user.account',0)}}"><i class="fa fa-circle-o"></i> <span>微信账号</span></a></li>
                    <li><a href="{{route('user.account',1)}}"><i class="fa fa-circle-o"></i> <span>支付宝账号</span></a></li>
                    <li><a href="{{ route('user.accountBank') }}"><i class="fa fa-circle-o"></i>银行卡号</a></li>
                </ul>
            </li>


            </li>

            {{--<li class="header">系统设置</li>--}}
            <li><a href="{{route('user.main')}}"><i class="fa fa-circle-o text-red"></i> <span>开发者</span></a></li>
            <li><a href="{{route('user.validator')}}"><i class="fa fa-circle-o text-yellow"></i> <span>安全设置</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>