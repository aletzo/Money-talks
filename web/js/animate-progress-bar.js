var parent_width = $('.progress').width();

$('.bar').delay(500).each(function(i, e) {
    var $this = $(this);

    var new_width = parseInt(parent_width * $this.attr('rel') / 100, 10);

    if (new_width > parent_width) {
        new_width = parent_width;
    }

    var $span = $this.siblings('span');

    if ($span.width() + 10 > new_width) {
        $span.removeClass('white');
    }

    console.log($(this).siblings('span').width() + ' | ' + new_width);

    $(this).animate({
        width: new_width
    }, 500);
});
