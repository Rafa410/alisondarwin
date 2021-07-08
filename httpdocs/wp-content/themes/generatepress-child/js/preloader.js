(function($) {
        
    $(document).ready(function ($) {
        const $preloader = $( '#preloader' );
        const $section = $( '.portada-section' );

        if ( $section.length ) {

            const $src = $section
                            .css( 'background-image' )
                            .replace( 'url("', '' )
                            .replace( '")', '' );
        
            $('<img/>').attr( 'src', $src ).on( 'load', function() { 
                $(this).remove(); // Prevent memory leaks
    
                $preloader.fadeOut();
                setTimeout(function() {
                    $preloader.remove();
                }, 2000);  
    
            }).each(function() { // Check if image was loaded before attaching event listener or via Service Worker
                if ( 
                    $( this ).prop( 'complete' ) &&
                    0 !== $( this ).prop( 'naturalWidth')
                ) {
                    $( this ).load();
                }
            });
        }
        else {
            $preloader.fadeOut();
            setTimeout(function() {
                $preloader.remove();
            }, 2000);  
        }

        $(window).on('load', () => $preloader.fadeOut()) // Just in case image load fails

    });

}(jQuery));