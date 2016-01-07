@extends('layout')

@section('content')
    <link rel="stylesheet" href="asserts/css/projects/profile.css">
    <script type="text/javascript">
        require(['jquery', 'bootstrap-datetimepicker'], function($) {

            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD'
            });

            require(['css!../css/bootstrap-datetimepicker.min'], function() {

            });

            require(['css!../css/timeline'], function() {});
        });

        require(['holder'], function() {});
    </script>
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
                                            @include('projects/full_form', ['project'=> $project])
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
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td class="col-lg-2">客户名称</td>
                            <td><a href="{{ route('client.profile', ['id'=> $project->client->id]) }}">{{ $project->client->name }}</a></td>
                        </tr>
                        <tr>
                            <td>项目名称</td>
                            <td>
                                {{ $project->name }}

                                @if ($project->vip)
                                    <span class="label label-danger">重点项目</span>
                                @endif

                                @if ($project->official)
                                    <span class="label label-info">正式</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>项目编号</td>
                            <td>{{ $project->ref_no }}</td>
                        </tr>
                        <tr>
                            <td>产品/产品类型</td>
                            <td><a href="{{ route('subproduct.profile', ['id'=> $project->product->id]) }}">{{ $project->product->name }} ({{ $project->product->product->name }})</a></td>
                        </tr>
                        <tr>
                            <td>联系人</td>
                            <td>{{ $project->contact_user }}</td>
                        </tr>
                        <tr>
                            <td>联系电话</td>
                            <td>{{ $project->contact_phone }}</td>
                        </tr>
                        <tr>
                            <td>联系邮箱</td>
                            <td>{{ $project->contact_email }}</td>
                        </tr>
                        <tr>
                            <td>销售负责人</td>
                            <td>{{ $project->seller }}</td>
                        </tr>
                        <tr>
                            <td>工程师负责人</td>
                            <td>{{  $project->engineer }}</td>
                        </tr>
                        <tr>
                            <td>部署地址</td>
                            <td>{{ $project->deploy_address }}</td>
                        </tr>
                        <tr>
                            <td>乘车路线</td>
                            <td>{{ $project->way }}</td>
                        </tr>

                        @foreach($project->items as $item)
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
                <div class="panel-body">


                    <div>

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
                                <div class="panel-body">


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
                                <div class="panel-body">
                                    <h4>模块列表</h4>

                                    <div class="row">
                                        <div class="col-sm-12">
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
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td>
                                                         <span class="pull-right">
                                                            <button data-toggle="modal" data-target="#edit-modules" type="submit" class="btn btn-primary"><i class="fa fa-wrench"></i> 设置模块</button>
                                                         </span>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="edit-modules" tabindex="-1" role="dialog" aria-labelledby="edit-modules-label">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title" id="myModalLabel">设置模块</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="edit-module-form" method="post" action="{{ route('project.modules', ['id'=> $project->id]) }}">

                                                                            @foreach($project->product->product->modules as $module)

                                                                                {{--*/ $selected = false /*--}}
                                                                                {{--*/ $btn_class = 'btn-default' /*--}}

                                                                                @if($project->modules->contains($module->id))
                                                                                    {{--*/ $selected = true /*--}}
                                                                                    {{--*/ $btn_class = 'btn-primary' /*--}}
                                                                                @endif

                                                                                <span data-id="{{ $module->id }}" data-dep-modules="{{ join(',', $module->dep_modules_ids()) }}" class="module-btn btn {{ $btn_class }} text-center">
                                                                                    {{ $module->name }}
                                                                                </span>

                                                                                @if($selected)
                                                                                    <input type="hidden" name="modules[]" value="{{ $module->id }}" />
                                                                                @endif

                                                                            @endforeach
                                                                        </form>

                                                                        <script type="text/javascript">

                                                                            require(['jquery'], function($) {

                                                                                function check_disabled(dep_modules_ids, form) {

                                                                                    disabled = false;

                                                                                    $('[data-id=' + dep_modules_ids.join('],[data-id=') + ']', form).each(function() {

                                                                                        if (! $(this).hasClass('btn-primary')) {
                                                                                            disabled = true;
                                                                                        }
                                                                                    });

                                                                                    return disabled;
                                                                                }

                                                                                function refresh_btn_status() {

                                                                                    $('.module-btn').each(function() {

                                                                                        var $btn = $(this);

                                                                                        var form = $(this).parents('form');

                                                                                        //查看依赖

                                                                                        if ($btn.data('dep-modules')) {

                                                                                            var raw_dep_modules = $btn.data('dep-modules');

                                                                                            if (raw_dep_modules.toString().indexOf(',') != -1) {
                                                                                                var dep_modules_ids = raw_dep_modules.toString().split(',');
                                                                                            }
                                                                                            else {
                                                                                                var dep_modules_ids = [raw_dep_modules.toString()];
                                                                                            }

                                                                                            //查找依赖的模块, 查看是否被 check
                                                                                            //如果没被check, 那么 disabled="disabled"
                                                                                            if (check_disabled(dep_modules_ids, form)) {
                                                                                                $btn.attr('disabled', 'disabled');
                                                                                                $btn.removeClass('btn-primary');
                                                                                                $btn.addClass('btn-default');
                                                                                                $btn.next(":input").remove();
                                                                                            }
                                                                                            else {
                                                                                                $btn.removeAttr('disabled');
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                }

                                                                                refresh_btn_status();


                                                                                $('.module-btn').bind('click', function() {
                                                                                    $input = $('<input type="hidden" name="modules[]" />');

                                                                                    var $span = $(this);

                                                                                    if (! $(this).attr('disabled')) {
                                                                                        if ($span.hasClass('btn-default')) {
                                                                                            $span.removeClass('btn-default');
                                                                                            $span.addClass('btn-primary');
                                                                                            $input.val($span.data('id'));

                                                                                            $span.after($input);
                                                                                        }
                                                                                        else {
                                                                                            $span.removeClass('btn-primary');
                                                                                            $span.addClass('btn-default');
                                                                                            $span.next(":input").remove();
                                                                                        }
                                                                                        refresh_btn_status();
                                                                                    }
                                                                                });
                                                                            });
                                                                        </script>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                                        <button type="subit" form="edit-module-form" class="btn btn-primary">保存</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                    <hr />


                                    <h4>参数列表</h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table-striped table-hover table">
                                                <tr>
                                                    <td>名称</td>
                                                    <td>参数值</td>
                                                </tr>

                                                @foreach($project->params as $param)
                                                    <tr>
                                                        <td>
                                                            {{ $param->name }}
                                                        </td>
                                                        <td>
                                                            <code>{{ $param->pivot->value }}</code>
                                                            <span class="pull-right">
                                                                <i class="fa fa-fw fa-edit edit-param" data-id="{{ $param->id }}" data-name="{{ $param->name }}" data-value="{{ $param->pivot->value }}"></i>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan="2">
                                                        <span class="pull-right">
                                                            <button data-toggle="modal" data-target="#params" type="button" class="btn btn-primary"><i class="fa fa-wrench"></i> 设置参数</button>
                                                        </span>

                                                        <div class="modal fade" id="params" tabindex="-1" role="dialog" aria-labelledby="add-param-modal-label">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title" id="add-module-modal-label">设置参数</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form id="params-form" class="form-horizontal" method="post" action="{{ route('project.params', ['id'=> $project->id]) }}">
                                                                            @foreach($project->product->product->params as $param)

                                                                                {{--*/ $selected = false /*--}}
                                                                                {{--*/ $btn_class = 'btn-default' /*--}}

                                                                                @if($project->params->contains($param->id))
                                                                                    {{--*/ $selected = true /*--}}
                                                                                    {{--*/ $btn_class = 'btn-primary' /*--}}
                                                                                @endif

                                                                                <div data-id="{{ $param->id }}" class="param-btn btn {{ $btn_class }}">
                                                                                    {{ $param->name }}
                                                                                </div>

                                                                                @if($selected)
                                                                                    <input type="hidden" name="params[]" value="{{ $param->id }}" />
                                                                                @endif

                                                                            @endforeach

                                                                            <script type="text/javascript">

                                                                                require(['jquery', 'bootstrap3-typeahead'], function($) {
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

                                                                                });

                                                                                require(['jquery'], function($) {

                                                                                    $('.edit-param').bind('click', function() {
                                                                                        var $modal = $('#edit-param');
                                                                                        $modal.find(':input[name=name]').val($(this).data('name'));
                                                                                        $modal.find(':input[name=value]').val($(this).data('value'));
                                                                                        $modal.find(':input[name=param_id]').val($(this).data('id'));


                                                                                        $modal.modal();
                                                                                    });

                                                                                    $('.param-btn').bind('click', function() {

                                                                                        $input = $('<input type="hidden" name="params[]" />');

                                                                                        var $div = $(this);

                                                                                        if ($div.hasClass('btn-default')) {
                                                                                            $div.removeClass('btn-default');
                                                                                            $div.addClass('btn-primary');
                                                                                            $input.val($div.data('id'));

                                                                                            $div.after($input);
                                                                                        }
                                                                                        else {
                                                                                            $div.removeClass('btn-primary');
                                                                                            $div.addClass('btn-default');
                                                                                            $div.next(":input").remove();
                                                                                        }
                                                                                    });
                                                                                });
                                                                            </script>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                                        <button type="submit" class="btn btn-primary" form="params-form">设置</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="modal fade" id="edit-param" tabindex="-1" role="dialog" aria-labelledby="edit-project-modal-label">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="edit-server-modal-label">修改参数信息</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="edit-project-param-form" class="form-horizontal" method="post" action="{{ route('project.param.edit', ['id'=> $project->id]) }}">

                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control" name="name" disabled="disabled">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-12">
                                                                    <input type="text" class="form-control" name="value">
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="param_id" value="" >

                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                        <button type="submit" class="btn btn-primary" form="edit-project-param-form">修改</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="hardware">
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <td>名称</td>
                                            <td>规格/型号</td>
                                            <td>生产类型</td>
                                            <td>部署数量</td>
                                            <td>签约数量</td>
                                            <td>备注</td>
                                        </tr>

                                        @foreach($project->hardwares as $hardware)
                                            <tr>
                                                <td>{{ $hardware->name }}</td>
                                                <td>{{ $hardware->model }}</td>
                                                <td>
                                                    @if ($hardware->self_produce)
                                                        自产
                                                    @else
                                                        外采
                                                    @endif

                                                </td>
                                                <td>
                                                    {{ $hardware->pivot->deployed_count }}
                                                </td>
                                                <td>
                                                    {{ $hardware->pivot->plan_count }}
                                                </td>

                                                <td>
                                                    {{ $hardware->pivot->description }}
                                                    <span class="pull-right">
                                                          <i class="fa fa-fw fa-edit edit-hardware" data-model="{{ $hardware->model }}" data-description="{{ $hardware->description }}" data-id="{{ $hardware->id }}" data-name="{{ $hardware->name }}" data-plan-count="{{ $hardware->pivot->plan_count }}" data-deployed-count="{{ $hardware->pivot->deployed_count }}"></i>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="6">
                                                <span class="pull-right">
                                                    <button data-toggle="modal" data-target="#hardwares" type="button" class="btn btn-primary"><i class="fa fa-wrench"></i> 设置硬件</button>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>

                                    <div class="modal fade" id="hardwares" tabindex="-1" role="dialog" aria-labelledby="hardwares-modal-label">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="hardwares-modal-label">设置硬件</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-hardware-form" class="form-horizontal" method="post" action="{{ route('project.hardwares', ['id'=> $project->id]) }}">
                                                        @foreach($project->product->product->hardwares as $hardware)

                                                            {{--*/ $selected = false /*--}}
                                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                                            {{--*/ $project_hardware = $project->hardwares->find($hardware->id)/*--}}

                                                            @if($project_hardware)
                                                                {{--*/ $selected = true /*--}}
                                                                {{--*/ $btn_class = 'btn-primary' /*--}}
                                                            @endif

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div data-id="{{ $hardware->id }}" class="hardware-btn btn {{ $btn_class }}">
                                                                        {{ $hardware->name }}
                                                                    </div>
                                                                    @if($selected)
                                                                        <input type="hidden" name="hardwares[]" value="{{ $hardware->id }}" />
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <script type="text/javascript">

                                                            require(['jquery'], function($) {

                                                                $('.hardware-btn').bind('click', function() {

                                                                    $input = $('<input type="hidden" name="hardwares[]" />');

                                                                    var $div = $(this);

                                                                    if ($div.hasClass('btn-default')) {
                                                                        $div.removeClass('btn-default');
                                                                        $div.addClass('btn-primary');
                                                                        $input.val($div.data('id'));

                                                                        $div.after($input);
                                                                    }
                                                                    else {
                                                                        $div.removeClass('btn-primary');
                                                                        $div.addClass('btn-default');
                                                                        $div.next(":input").remove();
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    <button type="submit" class="btn btn-primary" form="add-hardware-form">设置</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="edit-hardware" tabindex="-1" role="dialog" aria-labelledby="edit-hardware-modal-label">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="edit-hardware-modal-label">修改硬件信息</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-project-hardware-form" class="form-horizontal" method="post" action="{{ route('project.hardware.edit', ['id'=> $project->id]) }}">

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" name="name" disabled="disabled">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" name="model" disabled="disabled">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" name="deployed_count" placeholder="部署数量">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control" name="plan_count" placeholder="签约数量">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" name="description" rows="3" placeholder="备注"></textarea>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="hardware_id" value="" >

                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    <button type="submit" class="btn btn-primary" form="edit-project-hardware-form">修改</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        require(['jquery'], function($) {

                                            $('.edit-hardware').bind('click', function() {
                                                var $modal = $('#edit-hardware');
                                                $modal.find(':input[name=name]').val($(this).data('name'));
                                                $modal.find(':input[name=model]').val($(this).data('model'));
                                                $modal.find(':input[name=plan_count]').val($(this).data('plan-count'));
                                                $modal.find(':input[name=deployed_count]').val($(this).data('deployed-count'));
                                                $modal.find(':input[name=desription]').val($(this).data('description'));

                                                $modal.find(':input[name=hardware_id]').val($(this).data('id'));

                                                $modal.modal();
                                            });
                                        });
                                    </script>


                                </div>
                            </div>


                            <!-- server -->
                            <div role="tabpanel" class="tab-pane" id="server">
                                <div class="panel-body">

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

                                    <form class="form-horizontal" method="post" action="{{ route('project.servers', ['id'=> $project->id]) }}">

                                        <div class="form-group">
                                            <label for="server_selector" class="col-sm-2 control-label">选择服务器</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" data-provide="typeahead" id="server_selector">

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

@endsection
