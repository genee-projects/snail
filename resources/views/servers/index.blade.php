@extends('layout')


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">服务器列表</h1>
        </div>
    </div>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading ">
                <p class="vertical-middle">
                    <span>
                        <i class="fa fa-linux"> </i>
                    </span>

                    <span class="pull-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-server">
                            <i class="fa fa-plus"></i>
                            添加服务器
                        </button>
                    </span>

                    <div class="modal fade" id="add-server" tabindex="-1" role="dialog" aria-labelledby="add-server-modal-label">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-server-modal-label">添加服务器</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-server-form" class="form-horizontal" method="post" action="/servers/add">
                                        @include('servers/form')
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-server-form">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
            <div class="panel panel-body">

                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-hover table-striped table-bordered">

                            <tr>
                                <td>名称</td>
                                <td>FQDN</td>
                                <td>VPN</td>
                                <td>提供方</td>
                            </tr>

                            @foreach($servers as $server)
                            <tr>
                                <td>
                                    <a href="/servers/profile/{{ $server->id }}">
                                        {{ $server->name }}
                                    </a>
                                </td>
                                <td>
                                    <span>
                                        <code id="fqdn_clip_{{ $server->id }}">{{ $server->fqdn }}</code>
                                    </span>
                                    <span>
                                        <button class="btn btn-xs btn-clip" data-clipboard-action="copy" data-clipboard-target="#fqdn_clip_{{ $server->id }}">
                                        <i class="fa fa-fw fa-clipboard"></i>
                                    </button>
                                    </span>
                                </td>
                                <td>
                                    <span id="vpn_clip_{{ $server->id }}">
                                        {{ $server->vpn }}
                                    </span>

                                    <span>
                                        <button class="btn btn-xs btn-clip" data-clipboard-action="copy" data-clipboard-target="#vpn_clip_{{ $server->id }}">
                                            <i class="fa fa-fw fa-clipboard"></i>
                                        </button>
                                    </span>
                                </td>
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
                    </div>
                </div>

                <hr />

                <h2>基础服务</h2>
                <hr/>
                <div class="row">
                    <div class="col-sm-6">
                        <form method="post" action="{{ route('item.add') }}">
                            <table class="table table-hover table-striped table-bordered">

                                <tr>
                                    <td>名称</td>
                                    <td>代码</td>
                                </tr>

                                @foreach($root->services as $service)
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>
                                            <code>{{ $service->code }}</code>
                                        <span class="pull-right">
                                            <a href="{{ route('service.delete', ['id'=> $service->id]) }}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <a class="add-item" _id="{{ $service->id }}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </span>
                                        </td>
                                    </tr>

                                    @foreach($service->items as $item)
                                        <tr>
                                            <td colspan="2">
                                            <span class="pull-right">
                                                <code>{{ $item->key }}</code> / <code>{{ $item->value or NULL'}}</code>
                                                <a href="{{ route('item.delete', ['id'=> $item->id]) }}"><i class="fa fa-times"></i></a>
                                            </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <input type="hidden" name="object_type" value="{{ get_class($service)}}">
                                @endforeach
                            </table>
                        </form>
                    </div>

                    <div class="col-sm-6">
                        <form method="post" action="{{ route('service.add') }}">
                            <input type="hidden" name="object_type" value="{{ get_class($root) }}" />
                            <input type="hidden" name="object_id" value="{{ $root->id }}" />
                            @include('services/form')
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> 添加</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-item').bind('click', function() {
                var service_id = $(this).attr('_id');

                var $tr = $(this).parents('tr');

                $tr.after($('<input type="hidden" name="object_id" value="' +  service_id +  '"/>'));
                $tr.after($('<tr><td colspan="2"><span class="pull-right"><input type="text" name="key" placeholder="key"> <input type="text" name="value" placeholder="value"> <button type="submit" class="btn btn-primary btn-xs">添加</button></span></td></tr>'));
            });
        });
    </script>

@endsection