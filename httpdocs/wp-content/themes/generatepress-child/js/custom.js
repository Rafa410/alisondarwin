(function($) {

    /* When the user scrolls down, toggle the classes from header and cookie notice */
    function stickyElements() {
        const header = document.getElementById('site-navigation');
        const cookieNotice = document.getElementById('cookie-law-info-bar');
        cookieNotice.classList.add('cookie-notice-custom-hidden');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 20) {
                header.classList.add('fixed');
                cookieNotice.classList.remove('cookie-notice-custom-hidden');
            }
            else {
                header.classList.remove('fixed');
                cookieNotice.classList.add('cookie-notice-custom-hidden');
            }
        })
    }

    /************** DOCUMENT READY **************/

    $(document).ready(function() {

        stickyElements();
        

    })


})(jQuery);
