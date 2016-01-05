@extends('layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $user->name }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <i class="fa fa-linux"></i> 基本信息
                    <span class="pull-right">
                        <a href="#" data-toggle="modal" data-target="#edit-user">
                            <i class="fa fa-fw fa-edit"></i>
                        </a>

                        <a href="{{ route('user.delete', ['id' => $user->id]) }}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </span>
                    <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="edit-user-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="edit-user-modal-label">修改人员</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="edit-user-form" method="post" action="{{ route('user.edit') }}">

                                        <div class="form-group">
                                            <label for="user-name" class="control-label">名称</label>
                                            <input name="name" type="text" value="{{ $user->name }}" class="form-control" id="user-name">
                                        </div>

                                        <div class="form-group">
                                            <label for="user-role" class="control-label">角色</label>
                                            <div>
                                                @foreach(App\Role::all() as $role)

                                                    {{--*/ $selected = false /*--}}
                                                    {{--*/ $btn_class = 'btn-default' /*--}}

                                                    @if($user->roles->contains($role->id))
                                                        {{--*/ $selected = true /*--}}
                                                        {{--*/ $btn_class = 'btn-primary' /*--}}
                                                    @endif

                                                    <div _id="{{ $role->id }}" class="role-btn btn {{ $btn_class }} text-center" style="padding: 20px; margin: 10px 5px; min-width: 100px;">{{ $role->name }}</div>

                                                    @if ($selected)
                                                        <input type="hidden" name="roles[]" value="{{ $role->id }}">
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>

                                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                                        <script type="text/javascript">
                                            require(['jquery'], function($) {
                                                $('.role-btn').bind('click', function() {

                                                    $input = $('<input type="hidden" name="roles[]" />');

                                                    var $this = $(this);
                                                    if ($this.hasClass('btn-default')) {
                                                        $this.removeClass('btn-default');
                                                        $this.addClass('btn-primary');
                                                        $input.val($this.attr('_id'));
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
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button type="submit" class="btn btn-primary" form="edit-user-form">修改</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <td style="width: 20%">名称</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>角色</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <p>
                                        <code>
                                            {{ $role->name }}
                                        </code>
                                    </p>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
