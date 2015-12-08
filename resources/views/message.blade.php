<div style="position: fixed; top: 8px; right: 14px; z-index: 10;">
    <div class="alert alert-{{ session('message_type') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('message_content') }}
    </div>
</div>