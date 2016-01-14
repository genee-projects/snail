@extends('layout')

@section('content')


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">人员列表</h1>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-fw fa-user"></i>
                    <span class="pull-right">
                        <a href="{{ route('user.refresh') }}" class="btn btn-primary">
                            <i class="fa fa-refresh"></i>
                            同步人员
                        </a>
                    </span>
                    <div class="clearfix"></div>
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
