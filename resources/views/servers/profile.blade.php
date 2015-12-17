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
                <span class="pull-right">
                    <a href="#" data-toggle="modal" data-target="#edit-server">
                        <i class="fa fa-fw fa-edit"></i>
                    </a>

                    <a href="/servers/delete/{{ $server->id }}">
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
                                <form id="edit-server-form" class="form-horizontal" method="post" action="/servers/edit">
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

            </div>
            <div class="panel panel-body">

                <table class="table table-hover table-striped table-bordered">

                    <tr>
                        <td style="width: 20%;">名称</td>
                        <td>{{ $server->name }}</td>
                    </tr>

                    <tr>
                        <td>提供方</td>
                        <td>
                            @if ($server->customer_provide)
                                客户自备
                            @else
                                公司提供
                            @endif
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
                        <td>备注信息</td>
                        <td>{{ $server->description }}</td>
                    </tr>

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
        <div class="panel panel-body">

            <table class="table table-hover table-striped table-bordered">

                <tr>
                    <td>项目编号</td>
                    <td>项目名称</td>
                    <td>部署原因</td>
                    <td>部署时间</td>
                </tr>

                @foreach($server->projects as $project)
                    <tr>
                        <td>{{ $project->ref_no }}</td>
                        <td><a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a></td>
                        <td>{{ $project->pivot->usage }}</td>
                        <td>{{ date('Y/m/d', strtotime($project->pivot->usage)) }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading ">
            <span>
                <i class="fa fa-linux"></i> 服务信息
            </span>
        </div>
        <div class="panel panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <form method="post" action="{{ route('item.add') }}">
                        <table class="table table-hover table-striped table-bordered">

                            <tr>
                                <td>名称</td>
                                <td>代码</td>
                            </tr>

                            @foreach($server->services as $service)
                                <tr>
                                    <td>{{ $service->name }}</td>
                                    <td>
                                        <code>{{ $service->code }}</code>
                                        <span class="pull-right">
                                            <a href="{{ route('service.delete', ['id'=> $service->id]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <a class="add-item" _id="{{ $service->id }}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>

                                @foreach($service->items as $item)
                                    <tr>
                                        <td colspan="2">
                                            <span class="pull-right">
                                                <code>{{ $item->key }}</code> : <code>{{ $item->value }}</code>
                                                <a href="{{ route('item.delete', ['id'=> $item->id]) }}"><i class="fa fa-times"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                <input type="hidden" name="object_type" value="{{ get_class($service)}}">
                            @endforeach
                        </table>
                    </form>
                </div>

                <div class="col-sm-6">
                    <form method="post" action="{{ route('service.add') }}">
                        <input type="hidden" name="object_type" value="{{ get_class($server) }}" />
                        <input type="hidden" name="object_id" value="{{ $server->id }}" />
                        @include('services/form')
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> 添加</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-item').bind('click', function() {
                var service_id = $(this).attr('_id');

                var $tr = $(this).parents('tr');

                $tr.after($('<input type="hidden" name="object_id" value="' +  service_id +  '"/>'));
                $tr.after($('<tr><td colspan="2"><span class="pull-right"><input type="text" name="key" placeholder="key"> <input type="text" name="value" placeholder="value"> <button type="submit" class="btn btn-primary btn-xs">添加</button></span></td></tr>'));
            });
        });
    </script>
@endsection