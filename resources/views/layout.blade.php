<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Genee CRM</title>
    <base href="{{ url() }}">

    <!-- 基础服务 -->
    <script data-main="assets/js/main" src="assets/js/require.js"></script>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <link rel="stylesheet" href="assets/css/app.css">
    <!-- 基础服务 end -->

</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav id="nav" class="navbar navbar-default navbar-static-top" >
            <div class="navbar-header ">
                <a class="navbar-brand" href="/">Genee CRM V{{ config('app.version') }}</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li>

                    <div class="user">
                        {{--*/ $user = \Session::get('user');/*--}}
                        @if (parse_url($user->icon)['scheme'] == 'initials')
                            {{ parse_url($user->icon)['host'] }}
                        @else
                            <img class="img-rounded" src="{{ $user->icon }}" />
                        @endif
                    </div>

                </li>
                <li>
                    <a class="dropdown-toggle" href="{{ route('logout') }}">
                        <i class="fa fa-user fa-sign-out"></i> 登出
                    </a>
                </li>

            </ul>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar">

                <div class="sidebar-nav navbar-collapse">

                    <ul class="nav">
                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> 总览</a>
                        </li>

                        @if ($user->can(['客户查看', '客户信息管理']))
                        <li>
                            <a href="{{ route('clients') }}"><i class="fa fa-users fa-fw"></i> 客户</a>
                        </li>
                        @endif

                        @if ($user->can('项目查看', '项目签约', '项目信息管理', '项目模块管理', '项目参数管理', '项目硬件管理', '项目服务器管理'))
                        <li>
                            <a href="{{ route('projects') }}"><i class="fa fa-fw fa-list-alt"></i> 项目</a>
                        </li>
                        @endif

                        @if ($user->can(['服务器查看', '服务器信息管理']))
                        <li>
                            <a href="{{ route('servers') }}"><i class="fa fa-linux fa-fw"></i> 服务器</a>
                        </li>
                        @endif

                        @if ($user->can(['产品查看', '产品信息管理', '产品类别管理', '产品模块管理', '产品参数管理']))
                        <li>
                            <a href="{{ route('products') }}"><i class="fa fa-wrench fa-fw"></i> 产品</a>
                        </li>
                        @endif

                        @if ($user->can(['硬件查看', '硬件管理']))
                        <li>
                            <a href="{{ route('hardwares') }}"><i class="fa fa-cog fa-fw"></i> 硬件</a>
                        </li>
                        @endif

                        @if ($user->is_admin())
                        <li>
                            <a href="{{ route('users') }}"><i class="fa fa-user fa-fw"></i> 用户</a>
                        </li>

                        <li>
                            <a href="{{ route('roles') }}"><i class="fa fa-heart-o fa-fw"></i> 角色</a>
                        </li>
                        @endif

                        <li>
                            <a href="#" id="close-menu"><i class="fa fa-chevron-circle-left fa-fw"></i> 收起</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <button class="btn btn-primary hide btn-sm" id="show-menu">
            <i class="fa fa-fw fa-times"></i>
        </button>

        @if (session('message_content'))
            @include('message')
        @endif

        <div id="content">
            @yield('content')
        </div>
    </div>

    <script type="text/javascript">
        require(['jquery'], function($) {

            $('#show-menu').on('click', function(e) {
                $(this).addClass('hide');

                $('#close-menu').show();

                $('#close-menu').parents('nav').removeClass('hide');

                $('#content').css('margin-left', '100px');
                e.stopPropagation();

                return false;
            });

            //关闭按钮
            $('#close-menu').bind('click', function(e) {
                $(this).parents('nav').addClass('hide');

                $('#content').css('margin-left', '0px');

                e.stopPropagation();

                $('#show-menu').removeClass('hide');

                return false;
            });

            var trigger = 51, $sidebar = $('.sidebar');
            function sideBar() {
                var docScrollTop = $(document).scrollTop();

                if (docScrollTop >= trigger) {
                    $sidebar.stop().animate({top: 0}, 30);
                } else {
                    $sidebar.stop().animate({top: trigger - docScrollTop}, 30);
                }
            }
            $(window).scroll(function(){
                sideBar();
            });

            sideBar();
        });
    </script>
</body>
