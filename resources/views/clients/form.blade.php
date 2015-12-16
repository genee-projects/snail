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
    <label form="client-seller-url" class="col-sm-2 control-label">纷享销客链接</label>
    <div class="col-sm-10">
        <input value="{{ $client->seller_url or '' }}" name="seller_url" type="text" class="form-control" id="client-seller-url" placeholder="http://www.fxiaoke.com/XV/Home/Index#customers/home">
    </div>
</div>

<div class="form-group">
    <label form="client-type" class="col-sm-2 control-label">客户类型</label>
    <div class="col-sm-10">
        <input value="{{ $client->type or '' }}" name="type" type="text" class="form-control" id="client-type" placeholder="高校">
    </div>
</div>

<div class="form-group">
    <label form="client-region" class="col-sm-2 control-label">客户区域</label>
    <div class="col-sm-10">
        <input value="{{ $client->region or '' }}" name="region" type="text" class="form-control" id="client-region" placeholder="西南">
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