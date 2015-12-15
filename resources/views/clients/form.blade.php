<div class="form-group">
    <label for="client-name" class="col-sm-2 control-label">名称</label>
    <div class="col-sm-10">
        <input value="{{ $client->name or '' }}" name="name" type="text" class="form-control" id="client-name" placeholder="南开大学">
    </div>
</div>

<div class="form-group">
    <label for="client-address" class="col-sm-2 control-label">地址</label>
    <div class="col-sm-10">
        <input value="{{ $client->address or ''}}" name="address" type="text" class="form-control" id="client-address" placeholder="天津市南开区卫津路94号">
    </div>
</div>

<div class="form-group">
    <label for="client-url" class="col-sm-2 control-label">网站/链接</label>
    <div class="col-sm-10">
        <input value="{{ $client->url or '' }}" name="url" type="text" class="form-control" id="client-url" placeholder="http://www.nankai.edu.cn">
    </div>
</div>
<div class="form-group">
    <label for="client-progress" class="col-sm-2 control-label">销售进度</label>
    <div class="col-sm-10">
        <select name="progress" value="{{ $client->progress or 1 }}">
            @foreach($ps as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="client-description" class="col-sm-2 control-label">备注</label>
    <div class="col-sm-10">
        <textarea id="client-description" class="col-sm-2 form-control" rows="3" name="description">{{ $client->description or ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <strong>注意: </strong>
        默认填充字段, <mark>不会</mark> 提交!
    </div>
</div>

<input type="hidden" value="{{ $parent->id or 0 }}" name="parent_id">