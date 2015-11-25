@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">客户列表</h1>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-users"> </i>
            </div>
            <div class="panel panel-body">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <td>客户编号</td>
                        <td>客户名称</td>
                        <td>FQDN</td>
                        <td>访问地址</td>
                        <td>IP</td>
                        <td>VPN IP</td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">AAAAA</span></td>
                        <td><a href="clients/profile">广西大学</a></td>
                        <td>e141134.server.genee.cn</td>
                        <td>http://www.baidu.com</td>
                        <td>IP</td>
                        <td>10.0.10.111</td>
                    </tr>
                    <tr>
                        <td><span class="label label-primary">AAAAA</span></td>
                        <td>广西大学</td>
                        <td>e141134.server.genee.cn</td>
                        <td>http://www.baidu.com</td>
                        <td>IP</td>
                        <td>10.0.10.111</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection