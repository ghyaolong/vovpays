<!-- 左侧导航开始 -->
<aside class="main-sidebar">
    <section class="sidebar">
        <!-- 侧边栏用户 -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                {{--<p>{{ Auth::user()->username }}</p>--}}
                <p>admin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> 欢迎登录</a>
            </div>
        </div>
        <!-- /.侧边栏用户 -->

        <!-- 左侧导航条 -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主导航</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>后台首页</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a href="#"><i class="fa fa-circle-o"></i> 首页1</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> 首页2</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>权限控制</span>
                    <span class="pull-right-container">
              <span class="label label-primary pull-right">3</span>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> 角色管理</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> 菜单管理</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> 管理员管理</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ url('admin/user/userpay') }}">
                    <i class="fa fa-th"></i> <span>商户设置</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>账户管理</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> 个人信息</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> 银行卡管理</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> 认证信息</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> 资金变动记录</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>
<!-- 左侧导航结束 -->