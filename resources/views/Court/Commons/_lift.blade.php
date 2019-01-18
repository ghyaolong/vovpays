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


        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主导航</li>

            <li class="active treeview">

            <li><a href="{{route('court.index')}}"><i class="fa fa-circle-o text-aqua"></i> <span>主页</span></a></li>
            </li>

            <li><a href="{{route('court.order')}}"><i class="fa fa-circle-o text-aqua"></i> <span>交易管理</span></a></li>


            @if(Cache::get('systems')['add_account_type']->value && Cache::get('systems')['add_account_type']->value==4)
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-circle-o  text-aqua"></i>
                        <span>账号管理</span>
                        <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('court.account',[0])}}"><i class="fa fa-circle-o"></i>
                                <span>微信账号</span></a></li>
                        <li><a href="{{route('court.account',[1])}}"><i class="fa fa-circle-o"></i>
                                <span>支付宝账号</span></a></li>
                        <li><a href="{{ route('court.accountBank') }}"><i class="fa fa-circle-o"></i> <span>银行卡号</span></a>
                        </li>
                    </ul>
                </li>
            @else

            @endif

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>