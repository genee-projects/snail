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
                            {{--*/ $product_modules = $project->product->modules; $p/*--}}
                            {{ $module->name }}

                            @if ($product_modules->contains($module->id))
                                <span class="label label-success">
                                    默认模块
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach

                {{--*/ $can_manage_module = \Session::get('user')->can('项目模块管理')/*--}}

                @if ($can_manage_module)
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
                @endif
            </table>
        </div>

    </div>
    <hr />


    {{--*/ $can_manage_param = \Session::get('user')->can('项目参数管理')/*--}}
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
                            @if ($can_manage_param)
                                <span class="pull-right">
                                    <i class="fa fa-fw fa-edit edit-param edit" data-id="{{ $param->id }}" data-name="{{ $param->name }}" data-value="{{ $param->pivot->value }}"></i>
                                </span>

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
                            @endif
                        </td>
                    </tr>
                @endforeach

                @if ($can_manage_param)
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
                @endif
            </table>
        </div>

    </div>
</div>