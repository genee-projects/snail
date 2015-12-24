@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">参数管理</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading ">
                    <p>
                        <span>
                            <i class="fa fa-cubes"> </i>
                        </span>

                        <span class="pull-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-param">
                                <i class="fa fa-plus"></i>
                                添加参数
                            </button>
                        </span>
                    </p>

                    <div class="modal fade" id="add-param" tabindex="-1" role="dialog" aria-labelledby="add-param-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-param-modal-label">添加参数</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-param-form" method="post" action="{{ route('param.add') }}">
                                        @include('params/form')
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-param-form">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <td style="width: 20%;">参数名称</td>
                            <td>参数代码</td>
                            <td>默认值</td>
                            <td>参数描述</td>
                        </tr>
                        @foreach($params as $param)
                            <tr>
                                <td>
                                    <a href="{{ route('param.profile', ['id'=> $param->id]) }}">
                                        {{ $param->name }}
                                    </a>
                                </td>
                                <td><code>{{ $param->code }}</code></td>
                                <td><p class="text-right">{{ $param->value }}</p></td>
                                <td>{{ $param->description }}</td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
