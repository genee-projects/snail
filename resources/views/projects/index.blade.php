@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">项目列表</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading ">
                        <span>
                            <i class="fa fa-cubes"> </i>
                        </span>

                        <span class="pull-right">
                            项目添加, 请到 <a href="{{ route('clients') }}"> 客户信息</a> 页面进行 <mark>『项目签约』</mark>
                        </span>
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <td>项目编号</td>
                            <td>项目名称</td>
                            <td>签约客户</td>
                            <td>项目联系人</td>
                            <td>到期时间</td>
                        </tr>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project->ref_no }}</td>
                                <td>
                                    <a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a>
                                    @if ($project->vip)
                                        <span class="label label-danger">重点项目</span>
                                    @endif

                                    @if (! $project->official)
                                        <span class="label label-default">试用</span>
                                    @endif
                                </td>
                                <td>{!! $project->client->path() !!}</td>
                                <td>{{ $project->contact_user }}</td>
                                <td>@if ($project->cancelled_time)
                                        {{ (new DateTime($project->cancelled_time))->format('Y/m/d') }}
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
