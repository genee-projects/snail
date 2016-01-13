<div class="panel-heading role-card-header">
    {{ $role->name }}
    <button class="connect-many btn btn-primary btn-xs pull-right" data-role-id="{{ $role->id }}">
        添加全部
    </button>
</div>
<div class="panel-body role-card-body">

    @foreach($role->users as $user)
        <span class="role-user" data-user-id="{{ $user->id }}">{{ $user->name }} <i class="fa fa-times delete-member"></i></span>
    @endforeach
</div>