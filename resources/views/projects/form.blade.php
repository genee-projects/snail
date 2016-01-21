<script type="text/javascript">
    require(['jquery', 'bootstrap-datetimepicker', 'bootstrap-select', 'locale/zh-cn'], function($) {
        require(['css!../css/bootstrap-datetimepicker.min'], function() {});
        require(['css!../css/bootstrap-select.min'], function() {});

        $('.datetimepicker').datetimepicker({
            format: 'YYYY/MM/DD',
            locale: 'zh-cn'
        });

        $('select').selectpicker();

    });

    require(['jquery', 'bootstrap-toggle'], function($) {
        require(['css!../css/bootstrap-toggle.min'], function() {});
    })
</script>
<div class="form-group">
    <label for="project-ref-no" class="col-sm-2 control-label">项目编号</label>
    <div class="col-sm-10">
        <input value="{{ $project->ref_no or '' }}" name="ref_no" type="text" class="form-control" id="project-ref-no" placeholder="LIMS201533">
    </div>
</div>

<div class="form-group">
    <label for="project-name" class="col-sm-2 control-label">项目名称</label>
    <div class="col-sm-10">
        <input value="{{ $project->name or '' }}" name="name" type="text" class="form-control" id="project-name" placeholder="南开大学大型仪器管理系统">
    </div>
</div>

<div class="form-group">
    <label for="project-type" class="col-sm-2 control-label">产品类型</label>
    <div class="col-sm-10">
        <select class="selectpicker" name="product_id">
            @foreach(\App\Product::all() as $product)
                <optgroup label="{{ $product->name }}">
                    @foreach($product->sub_products as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="project-vip" class="col-sm-2 control-label">项目状态</label>
    <div class="col-sm-4">
        <input type="checkbox" data-width="140" data-onstyle="danger" name="vip" data-toggle="toggle" data-on="重点项目" data-off="普通项目">
    </div>
    <label for="project-official" class="col-sm-2 control-label">签约状态</label>
    <div class="col-sm-4">
        <input type="checkbox" data-width="140" name="official" checked="checked" data-on="正式项目" data-off="试用项目" data-toggle="toggle">
    </div>
</div>

<div class="form-group">
    <label for="project-time" class="col-sm-2 control-label">签约时间</label>
    <div class="col-sm-10">
        <div class="input-group date datetimepicker">
            <input type="text" class="datetimepicker form-control" name="signed_time">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="project-time" class="col-sm-2 control-label">合同到期时间</label>
    <div class="col-sm-10">
        <div class="input-group date datetimepicker">
            <input type="text" class="datetimepicker form-control" name="cancelled_time">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project-contact" class="col-sm-2 control-label">联系人</label>
    <div class="col-sm-10">
        <input value="{{ $project->contact_user or '' }}" name="contact_user" type="text" class="form-control" id="project-contact" placeholder="胡宁">
    </div>
</div>

<div class="form-group">
    <label for="project-seller" class="col-sm-2 control-label">销售</label>
    <div class="col-sm-10">
        <input value="{{ $project->seller or '' }}" name="seller" type="text" class="form-control" id="project-seller" placeholder="刘玉川">
    </div>
</div>


<div class="form-group">
    <label for="project-description" class="col-sm-2 control-label">备注</label>
    <div class="col-sm-10">
        <textarea id="project-description" class="col-sm-2 form-control" rows="3" name="description">{{ $project->description or ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <strong>注意: </strong>
        <ul>
            <li>默认填充字段, <mark>不会</mark> 提交!</li>
            <li>详细信息请去项目详细信息页面填充</li>
        </ul>
    </div>
</div>

<input type="hidden" name="client_id" value="{{ $client->id }}">

