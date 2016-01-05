@extends('layout')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">人员列表</h1>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p>
                    <i class="fa fa-fw fa-facebook"></i> 人员列表
                    <span class="pull-right">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#add-user">添加人员</button>
                    </span>
                </p>

                <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="add-user-modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="add-user-modal-label">添加人员</h4>
                            </div>
                            <div class="modal-body">
                                <form id="add-user-form" class="form-horizontal" method="post" action="{{ route('user.add') }}">

                                    <div class="form-group">
                                        <label for="user-name" class="col-sm-2 control-label">名称</label>
                                        <div class="col-sm-10">
                                            <input name="name" type="text" class="form-control" id="user-name">
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="add-user-form">添加</button>
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
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <a href="{{ route('user.profile', ['id'=> $user->id]) }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
