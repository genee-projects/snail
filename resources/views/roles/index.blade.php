@extends('layout')

@section('content')
    <link rel="stylesheet" href="asserts/css/roles/index.css">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">角色设置</h1>
        </div>

        <div class="col-lg-12" id="role-board">

            <div class="role-board-container col-lg-8">
                @foreach(App\Role::all() as $role)
                    <div class="col-lg-12">
                        <div data-role-id="{{ $role->id }}" class="panel panel-default role-card">
                            <div class="panel-heading role-card-header">
                                {{ $role->name }}
                                <a class="btn btn-primary btn-xs pull-right" href="{{ route('role.user.connect_all', ['role_id'=> $role->id]) }}">
                                    添加全部
                                </a>
                            </div>
                            <div class="panel-body role-card-body">

                                @foreach($role->users as $user)
                                    <span class="role-user" data-user-id="{{ $user->id }}">{{ $user->name }} <i class="fa fa-times delete-member"></i></span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-4 users">
                @foreach(App\User::all() as $user)
                    <p class="text-left user" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" >
                        <img data-src="holder.js/40x40">
                        {{ $user->name }}
                    </p>
                @endforeach
            </div>
        </div>
    </div>

    <script type="text/javascript">
        require(['jquery', 'dragdrop', 'holder'], function($) {

            var listUserDraggableOpts = {
                helper: 'clone',
                revert: false,
                containment: '#role-board',
                scroll: true,
                refreshPositions: true
            };

            var $board = $('#role-board');

            $board.find('.user').draggable(listUserDraggableOpts);

            $board.find('.role-card-body').droppable({
                accept: '.user',
                activeClass: 'drag-active',
                hoverClass: 'drag-hover',
                drop: function(evt, ui) {
                    var $ele = $(ui.helper);
                    var user_id = $ele.data('user-id');
                    var user_name = $ele.data('user-name');

                    $ele = $('<span class="role-user"/>');
                    var $del = $('<i class="fa fa-times delete-member"/>');

                    $ele.text(user_name + " ");
                    $ele.append($del);

                    $ele.data('user-id', user_id);
                    $ele.data('user-name', user_name);

                    var $body = $(this);
                    var $card = $body.parents('.role-card');

                    var role_id = $card.data('role-id');

                    // ajax 操作
                    $.post('/roles/'+ role_id + '/user/' + user_id, {
                    }).done(function(data) {
                        if (data === true) {
                            $body.append($ele);
                        }
                        else {
                            $ele.remove();
                        }
                    }).fail(function() {
                        $ele.remove();
                    });
                }
            });

            $board.on('click', '.role-card-body .delete-member', function(){
                var $button = $(this);
                var $user = $button.parents('.role-user');
                var $card = $button.parents('.role-card');

                var role_id = $card.data('role-id');
                var user_id = $user.data('user-id');

                // ajax 操作
                $.post('roles/' + role_id + '/user/' + user_id + '/delete', {
                }).done(function(data) {
                    if (data === true) {
                        $user.remove();
                    }
                });
            });
        });
    </script>

@endsection
