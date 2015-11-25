<!DOCTYPE html>
<html lang="en" ng-app="clients">
<head>
    <meta charset="UTF-8">
    <title>Genee CRM</title>
    <base href="http://parrot:8000/">
    <link rel="stylesheet" href="asserts/3rd/bootstrap/dist/css/bootstrap.min.css">
    <script src="asserts/3rd/jquery/dist/jquery.min.js"></script>
    <script src="asserts/3rd/angular/angular.min.js"></script>
    <script src="asserts/3rd/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>

    <link href="asserts/3rd/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <link rel="stylesheet" href="asserts/3rd/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="asserts/css/clients.css">

    <link href="asserts/css/sb-admin-2.css" rel="stylesheet">
    <link href="asserts/css/timeline.css" rel="stylesheet">

    <script src="asserts/js/clients.js"></script>

    <script src="asserts/3rd/metisMenu/dist/metisMenu.min.js"></script>

    <script src="asserts/3rd/holderjs/holder.js"></script>

    <script src="asserts/js/sb-admin-2.js"></script>

</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Genee CRM V0.0.1</a>
            </div>
            <!-- /.navbar-header -->



            <div class="navbar-default sidebar" role="navigation">


                <div class="sidebar-nav navbar-collapse">

                    <ul class="nav" id="side-menu">

                        <li>
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> 总览</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> 客户管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="morris.html">全部</a>
                                </li>
                                <li>
                                    <a href="flot.html">CF 客户</a>
                                </li>
                                <li>
                                    <a href="morris.html">Lims 客户</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-server fa-fw"></i> 服务器管理<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#" id="bars"><i class="fa fa-chevron-circle-left fa-fw"></i> 收起菜单</a>
                        </li>

                        <script type="text/javascript">

                            $('#bars').bind('click', function(e) {
                                $(this).parents('[role=navigation]').hide();

                                $('#page-wrapper').css('margin-left', '0px');

                                e.stopPropagation();

                                $('#hehe').removeClass('hide');

                                return false;

                            });

                        </script>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <button class="btn btn-primary hide btn-sm" id="hehe" style="position: fixed; left: 8px; bottom: 8px; z-index: 10;">
            <i class="fa fa-fw fa-chevron-circle-right">&#160;</i>
        </button>


        <div id="page-wrapper" style="min-height: 253px;">


            <script type="text/javascript">
                $('#hehe').on('click', function(e) {
                    $(this).addClass('hide');

                    $('#bars').show();

                    $('#bars').parents('[role=navigation]').show();

                    $('#page-wrapper').css('margin-left', '250px');
                    e.stopPropagation();
                    return false;
                });
            </script>


             @yield('content')
        </div>
    </div>
</body>
