$('.budget_delete').click(function() {
    var href = $('#budget_delete').attr('href').replace('budget_id', '');

   $('#budget_delete').attr('href', href + $(this).attr('rel')); 
});
