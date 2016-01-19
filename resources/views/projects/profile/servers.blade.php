{{--*/ $can_manage_server = \Session::get('user')->can('项目服务器管理')/*--}}
<div class="panel-body">

    <table class="table table-hover table-striped">

        <tr>
            <td>服务器名称</td>
            <td>服务器 FQDN</td>
            <td>服务器 VPN </td>
            <td>服务器用途</td>
            <td>部署时间</td>
            <td>提供方</td>
        </tr>

        @foreach($project->servers as $server)

            <tr>
                <td><a href="{{ route('server.profile', ['id'=> $server->id]) }}">{{ $server->name }}</a></td>
                <td>{{ $server->fqdn }}</td>
                <td>{{ $server->vpn }}</td>
                <td>{{ $server->pivot->usage }}</td>
                <td>{{ $server->pivot->deploy_time or '未设置' }}</td>
                <td>
                    {{ App\Server::$providers[$server->provider] }}
                    <span class="pull-right">
                        <a class="btn btn-xs btn-primary" href="{{ route('project.server.disconnect', ['id'=> $project->id, 'server_id'=> $server->id]) }}">解除关联</a>
                    </span>
                </td>
            </tr>
        @endforeach

    </table>

    <hr />

    @if ($can_manage_server)

    <h3>关联服务器</h3>

    <form class="form-horizontal" method="post" action="{{ route('project.servers', ['id'=> $project->id]) }}">

        <div class="form-group">
            <label for="server_selector" class="col-sm-2 control-label">选择服务器</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" data-provide="typeahead" id="server_selector">
            </div>
        </div>

        <div class="form-group">
            <label for="server_deploy_time" class="col-sm-2 control-label">部署时间</label>
            <div class="col-sm-10">

                <div class="input-group date datetimepicker">
                    <input type="text" class="datetimepicker form-control" name="deploy_time" id="server_deploy_time">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="server_usage" class="col-sm-2 control-label">服务器用途</label>
            <div class="col-sm-10">
                <textarea name="usage" class="form-control" rows="3" id="server_usage"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> 追加服务器
                </button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        require(['jquery', 'bootstrap-datetimepicker', 'bootstrap3-typeahead'], function($) {

            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD'
            });

            require(['css!../css/bootstrap-datetimepicker.min'], function() {});

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
    </script>

    @endif
</div>