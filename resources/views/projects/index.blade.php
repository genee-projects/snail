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
                        <tr class="theader">
                            <td class="td2">项目编号</td>
                            <td class="td2">项目名称</td>
                            <td class="td2">签约客户</td>
                            <td class="td1">销售负责人</td>
                            <td class="text-right td1"><small>签约时间</small></td>
                            <td class="text-right td1"><small>计划验收时间</small></td>
                            <td class="text-right td1"><small>实际验收时间</small></td>
                            <td class="text-right td1"><small>维保结束时间</small></td>
                            <td class="text-nowrap td1"><small>硬件部署进度</small></td>
                        </tr>
                        @foreach($projects as $project)
                            <tr>
                                <td class="td2">{{ $project->ref_no }}</td>
                                <td class="td2">
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
                                <td class="td2">{!! $project->client->path() !!}</td>
                                <td class="td1">{{ $project->seller }}</td>
                                <td class="td1 text-right">
                                    @if ($project->signed_time && $project->signed_status == \App\Project::SIGNED_STATUS_OFFICIAL)
                                        {{ $project->signed_time->format('Y/m/d') }}
                                    @endif
                                </td>
                                <td class="td1 text-right">
                                    {{ $project->planned_check_time }}
                                </td>
                                <td class="td1 text-right">
                                    @if ($project->check_time)
                                        @if ($project->check_time->gt(\Carbon\Carbon::now()))
                                            <strong class="text-danger">
                                        @endif
                                        {{ $project->check_time->format('Y/m/d') }}

                                        @if ($project->check_time->gt(\Carbon\Carbon::now()))
                                            </strong>
                                        @endif
                                    @else
                                        未验收
                                    @endif
                                </td>
                                <td class="text-right td1">
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
                                <td class="text-right td1">
                                    {{--*/  $all = 0; $deployed = 0; /*--}}
                                    @foreach($project->hardwares as $hardware)
                                        {{--*/ $all += $hardware->pivot->count /*--}}
                                        {{--*/
                                        foreach(\App\HardwareItem::where('project_id', $project->id)
                                            ->where('hardware_id', $hardware->id)
                                            ->where('status', \App\HardwareItem::STATUS_DEPLOYED)
                                            ->get() as $item) {
                                            $deployed ++;
                                        }

                                        /*--}}
                                    @endforeach
                                    {{ $deployed }} / {{ $all }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <style type="text/css">

        .td2 {
            width: 182px;
        }
        .td1 {
            width: 91px;
        }

    </style>

    <script type="text/javascript">

        requirejs(['jquery'], function($) {

            var trigger = 180, $theader = $('.theader');

            var ori_theader_width = $theader.width();

            function theader() {

                var docScrollTop = $(document).scrollTop();

                if (docScrollTop >= trigger) {
                    $theader.css({
                        position: 'fixed',
                        top: '0px',
                        width: ori_theader_width,
                        'z-index': 10,
                        'background-color': '#ffe'
                    });
                } else {
                    $theader.css({
                        position: 'relative'
                    });
                }
            }
            $(window).scroll(function(){
                theader();
            });

            theader();
        });

    </script>

@endsection
