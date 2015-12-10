@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">项目列表</h1>
        </div>
    </div>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading ">
                    <span>
                        <i class="fa fa-cubes"> </i>
                    </span>

                    <span class="pull-right">
                        项目添加, 请到 <a href="/clients"> 客户信息</a> 页面进行 <mark>『项目签约』</mark>
                    </span>
            </div>
            <div class="panel panel-body">

                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td>项目编号</td>
                        <td>项目名称</td>
                        <td>签约客户</td>
                        <td>项目联系人</td>
                        <td>签约时间</td>
                    </tr>
                    @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->ref_no }}</td>
                            <td><a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a></td>
                            <td><a href="{{ route('client.profile', ['id'=> $project->client->id]) }}">{{ $project->client->name }}</a></td>
                            <td>{{ $project->contact }}</td>
                            <td>{{ $project->time }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


@endsection