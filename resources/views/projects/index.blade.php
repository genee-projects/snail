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

                    <table id="projects" class="table table-hover table-striped table-bordered">
			<thead>
                        <tr class="theader">
                            <th class="col-md-2" id="hahaha"><small>项目编号</small></th>
                            <th class="col-md-2"><small>项目名称</small></th>
                            <th class="col-md-2"><small>签约客户</small></th>
                            <th class="col-md-1"><small>销售负责人</small></th>
                            <th class="text-right col-md-1"><small>签约时间</small></th>
                            <th class="text-right col-md-1"><small>计划验收时间</small></th>
                            <th class="text-right col-md-1"><small>实际验收时间</small></th>
                            <th class="text-right col-md-1"><small>维保结束时间</small></th>
                            <th class="text-nowrap col-md-1"><small>硬件部署进度</small></th>
                        </tr>
			</thead>
                        @foreach($projects as $project)
                            <tr>
                                <td class="col-md-2">{{ $project->ref_no }}</td>
                                <td class="col-md-2">
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
                                <td class="col-md-2">{!! $project->client->path() !!}</td>
                                <td class="col-md-1">{{ $project->seller }}</td>
                                <td class="col-md-1 text-right">
                                    @if ($project->signed_time && $project->signed_status == \App\Project::SIGNED_STATUS_OFFICIAL)
                                        {{ $project->signed_time->format('Y/m/d') }}
                                    @endif
                                </td>
                                <td class="col-md-1 text-right">
                                    {{ $project->planned_check_time }}
                                </td>
                                <td class="col-md-1 text-right">
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
                                <td class="text-right col-md-1">
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
                                <td class="text-right col-md-1">
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
            width: 16.66%;
        }
        .td1 {
            width: 8.33%;
        }

    </style>

    <script type="text/javascript">

        requirejs(['jquery'], function($) {
            var trigger = 190, $theader = $('thead');
            var width = $('#projects').width();
            var nav = '<nav id="projects-nav">' +
                    '<table class="table table-hover table-striped table-bordered">' +
                    $theader.html()+ "</table></nav>";


	        function theader() {
                var docScrollTop = $(document).scrollTop();
                if (docScrollTop >= trigger) {
                    if ($('#projects-nav').length < 1) {
                        $('#projects').append(nav);
                        $('#projects-nav').find('table').css({
                            width: width,
                            position: 'fixed',
                            top: '0px'
                        });
                    }
                } else {
                    $('#projects-nav').remove();
                }
            }

            $(window).scroll(function(){
                theader();
            });

            theader();
        });

    </script>

@endsection
