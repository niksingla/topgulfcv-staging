jQuery(document).ready(function ($) {
    $('.status-select').change(function () {
        var post_id = $(this).data('postid');
        var new_status = $(this).val();
        $.post(ajaxurl, {
            action: 'update_paid_post_status',
            post_id: post_id,
            new_status: new_status,
        });
    });
});


