@extends('layout')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">客户列表</h1>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p class="vertical-middle">
                    <i class="fa fa-users"> </i>

                    @if (\Session::get('user')->can('客户信息管理'))
                        <span class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-client">
                                <i class="fa fa-plus"></i>
                                添加客户
                            </button>
                        </span>

                        <div class="modal fade" id="add-client" tabindex="-1" role="dialog" aria-labelledby="add-client-modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="add-client-modal-label">添加客户</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="add-client-form" class="form-horizontal" method="post" action="/clients/add">
                                            @include('clients/form')
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="add-client-form">添加</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </p>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <td>客户名称</td>
                        <td>网站/链接</td>
                        <td>纷享销客链接</td>
                        <td>类型</td>
                        <td>区域</td>
                        <td>地址</td>
                    </tr>

                    @foreach($clients as $client)
                        <tr>
                            <td>
                                <a href="{{ route('client.profile', ['id'=> $client->id]) }}">
                                    {{ $client->name }}
                                </a>
                            </td>
                            <td>
                                <a target="_blank" href="{{ $client->url }}">
                                    {{ $client->url}}
                                </a>
                            </td>
                            <td>
                                <a target="_blank" href="{{ $client->seller_url }}">
                                    {{ $client->seller_url }}
                                </a>
                            </td>
                            <td>{{ $client->type }}</td>
                            <td>{{ $client->region }}</td>
                            <td>{{ $client->address}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
