@extends('layout')

@section('content')
    <link rel="stylesheet" href="assets/css/products/index.css">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">产品列表</h1>
        </div>

        @foreach($products as $product)
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-cube"></i> <a href="{{ route('product.profile', ['id'=> $product->id]) }}">{{ $product->name }}</a>

                        @if (\Session::get('user')->can('产品信息管理'))
                            <p class="pull-right"><a href="{{ route('product.delete', ['id'=> $product->id]) }}" ><i class="fa fa-fw fa-small fa-times">&#160;</i></a></p>
                        @endif
                    </div>
                    <div class="panel-body">
                        {{ $product->description }}
                    </div>

                    @if ($product->sub_products()->count())
                        <ul class="list-group">
                            <li class="list-group-item">
                                <h5>产品类型</h5>
                                @foreach($product->sub_products as $sub)
                                    <p class="indent">
                                        <a href="{{ route('subproduct.profile', ['id'=> $sub->id]) }}">
                                            {{ $sub->name }}
                                        </a>
                                    </p>
                                @endforeach
                            </li>
                        </ul>
                    @endif

                </div>
            </div>
        @endforeach

        @if (\Session::get('user')->can('产品信息管理'))
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-cube"></i> 添加产品
                    </div>
                    <div class="panel-body">

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
        @endif
    </div>

@endsection
