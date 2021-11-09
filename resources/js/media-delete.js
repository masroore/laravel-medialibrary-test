$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.delete-media').click(function () {
        if (confirm('Are you sure you want to delete this item?')) {
            var post_id = $(this).data('id');
            var elem_id = $(this).data('elem');

            $.ajax({
                type: 'DELETE',
                url: media_url + post_id,
                success: function (data) {
                    $('#media_' + elem_id).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
});
