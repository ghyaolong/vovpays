<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- 侧边栏用户 -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->username }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 欢迎登录</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主导航</li>
            {{--<li class="header">账户管理</li>--}}

            <li class="active treeview">
            {{--<li><a href="{{route('agent.extension')}}"><i class="fa fa-circle-o text-aqua"></i> <span>推广地址</span></a></li>--}}
            <li><a href="{{route('agent.index')}}"><i class="fa fa-circle-o text-aqua"></i> <span>账户管理</span></a></li>
            </li>

            {{--<li class="header">商户管理</li>--}}

            {{--<li class="active treeview">--}}
            <li><a href="{{route('agent.user')}}"><i class="fa fa-circle-o text-aqua"></i> <span>商户管理</span></a></li>
            <li><a href="{{route('agent.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易管理</span></a></li>
            {{--</li>--}}

            {{--<li class="header">结算管理</li>--}}

            <li class="active treeview">
            <li><a href="{{route('agent.clearing')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>结算管理</span></a>
            </li>
            {{--<li><a href="{{route('agent.withdraws')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>结算记录</span></a></li>--}}
            </li>

            {{--<li class="header">信息管理</li>--}}

            <li class="active treeview">
            {{--<li><a href="{{route('agent.info')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>个人信息</span></a></li>--}}
            <li><a href="{{route('agent.bankCard')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>银行卡信息</span></a>
            </li>
            {{--<li><a href="{{route('agent.rate')}}"><i class="fa fa-circle-o  text-aqua"></i> <span>商户费率</span></a></li>--}}
            </li>

            @if(isset($type) && $type >= '3')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-paper-plane"></i>
                        <span>账号管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('agent.account',[0])}}"><i class="fa fa-circle-o"></i>
                                <span>微信账号</span></a></li>
                        <li><a href="{{route('agent.account',[1])}}"><i class="fa fa-circle-o"></i>
                                <span>支付宝账号</span></a></li>
                        <li><a href="{{ route('agent.accountBank') }}"><i class="fa fa-circle-o"></i>银行卡号</a></li>
                    </ul>
                </li>
            @else

            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>