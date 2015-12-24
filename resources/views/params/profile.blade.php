@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $param->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <i class="fa fa-linux"></i> 基本信息
                    <span class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#edit-param">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>

                        <a href="{{ route('param.delete', ['id' => $param->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>
                    <div class="modal fade" id="edit-param" tabindex="-1" role="dialog" aria-labelledby="edit-param-modal-label">
                        <div class="modal-dialog role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="edit-server-modal-label">修改参数</h4>
                            </div>
                            <div class="modal-body">
                                <form id="edit-param-form" method="post" action="{{ route('param.edit', ['id'=> $param->id]) }}">

                                    <div class="form-group">
                                        <input name="name" value="{{ $param->name }}" type="text" class="form-control" placeholder="名称 (人员数量上限)">
                                    </div>

                                    <div class="form-group">
                                        <input name="code" value="{{ $param->code }}" type="text" class="form-control" placeholder="参数代码 (max_users_count)">
                                    </div>

                                    <div class="form-group">
                                        <input name="value" value="{{ $param->value }}" type="text" class="form-control" placeholder="默认值 (5000)">
                                    </div>


                                    <div class="form-group">
                                        <textarea name="description" class="form-control" rows="3" placeholder="参数描述">{{ $param->description }}</textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                <button type="submit" class="btn btn-primary" form="edit-param-form">修改</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-body">

                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td style="width: 10%;">名称</td>
                        <td>{{ $param->name }}</td>
                    </tr>
                    <tr>
                        <td>参数代码</td>
                        <td><code>{{ $param->code }}</code></td>
                    </tr>

                    <tr>
                        <td>默认值</td>
                        <td>{{ $param->value }}</td>
                    </tr>

                    <tr>
                        <td>简述</td>
                        <td>{{ $param->description }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


@endsection
