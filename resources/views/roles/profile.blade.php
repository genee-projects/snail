@extends('layout')

@section('content')
    <link rel="stylesheet" href="assets/css/roles/profile.css">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $role->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <i class="fa fa-linux"></i> 基本信息

                    @if (! $role->system)

                        {{--*/ $role_perms = (array) $role->perms /*--}}

                        <span class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#edit-role">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            <a href="{{ route('role.delete', ['id' => $role->id]) }}">
                                <i class="fa fa-fw fa-times"></i>
                            </a>
                        </span>
                        <div class="modal fade" id="edit-role" tabindex="-1" role="dialog" aria-labelledby="edit-role-modal-label">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="edit-role-modal-label">修改角色</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-role-form" method="post" action="{{ route('role.edit') }}">

                                            <div class="form-group">
                                                <label for="role-name" class="control-label">角色名称</label>
                                                <input name="name" type="text" value="{{ $role->name }}" class="form-control" id="role-name">
                                            </div>

                                            <div class="form-group">
                                                <label for="role-perm" class="control-label">权限设定</label>

                                                {{--*/ $perms = config('perms'); /*--}}
                                                <table class="table table-bordered table-condensed">

                                                    @foreach($perms as $title => $_perms)

                                                        <tr>
                                                            <td class="middle">{{ $title }}</td>
                                                            <td>
                                                                @foreach($_perms as $p)
                                                                    {{--*/ $selected = false/*--}}
                                                                    {{--*/ $class = 'btn-default'/*--}}
                                                                    @if (in_array($p, $role_perms))
                                                                        {{--*/ $selected = true/*--}}
                                                                        {{--*/ $class = 'btn-primary' /*--}}
                                                                    @endif

                                                                    <div class="perm-btn btn {{ $class }} text-center col-lg-12">{{ $p }}</div>

                                                                    @if ($selected)
                                                                        <input type="hidden" name="perms[]" value="{{ $p }}"/>
                                                                    @endif

                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                </table>
                                            </div>
                                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                        <button type="submit" class="btn btn-primary" form="edit-role-form">修改</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            require(['jquery'], function($) {
                                $('.perm-btn').bind('click', function() {

                                    $input = $('<input type="hidden" name="perms[]" />');

                                    var $this = $(this);
                                    if ($this.hasClass('btn-default')) {
                                        $this.removeClass('btn-default');
                                        $this.addClass('btn-primary');
                                        $input.val($this.text());

                                        $this.after($input);
                                    }
                                    else {
                                        $this.removeClass('btn-primary');
                                        $this.addClass('btn-default');
                                        $this.next(':input').remove();
                                    }
                                });
                            });
                        </script>
                    @endif
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr>
                            <td class="col-lg-3">角色名称</td>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <td>权限列表</td>
                            <td>
                                @if (count($role->perms))
                                    @foreach($role->perms as $perm)
                                    <p><code>{{ $perm }}</code></p>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
