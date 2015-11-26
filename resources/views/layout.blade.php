<!DOCTYPE html>
<html lang="en" ng-app="clients">
<head>
    <meta charset="UTF-8">
    <title>Genee CRM</title>
    <base href="http://parrot:8000/">
    <link rel="stylesheet" href="asserts/3rd/bootstrap/dist/css/bootstrap.min.css">
    <script src="asserts/3rd/jquery/dist/jquery.min.js"></script>

    <script src="asserts/3rd/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="asserts/3rd/holderjs/holder.js"></script>
    <link rel="stylesheet" href="asserts/3rd/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="asserts/css/crm.css">

    <link href="asserts/css/timeline.css" rel="stylesheet">


    <link href="asserts/3rd/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">

    <script src="asserts/3rd/bootstrap-select/dist/js/bootstrap-select.min.js"></script>


    <script src="asserts/js/crm.js"></script>
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
                            <a href="/servers"><i class="fa fa-server fa-fw"></i> 服务器管理</a>

                        </li>

                        <li>
                            <a href="products"><i class="fa fa-cubes"></i> 产品管理</a>
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

        <div class="" style="position: fixed; top: 8px; right: 14px; z-index: 10;">

            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Heads up!</strong> This alert needs your attention, but it's not super important.
            </div>
        </div>

        <div id="page-wrapper" style="min-height: 660px;">
             @yield('content')
        </div>
    </div>
</body>