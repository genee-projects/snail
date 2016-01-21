@extends('layout')

@section('content')
    <link rel="stylesheet" href="assets/css/products/profile.css">
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

                    @if (\Session::get('user')->can('产品信息管理'))
                        <span class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#edit-product">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            <a href="{{ route('product.delete', ['id' => $product->id]) }}">
                                <i class="fa fa-fw fa-times"></i>
                            </a>
                        </span>
                        <div class="modal fade" id="edit-product" tabindex="-1" role="dialog" aria-labelledby="edit-product-modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="edit-product-modal-label">修改产品</h4>
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
                    @endif
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped">
                        <tr>
                            <td class="col-lg-3">名称</td>
                            <td>{{ $product->name }}</td>
                        </tr>
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
                        <i class="fa fa-star"></i> 类别管理

                        @if (\Session::get('user')->can('产品类别管理'))
                            <span class="pull-right">

                                <button class="btn btn-primary" data-toggle="modal" data-target="#add-sub-product">
                                    <i class="fa fa-plus-circle"></i> 添加类别
                                </button>
                            </span>

                            <div class="modal fade" id="add-sub-product" tabindex="-1" role="dialog" aria-labelledby="add-sub-product-modal-label">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="add-module-modal-label">添加类别</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add-sub-product-form" method="post" action="{{ route('subproduct.add') }}">
                                                @include('subproducts/form')
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                            <button type="submit" class="btn btn-primary" form="add-sub-product-form">添加</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </p>
                </div>

                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td>类别名称</td>
                            <td>类别描述</td>
                        </tr>

                        {{--*/ $can_manage_subproduct = \Session::get('user')->can('产品类别管理') /*--}}
                        @foreach($product->sub_products as $p)
                            <tr>
                                <td><a href="{{ route('subproduct.profile', ['id'=> $p->id]) }}">{{ $p->name }}</a></td>
                                <td>
                                    {{ $p->description }}

                                    @if ($can_manage_subproduct)
                                    <span class="pull-right">

                                        <i data-description="{{ $p->description }}" data-id="{{ $p->id }}" data-name="{{ $p->name }}" class="edit edit-subproduct fa fa-edit"></i>

                                        <a href="{{ route('subproduct.delete', ['id'=> $p->id]) }}">
                                            <i class="fa fa-delete"></i>
                                        </a>
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if ($can_manage_subproduct)
                        <div class="modal fade" id="edit-subproduct-modal" tabindex="-1" role="dialog" aria-labelledby="add-module-modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="add-module-modal-label">修改类别</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-subproduct-form" method="post" action="{{ route('subproduct.edit') }}">
                                            <div class="form-group">
                                                <label for="subproduct-name">名称</label>
                                                <input id="subproduct-name" name="name" type="text" class="form-control" placeholder="cf-lite">
                                            </div>

                                            <div class="form-group">
                                                <label for="sub-description">简述</label>
                                                <input id="sub-description" name="description" type="text" class="form-control" placeholder="简述">
                                            </div>
                                            <input type="hidden" name="id" value="{{ $product->id }}">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="edit-subproduct-form">修改</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            require(['jquery'], function($) {

                                $('.edit-subproduct').bind('click', function() {
                                    $modal = $('#edit-subproduct-modal');

                                    $modal.find(':input[name=name]').val($(this).data('name'));
                                    $modal.find(':input[name=description]').val($(this).data('description'));

                                    $modal.find(':input[name=id]').val($(this).data('id'));
                                    $modal.modal();
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
                    <p>
                        <i class="fa fa-wrench"></i> 模块管理

                        @if (\Session::get('user')->can('产品模块管理'))
                            <span class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-module">
                                <i class="fa fa-wrench"></i> 添加模块
                            </button>

                            <div class="modal fade" id="add-module" tabindex="-1" role="dialog" aria-labelledby="add-module-modal-label">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="add-module-modal-label">添加模块</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="add-module-form" method="post" action="{{ route('module.add') }}">
                                                <div class="form-group">
                                                    <label for="name">名称</label>
                                                    <input id="name" name="name" type="text" class="form-control" placeholder="成员目录">
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">简述</label>
                                                    <input id="description" name="description" type="text" class="form-control" placeholder="简述">
                                                </div>

                                                <div class="form-group">
                                                    <label for="deps">模块依赖</label>

                                                    <div>
                                                        @foreach($product->modules as $module)
                                                            <span data-id="{{ $module->id }}" class="module-btn btn btn-default text-center">
                                                        {{ $module->name }}
                                                    </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                            <button type="submit" class="btn btn-primary" form="add-module-form">添加</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </span>
                        @endif

                    </p>
                </div>

                <div class="panel-body">
                    <table class="table table-hover table-striped">
                        <tr>
                            <td class="col-lg-3">名称</td>
                            <td>依赖模块</td>
                            <td>简述</td>
                        </tr>

                        {{--*/ $can_manage_module = \Session::get('user')->can('产品模块管理')/*--}}

                        @foreach($product->modules as $module)
                            <tr>
                                <td>{{ $module->name }}</td>
                                <td>
                                    @foreach($module->dep_modules as $m)
                                        <code>{{ $m->name }}</code>
                                    @endforeach
                                </td>
                                <td>
                                    {{ $module->description }}

                                    @if ($can_manage_module)
                                        <span class="pull-right">

                                            <i data-dep-modules="{{ join(',', $module->dep_modules_ids()) }}" data-description="{{ $module->description }}" data-id="{{ $module->id }}" data-name="{{ $module->name }}" class="edit edit-module fa fa-edit fa-fw"></i>
                                            <a href="{{ route('module.delete', ['id'=> $module->id]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if ($can_manage_module)
                        <script type="text/javascript">
                            require(['jquery'], function($) {

                                $('.edit-module').bind('click', function() {
                                    var $modal = $('#edit-module');
                                    $modal.find(':input[name=name]').val($(this).data('name'));
                                    $modal.find(':input[name=description]').val($(this).data('description'));
                                    $modal.find(':input[name=module_id]').val($(this).data('id'));

                                    id = $(this).data('id');

                                    // 隐藏自己
                                    $modal.find('span').show();
                                    $modal.find('span[data-id='+ id +']').hide();

                                    //遍历自己依赖的所有的模块

                                    if ($(this).data('dep-modules')) {

                                        var raw_dep_modules = new String($(this).data('dep-modules'));

                                        if (raw_dep_modules.indexOf(',') != -1) {
                                            dep_modules = raw_dep_modules.split(',');
                                        }
                                        else {
                                            dep_modules = [raw_dep_modules];
                                        }

                                        $modules = $('[data-id=' + dep_modules.join('],[data-id=') + ']');

                                        $modules.each(function() {

                                            if ($(this).data('id') == id) $(this).hide();

                                            //对依赖的模块进行勾选
                                            $(this).removeClass('btn-default').addClass('btn-primary');

                                            $input = $('<input type="hidden" name="modules[]" value="" />');
                                            $input.val($(this).data('id'));

                                            //对依赖的模块后面加 input
                                            $(this).after($input);
                                        });
                                    }

                                    $modal.modal();
                                });
                            });
                        </script>

                        <div class="modal fade" id="edit-module" tabindex="-1" role="dialog" aria-labelledby="edit-module-modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="edit-product-modal-label">修改模块</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-module-form" method="post" action="{{ route('module.edit') }}">

                                            <div class="form-group">
                                                <input name="name" type="text" placeholder="名称" class="form-control" />
                                            </div>

                                            <div class="form-group">
                                                <input name="description" type="text" placeholder="简述" class="form-control">
                                            </div>


                                            <div class="form-group">
                                                <div>
                                                    <label>
                                                        选择依赖模块
                                                    </label>
                                                </div>
                                                <div>
                                                    @foreach($product->modules as $m)
                                                        <span data-id="{{ $m->id }}" class="module-btn btn btn-default text-center">
                                                        {{ $m->name }}
                                                    </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input type="hidden" name="module_id">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="edit-module-form">修改</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">

                            require(['jquery'], function($) {
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

                                        if ($btn.data('dep-modules')) {

                                            var dep_modules = $btn.data('dep-modules');

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
                <div class="panel-heading ">
                    <p>
                        <span>
                            <i class="fa fa-wrench"></i> 参数信息
                        </span>

                        {{--*/ $can_manage_param = \Session::get('user')->can('产品参数管理')/*--}}

                        @if ($can_manage_param)
                            <span class="pull-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#add-param">
                                    <i class="fa fa-plus"></i> 添加参数
                                </button>

                                <div class="modal fade" id="add-param" tabindex="-1" role="dialog" aria-labelledby="add-param-modal-label">
                                    <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                  <h4 class="modal-title" id="add-module-modal-label">添加参数</h4>
                                              </div>
                                              <div class="modal-body">

                                                  <form id="add-param-form" method="post" action="{{ route('param.add') }}">

                                                      <div class="form-group">
                                                          <input name="name" type="text" class="form-control" placeholder="名称 (人员数量上限)">
                                                      </div>

                                                      <div class="form-group">
                                                          <input name="code" type="text" class="form-control" placeholder="参数代码 (max_users_count)">
                                                      </div>

                                                      <div class="form-group">
                                                          <input name="value" type="text" class="form-control" placeholder="参数值 (5000)">
                                                      </div>

                                                      <div class="form-group">
                                                          <textarea name="description" class="form-control" rows="3" placeholder="参数描述"></textarea>
                                                      </div>

                                                      <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                  </form>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                  <button type="submit" class="btn btn-primary" form="add-param-form">添加</button>
                                              </div>
                                          </div>
                                      </div>
                                </div>
                            </span>
                        @endif
                    </p>
                </div>

                <div class="panel-body">
                    <table class="table table-condensed table-hover table-striped">
                        <tr>
                            <td>参数名称</td>
                            <td>参数代码</td>
                            <td>参数值</td>
                            <td>简述</td>
                        </tr>

                        @foreach($product->params as $param)
                            <tr>
                                <td>{{ $param->name }}</td>
                                <td><code>{{ $param->code }}</code></td>
                                <td>
                                    <p>
                                        <span>
                                            {{ $param->value }}
                                        </span>
                                    </p>
                                </td>
                                <td>
                                    {{ $param->description }}

                                    @if ($can_manage_param)
                                        <span class="pull-right">
                                            <i data-value="{{ $param->value }}" data-code="{{ $param->code }}" data-description="{{ $param->description }}" data-id="{{ $param->id }}" data-name="{{ $param->name }}" class="edit edit-param fa fa-edit fa-fw"></i>
                                            <a href="{{ route('param.delete', ['id'=> $param->id]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    @if ($can_manage_param)
                        <div class="modal fade" id="edit-param" tabindex="-1" role="dialog" aria-labelledby="edit-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">修改参数</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-param-form" method="post" action="{{ route('param.edit') }}">
                                        <div class="form-group">
                                            <input name="name" type="text" class="form-control" placeholder="名称 (人员数量上限)">
                                        </div>

                                        <div class="form-group">
                                            <input name="code" type="text" class="form-control" placeholder="参数代码 (max_users_count)">
                                        </div>

                                        <div class="form-group">
                                            <input name="value" type="text" class="form-control" placeholder="默认值 (5000)">
                                        </div>
                                        <div class="form-group">
                                            <textarea name="description" class="form-control" rows="3" placeholder="参数描述"></textarea>
                                        </div>
                                        <input type="hidden" name="id">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-param-form">修改</button>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            require(['jquery'], function($) {

                                $('.edit-param').bind('click', function() {
                                    var $modal = $('#edit-param');
                                    $modal.find(':input[name=name]').val($(this).data('name'));
                                    $modal.find(':input[name=description]').val($(this).data('description'));
                                    $modal.find(':input[name=value]').val($(this).data('value'));
                                    $modal.find(':input[name=id]').val($(this).data('id'));
                                    $modal.find(':input[name=code]').val($(this).data('code'));

                                    $modal.modal();
                                });
                            });
                        </script>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
