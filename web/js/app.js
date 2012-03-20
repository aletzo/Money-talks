//Additional JavaScript Function (for IE):
if (!Array.indexOf) {
    Array.prototype.indexOf = function(obj){
        for (var i = 0; i < this.length; i++) {
            if (this[i] == obj) {
                return i;
            }
        }
        return -1;
    };
}

$(function() {

    /************************
   	 * begin the active menu
   	 */
    var foundActive = false;

    $('ul.nav li').each(function(i, e) {
        var $e  = $(e);

        if (window.location.pathname.indexOf($e.attr('rel')) != -1) {
            $e.addClass('active');
            foundActive = true;
        } else {
            $e.removeClass('active');
        }
    });

    if ( ! foundActive) {
        $('ul.nav li:first').addClass('active');
    }
    /*
   	 * end the active menu
   	 **********************/
   
    /************************
   	 * begin the konami code
   	 */
    var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";

    $(document).keydown(function(e) {
        kkeys.push( e.keyCode );

        if ( kkeys.toString().indexOf( konami ) >= 0 ){
   	        window.location.href = 'lyrics';
        }
    });

    $('#vanity_card').hover(function() {
        $('#konami_img').fadeIn(300);
    });

    $('#enjoy').click(function() {
        $('#iframe').fadeIn(300);

        return false;
    });
    /*
   	 * end the konami code
   	 **********************/



    /*******************
   	 * begin the tooltip 
   	 */
//   	$('.tooltip').tooltip();
    /*
   	 * end the tooltip
   	 *****************/



    /***********************
   	 * begin the datepicker
   	 */
   	$('.datepicker').datepicker({
   	    'dateFormat': 'yy-mm-dd'
   	});
    /*
   	 * end the datepicker
   	 *********************/
});
