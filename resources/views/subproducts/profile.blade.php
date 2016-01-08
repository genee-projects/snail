@extends('layout')

@section('content')

    <link rel="stylesheet" href="asserts/css/subproducts/profile.css">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $subproduct->name }}</h1>
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

                        <a href="{{ route('subproduct.delete', ['id' => $subproduct->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>

                    <div class="modal fade" id="edit-server" tabindex="-1" role="dialog" aria-labelledby="edit-server-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">修改产品</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-sub-product-form" method="post" action="{{ route('subproduct.edit') }}">

                                        <div class="form-group">
                                            <input value="{{ $subproduct->name }}" name="name" type="text" placeholder="名称" class="form-control" />
                                        </div>

                                        <div class="form-group">
                                            <textarea name="description" class="form-control" rows="3" placeholder="简述">{{ $subproduct->description }}</textarea>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $subproduct->id }}">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-sub-product-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <tr>
                            <td class="col-lg-2">名称</td>
                            <td>{{ $subproduct->name }}</td>
                        </tr>
                        <tr>
                            <td>简述</td>
                            <td>{{ $subproduct->description }}</td>
                        </tr>
                        <tr>
                            <td>所属产品</td>
                            <td><a href="{{ route('product.profile', ['id'=> $subproduct->product->id]) }}">{{ $subproduct->product->name }}</a></td>
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
                    <i class="fa fa-gear"></i> 模块管理
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped">

                        <tr>
                            <td class="col-lg-2">名称</td>
                            <td>简述</td>
                        </tr>

                        @foreach($subproduct->modules as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td>
                                    {{ $module->description }}
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <span class="pull-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-module">
                            <i class="fa fa-wrench"></i> 设置模块
                        </button>
                    </span>

                    <div class="modal fade" id="add-module" tabindex="-1" role="dialog" aria-labelledby="add-module-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">设置基础模块</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-module-form" method="post" action="{{ route('subproduct.modules', ['id'=> $subproduct->id]) }}">

                                        @foreach($subproduct->product->modules as $module)

                                            {{--*/ $selected = false /*--}}
                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                            @if($subproduct->modules->contains($module->id))
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-module-form">设置</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bookmark"></i> 参数管理
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>参数名称</td>
                            <td>参数代码</td>
                            <td>参数值</td>
                            <td>简述</td>
                        </tr>

                        @foreach($subproduct->params as $param)
                            <tr>
                                <td>{{ $param->name }}</td>
                                <td><code>{{ $param->code }}</code></td>
                                <td>{{ $param->pivot->value }}</td>
                                <td>
                                    {{ $param->description }}
                                    <span class="pull-right">
                                        <i data-value="{{ $param->pivot->value }}" data-id="{{ $param->id }}" data-name="{{ $param->name }}" class="edit-param fa fa-edit fa-fw"></i>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <span class="pull-right btn btn-primary" data-toggle="modal" data-target="#add-param">
                        <i class="fa fa-plus"></i> 设置参数
                    </span>

                    <div class="modal fade" id="edit-param" tabindex="-1" role="dialog" aria-labelledby="edit-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">设置参数</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-param-form" method="post" action="{{ route('subproduct.param.edit', ['id'=> $subproduct->id]) }}">
                                        <div class="form-group">
                                            <input disabled="disabled" name="name" type="text" class="form-control" placeholder="名称 (人员数量上限)">
                                        </div>

                                        <div class="form-group">
                                            <input name="value" type="text" class="form-control">
                                        </div>

                                        <input type="hidden" name="param_id">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-param-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="add-param" tabindex="-1" role="dialog" aria-labelledby="add-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">设置参数</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-param-form" class="form-horizontal" method="post" action="{{ route('subproduct.params', ['id'=> $subproduct->id]) }}">
                                        @foreach($subproduct->product->params as $param)

                                            {{--*/ $selected = false /*--}}
                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                            @if($subproduct->params->contains($param->id))
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
                                    <button type="submit" class="btn btn-primary" form="add-param-form">设置</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-hdd-o"></i> 硬件管理
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>硬件名称</td>
                            <td>型号/规格</td>
                            <td>部署数量</td>
                        </tr>

                        @foreach($subproduct->hardwares as $hardware)
                            <tr>
                                <td>{{ $hardware->name }}</td>
                                <td>{{ $hardware->model }}</td>
                                <td>{{ $hardware->pivot->count }}</td>
                            </tr>
                        @endforeach
                    </table>

                    <span class="pull-right btn btn-primary" data-toggle="modal" data-target="#add-hardware">
                        <i class="fa fa-plus"></i> 设置硬件
                    </span>

                    <div class="modal fade" id="add-hardware" tabindex="-1" role="dialog" aria-labelledby="add-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">设置硬件</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-hardware-form" class="form-horizontal" method="post" action="{{ route('subproduct.hardwares', ['id'=> $subproduct->id]) }}">
                                        @foreach($subproduct->product->hardwares as $hardware)

                                            {{--*/ $selected = false /*--}}
                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                            {{--*/ $subproduct_hardware = $subproduct->hardwares->find($hardware->id)/*--}}

                                            @if($subproduct_hardware)
                                                {{--*/ $selected = true /*--}}
                                                {{--*/ $btn_class = 'btn-primary' /*--}}
                                            @endif

                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="col-lg-8">
                                                        <div data-id="{{ $hardware->id }}" class="hardware-btn btn {{ $btn_class }}">
                                                            {{ $hardware->name }}
                                                        </div>
                                                        @if($selected)
                                                            <input type="hidden" name="hardwares[]" value="{{ $hardware->id }}" />
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input name="counts[{{ $hardware->id }}]" value="{{ $subproduct_hardware->pivot->count or 0 }}" type="text" class="form-control" placeholder="部署数量">
                                                    </div>
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
                </div>
            </div>
        </div>
    </div>

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

                        var raw_dep_modules = new String($btn.data('dep-modules'));

                        if (raw_dep_modules.indexOf(',') != -1) {
                            var dep_modules_ids = raw_dep_modules.split(',');
                        }
                        else {
                            var dep_modules_ids = [raw_dep_modules];
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
@endsection