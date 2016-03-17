@extends('layout')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">{{ $hardware->name }}</h1>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user"> 基本信息</i>

                    {{--*/ $can_manage_hardware = \Session::get('user')->can('硬件管理')/*--}}
                    @if ($can_manage_hardware)
                        <span class="pull-right">
                            <i data-self-produce="{{ $hardware->self_produce }}" data-model="{{ $hardware->model }}" data-description="{{ $hardware->description }}" data-id="{{ $hardware->id }}" data-name="{{ $hardware->name }}" class="edit edit-hardware fa fa-edit fa-fw"></i>

                            <form class="delete display-inline" method="POST" action="{{ route('hardware.delete', ['id'=> $hardware->id]) }}">
                                {{ method_field('DELETE') }}
                                <button type="submit" class="edit">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </form>
                        </span>

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
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <td class="col-md-2">硬件名称</td>
                            <td>
                                {{ $hardware->name }}
                            </td>
                        </tr>
                        <tr>
                            <td>型号/规格</td>
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
                            <td>备注</td>
                            <td>{{ $hardware->description }}</td>
                        </tr>

                        @foreach($hardware->items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    {{ $item->value }}
                                    <span class="pull-right">
                                        <form class="delete display-inline" method="POST" action="{{ route('item.delete', ['id'=> $item->id]) }}">
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="edit">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="2">
                            <span class="pull-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#add-item"><i class="fa fa-plus"></i> 追加字段</button>
                            </span>

                                <div class="modal fade" id="add-item" tabindex="-1" role="dialog" aria-labelledby="add-item-modal-label">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="edit-server-modal-label">追加字段</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form id="add-item-form" method="post" action="{{ route('item.add') }}">
                                                    <input type="hidden" name="object_type" value="{{ get_class($hardware) }}"/>
                                                    <input type="hidden" name="object_id" value="{{ $hardware->id }}" />

                                                    <div class="form-group">
                                                        <input name="name" type="text" class="form-control" placeholder="名称(易燃易爆性)">
                                                    </div>

                                                    <div class="form-group">
                                                        <input name="value" type="text" class="form-control" placeholder="显示值(遇空气可燃)">
                                                    </div>

                                                    <div class="form-group">
                                                        <input name="key" type="text" class="form-control" placeholder="代码(attributes) 可不填">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                <button type="submit" class="btn btn-primary" form="add-item-form">添加</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-user"> 部署表单信息</i>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-6">

                    <table class="table table-hover">
                        <tr>
                            <td>名称</td>
                        </tr>
                        <tr>
                            <td>硬件序列号</td>
                        </tr>
                        <tr>
                            <td>操作时间</td>
                        </tr>
                        <tr>
                            <td>状态</td>
                        </tr>
                        @foreach($hardware->fields as $field)
                            <tr>
                                <td>
                                    {{ $field->name }}
                                    <span class="pull-right">

                                        <span class="edit edit-hardware-field" data-id="{{ $field->id }}" data-name="{{ $field->name }}">
                                            <i class="fa fa-fw fa-edit"></i>
                                        </span>

                                         <form class="delete display-inline" method="POST" action="{{ route('hardware_field.delete', ['id'=> $field->id]) }}">
                                             {{ method_field('DELETE') }}
                                             <button type="submit" class="edit">
                                                 <i class="fa fa-fw fa-times"></i>
                                             </button>
                                         </form>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="col-md-6">

                    <form method="post" action="{{ route('hardware_field.add') }}">

                        <input type="hidden" name="hardware_id" value="{{ $hardware->id }}">
                        <div class="form-group">
                            <input name="name" type="text" placeholder="表单名称" class="form-control" />
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-fw fa-plus"></i> 添加
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-user"> 已部署硬件</i>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-12">

                    <table class="table table-hover">
                        <tr>
                            <td>项目名称</td>
                            @foreach($hardware->fields as $field)
                                <td>{{ $field->name }}</td>
                            @endforeach
                            <td>操作时间</td>
                            <td>状态</td>
                        </tr>
                        @foreach($hardware->hardware_items()->orderBy('project_id')->get() as $i)
                            <tr>
                                <td>
                                    <a href="{{ route('project.profile', ['id'=> $i->project->id]) }}">
                                        {{ $i->project->name }}
                                    </a>
                                </td>
                                {{--*/ $extra = $i->extra;/*--}}
                                @foreach($hardware->fields as $field)
                                    <td>{{ $extra[$field->id] or '' }}</td>
                                @endforeach
                                <td>{{ $i->time->format('Y/m/d') }}</td>
                                <td>
                                    {{--*/
                                    $status_label_class = [
                                        \App\HardwareItem::STATUS_ON_THE_WAY => 'warning',
                                        \App\HardwareItem::STATUS_DELIVERED => 'info',
                                        \App\HardwareItem::STATUS_DEPLOYED => 'success',
                                        \App\HardwareItem::STATUS_WASTED => 'danger',
                                    ];
                                    /*--}}

                                    @foreach(\App\HardwareItem::$status as $value => $display)

                                        @if ($i->status == $value)
                                            {{--*/ $label_class = $status_label_class[$i->status];/*--}}
                                        @else
                                            {{--*/ $label_class = 'default';/*--}}
                                        @endif

                                        <span class="label label-{{$label_class}}">
                                            {{ $display }}
                                        </span>

                                        @if (end(\App\HardwareItem::$status) != $display)
                                            &#160;
                                            --
                                            &#160;
                                        @endif

                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-hardware-field" tabindex="-1" role="dialog" aria-labelledby="edit-hardware-field-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit-hardware-field-modal-label">修改部署表单信息</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-hardware-field-form" class="form-horizontal" method="post" action="{{ route('hardware_field.edit') }}">
                        <input type="hidden" name="id">


                        <div class="form-group">
                            <label for="hardware-item-name" class="col-md-2 control-label">名称</label>
                            <div class="col-md-10">
                                <input name="name" type="text" class="form-control" id="hardware-item-name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" form="edit-hardware-field-form">修改</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        require(['jquery'], function($) {

            $('.edit-hardware-field').bind('click', function() {

                var $modal = $('#edit-hardware-field');

                $modal.find(':input[name=name]').val($(this).data('name'));
                $modal.find(':input[name=id]').val($(this).data('id'));

                $modal.modal();
            });
        });
    </script>

@endsection
