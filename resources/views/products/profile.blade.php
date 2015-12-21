@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $product->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <i class="fa fa-linux"></i> 基本信息
                    <span class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#edit-server">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>

                        <a href="{{ route('server.delete', ['id' => $product->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>
                    <div class="modal fade" id="edit-server" tabindex="-1" role="dialog" aria-labelledby="edit-server-modal-label">
                        <div class="modal-dialog role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">修改产品</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-product-form" method="post" action="{{ route('product.edit') }}">

                                        <div class="form-group">
                                            <input value="{{ $product->name }}" name="name" type="text" placeholder="名称" class="form-control" />
                                        </div>

                                        <div class="form-group">
                                            <textarea name="description" class="form-control" rows="3" placeholder="简述">{{ $product->description }}</textarea>
                                        </div>
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-product-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel panel-body">

                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <td>简述</td>
                            <td>{{ $product->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p>
                        <i class="fa fa-linux"></i> 基础模块
                        <span class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-normal-module">
                                <i class="fa fa-wrench"></i> 设置模块
                            </button>
                        </span>
                    </p>

                    <div class="modal fade" id="add-normal-module" tabindex="-1" role="dialog" aria-labelledby="add-normal-module-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">设置基础模块</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-normal-module-form" method="post" action="{{ route('product.module', ['id'=> $product->id]) }}">

                                        @foreach(\App\Module::all() as $module)

                                            @if($product->modules()->wherePivot('type', '=', 'extra')->get()->contains($module->id))
                                                {{--*/ continue; /*--}}
                                            @endif

                                            {{--*/ $selected = false /*--}}
                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                            @if($product->modules()->wherePivot('type', '=', 'normal')->get()->contains($module->id))
                                                {{--*/ $selected = true /*--}}
                                                {{--*/ $btn_class = 'btn-primary' /*--}}
                                            @endif


                                            <span _id="{{ $module->id }}" dep_modules="{{ join(',', $module->dep_modules_ids()) }}" class="module-btn btn {{ $btn_class }} text-center" style="padding: 20px; margin:10px 5px; width:100px;">
                                                {{ $module->name }}
                                            </span>

                                            @if($selected)
                                                <input type="hidden" name="modules[]" value="{{ $module->id }}" />
                                            @endif

                                        @endforeach
                                        <span>
                                            <input type="hidden" name="type" value="normal"/>
                                        </span>

                                    </form>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-normal-module-form">设置</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">

                    <table class="table table-hover table-striped table-bordered">

                        <tr>
                            <td style="width: 10%;">名称</td>
                            <td>简述</td>
                        </tr>

                        @foreach($product->modules()->wherePivot('type', '=', 'normal')->get() as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td>
                                    {{ $module->description }}
                                    <span class="pull-right">
                                        <a href="{{ route('product.module.delete', ['id'=> $product->id, 'module_id'=> $module->id]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <p>
                        <span>
                            <i class="fa fa-wrench"></i> 扩展模块
                        </span>
                        <span class="pull-right">
                             <button class="btn btn-primary" data-toggle="modal" data-target="#add-extra-module">
                                 <i class="fa fa-wrench"></i> 设置模块
                             </button>
                        </span>
                    </p>

                    <div class="modal fade" id="add-extra-module" tabindex="-1" role="dialog" aria-labelledby="add-extra-module-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">设置基础模块</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-extra-module-form" method="post" action="{{ route('product.module', ['id'=> $product->id]) }}">

                                        @foreach(\App\Module::all() as $module)

                                            @if($product->modules()->wherePivot('type', '=', 'normal')->get()->contains($module->id))
                                                {{--*/ continue; /*--}}
                                            @endif

                                            {{--*/ $selected = false /*--}}
                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                            @if($product->modules()->wherePivot('type', '=', 'extra')->get()->contains($module->id))
                                                {{--*/ $selected = true /*--}}
                                                {{--*/ $btn_class = 'btn-primary' /*--}}

                                            @endif


                                            <span _id="{{ $module->id }}" dep_modules="{{ join(',', $module->dep_modules_ids()) }}" class="module-btn btn {{ $btn_class }} text-center" style="padding: 20px; margin:10px 5px; width:100px;">
                                                {{ $module->name }}
                                            </span>

                                            @if($selected)
                                                <input type="hidden" name="modules[]" value="{{ $module->id }}" />
                                            @endif
                                        @endforeach

                                        <span>
                                            <input type="hidden" name="type" value="extra" />
                                        </span>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-extra-module-form">设置</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">
                    <table class="table table-hover table-bordered">
                        <tr>
                            <td style="width: 10%;">名称</td>
                            <td>简述</td>
                        </tr>
                        @foreach($product->modules()->wherePivot('type', '=', 'extra')->get() as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td>
                                    {{ $module->description }}
                                    <span class="pull-right">
                                        <a href="{{ route('product.module.delete', ['id'=> $product->id, 'module_id'=> $module->id]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <p>
                        <span>
                            <i class="fa fa-wrench"></i> 参数信息
                        </span>
                         <span class="pull-right">
                             <button class="btn btn-primary" data-toggle="modal" data-target="#add-param">
                                 <i class="fa fa-plus"></i> 追加参数
                             </button>
                        </span>
                    </p>

                    <div class="modal fade" id="add-param" tabindex="-1" role="dialog" aria-labelledby="add-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">追加参数</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" id="add-param-form" method="post" action="{{ route('product.param', ['id'=> $product->id]) }}">
                                        <div class="form-group">
                                            <label for="server_selector" class="col-sm-2 control-label">选择参数</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" data-provide="typeahead" id="param_selector">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="server_usage" class="col-sm-2 control-label">参数值</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="value" >
                                            </div>
                                        </div>

                                        <script type="text/javascript">

                                            $.get('/params.json', function(data){
                                                var $selector = $("#param_selector");
                                                $selector.typeahead({
                                                    source:data,
                                                    displayText: function(item) {
                                                        return item.name + ' ('+  item.value + ')';
                                                    },
                                                    afterSelect: function(item) {
                                                        //修改 $selector 的 value
                                                        $selector.val(item.name);
                                                        //同步设定 value 到 value 输入框
                                                        $selector.parents('form').find(':input[name=value]').val(item.value);

                                                        var $input = $('<input name="param_id" type="hidden">');

                                                        $input.val(item.id);
                                                        $selector.after($input);
                                                    }
                                                });
                                            },'json');
                                        </script>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-param-form">设置</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="panel panel-body">
                    <table class="table table-hover table-striped">
                        <tr>
                            <td>参数名称</td>
                            <td>参数代码</td>
                            <td>参数值</td>
                        </tr>

                        @foreach($product->params as $param)
                            <tr>
                                <td>{{ $param->name }}</td>
                                <td><code>{{ $param->code }}</code></td>
                                <td>
                                    <p>
                                        <span>
                                            {{ $param->pivot->value }}
                                        </span>

                                        <span class="pull-right">
                                            <a href="{{ route('product.param.delete', ['id'=> $product->id, 'param_id'=> $param->id]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </span>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            function check_disabled(dep_modules_ids, form) {

                disabled = false;

                $('[_id=' + dep_modules_ids.join('],[_id=') + ']', form).each(function() {

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

                    if ($btn.attr('dep_modules')) {

                        var dep_modules = $btn.attr('dep_modules');

                        var dep_modules_ids = dep_modules.split(',');

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
                        $input.val($span.attr('_id'));

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

    {{--<div class="row">--}}
        {{--<div class="col-lg-6">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading ">--}}
                    {{--<i class="fa fa-linux"></i> 服务管理--}}
                {{--</div>--}}
                {{--<div class="panel panel-body">--}}
                    {{--<form method="post" action="{{ route('item.add') }}">--}}
                        {{--<table class="table table-hover table-striped table-bordered">--}}

                            {{--<tr>--}}
                                {{--<td>名称</td>--}}
                                {{--<td>代码</td>--}}
                            {{--</tr>--}}

                            {{--@foreach($product->services as $service)--}}
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
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="col-lg-6">--}}
            {{--<div class="panel panel-default">--}}
                {{--<div class="panel-heading ">--}}
                    {{--<i class="fa fa-linux"></i> 服务添加--}}
                {{--</div>--}}
                {{--<div class="panel panel-body">--}}
                    {{--<form method="post" action="{{ route('service.add') }}">--}}
                        {{--<input type="hidden" name="object_type" value="{{ get_class($product) }}" />--}}
                        {{--<input type="hidden" name="object_id" value="{{ $product->id }}" />--}}
                        {{--@include('services/form')--}}
                        {{--<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> 添加</button>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

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