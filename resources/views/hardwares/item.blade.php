@extends('layout')

@section('content')

    {{--*/
    $hardware = $item->hardware;
    $project = $item->project;
    $extra = $item->extra;
    /*--}}

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">{{ $hardware->name }} ({{ $item->equipment_name }} {{ $item->equipment_id }})</h1>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 基本信息</i>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td class="col-md-2">所属硬件</td>
                            <td>
                                <a href="{{ route('hardware.profile', ['id'=> $hardware->id]) }}">
                                    {{ $hardware->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>所属项目</td>
                            <td>
                                <a href="{{ route('project.profile', ['id'=> $project->id]) }}">
                                    {{ $project->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>硬件型号/规格</td>
                            <td>{{ $hardware->model }}</td>
                        </tr>
                        <tr>
                            <td>生产状态</td>
                            <td>
                                @if ($hardware->self_produce)
                                    自产
                                @else
                                    外采
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>硬件备注</td>
                            <td>{{ $hardware->description }}</td>
                        </tr>

                        <tr>
                            <td>仪器名称 / CF-ID</td>
                            <td>
                                {{ $item->equipment_name }} / {{ $item->equipment_id }}

                                {{--*/
                                 $status_label_class = [
                                     \App\HardwareItem::STATUS_ON_THE_WAY => 'warning',
                                     \App\HardwareItem::STATUS_DELIVERED => 'default',
                                     \App\HardwareItem::STATUS_DEPLOYED => 'success',
                                     \App\HardwareItem::STATUS_WASTED => 'danger',
                                 ];
                                 /*--}}

                                <span class="label label-{{$status_label_class[$item->status]}}">
                                    {{ \App\HardwareItem::$status[$item->status] }}
                                </span>
                            </td>
                        </tr>


                        @foreach($hardware->fields as $field)
                            <tr>
                                <td>{{ $field->name }}</td>
                                <td>{{ $extra[$field->id] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
