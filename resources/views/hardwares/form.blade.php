{{--*/
$hardware = $item->hardware;
$project = $item->project;
$extra = $item->extra;
/*--}}

<script type="text/javascript">
    require(['jquery', 'bootstrap-select'], function($) {
        require(['css!../css/bootstrap-select.min'], function() {});
        $('select').selectpicker();
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
        <label for="edit-hardware-{{$hardware->id}}-equipment-name" class="col-md-2 control-label">仪器名称</label>
        <div class="col-md-10">
            <input value="{{ $item->equipment_name }}" type="text" id="edit-hardware-{{$hardware->id}}-equipment-name" class="form-control" name="equipment_name">
        </div>
    </div>

    <div class="form-group">
        <label for="edit-hardware-item-{{$hardware->id}}-equipment-id" class="col-md-2 control-label">CF-ID</label>
        <div class="col-md-10">
            <input value="{{ $item->equipment_id }}" type="text" id="edit-hardware-item-{{$hardware->id}}-equipment-id" class="form-control" name="equipment_id">
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
                <input value="{{ $extra[$field->id] }}" id="edit-hardware-{{ $hardware->id }}-{{$field->name}}" type="text" class="form-control" name="fields[{{ $field->id }}]">
            </div>
        </div>
    @endforeach

    <input type="hidden" name="hardware_id" value="{{ $hardware->id }}">
    <input type="hidden" name="project_id" value="{{ $project->id }}">
    <input type="hidden" name="id" value="{{ $item->id }}">

</form>