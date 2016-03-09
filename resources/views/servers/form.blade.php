<div class="form-group">
    <label for="server-name" class="col-md-1 control-label">名称</label>
    <div class="col-md-5">
        <input value="{{ $server->name or '' }}" name="name" type="text" class="form-control" id="server-name" placeholder="南开大学校级 LIMS-CF 服务器">
    </div>
    <label for="server-customer-provide" class="col-md-1 control-label">提供方</label>
    <div class="col-md-5">

        <select class="selectpicker" name="provider">
            @foreach(\App\Server::$providers as $value => $name)
                <option @if (isset($server) && ($value == $server->provider))
                        selected="selected"
                        @endif
                        value="{{ $value }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label for="server-barcode" class="col-md-1 control-label">条形码</label>
    <div class="col-md-5">
        <input value="{{ $server->barcode or ''}}" name="barcode" type="text" class="form-control" id="server-barcode" placeholder="5382058398">
    </div>
    <label for="server-sn" class="col-md-1 control-label">序列号</label>
    <div class="col-md-5">
        <input value="{{ $server->sn or '' }}" name="sn" type="text" class="form-control" id="server-sn" placeholder="28563-324-44">
    </div>
</div>

<div class="form-group">
    <label for="server-model" class="col-md-1 control-label">型号</label>
    <div class="col-md-5">
        <input value="{{ $server->model or '' }}" name="model" type="text" class="form-control" id="server-model" placeholder="Dell T1000">
    </div>
    <label for="server-cpu" class="col-md-1 control-label">CPU</label>
    <div class="col-md-5">
        <div class="input-group">
            <input value="{{ $server->cpu or '' }}" name="cpu" type="text" class="form-control" id="server-cpu" placeholder="8">
            <span class="input-group-addon">核</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="server-memory" class="col-md-1 control-label">内存</label>
    <div class="col-md-5">
        <div class="input-group">
            <input value="{{ $server->memory or '' }}" name="memory" type="text" class="form-control" id="server-memory" placeholder="16">
            <span class="input-group-addon">GB</span>
        </div>
    </div>

    <label for="server-disk" class="col-md-1 control-label">硬盘</label>
    <div class="col-md-5">
        <div class="input-group">
            <input value="{{ $server->disk or '' }}" name="disk" type="text" class="form-control" id="server-disk" placeholder="1024">
            <span class="input-group-addon">GB</span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="server-os" class="col-md-1 control-label">OS</label>
    <div class="col-md-5">
        <input value="{{ $server->os or '' }}" name="os" type="text" class="form-control" id="server-os" placeholder="Ubuntu 14.04.3 LTS">
    </div>

    <label for="server-fqdn" class="col-md-1 control-label">FQDN</label>
    <div class="col-md-5">
        <input value="{{ $server->fqdn or '' }}" name="fqdn" type="text" class="form-control" id="server-fqdn" placeholder="e143502.server.genee.cn">
    </div>
</div>


<div class="form-group">
    <label for="inner-ip" class="col-md-1 control-label">内网IP</label>
    <div class="col-md-5">
        <input value="{{ $server->inner_ip or '' }}" name="inner_ip" type="text" class="form-control" id="inner-ip" placeholder="10.0.0.1">
    </div>

    <label for="outer-ip" class="col-md-1 control-label">外网IP</label>
    <div class="col-md-5">
        <input value="{{ $server->outer_ip or '' }}" name="outer_ip" type="text" class="form-control" id="outer-ip" placeholder="133.130.55.133">
    </div>
</div>

<div class="form-group">

    <label for="server-vpn" class="col-md-1 control-label">VPN</label>
    <div class="col-md-11">
        <input value="{{ $server->vpn or '' }}" name="vpn" type="text" class="form-control" id="server-vpn" placeholder="10.0.10.1">
    </div>
</div>



<div class="form-group">
    <label for="server-description" class="col-md-1 control-label">备注</label>
    <div class="col-md-11">
        <textarea id="server-description" class="col-md-2 form-control" rows="3" name="description">{{ $server->description or ''}}</textarea>
    </div>
</div>

<div class="form-group">
    <div class="col-md-1"></div>
    <div class="col-md-11">
        <strong>注意: </strong>
        默认填充字段, <mark>不会</mark> 提交!
    </div>
</div>

<script type="text/javascript">
    require(['jquery', 'bootstrap-select'], function($) {
        require(['css!../css/bootstrap-select.min'], function() {});

        $('select').selectpicker();
    });
</script>
