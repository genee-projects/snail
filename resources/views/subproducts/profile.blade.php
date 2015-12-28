@extends('layout')

@section('content')

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
                                    <button type="submit" class="btn btn-primary" form="edit-product-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <table class="table table-hover table-striped">
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
                            <td style="width: 10%;">名称</td>
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
                                    <form id="add-module-form" method="post" action="{{ route('subproduct.module.edit', ['id'=> $subproduct->id]) }}">

                                        @foreach($subproduct->product->modules as $module)

                                            {{--*/ $selected = false /*--}}
                                            {{--*/ $btn_class = 'btn-default' /*--}}

                                            @if($subproduct->modules->contains($module->id))
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
                                        <i _value="{{ $param->pivot->value }}" _id="{{ $param->id }}" _name="{{ $param->name }}" class="edit-param fa fa-edit fa-fw" style="color: #337ab7; text-decoration:none;"></i>
                                        <a href="{{ route('subproduct.param.delete', ['id'=> $subproduct->id, 'param_id'=> $param->id]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <span class="pull-right btn btn-primary" data-toggle="modal" data-target="#add-param">
                        <i class="fa fa-plus"></i> 追加参数
                    </span>

                    <div class="modal fade" id="edit-param" tabindex="-1" role="dialog" aria-labelledby="edit-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">修改参数</h4>
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
                                    <h4 class="modal-title" id="add-module-modal-label">追加参数</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-param-form" class="form-horizontal" method="post" action="{{ route('subproduct.param.add') }}">
                                        <div class="form-group">
                                            <label for="param_selector" class="col-sm-2 control-label">选择参数</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" data-provide="typeahead" id="param_selector">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="param_usage" class="col-sm-2 control-label">参数值</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="text" name="value" >
                                            </div>
                                        </div>

                                        <input type="hidden" name="sub_product_id" value="{{ $subproduct->id }}">

                                        <script type="text/javascript">

                                            require(['jquery', 'bootstrap3-typeahead'], function($) {

                                                $('.edit-param').bind('click', function() {
                                                    var $modal = $('#edit-param');
                                                    $modal.find(':input[name=name]').val($(this).attr('_name'));
                                                    $modal.find(':input[name=description]').val($(this).attr('_description'));
                                                    $modal.find(':input[name=value]').val($(this).attr('_value'));
                                                    $modal.find(':input[name=param_id]').val($(this).attr('_id'));
                                                    $modal.find(':input[name=code]').val($(this).attr('_code'));

                                                    $modal.modal();
                                                });


                                                $.get('{{ route('product.params.json', ['id'=>$subproduct->product->id]) }}', function(data){
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
                                            });
                                        </script>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-param-form">追加</button>
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
@endsection