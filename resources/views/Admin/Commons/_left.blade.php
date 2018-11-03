<!-- 左侧导航开始 -->
<aside class="main-sidebar">
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
        <!-- /.侧边栏用户 -->

        <!-- 左侧导航条 -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">主导航</li>
            <li>
                <a href="{{ route('admin') }}">
                    <i class="fa fa-tachometer"></i>
                    <span>后台首页</span>
                </a>
            </li>
            <li>
                <a href="{{ route('rules.index') }}">
                    <i class="fa fa-paper-plane"></i>
                    <span>权限管理</span>
                </a>
            </li>
            <li>
                <a href="{{ url('admin/user/userpay') }}">
                    <i class="fa fa-user"></i>
                    <span>商户管理</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-cog"></i>
                    <span>系统设置</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
<!-- 左侧导航结束 -->