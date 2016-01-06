@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">角色列表</h1>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p>
                    <i class="fa fa-fw fa-facebook"></i> 角色列表
                    <span class="pull-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-role">添加角色</button>
                    </span>
                </p>

                <div class="modal fade" id="add-role" tabindex="-1" role="dialog" aria-labelledby="add-role-modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="add-role-modal-label">添加角色</h4>
                            </div>
                            <div class="modal-body">
                                <form id="add-role-form" class="form-horizontal" method="post" action="{{ route('role.add') }}">

                                    <div class="form-group">
                                        <label for="role-name" class="col-sm-2 control-label">名称</label>
                                        <div class="col-sm-10">
                                            <input name="name" type="text" class="form-control" id="role-name">
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="add-role-form">添加</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-hover">

                    <tr>
                        <td>名称</td>
                    </tr>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <a href="{{ route('role.profile', ['id'=> $role->id]) }}">
                                    {{ $role->name }}
                                </a>
                                @if ($role->system)
                                    <span class="badge">默认角色</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
