<!-- 顶部 -->
<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
        <!-- 侧边栏小标志 -->
        <span class="logo-mini"><img src="/images/logo/logo-ico.png" alt="User Image"></span>
        <!-- 常规状态的标志 -->
        <span class="logo-lg"><img src="/images/logo/logo.png" alt="User Image"></span>
    </a>
    <!-- 首部导航条 -->
    <nav class="navbar navbar-static-top">
        <!-- 侧边栏切换按钮-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">admin</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- 用户图片 -->
                        <li class="user-header">
                            <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">

                            <p>{{ Auth::user()->username }} - 网站开发者</p>
                        </li>
                        <!-- 用户退出登录-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">修改密码</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.dropout') }}" class="btn btn-default btn-flat">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- 顶部结束-->