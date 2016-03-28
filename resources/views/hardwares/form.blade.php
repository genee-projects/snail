{{--*/
$hardware = $item->hardware;
$project = $item->project;
$extra = $item->extra;
/*--}}

<script type="text/javascript">
    require(['jquery', 'bootstrap-select', 'bootstrap-datetimepicker', 'moment/locale/zh-cn'], function($) {
        require(['css!../css/bootstrap-select.min'], function() {});
        require(['css!../css/bootstrap-datetimepicker.min'], function() {});

        $('select').selectpicker();

        $('.datetimepicker').datetimepicker({
            format: 'YYYY/MM/DD',
            locale: 'zh-cn'
        });

    });
</script>
<form id="edit-hardware-item-form" class="form-horizontal" method="post" action="{{ route('hardware_item.edit') }}">

    <div class="form-group">
        <label for="edit-hardware-item-{{$hardware->id}}-project-name" class="col-md-2 control-label">项目名称</label>
        <div class="col-md-10">
            <input type="text" id="edit-hardware-item-{{$hardware->id}}-project-name" class="form-control" value="{{ $project->name }}" disabled="disabled">
        </div>
    </div>

    <div class="form-group">
        <label for="edit-hardware-item-{{$hardware->id}}-hardware-name" class="col-md-2 control-label">硬件名称</label>
        <div class="col-md-10">
            <input type="text" id="edit-hardware-item-{{$hardware->id}}-hardware-name" class="form-control" value="{{ $hardware->name }}" disabled="disabled">
        </div>
    </div>

    <div class="form-group">
        <label for="edit-hardware-item-{{$hardware->id}}-ref-no" class="col-md-2 control-label">硬件序号</label>
        <div class="col-md-10">
            <input name="ref_no" value="{{ $item->ref_no }}" type="text" id="edit-hardware-item-{{$hardware->id}}-ref-no" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="edit-hardware-item-{{ $hardware->id }}-time" class="col-md-2 control-label">操作时间</label>
        <div class="col-md-10">
            <input value="{{ $item->time }}" type="text" id="edit-hardware-item-{{$hardware->id}}-time" class="datetimepicker form-control" name="time">
        </div>
    </div>

    <div class="form-group">
        <label for="edit-hardware-item-{{$hardware->id}}-status" class="col-md-2 control-label">状态</label>
        <div class="col-md-10 text-left">
            <select class="selectpicker" name="status">
                @foreach(\App\HardwareItem::$status as $value=>$display)
                    <option value="{{ $value }}"
                    @if ($item->status == $value)
                        selected="selected"
                    @endif
                    >{{ $display }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @foreach($hardware->fields as $field)
        <div class="form-group">
            <label for="edit-hardware-{{ $hardware->id }}-{{$field->name}}" class="col-md-2 control-label">{{ $field->name }}</label>
            <div class="col-md-10">
                <input value="{{ $extra[$field->id] or ''}}" id="edit-hardware-{{ $hardware->id }}-{{$field->name}}" type="text" class="form-control" name="fields[{{ $field->id }}]">
            </div>
        </div>
    @endforeach

    <input type="hidden" name="hardware_id" value="{{ $hardware->id }}">
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <input type="hidden" name="id" value="{{ $item->id }}">

</form>