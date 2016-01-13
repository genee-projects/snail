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
