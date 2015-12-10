<!DOCTYPE html>
<html lang="en" ng-app="clients">
<head>
    <meta charset="UTF-8">
    <title>Genee CRM</title>
    <base href="http://parrot:8000/">
    <link rel="stylesheet" href="asserts/3rd/bootstrap/dist/css/bootstrap.min.css">
    <script src="asserts/3rd/jquery/dist/jquery.min.js"></script>

    <script src="asserts/3rd/moment/min/moment.min.js"></script>

    <script src="asserts/3rd/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="asserts/3rd/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="asserts/3rd/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <script src="asserts/3rd/holderjs/holder.js"></script>
    <link rel="stylesheet" href="asserts/3rd/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="asserts/css/crm.css">

    <link href="asserts/css/timeline.css" rel="stylesheet">


    <link href="asserts/3rd/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <script src="asserts/3rd/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

    <script src="asserts/3rd/clipboard/dist/clipboard.min.js"></script>


    <link href="asserts/3rd/bootstrap-toggle/css/bootstrap-toggle.css" rel="stylesheet">
    <script src="asserts/3rd/bootstrap-toggle/js/bootstrap-toggle.js"></script>

    <script src="asserts/js/crm.js"></script>

    <script src="asserts/3rd/bootstrap3-typeahead/bootstrap3-typeahead.min.js"></script>

    <script src="asserts/3rd/vue/dist/vue.min.js"></script>
</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; position: fixed;">
            <div class="navbar-header ">
                <a class="navbar-brand" href="/" style="margin: 0px auto;">Genee CRM V0.0.1</a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">


                <div class="sidebar-nav navbar-collapse">

                    <ul class="nav">

                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> 总览</a>
                        </li>

                        <li>
                            <a href="/clients"><i class="fa fa-users fa-fw"></i> 客户管理</a>
                        </li>

                        <li>
                            <a href="/projects"><i class="fa fa-fw fa-list-alt"></i> 项目管理</a>
                        </li>

                        <li>
                            <a href="/servers"><i class="fa fa-linux fa-fw"></i> 服务器管理</a>
                        </li>

                        <li>
                            <a href="products"><i class="fa fa-cubes"></i> 产品管理

                                {{--<span class="badge pull-right">--}}
                                    {{--{{ $products_count}}--}}
                                {{--</span>--}}
                                {{----}}
                            </a>
                        </li>

                        <li>
                            <a href="templates"><i class="fa fa-file-code-o"></i> 模板生成器</a>
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
</body>