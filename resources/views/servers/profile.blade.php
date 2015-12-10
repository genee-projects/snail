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
                        <td>数据库</td>
                        <td>{{ $server->database }}</td>
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
                </tr>

                @foreach($server->projects as $project)
                    <tr>
                        <td>{{ $project->ref_no }}</td>
                        <td><a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a></td>
                        <td>{{ $project->pivot->usage }}</td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
    </div>



    <script type="text/javascript">
        new Clipboard('.btn-clip');
    </script>

@endsection