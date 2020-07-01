(function($) {

    /* Modify product quantity with '-' and '+' icons */
    function modify_product_quantity() {
        let timeout;

        $( ".minus" ).on( 'click', function() {
            var $input = $( this ).parent().parent().find( 'input.qty' ),
                minVal = $input.prop( 'min' ),
                currVal = parseInt( $input.val() ) || 0;

            if (timeout) {
                clearTimeout(timeout);
            }

            if ( currVal <= minVal ) {
                return;
            }

            if( currVal > 1 ) {
                $input.val( currVal - 1 ).trigger( 'change' );
            };

            timeout = setTimeout(function() {
                $input
                    .trigger( 'updated_addons' )
                    .trigger ( 'keyup' );
                $( document.body ).trigger( 'woocommerce_variation_has_changed' );
            }, 500);

            /* Cart page: Enable button 'update cart' when quantity changed */
            // $( "[name='update_cart']" ).prop( "disabled", false ); // Not necessary, now it updates automatically
        });

        $( ".plus" ).on( 'click', function() {
            var $input = $( this ).parent().parent().find( 'input.qty' ),
                currVal = parseInt( $input.val() ) || 0,
                max = parseInt( $input.prop( 'max' ) ) || 99;

            if (timeout) {
                clearTimeout(timeout);
            }

            if( currVal >= max ) {
                return;
            }

            $input.val( currVal + 1 ).trigger( 'change' );

            timeout = setTimeout(function() {
                $input
                    .trigger( 'updated_addons' )
                    .trigger ( 'keyup' );
                $( document.body ).trigger( 'woocommerce_variation_has_changed' );
            }, 500);

            /* Cart page: Enable button 'update cart' when quantity changed */
            // $( "[name='update_cart']" ).prop( "disabled", false );
        });

    }

    /* When the user scroll down, adds the class 'fixed' to the header */
    function stickyMenu()
    {
        const header = document.getElementById('site-navigation');

        window.onscroll = function () {

            if (window.pageYOffset > 20) {
                header.classList.add('fixed');
            }
            else {
                header.classList.remove('fixed');
            }
        }
    }


    /************** DOCUMENT READY **************/

    $(document).ready(function() {

        stickyMenu();

        /* woocommerce: event triggered when cart updated */
		$( document.body ).on( 'updated_cart_totals', function() {
			modify_product_quantity();
		});
		modify_product_quantity();


    }) // END $(doc).ready


})(jQuery);

