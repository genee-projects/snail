@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">项目列表</h1>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">

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
                            <td>销售负责人</td>
                            <td class="text-right">维保结束时间</td>
                        </tr>
                        @foreach($projects as $project)
                            <tr>
                                <td>{{ $project->ref_no }}</td>
                                <td>
                                    <a href="{{ route('project.profile', ['id'=> $project->id]) }}">{{ $project->name }}</a>
                                    @if ($project->vip)
                                        <span class="label label-danger">重点项目</span>
                                    @endif

                                    {{--*/
                                       $signed_status_label_class = [
                                           \App\Project::SIGNED_STATUS_PENDING => 'warning',
                                           \App\Project::SIGNED_STATUS_PROBATIONARY => 'default',
                                       ];
                                    /*--}}

                                    @if ($project->signed_status != \App\Project::SIGNED_STATUS_OFFICIAL)
                                        <span class="label label-{{$signed_status_label_class[$project->signed_status]}}">
                                        {{ \App\Project::$signed_status[$project->signed_status] }}
                                    </span>
                                    @endif

                                </td>
                                <td>{!! $project->client->path() !!}</td>
                                <td>{{ $project->seller }}</td>
                                <td class="text-right">
                                    @if ($project->check_time)
                                        {{--*/
                                        $now = \Carbon\Carbon::now();
                                        /*--}}

                                        @if ($now->gt($project->service_end_time))
                                            <strong class="text-danger">
                                        @endif

                                        {{ $project->service_end_time->format('Y/m/d') }}

                                        @if ($now->gt($project->service_end_time))
                                            <label>已过维保!</label></strong>
                                        @endif
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
