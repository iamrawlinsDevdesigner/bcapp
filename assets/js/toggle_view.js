$(document).ready(function() {
    $('#grid-view').click(function() {
        $('#posts-container').removeClass('list-view').addClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4');
    });

    $('#list-view').click(function() {
        $('#posts-container').removeClass('grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4').addClass('list-view');
    });
});
