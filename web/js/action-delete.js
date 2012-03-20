$('.action_delete').click(function() {
    var href = $('#action_delete').attr('href').replace('action_id', '');

   $('#action_delete').attr('href', href + $(this).attr('rel')); 
});
