@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">模块管理</h1>
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
                            <button class="btn btn-primary" data-toggle="modal" data-target="#add-module">
                                <i class="fa fa-plus"></i>
                                添加模块
                            </button>
                        </span>
                    </p>

                    <div class="modal fade" id="add-module" tabindex="-1" role="dialog" aria-labelledby="add-module-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="add-module-modal-label">添加模块</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="add-module-form" method="post" action="{{ route('module.add') }}">
                                        @include('modules/form')
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="add-module-form">添加</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">

                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <td style="width: 10%;">模块名称</td>
                            <td>模块描述</td>
                        </tr>
                        @foreach($modules as $module)
                            <tr>
                                <td>
                                    <a href="{{ route('module.profile', ['id'=> $module->id]) }}">
                                        {{ $module->name }}
                                    </a>
                                </td>
                                <td>{{ $module->description }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
