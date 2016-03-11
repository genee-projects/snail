@extends('layout')

@section('content')
<div class="row">

    <link rel="stylesheet" href="assets/css/hardwares/index.css">

    <div class="col-md-12">
        <h1 class="page-header">硬件列表</h1>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <span>
                    <i class="fa fa-wrench"></i>
                </span>

                {{--*/ $can_manage_hardware = \Session::get('user')->can('硬件管理')/*--}}
                @if ($can_manage_hardware)
                <span class="pull-right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#add-hardware">
                        <i class="fa fa-plus"></i> 添加硬件
                    </button>
                </span>

                <div class="modal fade" id="add-hardware" tabindex="-1" role="dialog" aria-labelledby="add-hardware-modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="add-hardware-modal-label">添加硬件</h4>
                            </div>
                            <div class="modal-body">

                                <form id="add-hardware-form" method="post" action="{{ route('hardware.add') }}">

                                    <div class="form-group">
                                        <input name="name" type="text" class="form-control" placeholder="名称 (电源控制器v1.0)">
                                    </div>

                                    <div class="form-group">
                                        <input name="model" type="text" class="form-control" placeholder="型号/规格">
                                    </div>

                                    <div class="form-group">
                                        <textarea name="description" class="form-control" rows="3" placeholder="参数描述"></textarea>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="self_produce"> 自产硬件
                                        </label>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="add-hardware-form">添加</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="clearfix"></div>

            </div>

            <div class="panel-body">
                <table class="table table-hover table-striped">
                    <tr>
                        <td>硬件名称</td>
                        <td>型号/规格</td>
                        <td>生产状态</td>
                        <td>备注</td>
                    </tr>


                    @foreach($hardwares as $hardware)
                        <tr>
                            <td>
                                <a href="{{ route('hardware.profile', ['id'=> $hardware->id]) }}">
                                    {{ $hardware->name }}
                                </a>
                            </td>
                            <td>{{ $hardware->model }}</td>
                            <td>
                                @if ($hardware->self_produce)
                                    自产
                                @else
                                    外采
                                @endif
                            </td>
                            <td>
                                {{ $hardware->description }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
