$('#filters_form button').click(function(e) {
    e.preventDefault();
    var $this = $(this);
    var isActive = $this.hasClass('active');

    switch ($this.attr('id')) {
        case 'deposit':
            $('#deposit_value').val(isActive ? 'false' : 'true');
            break;
        case 'withdrawal':
            $('#withdrawal_value').val(isActive ? 'false' : 'true');
            break;
        case 'history_1':
            $('#history_value').val(1);
            break;
        case 'history_3':
            $('#history_value').val(3);
            break;
        case 'history_12':
            $('#history_value').val(12);
            break;

    }

    $('#filters_form').submit();
});
