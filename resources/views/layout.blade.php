<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Genee CRM</title>
    <base href="{{ config('app.url') }}">

    <!-- 基础服务 -->
    <script data-main="asserts/js/main" src="asserts/js/require.js"></script>

    <link rel="stylesheet" href="asserts/css/bootstrap.min.css">
    <link rel="stylesheet" href="asserts/css/font-awesome.min.css">

    <link rel="stylesheet" href="asserts/css/crm.css">
    <!-- 基础服务 end -->

</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; position: fixed;">
            <div class="navbar-header ">
                <a class="navbar-brand" href="/" style="margin: 0px auto;">Genee CRM V0.2.0</a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">

                <div class="sidebar-nav navbar-collapse">

                    <ul class="nav metismenu">
                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> 总览</a>
                        </li>

                        <li>
                            <a href="{{ route('clients') }}"><i class="fa fa-users fa-fw"></i> 客户管理</a>
                        </li>

                        <li>
                            <a href="{{ route('projects') }}"><i class="fa fa-fw fa-list-alt"></i> 项目管理</a>
                        </li>

                        <li>
                            <a href="{{ route('servers') }}"><i class="fa fa-linux fa-fw"></i> 服务器管理</a>
                        </li>

                        <li>
                            <a href="{{ route('products') }}"><i class="fa fa-wrench fa-fw"></i> 产品管理</a>
                        </li>

                        <li>
                            <a href="{{ route('users') }}"><i class="fa fa-user fa-fw"></i> 用户管理</a>
                        </li>

                        <li>
                            <a href="{{ route('roles') }}"><i class="fa fa-heart-o fa-fw"></i> 角色设置</a>
                        </li>

                        <li>
                            <a href="#" id="close-menu"><i class="fa fa-chevron-circle-left fa-fw"></i> 收起菜单</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <button class="btn btn-primary hide btn-sm" id="show-menu">
            <i class="fa fa-fw fa-chevron-circle-right">&#160;</i>
        </button>

        @if (session('message_content'))
            @include('message')
        @endif

        <div id="page-wrapper" style="min-height: 660px;">
             @yield('content')
        </div>
    </div>

    <script type="text/javascript">
        require(['jquery'], function($) {

            $('#show-menu').on('click', function(e) {
                $(this).addClass('hide');

                $('#close-menu').show();

                $('#close-menu').parents('[role=navigation]').removeClass('hide');

                $('#page-wrapper').css('margin-left', '200px');
                e.stopPropagation();

                return false;
            });

            //关闭按钮
            $('#close-menu').bind('click', function(e) {
                $(this).parents('[role=navigation]').addClass('hide');

                $('#page-wrapper').css('margin-left', '0px');

                e.stopPropagation();

                $('#show-menu').removeClass('hide');

                return false;

            });
        });
    </script>
</body>
