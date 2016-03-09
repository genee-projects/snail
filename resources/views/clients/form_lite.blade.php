<div class="form-group">
    <label for="client-name" class="col-md-2 control-label">名称</label>
    <div class="col-md-10">
        <input value="{{ $client->name or '' }}" name="name" type="text" class="form-control" id="client-name" placeholder="电信学院">
    </div>
</div>

<div class="form-group">
    <label for="client-address" class="col-md-2 control-label">地址</label>
    <div class="col-md-10">
        <input value="{{ $client->address or ''}}" name="address" type="text" class="form-control" id="client-address" placeholder="南校区 11 号楼">
    </div>
</div>

<div class="form-group">
    <label for="client-url" class="col-md-2 control-label">网站/链接</label>
    <div class="col-md-10">
        <input value="{{ $client->url or '' }}" name="url" type="text" class="form-control" id="client-url" placeholder="http://sky.nankai.edu.cn">
    </div>
</div>

<div class="form-group">
    <label form="client-seller-url" class="col-md-2 control-label">纷享销客链接</label>
    <div class="col-md-10">
        <input value="{{ $client->seller_url or '' }}" name="seller_url" type="text" class="form-control" id="client-seller-url" placeholder="http://www.fxiaoke.com/XV/Home/Index#customers/home">
    </div>
</div>

<div class="form-group">
    <label for="client-description" class="col-md-2 control-label">备注</label>
    <div class="col-md-10">
        <textarea id="client-description" class="col-md-2 form-control" rows="3" name="description">{{ $client->description or ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <strong>注意: </strong>
        默认填充字段, <mark>不会</mark> 提交!
    </div>
</div>

<input type="hidden" value="{{ $parent->id or 0 }}" name="parent_id">
