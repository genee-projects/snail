@extends('layout')


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">服务器列表</h1>
        </div>
    </div>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading ">
                <p class="vertical-middle">
                    <span>
                        <i class="fa fa-linux"> </i>
                    </span>

                    <span class="pull-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-server">
                            <i class="fa fa-plus"></i>
                            添加服务器
                        </button>
                    </span>

                    <div class="modal fade" id="add-server" tabindex="-1" role="dialog" aria-labelledby="add-server-modal-label">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-server-modal-label">添加服务器</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-server-form" class="form-horizontal" method="post" action="/servers/add">
                                        @include('servers/form')
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-server-form">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-hover table-striped table-bordered">

                            <tr>
                                <td>名称</td>
                                <td>FQDN</td>
                                <td>VPN</td>
                                <td>提供方</td>
                            </tr>

                            @foreach($servers as $server)
                            <tr>
                                <td>
                                    <a href="/servers/profile/{{ $server->id }}">
                                        {{ $server->name }}
                                    </a>
                                </td>
                                <td>
                                    <span>
                                        <code id="fqdn_clip_{{ $server->id }}">{{ $server->fqdn }}</code>
                                    </span>
                                </td>
                                <td>
                                    <span id="vpn_clip_{{ $server->id }}">
                                        {{ $server->vpn }}
                                    </span>
                                </td>
                                <td>
                                    {{ App\Server::$providers[$server->provider]}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
