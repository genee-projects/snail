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
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation" class="active">
                            <a href="#normal-modules" aria-controls="normal-modules" role="tab" data-toggle="tab">
                                <i class="fa fa-comment-o"></i> 基础模块
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#extra-modules" aria-controls="extra-modules" role="tab" data-toggle="tab">
                                <i class="fa fa-linux"></i> 附加模块
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="normal-modules">
                            <div class="panel-body">

                                <table class="table table-hover table-striped">

                                    <tr>
                                        <td style="width: 10%;">名称</td>
                                        <td>简述</td>
                                    </tr>

                                    @foreach($subproduct->modules()->wherePivot('type', '=', 'normal')->get() as $module)
                                        <tr>
                                            <td>{{ $module->name }}</td>
                                            <td>
                                                {{ $module->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                     <span class="pull-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-normal-module">
                                            <i class="fa fa-wrench"></i> 设置模块
                                        </button>
                                    </span>

                                <div class="modal fade" id="add-normal-module" tabindex="-1" role="dialog" aria-labelledby="add-normal-module-modal-label">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="add-module-modal-label">设置基础模块</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add-normal-module-form" method="post" action="{{ route('subproduct.module', ['id'=> $subproduct->id]) }}">

                                                    @foreach($subproduct->product->modules as $module)

                                                        @if($subproduct->modules()->wherePivot('type', '=', 'extra')->get()->contains($module->id))
                                                            {{--*/ continue; /*--}}
                                                        @endif

                                                        {{--*/ $selected = false /*--}}
                                                        {{--*/ $btn_class = 'btn-default' /*--}}

                                                        @if($subproduct->modules()->wherePivot('type', '=', 'normal')->get()->contains($module->id))
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
                        </div>

                        <div role="tabpanel" class="tab-pane" id="extra-modules">
                            <div class="panel-body">

                                <table class="table table-hover">
                                    <tr>
                                        <td style="width: 10%;">名称</td>
                                        <td>简述</td>
                                    </tr>
                                    @foreach($subproduct->modules()->wherePivot('type', '=', 'extra')->get() as $module)
                                        <tr>
                                            <td>{{ $module->name }}</td>
                                            <td>
                                                {{ $module->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                <span class="pull-right">
                                     <button class="btn btn-primary" data-toggle="modal" data-target="#add-extra-module">
                                         <i class="fa fa-wrench"></i> 设置模块
                                     </button>
                                </span>

                                <div class="modal fade" id="add-extra-module" tabindex="-1" role="dialog" aria-labelledby="add-extra-module-modal-label">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="add-module-modal-label">设置扩展模块</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add-extra-module-form" method="post" action="{{ route('subproduct.module', ['id'=> $subproduct->id]) }}">

                                                    @foreach($subproduct->product->modules as $module)

                                                        @if($subproduct->modules()->wherePivot('type', '=', 'normal')->get()->contains($module->id))
                                                            {{--*/ continue; /*--}}
                                                        @endif

                                                        {{--*/ $selected = false /*--}}
                                                        {{--*/ $btn_class = 'btn-default' /*--}}

                                                        @if($subproduct->modules()->wherePivot('type', '=', 'extra')->get()->contains($module->id))
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