@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $server->name }}</h1>
        </div>
    </div>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading ">
                <span>
                    <i class="fa fa-linux"></i> 基本信息
                </span>

                {{--*/ $can_manage_server = \Session::get('user')->can('服务器信息管理')/*--}}

                @if ($can_manage_server)
                <span class="pull-right">
                    <a href="#" data-toggle="modal" data-target="#edit-server">
                        <i class="fa fa-fw fa-edit"></i>
                    </a>

                    <a href="{{ route('server.delete', ['id'=> $server->id]) }}">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                </span>

                <div class="modal fade" id="edit-server" tabindex="-1" role="dialog" aria-labelledby="edit-server-modal-label">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="edit-server-modal-label">修改服务器</h4>
                            </div>
                            <div class="modal-body">
                                <form id="edit-server-form" class="form-horizontal" method="post" action="{{ route('server.edit') }}">
                                    <input type="hidden" name="id" value="{{ $server->id }}">
                                    @include('servers/form', ['server'=> $server])
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="edit-server-form">修改</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="panel-body">

                <table class="table table-hover table-striped table-bordered">

                    <tr>
                        <td class="col-lg-2">名称</td>
                        <td>{{ $server->name }}</td>
                    </tr>

                    <tr>
                        <td>提供方</td>
                        <td>
                          {{ App\Server::$providers[$server->provider] }}
                        </td>
                    </tr>

                    <tr>
                        <td>条形码</td>
                        <td>{{ $server->barcode }}</td>
                    </tr>

                    <tr>
                        <td>序列号</td>
                        <td>{{ $server->sn }}</td>
                    </tr>

                    <tr>
                        <td>型号</td>
                        <td>{{ $server->model }}</td>
                    </tr>

                    <tr>
                        <td>CPU</td>
                        <td>{{ $server->cpu }}核</td>
                    </tr>

                    <tr>
                        <td>内存</td>
                        <td>{{ $server->memory }}GB</td>
                    </tr>

                    <tr>
                        <td>硬盘</td>
                        <td>{{ $server->disk }}GB</td>
                    </tr>

                    <tr>
                        <td>操作系统</td>
                        <td>{{ $server->os }}</td>
                    </tr>

                    <tr>
                        <td>FQDN</td>
                        <td><code>{{ $server->fqdn }}</code></td>
                    </tr>

                    <tr>
                        <td>VPN</td>
                        <td><code>{{ $server->vpn }}</code></td>
                    </tr>

                    <tr>
                        <td>内网 IP</td>
                        <td><code>{{ $server->inner_ip }}</code></td>
                    </tr>

                    <tr>
                        <td>外网 IP</td>
                        <td><code>{{ $server->outer_ip }}</code></td>
                    </tr>

                    <tr>
                        <td>备注信息</td>
                        <td>{{ $server->description }}</td>
                    </tr>

                    @foreach($server->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                {{ $item->value }}
                                <span class="pull-right">
                                    <a href="{{ route('item.delete', ['id'=> $item->id]) }}"><i class="fa fa-times"></i></a>
                                </span>
                            </td>
                        </tr>
                    @endforeach


                    @if ($can_manage_server)
                        <tr>
                            <td colspan="2">
                                <span class="pull-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#add-item"><i class="fa fa-plus"></i> 追加字段</button>
                                </span>

                                <div class="modal fade" id="add-item" tabindex="-1" role="dialog" aria-labelledby="add-item-modal-label">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="edit-server-modal-label">追加字段</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add-item-form" method="post" action="{{ route('item.add') }}">
                                                    <input type="hidden" name="object_type" value="{{ get_class($server) }}"/>
                                                    <input type="hidden" name="object_id" value="{{ $server->id }}" />

                                                    <div class="form-group">
                                                        <input name="name" type="text" class="form-control" placeholder="名称(机器尺寸)">
                                                    </div>

                                                    <div class="form-group">
                                                        <input name="value" type="text" class="form-control" placeholder="显示值(3U)">
                                                    </div>

                                                    <div class="form-group">
                                                        <input name="key" type="text" class="form-control" placeholder="代码(size) 可不填">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                <button type="submit" class="btn btn-primary" form="add-item-form">添加</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading ">
            <span>
                <i class="fa fa-linux"></i> 项目信息
            </span>
        </div>
        <div class="panel-body">

            <table class="table table-hover table-striped table-bordered">

                <tr>
                    <td>项目编号</td>
                    <td>项目名称</td>
                    <td>部署时间</td>
                </tr>

                @foreach($server->projects as $project)
                    <tr>
                        <td>{{ $project->ref_no }}</td>
                        <td><a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a></td>
                        <td>{{ (new DateTime($project->pivot->deploy_time))->format('Y/m/d') }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

@endsection
