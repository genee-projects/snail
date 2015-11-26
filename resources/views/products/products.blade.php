@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">产品列表</h1>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cube"></i> Lims2-CF
                </div>
                <div class="panel panel-body">
                    全世界最牛 x 的大型仪器管理系统
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cube"></i> Lims
                    <span class="pull-right">
                        <i class="fa fa-fw fa-1x fa-toggle-off"></i>
                    </span>
                </div>
                <div class="panel panel-body">
                    全世界最赞的实验室信息管理系统
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cube"> </i>
                </div>
                <div class="panel panel-body">

                    <div class="form-group">
                        <input type="text" placeholder="名称" class="form-control" />
                    </div>

                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="简述"></textarea>
                    </div>

                    <button type="button" class="btn btn-primary">
                        <i class="fa fa-fw fa-plus"></i> 添加
                    </button>
                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <select class="selectpicker show-tick" data-header="选择产品">
                <option><b>Lims2-CF</b></option>
                <option><b>Lims2</b></option>
                <option><b>Mall</b></option>
            </select>
        </div>

    </div>

@endsection