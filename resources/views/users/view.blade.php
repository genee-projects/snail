<div class="text-left user" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">

    <div class="user-icon-text">

        @if (parse_url($user->icon)['scheme'] == 'initials')
            {{ parse_url($user->icon)['host'] }}
        @else
            <img class="img-rounded" src="{{ $user->icon }}" />
        @endif
    </div>
    <div class="user-desc">
        {{ $user->name }}
    </div>
</div>