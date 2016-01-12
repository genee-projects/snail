<link rel="stylesheet" href="assets/css/message.css">

<div class="message-container">
    <div class="alert alert-{{ session('message_type') }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{ session('message_content') }}
    </div>
</div>