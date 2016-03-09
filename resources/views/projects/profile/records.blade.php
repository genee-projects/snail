<script type="text/javascript">
    require(['jquery', 'bootstrap-datetimepicker', 'bootstrap3-typeahead', 'moment/locale/zh-cn'], function($) {
        require(['css!../css/bootstrap-datetimepicker.min'], function() {});

        $('.datetimepicker').datetimepicker({
            format: 'YYYY/MM/DD',
            locale: 'zh-cn'
        });

        $('select').selectpicker();

        $.get('/hardwares.json', function(data){

            var $selector = $("#record-hardware-name");

            var $input = $('<input name="hardware_name" type="hidden">');
            $selector.after($input);

            $selector.bind('change', function(e) {
                $input.val($selector.val());
            });

            $selector.typeahead({
                source:data,
                displayText: function(item) {
                    return item.name;
                },
                afterSelect: function(item) {
                    $input.val(item.name);
                }
            });
        },'json');
    });

</script>
<div class="panel-body">

    <div class="panel panel-default">

        <div class="panel-heading">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-record"><i class="fa fa-plus"></i> 添加记录</button>

            <div class="modal fade" id="add-record" tabindex="-1" role="dialog" aria-labelledby="add-record-modal-label">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="add-record-modal-label">添加记录</h4>
                        </div>
                        <div class="modal-body">

                            <form id="add-record-form" method="post" action="{{ route('record.add') }}" class="form-horizontal">

                                <input type="hidden" name="project_id" value="{{ $project->id }}" />

                                <div class="form-group">
                                    <label for="record-user" class="col-md-2 control-label">外出人员</label>
                                    <div class="col-md-4">
                                        <input  type="text" value="{{ \Session::get('user')->name }}" disabled="disabled" class="form-control" id="record-user">
                                    </div>

                                    <label for="record-time" class="col-md-2 control-label">外出时间</label>
                                    <div class="col-md-4">
                                        <input type="text" name="time" class="form-control datetimepicker">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="record-contact" class="col-md-2 control-label">联系人</label>
                                    <div class="col-md-4">
                                        <input name="contact" type="text" class="form-control" id="record-contact" placeholder="曹老师">
                                    </div>

                                    <label for="record-phone" class="col-md-2 control-label">联系方式</label>
                                    <div class="col-md-4">
                                        <input name="phone" type="text" class="form-control" id="record-phone">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="record-hardware-count" class="col-md-2 control-label">硬件名称/版本</label>
                                    <div class="col-md-10">
                                        <input name="hardware_name" autocomplete="off" class="form-control" id="record-hardware-name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="record-hardware-count" class="col-md-2 control-label">硬件数量</label>
                                    <div class="col-md-4">
                                        <input name="hardware_count" type="text" class="form-control" id="record-hardware-count" placeholder="10">
                                    </div>
                                    <label for="record-software-count" class="col-md-2 control-label">软件数量</label>
                                    <div class="col-md-4">
                                        <input name="software_count" type="text" class="form-control" id="record-software-count" placeholder="10">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="record-content" class="col-md-2 control-label">工作内容</label>
                                    <div class="col-md-10">
                                        <textarea class="form-control" id="record-content" name="content" rows="3" placeholder="工作内容"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary" form="add-record-form">添加</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-body">

            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <td>日期</td>
                    <td>人员</td>
                    <td>联系人</td>
                    <td>联系方式</td>
                    <td>软件数量</td>
                    <td>硬件名称</td>
                    <td>硬件数量</td>
                    <td>工作内容</td>
                    <td>操作</td>
                </tr>

                @foreach($project->records()->orderBy('time', 'desc')->get() as $record)
                    <tr>
                        <td>{{ $record->time->format('Y/m/d') }}</td>
                        <td>{{ $record->user->name }}</td>
                        <td>{{ $record->contact }}</td>
                        <td>{{ $record->phone }}</td>
                        <td>{{ $record->software_count }}</td>
                        <td>{{ $record->hardware_name }}</td>
                        <td>{{ $record->hardware_count }}</td>
                        <td>{{ $record->content }}</td>
                        <td>
                            <a class="pull-right" href="{{ route('record.delete', ['id'=> $record->id]) }}">
                                <i class="fa fa-fw fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
