<div class="panel-body">
    <table class="table table-hover">
        <tr>
            <td>名称</td>
            <td>规格/型号</td>
            <td>生产类型</td>
            <td>部署数量</td>
            <td>签约数量</td>
            <td>备注</td>
        </tr>

        @foreach($project->hardwares as $hardware)
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
                    {{ $hardware->pivot->deployed_count }}
                </td>
                <td>
                    {{ $hardware->pivot->plan_count }}
                </td>

                <td>
                    {{ $hardware->pivot->description }}
                    <span class="pull-right">
                          <i class="fa fa-fw fa-edit edit-hardware" data-model="{{ $hardware->model }}" data-description="{{ $hardware->description }}" data-id="{{ $hardware->id }}" data-name="{{ $hardware->name }}" data-plan-count="{{ $hardware->pivot->plan_count }}" data-deployed-count="{{ $hardware->pivot->deployed_count }}"></i>
                    </span>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6">
                <span class="pull-right">
                    <button data-toggle="modal" data-target="#hardwares" type="button" class="btn btn-primary"><i class="fa fa-wrench"></i> 设置硬件</button>
                </span>
            </td>
        </tr>
    </table>

    <div class="modal fade" id="hardwares" tabindex="-1" role="dialog" aria-labelledby="hardwares-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="hardwares-modal-label">设置硬件</h4>
                </div>
                <div class="modal-body">
                    <form id="add-hardware-form" class="form-horizontal" method="post" action="{{ route('project.hardwares', ['id'=> $project->id]) }}">
                        @foreach(\App\Hardware::all() as $hardware)

                            {{--*/ $selected = false /*--}}
                            {{--*/ $btn_class = 'btn-default' /*--}}

                            {{--*/ $project_hardware = $project->hardwares->find($hardware->id)/*--}}

                            @if($project_hardware)
                                {{--*/ $selected = true /*--}}
                                {{--*/ $btn_class = 'btn-primary' /*--}}
                            @endif

                            <div class="row">
                                <div class="col-lg-12">
                                    <div data-id="{{ $hardware->id }}" class="hardware-btn btn {{ $btn_class }}">
                                        {{ $hardware->name }}
                                    </div>
                                    @if($selected)
                                        <input type="hidden" name="hardwares[]" value="{{ $hardware->id }}" />
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <script type="text/javascript">

                            require(['jquery'], function($) {

                                $('.hardware-btn').bind('click', function() {

                                    $input = $('<input type="hidden" name="hardwares[]" />');

                                    var $div = $(this);

                                    if ($div.hasClass('btn-default')) {
                                        $div.removeClass('btn-default');
                                        $div.addClass('btn-primary');
                                        $input.val($div.data('id'));

                                        $div.after($input);
                                    }
                                    else {
                                        $div.removeClass('btn-primary');
                                        $div.addClass('btn-default');
                                        $div.next(":input").remove();
                                    }
                                });
                            });
                        </script>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" form="add-hardware-form">设置</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit-hardware" tabindex="-1" role="dialog" aria-labelledby="edit-hardware-modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit-hardware-modal-label">修改硬件信息</h4>
                </div>
                <div class="modal-body">
                    <form id="edit-project-hardware-form" class="form-horizontal" method="post" action="{{ route('project.hardware.edit', ['id'=> $project->id]) }}">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="name" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="model" disabled="disabled">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="deployed_count" placeholder="部署数量">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="plan_count" placeholder="签约数量">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="description" rows="3" placeholder="备注"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="hardware_id" value="" >

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary" form="edit-project-hardware-form">修改</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        require(['jquery'], function($) {

            $('.edit-hardware').bind('click', function() {
                var $modal = $('#edit-hardware');
                $modal.find(':input[name=name]').val($(this).data('name'));
                $modal.find(':input[name=model]').val($(this).data('model'));
                $modal.find(':input[name=plan_count]').val($(this).data('plan-count'));
                $modal.find(':input[name=deployed_count]').val($(this).data('deployed-count'));
                $modal.find(':input[name=desription]').val($(this).data('description'));

                $modal.find(':input[name=hardware_id]').val($(this).data('id'));

                $modal.modal();
            });
        });
    </script>


</div>