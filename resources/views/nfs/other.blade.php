@extends('layout')

{{--清空 Sidebar--}}
@section('sidebar')
@endsection

@section('navbar-header')
    <div class="navbar-header ">
        <span class="navbar-brand">
            {{ $project->name }}
            @if ($project->ref_no)
                <strong>
                    ({{ $project->ref_no }})
                </strong>
            @endif
            文件系统
        </span>
    </div>
@endsection


@section('content')
    <script type="text/javascript">
        require(['css!../css/nfs/index.css'], function() {});
    </script>

    <div class="col-lg-12">

        <hr/>

        <ol class="breadcrumb">
            <li><a href="{{ route('nfs.path', ['project'=> $project, 'path'=> 'root']) }}">Root</a></li>

            @if (isset($path))
                {{--*/ $_p =  [];/*--}}
                @foreach(explode('/', trim($path, '/')) as $p)
                    {{--*/ $_p[] = $p;/*--}}

                    <li>
                        <a href="{{ route('nfs.path', ['project'=> $project, 'path'=> join('/', $_p)]) }}">{{ $p }}</a>
                    </li>
                @endforeach
            @endif
        </ol>

        <hr />

        <div class="panel panel-default">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                @include('nfs.path', ['project'=> $project, 'path'=> $path])
            </div>
        </div>

    </div>
    
    <script type="text/javascript">
        require(['jquery'], function($) {

            $('ul li.item').hover(function() {
                $(this).addClass('hover');
                $(this).find('a.action').removeClass('hidden');
            }, function() {
                $(this).removeClass('hover');
                $(this).find('a.action').addClass('hidden');
            });

            $('ul li.item button.edit-btn').bind('click', function() {

                var $modal = $('#file-edit');

                $modal.find(':input[name=project_id]').val($(this).data('project-id'));
                $modal.find(':input[name=file]').val($(this).data('file'));
                $modal.find(':input[name=display_file]').val($(this).data('file'));
                $modal.find(':input[name=path]').val($(this).data('path'));

                $modal.modal();
                return false;

            });
        });

        require(['jquery', 'fileinput'], function($) {
            require(['css!../css/fileinput.min'], function() {});
        });
    </script>
@endsection
