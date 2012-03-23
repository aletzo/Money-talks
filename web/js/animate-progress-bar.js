var parent_width = $('.progress').width();

$('.bar').delay(500).each(function(i, e) {

    var new_width = parseInt(parent_width * $(this).attr('rel') / 100, 10);

    if (new_width > parent_width) {
        new_width = parent_width;
    }

    $(this).animate({
        width: new_width
    }, 500);
});
