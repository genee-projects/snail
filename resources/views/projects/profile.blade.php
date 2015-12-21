@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $project->name }}</h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 基本信息</i>
                    <span class="pull-right">

                         <a href="#" data-toggle="modal" data-target="#edit-project">
                             <i class="fa fa-fw fa-edit"></i>
                         </a>

                        <a href="{{ route('project.delete', ['id'=> $project->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                        <div class="clearfix"></div>

                        <div class="modal fade" id="edit-project" tabindex="-1" role="dialog" aria-labelledby="edit-project-modal-label">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="edit-server-modal-label">修改客户信息</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-client-form" class="form-horizontal" method="post" action="{{ route('project.edit') }}">
                                            <input type="hidden" name="id" value="{{ $project->id }}">
                                            @include('projects/full_form', ['project'=> $project, 'products'=> $products])
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="edit-client-form">修改</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
                <div class="panel panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td style="width: 20%;">客户名称</td>
                            <td colspan="2"><a href="{{ route('client.profile', ['id'=> $project->client->id]) }}">{{ $project->client->name }}</a></td>
                        </tr>
                        <tr>
                            <td>项目名称 (编号)</td>
                            <td colspan="2">{{ $project->name }} ({{ $project->ref_no }})</td>
                        </tr>
                        <tr>
                            <td>产品类型 (版本)</td>
                            <td colspan="2"><a href="{{ route('products') }}">{{ $project->product->name }} ( {{ $project->version }})</a></td>
                        </tr>
                        <tr>
                            <td>联系人</td>
                            <td colspan="2">{{ $project->contact_user }}</td>
                        </tr>
                        <tr>
                            <td>联系电话</td>
                            <td colspan="2">{{ $project->contact_phone }}</td>
                        </tr>
                        <tr>
                            <td>联系邮箱</td>
                            <td colspan="2">{{ $project->contact_email }}</td>
                        </tr>
                        <tr>
                            <td>销售负责人</td>
                            <td colspan="2">{{ $project->seller }}</td>
                        </tr>
                        <tr>
                            <td>工程师负责人</td>
                            <td colspan="2">{{  $project->engineer }}</td>
                        </tr>
                        <tr>
                            <td>部署地址</td>
                            <td colspan="2">{{ $project->deploy_address }}</td>
                        </tr>
                        <tr>
                            <td>乘车路线</td>
                            <td colspan="2">{{ $project->way }}</td>
                        </tr>

                        @foreach($project->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    {{ $item->value }}
                                    <span class="pull-right">
                                        <a href="{{ route('item.delete', ['id'=> $item->id]) }}"><i class="fa fa-times"></i></a>
                                    </span></td>
                            </tr>
                        @endforeach
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
                                                    <input type="hidden" name="object_type" value="{{ get_class($project) }}"/>
                                                    <input type="hidden" name="object_id" value="{{ $project->id }}" />

                                                    <div class="form-group">
                                                        <input name="name" type="text" class="form-control" placeholder="名称(前台页面)">
                                                    </div>

                                                    <div class="form-group">
                                                        <input name="value" type="text" class="form-control" placeholder="显示值(http://www.baidu.com)">
                                                    </div>

                                                    <div class="form-group">
                                                        <input name="key" type="text" class="form-control" placeholder="代码(web_fronted) 可不填">
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
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 其他信息</i>
                </div>
                <div class="panel panel-body">


                    <div id="myTabs">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">

                            <li role="presentation" >
                                <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">
                                    <i class="fa fa-comment-o"></i> 备注信息
                                </a>
                            </li>

                            <li role="presentation">
                                <a href="#server" aria-controls="server" role="tab" data-toggle="tab">
                                    <i class="fa fa-linux"></i> 服务器信息
                                </a>
                            </li>

                            <li role="presentation" class="active">
                                <a href="#software" aria-controls="software" role="tab" data-toggle="tab">
                                    <i class="fa fa-bolt"></i> 软件信息
                                </a>
                            </li>

                            <li role="presentation">
                                <a href="#hardware" aria-controls="hardware" role="tab" data-toggle="tab">
                                    <i class="fa fa-archive"></i> 硬件信息
                                </a>
                            </li>

                            <li role="presentation">
                                <a href="#info" aria-controls="info" role="tab" data-toggle="tab">
                                    <i class="fa fa-info"></i> 信息变动
                                </a>
                            </li>

                            <li role="presentation">
                                <a href="#trello" aria-controls="trello" role="tab" data-toggle="tab">
                                    <i class="fa fa-wrench"></i> 部署情况
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane" id="comments">
                                <div class="panel panel-body">


                                    @foreach($project->comments as $comment)
                                        <div class="media">
                                            <div class="media-left media-middle">
                                                <img data-src="holder.js/40x40">
                                            </div>

                                            <div class="media-body">
                                                {{ $comment->content }}
                                            </div>
                                        </div>
                                    @endforeach

                                    <hr />

                                    <form method="post" action="/comments/add">

                                        <input type="hidden" name="object_type" value="{{ get_class($project) }}" />
                                        <input type="hidden" name="object_id" value="{{ $project->id }}" />

                                        <div class="form-group">
                                            <textarea class="form-control" name="content" rows="3" placeholder="内容"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="fa fa-plus"></i> 备注追加
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane  active" id="software">
                                <div class="panel panel-body">
                                    <h4>模块列表</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <table class="table-striped table-hover table">
                                                <tr>
                                                    <td>名称</td>
                                                </tr>

                                                @foreach($project->modules as $module)
                                                    <tr>
                                                        <td>
                                                            <p>
                                                                <span>
                                                                    {{ $module->name }}
                                                                </span>

                                                                @if($module->pivot->type == 'extra')
                                                                    <span class="pull-right">
                                                                        <a href="{{ route('project.module.delete', ['id'=> $project->id, 'module_id'=> $module->id]) }}">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </span>
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="col-sm-6">
                                            <form id="add-client-form" method="post" action="{{ route('project.module.add', ['id'=> $project->id]) }}">

                                                <div class="form-group">
                                                    <input class="form-control" type="text" data-provide="typeahead" id="extra_module_selector">
                                                </div>

                                                <script type="text/javascript">

                                                    $(document).ready(function() {

                                                        $.get('{{ route('product.extra_modules.json', ['id'=> $project->product->id]) }}', function(data){

                                                            var $selector = $("#extra_module_selector");
                                                            $selector.typeahead({
                                                                source:data,
                                                                displayText: function(item) {
                                                                    return item.name;
                                                                },
                                                                afterSelect: function(item) {
                                                                    //修改 $selector 的 value
                                                                    $selector.val(item.name);
                                                                    //同步设定 value 到 value 输入框
                                                                    $selector.parents('form').find(':input[name=value]').val(item.value);

                                                                    var $input = $('<input name="module_id" type="hidden">');

                                                                    $input.val(item.id);
                                                                    $selector.after($input);
                                                                }
                                                            });
                                                        },'json');
                                                    });

                                                </script>

                                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> 添加附加模块</button>
                                            </form>
                                        </div>
                                    </div>
                                    <hr />
                                    {{--<h4>服务列表</h4>--}}
                                    {{--<div class="row">--}}

                                        {{--<div class="col-sm-6">--}}
                                            {{--<form method="post" action="{{ route('item.add') }}">--}}
                                                {{--<table class="table table-hover table-striped">--}}

                                                    {{--<tr>--}}
                                                        {{--<td>名称</td>--}}
                                                        {{--<td>代码</td>--}}
                                                    {{--</tr>--}}

                                                    {{--@foreach($project->services as $service)--}}
                                                        {{--<tr>--}}
                                                            {{--<td>{{ $service->name }}</td>--}}
                                                            {{--<td>--}}
                                                                {{--<code>{{ $service->code }}</code>--}}
                                                                {{--<span class="pull-right">--}}
                                                                    {{--<a href="{{ route('service.delete', ['id'=> $service->id]) }}">--}}
                                                                        {{--<i class="fa fa-times"></i>--}}
                                                                    {{--</a>--}}
                                                                    {{--<a class="add-item" _id="{{ $service->id }}">--}}
                                                                        {{--<i class="fa fa-plus"></i>--}}
                                                                    {{--</a>--}}
                                                                {{--</span>--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}

                                                        {{--@foreach($service->items as $item)--}}
                                                            {{--<tr>--}}
                                                                {{--<td colspan="2">--}}
                                                                {{--<span class="pull-right">--}}
                                                                    {{--<code>{{ $item->key }}</code> : <code>{{ $item->value }}</code>--}}
                                                                    {{--<a href="{{ route('item.delete', ['id'=> $item->id]) }}"><i class="fa fa-times"></i></a>--}}
                                                                {{--</span>--}}
                                                                {{--</td>--}}
                                                            {{--</tr>--}}
                                                        {{--@endforeach--}}
                                                        {{--<input type="hidden" name="object_type" value="{{ get_class($service)}}">--}}
                                                    {{--@endforeach--}}
                                                {{--</table>--}}
                                            {{--</form>--}}
                                        {{--</div>--}}
                                        {{--<div class="col-sm-6">--}}
                                            {{--<form method="post" action="{{ route('service.add') }}">--}}
                                                {{--<input type="hidden" name="object_type" value="{{ get_class($project) }}">--}}
                                                {{--<input type="hidden" name="object_id" value="{{ $project->id }}">--}}
                                                {{--@include('services/form')--}}
                                                {{--<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> 添加</button>--}}
                                            {{--</form>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="hardware">
                                <div class="panel panel-body">
                                    硬件信息, 等待完善
                                </div>
                            </div>


                            <!-- server -->
                            <div role="tabpanel" class="tab-pane" id="server">
                                <div class="panel panel-body">

                                    <table class="table table-hover table-bordered table-striped">

                                        <tr>
                                            <td>服务器名称</td>
                                            <td>服务器 FQDN</td>
                                            <td>服务器 VPN </td>
                                            <td>服务器用途</td>
                                            <td>部署时间</td>
                                            <td>提供方</td>
                                        </tr>

                                        @foreach($project->servers as $server)

                                            <tr>
                                                <td><a href="{{ route('server.profile', ['id'=> $server->id]) }}">{{ $server->name }}</a></td>
                                                <td>{{ $server->fqdn }}</td>
                                                <td>{{ $server->vpn }}</td>
                                                <td>{{ $server->pivot->usage }}</td>
                                                <td>{{ date('Y/m/d', strtotime($server->pivot->deploy_time)) }}</td>
                                                <td>
                                                    @if ($server->customer_provide)
                                                        客户自备
                                                    @else
                                                        公司提供
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </table>

                                    <hr />

                                    <h3>关联服务器</h3>

                                    <form class="form-horizontal" method="post" action="{{ route('project.server', ['id'=> $project->id]) }}">

                                        <div class="form-group">
                                            <label for="server_selector" class="col-sm-2 control-label">选择服务器</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" style="witdh: 100%;" type="text" data-provide="typeahead" id="server_selector">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="server_deploy_time" class="col-sm-2 control-label">部署时间</label>
                                            <div class="col-sm-10">
                                                <div class="input-group date datetimepicker">
                                                    <input type="text" class="form-control" name="deploy_time" id="server_deploy_time">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="server_usage" class="col-sm-2 control-label">服务器用途</label>
                                            <div class="col-sm-10">
                                                <textarea name="usage" class="form-control" rows="3" id="server_usage"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-10 col-sm-offset-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-plus-circle"></i> 追加服务器
                                                </button>
                                            </div>
                                        </div>

                                        <script type="text/javascript">

                                            $.get('/servers.json', function(data){
                                                var $selector = $("#server_selector");
                                                $selector.typeahead({
                                                    source:data,
                                                    displayText: function(item) {
                                                        return item.name;
                                                    },
                                                    afterSelect: function(item) {
                                                        var $input = $('<input name="server_id" type="hidden">');
                                                        $input.val(item.id);
                                                        $selector.after($input);
                                                    }
                                                });
                                            },'json');
                                        </script>

                                    </form>
                                </div>
                            </div>
                            <!-- server end -->

                            <!-- info -->
                            <div role="tabpanel" class="tab-pane" id="info">
                                <ul class="timeline">
                                    <li>
                                        <div class="timeline-badge info"><i class="fa fa-flag"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title">信息修改</h4>
                                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via Rui Ma</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p> 修改用户信息 <mark>「广东大学」</mark>-&gt;<mark>「广西大学」</mark></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-inverted">
                                        <div class="timeline-badge warning"><i class="fa fa-flag"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="timeline-heading">
                                                <h4 class="timeline-title"> 信息修改</h4>
                                                <p><small class="text-muted"><i class="fa fa-check-o"></i> 12 hours age via Rui Ma</small></p>
                                            </div>
                                            <div class="timeline-body">
                                                <p>创建新客户</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- info end-->

                            <!-- trello -->
                            <div role="tabpanel" class="tab-pane" id="trello">
                                对接 Trello
                            </div>
                            <!-- trello end-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function() {--}}
            {{--$('.add-item').bind('click', function() {--}}
                {{--var service_id = $(this).attr('_id');--}}

                {{--var $tr = $(this).parents('tr');--}}

                {{--$tr.after($('<input type="hidden" name="object_id" value="' +  service_id +  '"/>'));--}}
                {{--$tr.after($('<tr><td colspan="2"><span class="pull-right"><input type="text" name="key" placeholder="key"> <input type="text" name="value" placeholder="value"> <button type="submit" class="btn btn-primary btn-xs">添加</button></span></td></tr>'));--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}

@endsection