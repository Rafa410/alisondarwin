jQuery(window).ready(function ($) {
    "use strict";

    var tabs = $('.wpmc-tab-item');
    var sections = $('.wpmc-step-item');
    var buttons = $('.wpmc-nav-buttons .button');
    var checkout_form = $('form.woocommerce-checkout');
    var coupon_form = $('#checkout_coupon');
    var before_form = $('#woocommerce_before_checkout_form');

    $('.wpmc-step-item:first').addClass('current');

    // Find the current index
    function currentIndex() {
        return sections.index(sections.filter('.current'));
    }

    // Click on "next" button
    $('#wpmc-next, #wpmc-skip-login').on('click', function () {
        switchTab(currentIndex() + 1);
    });

    // Click on "previous" button
    $('#wpmc-prev').on('click', function () {
        switchTab(currentIndex() - 1);
    });

    // After submit, switch tabs where the invalid fields are
    $(document).on('checkout_error', function () {
        var section_class = $('.woocommerce-invalid-required-field').closest('.wpmc-step-item').attr('class');
        $('.wpmc-step-item').each(function (i) {
            if ($(this).attr('class') === section_class) {
                switchTab(i)
            }
        })
    });

    // Clickable tabs
        $(".wpmc-tab-item").on("click", function () {
            if ($(this).hasClass("current")) return;
            if (currentIndex() < $(this).index() - 1 && !$(this).hasClass("visited")) return;
            switchTab($(this).index());
        });

    // Switch the tab
    function switchTab(theIndex) {

        $('.woocommerce-checkout').trigger('wpmc_before_switching_tab');

        if (theIndex < 0 || theIndex > sections.length - 1) return false;

        // scroll to top
        var diff = $('.wpmc-tabs-wrapper').offset().top - $(window).scrollTop();
        if (diff < -40) {
            $('html, body').animate({
                scrollTop: $('.wpmc-tabs-wrapper').offset().top - 70,
            }, 800);
        }

        $('html, body').promise().done(function () {

            tabs.removeClass('previous').filter('.current').addClass('previous');
            sections.removeClass('previous').filter('.current').addClass('previous');

            // Change the tab
            tabs.removeClass('current', { duration: 500 });
            tabs.eq(theIndex).addClass('current', { duration: 500 });

            // Change the section
            sections.removeClass('current', { duration: 500 });
            sections.eq(theIndex).addClass('current', { duration: 500 });

            // Which buttons to show?
            buttons.removeClass('current');
            checkout_form.addClass('processing');
            coupon_form.hide();
            before_form.hide();

            // Show "next" button 
            if (theIndex < sections.length - 1) $('#wpmc-next').addClass('current');

            // Show "skip login" button
            if (theIndex === 0 && $('.wpmc-step-login').length > 0) {
                $("#wpmc-skip-login").addClass('current');
                $("#wpmc-next").removeClass('current');
            }
            // Last section
            if (theIndex === sections.length - 1) {
                $("#wpmc-prev").addClass('current');
                $('#wpmc-submit').addClass('current');
                checkout_form.removeClass('processing').unblock();
            }
            // Show "previous" button 
            if (theIndex != 0) $('#wpmc-prev').addClass('current');



            if ($('.wpmc-step-review.current').length > 0) {
                coupon_form.show();
            }

            if ($('.wpmc-' + before_form.data('step') + '.current').length > 0) {
                before_form.show();
            }

            $('.woocommerce-checkout').trigger('wpmc_after_switching_tab');

        });


    }


    // Compatibility with Super Socializer
    if ($('.the_champ_sharing_container').length > 0) {
        $('.the_champ_sharing_container').insertAfter($(this).parent().find('#checkout_coupon'));
    }

    // Prevent form submission on Enter
    $('.woocommerce-checkout').keydown(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            return false;
        }
    });

    // "Back to Cart" button
    $('#wpmc-back-to-cart').click(function () {
        window.location.href = $(this).data('href');
    });

    // Switch tabs with <- and -> keyboard arrows
    /*if (WPMC.keyboard_nav == '1') {*/ // Error: WPMC is not defined
        $(document).keydown(function (e) {
            var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
            if (key === 39) {
                switchTab(currentIndex() + 1);
            }
            if (key === 37) {
                switchTab(currentIndex() - 1);
            }
        });
    //}


    ///// Switch tabs on swipe (only touch screen devices) /////

    function is_touch_enabled() { // Detects touch screen devices
        return ('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0);
    }

    if (is_touch_enabled()) {

        function swipedetect(el, callback) {

            const threshold = 80, //required min distance traveled to be considered swipe
            restraint = 40, // maximum distance allowed at the same time in perpendicular direction
            allowedTime = 350; // maximum time allowed to travel that distance

            var touchsurface = el,
            swipedir,
            startX,
            startY,
            distX,
            distY,
            elapsedTime,
            startTime,
            handleswipe = callback || function (swipedir) { }

            touchsurface.addEventListener('touchstart', function (e) {

                var touchobj = e.changedTouches[0];

                swipedir = 'none'
                // dist = 0
                startX = touchobj.pageX
                startY = touchobj.pageY
                startTime = new Date().getTime() // record time when finger first makes contact with surface
                // e.preventDefault()

            }, false)

            //touchsurface.addEventListener('touchmove', function (e) {
            //    e.preventDefault() // prevent scrolling when inside div
            //}, false)

            touchsurface.addEventListener('touchend', function (e) {

                var touchobj = e.changedTouches[0];

                distX = touchobj.pageX - startX // get horizontal dist traveled by finger while in contact with surface
                distY = touchobj.pageY - startY // get vertical dist traveled by finger while in contact with surface
                elapsedTime = new Date().getTime() - startTime // get time elapsed

                if (elapsedTime <= allowedTime) { // first condition for swipe met
                    if (Math.abs(distX) >= threshold && Math.abs(distY) <= restraint) { // 2nd condition for horizontal swipe met
                        swipedir = (distX < 0) ? 'left' : 'right' // if dist traveled is negative, it indicates left swipe
                    }
                    //else if (Math.abs(distY) >= threshold && Math.abs(distX) <= restraint) { // 2nd condition for vertical swipe met
                    //    swipedir = (distY < 0) ? 'up' : 'down' // if dist traveled is negative, it indicates up swipe
                    //}
                }

                handleswipe(swipedir);
                // e.preventDefault();

            }, false)
        }

        //USAGE:
            /*
            var el = document.getElementById('someel')
            swipedetect(el, function(swipedir){
                // swipedir contains either "none", "left", "right", "top", or "down"
                if (swipedir =='left')
                    alert('You just swiped left!')
            })
            */
        const el = document.getElementById('content');

        swipedetect(el, function (swipedir) {

            if (swipedir == 'right') {
                switchTab(currentIndex() - 1);
            }
            else if (swipedir == 'left') {
                switchTab(currentIndex() + 1);
            }

        })

    }

    /// END Switch tabs on swipe ///

});
