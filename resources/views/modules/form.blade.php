<div class="form-group">
    <input name="name" type="text" class="form-control" placeholder="名称(成员目录)">
</div>

<div class="form-group">
    <input name="description" type="text" class="form-control" placeholder="简述">
</div>

<div class="form-group">
    <div style="border-bottom: 1px solid #eee; margin-bottom: 20px; margin-top: 20px;">
        选择依赖模块
    </div>
    @foreach(\App\Module::all() as $module)
    <span _id="{{ $module->id }}" class="module-btn btn btn-default text-center" style="padding: 20px; margin:10px 5px; width:100px;">
        {{ $module->name }}
    </span>
    @endforeach
</div>

<script type="text/javascript">
    require(['jquery'], function($) {
        $('.module-btn').bind('click', function() {
            $input = $('<input type="hidden" name="modules[]" />');

            var $span = $(this);


            if ($span.hasClass('btn-default')) {
                $span.removeClass('btn-default');
                $span.addClass('btn-primary');
                $input.val($span.attr('_id'));

                $span.after($input);
            }
            else {
                $span.removeClass('btn-primary');
                $span.addClass('btn-default');
                $span.next(":input").remove();
            }
        });
    });


</script>