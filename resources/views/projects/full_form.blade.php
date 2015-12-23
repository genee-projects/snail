<script type="text/javascript">
    require(['jquery', 'bootstrap-datetimepicker', 'bootstrap-select'], function($) {

        require(['css!../css/bootstrap-datetimepicker.min'], function() {});
        require(['css!../css/bootstrap-select.min'], function() {});

        $('.datetimepicker').datetimepicker({
            format: 'YYYY/MM/DD'
        });

        $('select').selectpicker();
    });
</script>

<div class="form-group">
    <label for="project-ref-no" class="col-sm-2 control-label">项目编号</label>
    <div class="col-sm-4">
        <input value="{{ $project->ref_no or '' }}" name="ref_no" type="text" class="form-control" id="project-ref-no" placeholder="LIMS201533">
    </div>

    <label for="project-name" class="col-sm-2 control-label">项目名称</label>
    <div class="col-sm-4">
        <input value="{{ $project->name or '' }}" name="name" type="text" class="form-control" id="project-name" placeholder="南开大学大型仪器管理系统">
    </div>
</div>

<div class="form-group">

    <label for="project-type" class="col-sm-2 control-label">产品类型</label>
    <div class="col-sm-4">
        <select class="selectpicker" name="product_id">
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>

    <label for="project-product-version" class="col-sm-2 control-label">项目版本</label>
    <div class="col-sm-4">
        <input value="{{ $project->version or '' }}" name="version" type="text" class="form-control" id="project-product-version" placeholder="南开大学大型仪器管理系统">
    </div>
</div>

<hr/>

<div class="form-group">


    <label for="project-contact" class="col-sm-2 control-label">联系人</label>
    <div class="col-sm-4">
        <input value="{{ $project->contact_user or '' }}" name="contact_user" type="text" class="form-control" id="project-contact" placeholder="胡宁">
    </div>
    <label for="project-contact" class="col-sm-2 control-label">联系人电话</label>
    <div class="col-sm-4">
        <input value="{{ $project->contact_phone or '' }}" name="contact_phone" type="text" class="form-control" id="project-contact" placeholder="13102123203">
    </div>

</div>

<div class="form-group">

    <label for="project-contact" class="col-sm-2 control-label">联系人邮箱</label>
    <div class="col-sm-10">
        <input value="{{ $project->contact_email or '' }}" name="contact_email" type="text" class="form-control" id="project-contact" placeholder="ning.hu@nankai.edu.cn">
    </div>

</div>


<div class="form-group">
    <label for="project-signed-time" class="col-sm-2 control-label">签约时间</label>
    <div class="col-sm-4">
        <div class="input-group date datetimepicker">
            <input type="text" class="form-control" name="signed_time" value="{{ $project->signed_time }}" placeholder="2015/12/01">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>

    <label for="project-divorced-time" class="col-sm-2 control-label">合同到期时间</label>
    <div class="col-sm-4">
        <div class="input-group date datetimepicker">
            <input type="text" class="form-control" name="cancelled_time" value="{{ $project->cancelled_time }}" placeholder="2017/12/01">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>
</div>


<div class="form-group">

    <label for="project-seller" class="col-sm-2 control-label">销售负责人</label>
    <div class="col-sm-4">
        <input value="{{ $project->seller or '' }}" name="seller" type="text" class="form-control" id="project-seller" placeholder="刘玉川">
    </div>

    <label for="project-seller" class="col-sm-2 control-label">工程师负责人</label>
    <div class="col-sm-4">
        <input value="{{ $project->engineer or '' }}" name="engineer" type="text" class="form-control" id="project-seller" placeholder="李彬">
    </div>
</div>

<hr/>


<div class="form-group">
    <label for="project-deploy-address" class="col-sm-2 control-label">部署地址</label>

    <div class="col-sm-10">
        <textarea id="project-deploy-address" class="col-sm-2 form-control" rows="2" name="deploy_address">{{ $project->deploy_address or ''}}</textarea>
    </div>
</div>

<div class="form-group">

    <label for="project-way" class="col-sm-2 control-label">乘车路线</label>

    <div class="col-sm-10">
        <textarea id="project-way" class="col-sm-2 form-control" rows="2" name="way">{{ $project->way or ''}}</textarea>
    </div>

</div>

<div class="form-group">
    <label for="project-description" class="col-sm-2 control-label">备注</label>
    <div class="col-sm-10">
        <textarea id="project-description" class="col-sm-2 form-control" rows="2" name="description">{{ $project->description or ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <strong>注意: </strong>
        <ul>
            <li>默认填充字段, <mark>不会</mark> 提交!</li>
        </ul>
    </div>
</div>