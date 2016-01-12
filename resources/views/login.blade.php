<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Genee CRM</title>
    <base href="{{ url() }}">

    <!-- 基础服务 -->
    <script data-main="asserts/js/main" src="asserts/js/require.js"></script>

    <link rel="stylesheet" href="asserts/css/bootstrap.min.css">
    <link rel="stylesheet" href="asserts/css/font-awesome.min.css">

    <!-- 基础服务 end -->

    <link rel="stylesheet" href="asserts/css/login.css">
</head>
<body>

    <div id="content">

        <div class="top"></div>

        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">登录</h4>
                    </div>
                    <form class="modal-body form gapper-auth-login-form" method="POST" action="{{ route('login') }}">
                        <dl class="dl-horizontal">
                            <dt class="text-center">
                            <div class="app-icon">
                                <div class="text-center app-icon-image"><img src="asserts/icon/gapper.png" /></div>
                                <div class="text-center app-icon-title">Gapper</div>
                            </div>
                            </dt>
                            <dd>
                                <div class="gapper-auth-login-form-li form-group">
                                    <div class="gapper-auth-login-form-placeholder">Email</div>
                                    <input class="form-control" type="text" name="username" placeholder="电子邮箱" />
                                </div>
                                <div class="gapper-auth-login-form-li form-group">
                                    <div class="gapper-auth-login-form-placeholder">Password</div>
                                    <input class="form-control" type="password" name="password" placeholder="密码" />
                                    <div class="text-right">
                                        <a href="{{ route('gapper.go', ['type'=> 'forgot-password']) }}" class="text-muted" target="_blank">
                                            <small>忘记密码?</small>
                                        </a>
                                    </div>
                                </div>
                                <div class="gapper-auth-login-form-li form-group">
                                    <input class="form-control btn btn-primary" type="submit" value="登录"/>
                                </div>
                            </dd>
                        </dl>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('message'))
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true" style="margin-top: -10px;">×</button>
                        <div class="bootbox-body">{{ session('message') }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        require(['jquery', 'bootstrap'], function($) {
            $('.modal').modal({backdrop: 'static', keyboard: false});
        });
    </script>

</body>

