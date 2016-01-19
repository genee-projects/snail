@extends('layout')

@section('content')
<div class="row">

    <link rel="stylesheet" href="assets/css/hardwares/index.css">

    <div class="col-lg-12">
        <h1 class="page-header">硬件列表</h1>
    </div>

    <div class="col-lg-12">
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
                            <td>{{ $hardware->name }}</td>
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

                                @if ($can_manage_hardware)
                                    <span class="pull-right">
                                        <i data-self-produce="{{ $hardware->self_produce }}" data-model="{{ $hardware->model }}" data-description="{{ $hardware->description }}" data-id="{{ $hardware->id }}" data-name="{{ $hardware->name }}" class="edit-hardware fa fa-edit fa-fw"></i>
                                        <a href="{{ route('hardware.delete', ['id'=> $hardware->id]) }}">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                @if ($can_manage_hardware)
                    <script type="text/javascript">
                        require(['jquery'], function($) {
                            $('.edit-hardware').bind('click', function() {

                                var $modal = $('#edit-hardware');
                                $modal.find(':input[name=name]').val($(this).data('name'));
                                $modal.find(':input[name=model]').val($(this).data('model'));
                                $modal.find(':input[name=description]').val($(this).data('description'));
                                $modal.find(':input[name=id]').val($(this).data('id'));

                                if($(this).data('self-produce') > 0) {
                                    $modal.find(':input[name=self_produce]').attr('checked', 'checked');
                                }

                                $modal.modal();

                            });
                        });
                    </script>

                    <div class="modal fade" id="edit-hardware" tabindex="-1" role="dialog" aria-labelledby="edit-param-modal-label">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="edit-server-modal-label">修改硬件</h4>
                            </div>
                            <div class="modal-body">
                                <form id="edit-hardware-form" method="post" action="{{ route('hardware.edit') }}">
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

                                    <input type="hidden" name="id">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="edit-hardware-form">修改</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
