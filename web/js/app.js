//Additional JavaScript Functions (for IE):
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
   	 * begin the twipsy 
   	 */
   	$('.tooltip').twipsy();
    /*
   	 * end the twipsy
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
