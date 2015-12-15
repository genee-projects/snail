@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $client->name }} </h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 基本信息</i>
                    <span class="pull-right">
                         <a href="#" data-toggle="modal" data-target="#edit-client">
                             <i class="fa fa-fw fa-edit"></i>
                         </a>

                        <a href="/clients/delete/{{ $client->id }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>

                    <div class="modal fade" id="edit-client" tabindex="-1" role="dialog" aria-labelledby="edit-server-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">修改客户信息</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-client-form" class="form-horizontal" method="post" action="/clients/edit">
                                        <input type="hidden" name="id" value="{{ $client->id }}">
                                        @include('clients/form', ['client'=> $client, 'products'=> $products])
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-client-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td style="width: 20%;">客户名称</td>
                            <td>{{ $client->name }}</td>
                        </tr>

                        <tr>
                            <td>网站/链接</td>
                            <td><a href="{{ $client->url }}">{{ $client->url }}</a></td>
                        </tr>

                        <tr>
                            <td>纷享销客链接</td>
                            <td><a href="{{ $client->seller_url }}">{{ $client->seller_url }}</a></td>
                        </tr>
                        <tr>
                            <td>客户地址</td>
                            <td>{{ $client->address }}</td>
                        </tr>

                        <tr>
                            <td>备注信息</td>
                            <td>{{ $client->description }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-twitter"> 层级结构</i>
                </div>

                <div class="panel panel-body">
                    <p><a href="/clients/profile/{{ $client->id }}">{{ $client->name }}</a></p>

                    @foreach($client->root()->children as $c)
                        <p class="col-sm-offset-1">├ <a href="/clients/profile/{{ $c->id }}">{{ $c->name }}</a></p>
                            @foreach($c->children as $_c)
                                <p class="col-sm-offset-2">├ <a href="/clients/profile/{{$_c->id}}">{{ $_c->name }}</a></p>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-facebook"> 增加子级</i>
                </div>

                <div class="panel panel-body">
                    <form class="form-horizontal" method="post" action="/clients/add">
                        @include('clients/form', ['client'=> new \App\Client, 'parent'=> $client])
                        <div class="form-group">
                            <label for="client-name" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">添加</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list-alt"> 项目信息</i>
                </div>

                <div class="panel panel-body">
                    <p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-project">
                            <i class="fa fa-plus"></i> 签约项目
                        </button>
                    </p>

                    <div class="modal fade" id="add-project" tabindex="-1" role="dialog" aria-labelledby="add-project-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-server-modal-label">签约项目</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-project-form" class="form-horizontal" method="post" action="/projects/add">
                                        @include('projects/form', ['client'=> $client])
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-project-form">签约</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-hover table-striped">

                        <tr>
                            <td>项目名称</td>
                            <td>产品类型</td>
                            <td>签约时间</td>
                            <td>合约到期时间</td>
                        </tr>

                        @foreach($client->projects as $project)
                        <tr>
                            <td><a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a></td>
                            <td>{{ $project->product->name }}</td>
                            <td>{{ date('Y/m/d', strtotime($project->signed_time)) }}</td>
                            <td>{{ date('Y/m/d', strtotime($project->divorced_time)) }}</td>
                        </tr>
                        @endforeach
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
                            <li role="presentation" class="active">
                                <a href="#comment" aria-controls="info" role="tab" data-toggle="tab">
                                    <i class="fa fa-comment"></i> 备注信息
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#info" aria-controls="info" role="tab" data-toggle="tab">
                                    <i class="fa fa-info"></i> 信息变动
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- comment -->
                            <div role="tabpanel" class="tab-pane active" id="comment">
                                <div class="panel panel-body">

                                    @foreach($client->comments as $comment)
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

                                        <input type="hidden" name="object_type" value="{{ get_class($client) }}" />
                                        <input type="hidden" name="object_id" value="{{ $client->id }}" />

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
                            <!-- comment-end -->


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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
