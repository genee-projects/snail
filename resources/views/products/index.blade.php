@extends('layout')

@section('content')
<div class="row" id="products">
    <div class="col-lg-12">
        <h1 class="page-header">产品列表</h1>
    </div>

    @foreach($products as $p)
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-cube"></i> {{ $p->name }}
                    <p class="pull-right"><a name="delete" _id="{{ $p->id }}"><i class="fa fa-fw fa-small fa-times">&#160;</i></a></p>
                </div>
                <div class="panel panel-body">
                    {{ $p->description }}
                </div>
            </div>
        </div>
    @endforeach

    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-cube"> </i>
            </div>
            <div class="panel panel-body">

                <div class="form-group">
                    <input name="name" type="text" placeholder="名称" class="form-control" />
                </div>

                <div class="form-group">
                    <textarea name="description" class="form-control" rows="3" placeholder="简述"></textarea>
                </div>

                <button name="add" type="button" class="btn btn-primary">
                    <i class="fa fa-fw fa-plus"></i> 添加
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var $products = $('#products');

        $products.find('[name=add]').bind('click', function() {
            $.ajax({
               'url':'products/add',
                'data': {
                    'name': $products.find(':input[name=name]').val(),
                    'description': $products.find(':input[name=description]').val()
                },
                'success': function() {
                    window.location.reload();
                }
            });
        });

        $products.find('[name=delete]').bind('click', function() {
            $.ajax({
                'url': 'products/delete',
                'data': {
                    'id': $(this).attr('_id')
                },
                'success': function() {
                    window.location.reload();
                }
            });
        });
    });
</script>
@endsection