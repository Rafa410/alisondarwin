(function($) {

    /* Modify product quantity with '-' and '+' icons */
    function modify_product_quantity() {
        let timeout;

        $( ".minus" ).on( 'click', function() {
            var $input = $( this ).parent().find( 'input.qty' ),
                minVal = $input.prop( 'min' ),
                currVal = parseInt( $input.val(), 10 );

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
                $input.trigger( 'updated_addons' );
            }, 500);

            /* Cart page: Enable button 'update cart' when quantity changed */
            $( "[name='update_cart']" ).prop( "disabled", false );
        });

        $( ".plus" ).on( 'click', function() {
            var $input = $( this ).parent().find( 'input.qty' ),
                currVal = parseInt( $input.val(), 10 ),
                max = parseInt( $input.prop( 'max' ) );

            if (timeout) {
                clearTimeout(timeout);
            }

            if( currVal >= max ) {
                return;
            }

            $input.val( currVal + 1 ).trigger( 'change' );

            timeout = setTimeout(function() {
                $input.trigger( 'updated_addons' );
            }, 500);

            /* Cart page: Enable button 'update cart' when quantity changed */
            $( "[name='update_cart']" ).prop( "disabled", false );
        });

    }




    /************** DOCUMENT READY **************/

    $(document).ready(function() {

        /* woocommerce: event when update cart total */
		$( document.body ).on( 'updated_cart_totals', function() {
			modify_product_quantity();
		});

		modify_product_quantity();



    }) // END $(doc).ready


})(jQuery);

