{{--*/ $can_manage_hardware = \Session::get('user')->can('项目硬件管理') /*--}}

<script type="text/javascript">
    require(['jquery', 'bootstrap-select'], function($) {
        require(['css!../css/bootstrap-select.min'], function() {});
        $('select').selectpicker();
    });
</script>
<div class="panel-body">
    <table class="table">
        <tr>
            <td>名称</td>
            <td>规格/型号</td>
            <td>生产类型</td>
            <td>计划部署数量</td>
            <td>备注</td>
        </tr>

        @foreach($project->hardwares as $hardware)
            <tr>
                <td>
                    <div class="pull-right  hardware-drawer">
                        <span class="caret"></span>
                    </div>
                    <a href="{{ route('hardware.profile', ['id'=> $hardware->id]) }}">
                        {{ $hardware->name }}
                    </a>
                </td>
                <td>{{ $hardware->model }}</td>
                <td>
                    @if ($hardware->self_produce)
                        自产
                    @else
                        外采
                    @endif
                </td>
                <td>
                    {{ $hardware->pivot->count }}
                </td>
                <td>
                    {{ $hardware->pivot->description }}
                    @if ($can_manage_hardware)
                        <span class="pull-right">
                            <i class="fa fa-fw fa-edit edit-hardware edit" data-model="{{ $hardware->model }}" data-description="{{ $hardware->pivot->description }}" data-id="{{ $hardware->id }}" data-name="{{ $hardware->name }}" data-count="{{ $hardware->pivot->count }}"></i>
                            <i class="fa fa-fw fa-plus add-hardware-item edit" data-id="{{ $hardware->id }}"></i>
                        </span>

                        <div class="modal fade" id="add-hardware-item{{$hardware->id}}" tabindex="-1" role="dialog" aria-labelledby="add-hardware-item-modal-label">
                            <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="add-hardware-item-modal-label">部署硬件明细</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add-hardware-item-form{{$hardware->id}}" class="form-horizontal" method="post" action="{{ route('hardware_item.add') }}">

                                            <div class="form-group">
                                                <label for="add-hardware-item-{{$hardware->id}}-project-name" class="col-md-2 control-label">项目名称</label>
                                                <div class="col-md-10">
                                                    <input type="text" id="add-hardware-item-{{$hardware->id}}-project-name" class="form-control" value="{{ $project->name }}" disabled="disabled">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="add-hardware-item-{{$hardware->id}}-hardware-name" class="col-md-2 control-label">硬件名称</label>
                                                <div class="col-md-10">
                                                    <input type="text" id="add-hardware-item-{{$hardware->id}}-hardware-name" class="form-control" value="{{ $hardware->name }}" disabled="disabled">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="add-hardware-{{$hardware->id}}-equipment-name" class="col-md-2 control-label">仪器名称</label>
                                                <div class="col-md-10">
                                                    <input type="text" id="add-hardware-{{$hardware->id}}-equipment-name" class="form-control" name="equipment_name">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="add-hardware-item-{{$hardware->id}}-equipment-id" class="col-md-2 control-label">CF-ID</label>
                                                <div class="col-md-10">
                                                    <input type="text" id="add-hardware-item-{{$hardware->id}}-equipment-id" class="form-control" name="equipment_id">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="add-hardware-item-{{$hardware->id}}-status" class="col-md-2 control-label">状态</label>
                                                <div class="col-md-10">
                                                    <select class="selectpicker" name="status">
                                                        @foreach(\App\HardwareItem::$status as $value=>$display)
                                                            <option value="{{ $value }}">{{ $display }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            @foreach($hardware->fields as $field)
                                                <div class="form-group">
                                                    <label for="edit-hardware-{{ $hardware->id }}-{{$field->name}}" class="col-md-2 control-label">{{ $field->name }}</label>
                                                    <div class="col-md-10">
                                                        <input id="edit-hardware-{{ $hardware->id }}-{{$field->name}}" type="text" class="form-control" name="fields[{{ $field->id }}]">
                                                    </div>
                                                </div>

                                            @endforeach

                                            <input type="hidden" name="hardware_id" value="{{ $hardware->id }}">
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="add-hardware-item-form{{$hardware->id}}">添加</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>

            <tr class="item-list hidden">
                <td colspan="5">

                    {{--*/
                    $items = \App\HardwareItem::where('project_id', $project->id)->where('hardware_id', $hardware->id);
                    $process = (int) (((float) $items->where('status', App\HardwareItem::STATUS_DEPLOYED)->count()) / $hardware->pivot->count * 100);
                    /*--}}
                    <div class="col-md-12">
                        <p>

                            <div class="progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="{{ $process }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $process }}%;">
                                    {{ $process }}%
                                </div>
                            </div>
                        </p>
                        <table class="table">
                            <tr>
                                <td>仪器名称</td>
                                <td class="text-right">CF-ID</td>
                                <td>状态</td>
                            </tr>

                            @foreach(\App\HardwareItem::where('project_id', $project->id)->where('hardware_id', $hardware->id)->get() as $i)
                                <tr>
                                    <td>{{ $i->equipment_name }}</td>
                                    <td class="text-right"><strong>{{ $i->equipment_id }}</strong></td>
                                    <td>
                                        {{--*/
                                        $status_label_class = [
                                            \App\HardwareItem::STATUS_ON_THE_WAY => 'warning',
                                            \App\HardwareItem::STATUS_DELIVERED => 'default',
                                            \App\HardwareItem::STATUS_DEPLOYED => 'success',
                                            \App\HardwareItem::STATUS_WASTED => 'danger',
                                        ];
                                        /*--}}

                                        <span class="label label-{{$status_label_class[$i->status]}}">
                                            {{ \App\HardwareItem::$status[$i->status] }}
                                        </span>

                                        <span class="pull-right edit edit-hardware-item" data-id="{{ $i->id }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </td>
            </tr>
        @endforeach

        @if ($can_manage_hardware)
        <tr>
            <td colspan="6">
                <span class="pull-right">
                    <button data-toggle="modal" data-target="#hardwares" type="button" class="btn btn-primary"><i class="fa fa-wrench"></i> 设置硬件</button>
                </span>
            </td>
        </tr>
        @endif
    </table>

    @if ($can_manage_hardware)
    <div class="modal fade" id="hardwares" tabindex="-1" role="dialog" aria-labelledby="hardwares-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="hardwares-modal-label">设置硬件</h4>
                </div>
                <div class="modal-body">
                    <form id="add-hardware-form" class="form-horizontal" method="post" action="{{ route('project.hardwares', ['id'=> $project->id]) }}">
                        @foreach(\App\Hardware::all() as $hardware)

                            {{--*/ $selected = false /*--}}
                            {{--*/ $btn_class = 'btn-default' /*--}}

                            {{--*/ $project_hardware = $project->hardwares->find($hardware->id)/*--}}

                            @if($project_hardware)
                                {{--*/ $selected = true /*--}}
                                {{--*/ $btn_class = 'btn-primary' /*--}}
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <div data-id="{{ $hardware->id }}" class="hardware-btn btn {{ $btn_class }}">
                                        {{ $hardware->name }}
                                        @if ($hardware->model)
                                            ({{$hardware->model}})
                                        @endif
                                    </div>
                                    @if($selected)
                                        <input type="hidden" name="hardwares[]" value="{{ $hardware->id }}" />
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control"
                                        @if ($project_hardware && $project_hardware->pivot->count)
                                            value="{{ $project_hardware->pivot->count }}"
                                        @endif
                                    placeholder="计划部署数量" name="count[{{ $hardware->id }}]">
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
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="model" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="count" placeholder="计划部署数量">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <textarea class="form-control" name="description" rows="3" placeholder="备注"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="hardware_id">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" form="edit-project-hardware-form">修改</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-hardware-item-modal" tabindex="-1" role="dialog" aria-labelledby="edit-hardware-item-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit-hardware-modal-label">修改部署硬件信息</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center loading">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" form="edit-hardware-item-form">修改</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        require(['jquery'], function($) {

            $('.edit-hardware').bind('click', function() {
                var $modal = $('#edit-hardware');
                $modal.find(':input[name=name]').val($(this).data('name'));

                if ($(this).data('model')) {
                    $modal.find(':input[name=model]').show().val($(this).data('model'));
                } else {
                    $modal.find(':input[name=model]').hide();
                }

                $modal.find(':input[name=count]').val($(this).data('count'));
                $modal.find(':input[name=description]').val($(this).data('description'));

                $modal.find(':input[name=hardware_id]').val($(this).data('id'));

                $modal.modal();
            });

            $('.add-hardware-item').bind('click', function() {

                var $modal = $('#add-hardware-item' + $(this).data('id'));

                $modal.modal();
            });

            $('.hardware-drawer').bind('click', function() {

                var $item_list = $(this).parents('tr').next('.item-list');

                if ($item_list.hasClass('hidden')) {
                    $item_list.removeClass('hidden');
                } else {
                    $item_list.addClass('hidden');
                }
            });

            $('.edit-hardware-item').bind('click', function() {

                var $modal = $('#edit-hardware-item-modal');

                var id = $(this).data('id');

                $modal.find('.loading').load("{{ route('hardware_item.form') }}", {
                    'id': id
                });

                $modal.modal();
            });
        });
    </script>

    @endif
</div>
