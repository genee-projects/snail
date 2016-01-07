@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $user->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <i class="fa fa-linux"></i> 基本信息
                    <span class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#edit-user">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>

                        <a href="{{ route('user.delete', ['id' => $user->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>
                    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-user-modal-label">修改人员</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-user-form" method="post" action="{{ route('user.edit') }}">

                                        <div class="form-group">
                                            <label for="user-name" class="control-label">名称</label>
                                            <input name="name" type="text" value="{{ $user->name }}" class="form-control" id="user-name">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-user-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td class="col-lg-1">名称</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>角色</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <p>
                                        <code>
                                            {{ $role->name }}
                                        </code>
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
