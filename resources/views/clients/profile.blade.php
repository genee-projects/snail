@extends('layout')

@section('content')
    <script type="text/javascript">
        requirejs(['holder'], function() {});
        require(['css!../css/timeline'], function() {});
    </script>
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">{{ $client->name }} </h1>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 基本信息</i>

                    {{--*/ $can_manage_client = \Session::get('user')->can('客户信息管理')/*--}}

                    @if ($can_manage_client)
                        <span class="pull-right">
                             <a href="#" data-toggle="modal" data-target="#edit-client">
                                 <i class="fa fa-fw fa-edit"></i>
                             </a>

                            <a href="{{ route('client.delete', ['id'=> $client->id]) }}">
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
                                        <form id="edit-client-form" class="form-horizontal" method="post" action="{{ route('client.edit') }}">
                                            <input type="hidden" name="id" value="{{ $client->id }}">
                                            @include('clients/form', ['client'=> $client])
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="edit-client-form">修改</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td class="col-md-2">客户名称</td>
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
                            <td>客户类型</td>
                            <td>{{ $client->type }}</td>
                        </tr>
                        <tr>
                            <td>客户区域</td>
                            <td>{{ $client->region }}</td>
                        </tr>
                        <tr>
                            <td>客户地址</td>
                            <td>{{ $client->address }}</td>
                        </tr>

                        <tr>
                            <td>备注信息</td>
                            <td>{{ $client->description }}</td>
                        </tr>


                        @foreach($client->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    {{ $item->value }}
                                    <span class="pull-right">
                                        <a href="{{ route('item.delete', ['id'=> $item->id]) }}"><i class="fa fa-times"></i></a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @if ($can_manage_client)
                            <tr>
                                <td colspan="2">
                                    <span class="pull-right">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-item"><i class="fa fa-plus"></i> 追加字段</button>
                                    </span>

                                    <div class="modal fade" id="add-item" tabindex="-1" role="dialog" aria-labelledby="add-item-modal-label">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="edit-server-modal-label">追加字段</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-item-form" method="post" action="{{ route('item.add') }}">
                                                        <input type="hidden" name="object_type" value="{{ get_class($client) }}"/>
                                                        <input type="hidden" name="object_id" value="{{ $client->id }}" />

                                                        <div class="form-group">
                                                            <input name="name" type="text" class="form-control" placeholder="名称(学校类型)">
                                                        </div>

                                                        <div class="form-group">
                                                            <input name="value" type="text" class="form-control" placeholder="显示值(211/985)">
                                                        </div>

                                                        <div class="form-group">
                                                            <input name="key" type="text" class="form-control" placeholder="代码(school) 可不填">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                    <button type="submit" class="btn btn-primary" form="add-item-form">添加</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>


        <div class="
        @if ($can_manage_client)
            col-md-4
        @else
                col-md-12
        @endif
        ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-twitter"> 层级结构</i>
                </div>

                <div class="panel-body">
                    <p><a href="{{ route('client.profile', ['id'=> $client->root()->id]) }}">{{ $client->root()->name }}</a></p>

                    @foreach($client->root()->children as $c)
                        <p class="col-md-offset-1">├ <a href="{{ route('client.profile', ['id'=> $c->id]) }}">{{ $c->name }}</a></p>
                            @foreach($c->children as $_c)
                                <p class="col-md-offset-2">├ <a href="{{ route('client.profile', ['id'=> $_c->id]) }}">{{ $_c->name }}</a></p>
                            @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        @if ($can_manage_client)
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-facebook"> 增加子级</i>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="{{ route('client.add') }}">
                        @include('clients/form_lite', ['client'=> new \App\Client, 'parent'=> $client])
                        <div class="form-group">
                            <label for="client-name" class="col-md-2 control-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary">添加</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list-alt"> 项目信息</i>
                </div>

                <div class="panel-body">
                    @if (\Session::get('user')->can('项目签约'))
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
                    @endif

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
                            <td>
                                @if ($project->signed_time)
                                    {{ (new DateTime($project->signed_time))->format('Y/m/d') }}
                                @endif
                            </td>
                            <td>
                                @if ($project->cancelled_time)
                                    {{ (new DateTime($project->cancelled_time))->format('Y/m/d') }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 其他信息</i>
                </div>
                <div class="panel-body">


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
                                <div class="panel-body">

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

                                    <form method="post" action="{{ route('comment.add') }}">

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
                                    {{--*/ $class = 'timeline-inverted';/*--}}
                                    @foreach($client->logs()->orderBy('time', 'desc')->get() as $log)
                                        {{--*/
                                        if ($class == 'timeline-inverted') $class = null;
                                        else $class = 'timeline-inverted';
                                        /*--}}
                                        <li class="{{ $class }}">
                                            <div class="timeline-badge {{ \App\Clog::$level_class[$log->level] }}
                                            "><i class="fa fa-flag"></i>
                                            </div>
                                            <div class="timeline-panel">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title">{{ $log->action }}</h4>
                                                    <p><small class="text-muted"><i class="fa fa-clock-o"></i> {{ $log->time->format('Y/m/d') }} via <strong>{{ $log->user->name }}</strong></small></p>
                                                </div>
                                                <div class="timeline-body">
                                                    @if (count($log->change))
                                                        @foreach($log->change as $c)
                                                            @if (isset($c['old']))
                                                                <p> {{ $c['title'] }}: <mark>「{{ $c['old'] }}」</mark>-&gt;<mark>「{{ $c['new'] }}」</mark></p>
                                                            @else
                                                                <p>{{ $c }}</p>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
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
