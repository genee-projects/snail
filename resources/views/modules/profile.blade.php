@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $module->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <i class="fa fa-linux"></i> 基本信息
                    <span class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#edit-module">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>

                        <a href="{{ route('module.delete', ['id' => $module->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>
                    <div class="modal fade" id="edit-module" tabindex="-1" role="dialog" aria-labelledby="edit-module-modal-label">
                        <div class="modal-dialog role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="edit-server-modal-label">修改模块</h4>
                            </div>
                            <div class="modal-body">
                                <form id="edit-module-form" method="post" action="{{ route('module.edit', ['id'=> $module->id]) }}">

                                    <div class="form-group">
                                        <input value="{{ $module->name }}" name="name" type="text" placeholder="名称" class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <input value="{{ $module->description }}" name="description" type="text" placeholder="简述" class="form-control">
                                    </div>


                                    <div class="form-group">
                                        <div style="border-bottom: 1px solid #eee; margin-bottom: 20px; margin-top: 20px;">
                                            选择依赖模块
                                        </div>
                                        @foreach(\App\Module::all() as $m)
                                            @if($m->id != $module->id)
                                                {{--*/ $dep = false /*--}}
                                                {{--*/ $btn_class = 'btn-default' /*--}}

                                                @if($module->dep_modules->contains($m->id))
                                                    {{--*/ $dep = true /*--}}
                                                    {{--*/ $btn_class = 'btn-primary' /*--}}
                                                @endif

                                                <span _id="{{ $m->id }}" class="module-btn btn {{ $btn_class }} text-center" style="padding: 20px; margin:10px 5px; width:100px;">
                                                    {{ $m->name }}
                                                </span>

                                                @if($dep)
                                                    <input type="hidden" name="modules[]" value="{{ $m->id }}" />
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>

                                    <script type="text/javascript">
                                        require(['jquery'], function($) {
                                            $('.module-btn').bind('click', function() {
                                                $input = $('<input type="hidden" name="modules[]" />');

                                                var $span = $(this);


                                                if ($span.hasClass('btn-default')) {
                                                    $span.removeClass('btn-default');
                                                    $span.addClass('btn-primary');
                                                    $input.val($span.attr('_id'));

                                                    $span.after($input);
                                                }
                                                else {
                                                    $span.removeClass('btn-primary');
                                                    $span.addClass('btn-default');
                                                    $span.next(":input").remove();
                                                }
                                            });
                                        });
                                    </script>
                                    <input type="hidden" name="module_id" value="{{ $module->id }}">
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="edit-module-form">修改</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-body">

                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td style="width: 10%;">名称</td>
                        <td>{{ $module->name }}</td>
                    </tr>
                    <tr>
                        <td>简述</td>
                        <td>{{ $module->description }}</td>
                    </tr>
                    <tr>
                        <td>依赖模块</td>
                        <td>

                            @foreach($module->dep_modules as $m)
                                <code>
                                    <a href="{{ route('module.profile', ['id'=> $m->id]) }}">
                                        {{ $m->name }}
                                    </a>
                                </code>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


@endsection
