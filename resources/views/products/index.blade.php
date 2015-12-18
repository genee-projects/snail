@extends('layout')

@section('content')
<div class="row" id="products">
    <div class="col-lg-12">
        <h1 class="page-header">产品列表</h1>
    </div>

    @foreach($products as $p)
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cube"></i> <a href="{{ route('product.profile', ['id'=> $p->id]) }}">{{ $p->name }}</a>
                    <p class="pull-right"><a name="delete" _id="{{ $p->id }}"><i class="fa fa-fw fa-small fa-times">&#160;</i></a></p>
                </div>
                <div class="panel panel-body">
                    {{ $p->description }}
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-cube"></i> 添加产品
            </div>
            <div class="panel panel-body">

                <form method="post" action="{{ route('product.add') }}">
                    <div class="form-group">
                        <input name="name" type="text" placeholder="名称" class="form-control" />
                    </div>

                    <div class="form-group">
                        <textarea name="description" class="form-control" rows="3" placeholder="简述"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-fw fa-plus"></i> 添加
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection