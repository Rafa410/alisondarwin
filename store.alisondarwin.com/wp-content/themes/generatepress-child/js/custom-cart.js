(function($) {

    function autoUpdateCart() {
        let timeout;
        $( 'div.woocommerce' ).on( 'change keyup mouseup', 'input.qty', function() { // keyup and mouseup for Firefox support
            if (timeout) {
                clearTimeout(timeout); // Cancel previously scheduled event
            }
            
            if (! $(this).val() || $(this).val() < 1) { // If qty empty, instead of removing item from cart, do nothing
                return; 
            }
            
            timeout = setTimeout(function() {
                $('[name="update_cart"]').trigger('click');
            }, 1000 ); // sSchedule update cart event with 1000 miliseconds delay
        });
    }


    /************** DOCUMENT READY **************/

    $(document).ready(function() {

        autoUpdateCart();

    });

}(jQuery));