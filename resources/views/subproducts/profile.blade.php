@extends('layout')

@section('content')

    <link rel="stylesheet" href="assets/css/subproducts/profile.css">

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

                    @if (\Session::get('user')->can('产品类别管理'))
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
                    @endif
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

                    @if (\Session::get('user')->can('产品模块管理'))
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

                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="sync_new_modules"> 同步新加模块到已有项目
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="add-module-form">设置</button>
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
                    @endif
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

                        {{--*/ $can_manage_param = \Session::get('user')->can('产品参数管理')/*--}}

                        {{--*/
                        $normal_params = [];
                        $spec_params = [];

                        foreach($subproduct->params as $param) {
                            if ($param->pivot->manual) {
                                $spec_params[] = $param;
                            } else {
                                $normal_params[] = $param;
                            }
                        }

                        /*--}}

                        @if (count($spec_params))
                            <tr class="warning">
                                <td colspan="4">
                                    <h5>特殊参数</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>参数名称</td>
                                <td>参数代码</td>
                                <td>参数值</td>
                                <td>简述</td>
                            </tr>

                            @foreach($spec_params as $param)
                                <tr>
                                    <td>{{ $param->name }}</td>
                                    <td><code>{{ $param->code }}</code></td>
                                    <td>{{ $param->pivot->value }}</td>
                                    <td>
                                        {{ $param->description }}

                                        @if ($can_manage_param)
                                            <span class="pull-right">
                                                <i data-value="{{ $param->pivot->value }}" data-id="{{ $param->id }}" data-name="{{ $param->name }}" class="edit edit-param fa fa-edit fa-fw"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        @if (count($normal_params))
                            <tr class="info show-params">
                                <td colspan="4">
                                    <h5>统一参数(点击显示)</h5>
                                </td>
                            </tr>
                            <tr class="hidden normal-param">
                                <td>参数名称</td>
                                <td>参数代码</td>
                                <td>参数值</td>
                                <td>简述</td>
                            </tr>

                            @foreach($normal_params as $param)
                                <tr class="active hidden normal-param">
                                    <td>{{ $param->name }}</td>
                                    <td><code>{{ $param->code }}</code></td>
                                    <td>{{ $param->pivot->value }}</td>
                                    <td>
                                        {{ $param->description }}

                                        @if ($can_manage_param)
                                            <span class="pull-right">
                                                <i data-value="{{ $param->pivot->value }}" data-id="{{ $param->id }}" data-name="{{ $param->name }}" class="edit edit-param fa fa-edit fa-fw"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </table>


                    @if ($can_manage_param)
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

                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="reset"> 恢复默认参数 (勾选该参数后, 上述修改无效)
                                                </label>
                                            </div>
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

                    <script type="text/javascript">

                        require(['jquery'], function($) {
                            $('.edit-param').bind('click', function() {
                                var $modal = $('#edit-param');
                                $modal.find(':input[name=name]').val($(this).data('name'));
                                $modal.find(':input[name=value]').val($(this).data('value'));
                                $modal.find(':input[name=param_id]').val($(this).data('id'));

                                $modal.modal();
                            });

                            $('.show-params').bind('click', function() {
                                $(this).parents('table').find('.normal-param').removeClass('hidden');
                            });
                        });
                    </script>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection