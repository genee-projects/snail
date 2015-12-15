$(document).ready(function() {

    //
    $('#show-menu').on('click', function(e) {
        $(this).addClass('hide');

        $('#close-menu').show();

        $('#close-menu').parents('[role=navigation]').removeClass('hide');

        $('#page-wrapper').css('margin-left', '200px');
        e.stopPropagation();

        return false;
    });

    //关闭按钮
    $('#close-menu').bind('click', function(e) {
        $(this).parents('[role=navigation]').addClass('hide');

        $('#page-wrapper').css('margin-left', '0px');

        e.stopPropagation();

        $('#show-menu').removeClass('hide');

        return false;

    });

    $('select').selectpicker();
});
