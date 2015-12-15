@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $project->name }}</h1>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user"> 基本信息</i>
                <span class="pull-right">

                     <a href="#" data-toggle="modal" data-target="#edit-project">
                         <i class="fa fa-fw fa-edit"></i>
                     </a>


                    <a href="{{ route('project.delete', ['id'=> $project->id]) }}">
                        <i class="fa fa-fw fa-times"></i>
                    </a>
                    <div class="clearfix"></div>

                    <div class="modal fade" id="edit-project" tabindex="-1" role="dialog" aria-labelledby="edit-project-modal-label">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">修改客户信息</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-client-form" class="form-horizontal" method="post" action="/projects/edit">
                                        <input type="hidden" name="id" value="{{ $project->id }}">
                                        @include('projects/full_form', ['project'=> $project, 'products'=> $products])
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-client-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
            <div class="panel panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <td style="width: 20%;">客户名称</td>
                        <td colspan="2"><a href="{{ route('client.profile', ['id'=> $project->client->id]) }}">{{ $project->client->name }}</a></td>
                    </tr>
                    <tr>
                        <td>项目名称</td>
                        <td colspan="2">{{ $project->name }}</td>
                    </tr>
                    <tr>
                        <td>产品类型</td>
                        <td colspan="2"><a href="{{ route('products') }}">{{ $project->product->name }}</a></td>
                    </tr>
                    <tr>
                        <td>版本</td>
                        <td colspan="2">{{ $project->product_version }}</td>
                    </tr>
                    <tr>
                        <td>客户类型</td>
                        <td colspan="2">{{ $project->client_type }}</td>
                    </tr>
                    <tr>
                        <td>所在区域</td>
                        <td colspan="2">{{ $project->position }}</td>
                    </tr>
                    <tr>
                        <td>联系人</td>
                        <td colspan="2">{{ $project->contact }}</td>
                    </tr>
                    <tr>
                        <td>联系电话</td>
                        <td colspan="2">{{ $project->contact_phone }}</td>
                    </tr>
                    <tr>
                        <td>邮箱</td>
                        <td colspan="2">{{ $project->contact_email }}</td>
                    </tr>
                    <tr>
                        <td>销售</td>
                        <td colspan="2">{{ $project->seller }}</td>
                    </tr>
                    <tr>
                        <td>工程师负责人</td>
                        <td colspan="2">{{  $project->engineer }}</td>
                    </tr>
                    <tr>
                        <td>IP 地址(内网) web 访问</td>
                        <td colspan="2">http://172.18.194.2/lims</td>
                    </tr>
                    <tr>
                        <td>IP 地址(内网) 仪器连接</td>
                        <td colspan="2">172.18.194.2</td>
                    </tr>
                    <tr>
                        <td>IP 地址(外网) web 访问</td>
                        <td colspan="2">http://210.36.22.87/lims</td>
                    </tr>
                    <tr>
                        <td>IP 地址(外网) 前台访问</td>
                        <td colspan="2">http://gxpt.gxu.edu.cn/</td>
                    </tr>
                    <tr>
                        <td>部署地址</td>
                        <td colspan="2">{{ $project->address }}</td>
                    </tr>
                    <tr>
                        <td>乘车路线</td>
                        <td colspan="2">{{ $project->way }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-user"> 其他信息</i>
            </div>
            <div class="panel panel-body">


                <div id="myTabs">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation"  class="active">
                            <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">
                                <i class="fa fa-comment-o"></i> 备注信息
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#server" aria-controls="server" role="tab" data-toggle="tab">
                                <i class="fa fa-linux"></i> 服务器信息
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#software" aria-controls="software" role="tab" data-toggle="tab">
                                <i class="fa fa-bolt"></i> 软件信息
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#hardware" aria-controls="hardware" role="tab" data-toggle="tab">
                                <i class="fa fa-archive"></i> 硬件信息
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#info" aria-controls="info" role="tab" data-toggle="tab">
                                <i class="fa fa-info"></i> 信息变动
                            </a>
                        </li>

                        <li role="presentation">
                            <a href="#trello" aria-controls="trello" role="tab" data-toggle="tab">
                                <i class="fa fa-wrench"></i> 部署情况
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="comments">
                            <div class="panel panel-body">


                                @foreach($project->comments as $comment)
                                    <div class="media">
                                        <div class="media-left media-middle">
                                            <img data-src="holder.js/40x40">
                                        </div>

                                        <div class="media-body">
                                            {{ $comment->content }}
                                        </div>
                                    </div>
                                @endforeach

                                <hr />

                                <form method="post" action="/comments/add">

                                    <input type="hidden" name="object_type" value="{{ get_class($project) }}" />
                                    <input type="hidden" name="object_id" value="{{ $project->id }}" />

                                    <div class="form-group">
                                        <textarea class="form-control" name="content" rows="3" placeholder="内容"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fa fa-plus"></i> 备注追加
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="software">
                            <div class="panel panel-body">
                                软件信息, 等待完善
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="hardware">
                            <div class="panel panel-body">
                                硬件信息, 等待完善
                            </div>
                        </div>


                        <!-- server -->
                        <div role="tabpanel" class="tab-pane" id="server">
                            <div class="panel panel-body">

                                <table class="table table-hover table-bordered table-striped">

                                    <tr>
                                        <td>服务器名称</td>
                                        <td>服务器 FQDN</td>
                                        <td>服务器 VPN </td>
                                        <td>服务器用途</td>
                                        <td>提供方</td>
                                    </tr>

                                    @foreach($project->servers as $server)

                                        <tr>
                                            <td><a href="{{ route('server.profile', ['id'=> $server->id]) }}">{{ $server->name }}</a></td>
                                            <td>{{ $server->fqdn }}</td>
                                            <td>{{ $server->vpn }}</td>
                                            <td>{{ $server->pivot->usage }}</td>
                                            <td>
                                                @if ($server->customer_provide)
                                                    客户自备
                                                @else
                                                    公司提供
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </table>

                                <hr />

                                <h3>关联服务器</h3>

                                <form class="form-horizontal" method="post" action="{{ route('project.server', ['project_id'=> $project->id]) }}">

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">选择服务器</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" style="witdh: 100%;" type="text" data-provide="typeahead" id="server_selector">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">服务器用途</label>
                                        <div class="col-sm-10">
                                            <textarea name="usage" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-10 col-sm-offset-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-plus-circle"></i> 追加服务器
                                            </button>
                                        </div>
                                    </div>

                                    <script type="text/javascript">

                                        $.get('/servers.json', function(data){
                                            var $selector = $("#server_selector");
                                            $selector.typeahead({
                                                source:data,
                                                displayText: function(item) {
                                                    return item.name;
                                                },
                                                afterSelect: function(item) {
                                                    var $input = $('<input name="server_id" name="hehe" type="hidden">');
                                                    $input.val(item.id);
                                                    $selector.after($input);
                                                }
                                            });
                                        },'json');
                                    </script>

                                </form>
                            </div>
                        </div>
                        <!-- server end -->

                        <!-- info -->
                        <div role="tabpanel" class="tab-pane" id="info">
                            <ul class="timeline">
                                <li>
                                    <div class="timeline-badge info"><i class="fa fa-flag"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title">信息修改</h4>
                                            <p><small class="text-muted"><i class="fa fa-clock-o"></i> 11 hours ago via Rui Ma</small></p>
                                        </div>
                                        <div class="timeline-body">
                                            <p> 修改用户信息 <mark>「广东大学」</mark>-&gt;<mark>「广西大学」</mark></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="timeline-inverted">
                                    <div class="timeline-badge warning"><i class="fa fa-flag"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"> 信息修改</h4>
                                            <p><small class="text-muted"><i class="fa fa-check-o"></i> 12 hours age via Rui Ma</small></p>
                                        </div>
                                        <div class="timeline-body">
                                            <p>创建新客户</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- info end-->

                        <!-- trello -->
                        <div role="tabpanel" class="tab-pane" id="trello">
                            对接 Trello
                        </div>
                        <!-- trello end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection