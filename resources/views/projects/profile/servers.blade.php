{{--*/ $can_manage_server = \Session::get('user')->can('项目服务器管理')/*--}}
<div class="panel-body">

    <table class="table table-hover table-striped">

        <tr>
            <td>服务器名称</td>
            <td>服务器 FQDN</td>
            <td>服务器 VPN </td>
            <td>部署时间</td>
            <td>提供方</td>
        </tr>

        @foreach($project->servers as $server)

            <tr>
                <td><a href="{{ route('server.profile', ['id'=> $server->id]) }}">{{ $server->name }}</a></td>
                <td>{{ $server->fqdn }}</td>
                <td>{{ $server->vpn }}</td>
                <td>
                    @if ($server->pivot->deploy_time)
                        {{ $server->pivot->deploy_time->format('Y/m/d') }}
                    @endif
                </td>
                <td>
                    {{ App\Server::$providers[$server->provider] }}

                    @if ($can_manage_server)
                    <span class="pull-right">
                        <i class="fa fa-fw fa-edit edit-server edit"
                            data-name="{{ $server->name }}"
                            data-fqdn="{{ $server->fqdn }}"
                            data-id="{{ $server->id }}"
                            @if ($server->pivot->deploy_time)
                                data-deploy-time="{{ $server->pivot->deploy_time->format('Y/m/d') }}"
                            @endif
                        ></i>

                        <a href="{{ route('project.server.disconnect', ['id'=> $project->id, 'server_id'=> $server->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>


    @if ($can_manage_server)

    <hr />

    <div class="modal fade" id="edit-server" tabindex="-1" role="dialog" aria-labelledby="edit-server-modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit-server-modal-label">修改服务器信息</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-project-server-form" class="form-horizontal" method="post" action="{{ route('project.server.edit', ['id'=> $project->id]) }}">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="datetimepicker form-control" name="deploy_time">
                            </div>
                        </div>

                        <input type="hidden" name="server_id" value="" >

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" form="edit-project-server-form">修改</button>
                </div>
            </div>
        </div>
    </div>

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

                <div class="date">
                    <input type="text" class="datetimepicker form-control" name="deploy_time" id="server_deploy_time">
                </div>
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
        require(['jquery', 'bootstrap-datetimepicker', 'bootstrap3-typeahead', 'moment/locale/zh-cn'], function($) {

            $('.datetimepicker').datetimepicker({
                format: 'YYYY/MM/DD',
                locale: 'zh-cn'
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

            $('.edit-server').bind('click', function() {
                var $modal = $('#edit-server');
                $modal.find(':input[name=name]').val($(this).data('name'));
                $modal.find(':input[name=deploy_time]').val($(this).data('deploy-time'));

                $modal.find(':input[name=server_id]').val($(this).data('id'));

                $modal.modal();
            });
        });
    </script>

    @endif
</div>