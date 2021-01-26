jQuery(window).ready(function($){
    "use strict";

	var wpmc_checkout = {
		$tabs			: $( '.wpmc-tab-item' ),
		$sections		: $( '.wpmc-step-item' ),
		$buttons		: $( '.wpmc-nav-button' ),
		$checkout_form	: $( 'form.woocommerce-checkout' ),
		$coupon_form	: $( '#checkout_coupon' ),
		$before_form	: $( '#woocommerce_before_checkout_form' ),

		init: function() {
			var self = this;

			// add the "wpmc_switch_tab" trigger
			$( '.woocommerce-checkout' ).on( 'wpmc_switch_tab', function( event, theIndex) {
				self.switch_tab( theIndex );
			});

			$( '.wpmc-step-item:first' ).addClass( 'current' );

			// Click on "next" button
			$( '#wpmc-next, #wpmc-skip-login').on( 'click', function() {
				self.switch_tab( self.current_index() + 1);
			});

			// Click on "previous" button
			$( '#wpmc-prev' ).on( 'click', function() {
				self.switch_tab( self.current_index() - 1);
			});

			// After submit, switch tabs where the invalid fields are
			$( document ).on( 'checkout_error', function() {

				if ( ! $( '#createaccount' ).is( ':checked') ) {
					$( '#account_password_field, #account_username_field' ).removeClass( 'woocommerce-invalid-required-field' );
				}

				if ( ! $( '#ship-to-different-address-checkbox' ).is( ':checked' ) ) {
					$( '.woocommerce-shipping-fields__field-wrapper p' ).removeClass( 'woocommerce-invalid-required-field' );
				}

				var section_class = $( '.woocommerce-invalid-required-field' ).closest( '.wpmc-step-item' ).attr( 'class' );

				$( '.wpmc-step-item' ).each( function( i ) {
					if ( $( this ).attr( 'class' ) === section_class ) {
						self.switch_tab(i)
					}
				})
			});

			// Clickable tabs
			$(self.$tabs).on("click", function () {
				if ($(this).hasClass("current")) {
					return;
				}
				if (self.current_index() < $(this).index() - 1) {
					return;
				}
				self.switch_tab($(this).index());
			});

			// Compatibility with Super Socializer
			if ( $( '.the_champ_sharing_container' ).length > 0 ) {
				$( '.the_champ_sharing_container' ).insertAfter( $( this ).parent().find( '#checkout_coupon' ) );
			}

			// Prevent form submission on Enter
			$( '.woocommerce-checkout' ).on( 'keydown', function( e ) {
				if ( e.which === 13 ) {
					e.preventDefault();
					return false;
				}
			});

			// "Back to Cart" button
			$( '#wpmc-back-to-cart' ).on( 'click', function() {
				window.location.href = $( this ).data( 'href' ); 
			});

			// Switch tabs with <- and -> keyboard arrows
			//if ( WPMC.keyboard_nav === '1' ) { // Error: WPMC undefined
				$( document ).on( 'keydown', function ( e ) {
				  var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
				  if ( key === 39 ) {
					  self.switch_tab( self.current_index() + 1 );
				  }
				  if ( key === 37 ) {
					  self.switch_tab( self.current_index() - 1 );
				  }
				});
			//}

			// Change tab if the hash #step-0 is present in the URL
			if ( window.location.hash ) {
				changeTabOnHash( window.location.hash );
			}
			$( window ).on( 'hashchange', function() { 
				changeTabOnHash( window.location.hash ) 
			} ); 
			function changeTabOnHash( hash ) {
				if ( /step-[0-9]/.test( hash ) ) {
					var step = hash.match( /step-([0-9])/ )[1];
					self.switch_tab( step );
				}
			}


			/***** Switch tabs on swipe (only touch screen devices) ****/

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
						self.switch_tab(self.current_index() - 1);
					}
					else if (swipedir == 'left') {
						self.switch_tab(self.current_index() + 1);
					}

				})

			}	/***** END Switch tabs on swipe *****/


		},
		current_index: function() {

			return this.$sections.index( this.$sections.filter( '.current' ) );
		},
		scroll_top: function() {
			// scroll to top
			if ( $( '.wpmc-tabs-wrapper' ).length === 0 ) {
				return;
			}

			var diff = $( '.wpmc-tabs-wrapper' ).offset().top - $( window ).scrollTop();
			var scroll_offset = 70;
			/*if (typeof WPMC.scroll_top !== 'undefined') { // Error: WPMC undefined
				scroll_offset = WPMC.scroll_top;
			}*/
			if ( diff < -40 ) {
				$( 'html, body' ).animate({
					scrollTop: $( '.wpmc-tabs-wrapper' ).offset().top - scroll_offset, 
				}, 800);
			}
		},
		switch_tab: function( theIndex ) {
			var self = this;

			$( '.woocommerce-checkout' ).trigger( 'wpmc_before_switching_tab' );

			if ( theIndex < 0 || theIndex > this.$sections.length - 1 ) {
				return false;
			}

			this.scroll_top(); 
		
			$( 'html, body' ).promise().done( function() {

				self.$tabs.removeClass( 'previous' ).filter( '.current' ).addClass( 'previous' );
				self.$sections.removeClass( 'previous' ).filter( '.current' ).addClass( 'previous' );
				$( '.woocommerce-NoticeGroup-checkout:not(wpmc-error)' ).show();

				// Change the tab
				self.$tabs.removeClass( 'current' );
				self.$tabs.eq( theIndex ).addClass( 'current' );
			 
				// Change the section
				self.$sections.removeClass( 'current' );
				self.$sections.eq( theIndex ).addClass( 'current' );

				// Which buttons to show?
				self.$buttons.removeClass( 'current' );
				self.$checkout_form.addClass( 'processing' );
				self.$coupon_form.hide();
				self.$before_form.hide();

				// Show "next" button 
				if ( theIndex < self.$sections.length - 1 ) {
					$( '#wpmc-next' ).addClass( 'current' );
				}

				// Show "skip login" button
				if ( theIndex === 0 && $( '.wpmc-step-login' ).length > 0 ) {
					$( '#wpmc-skip-login').addClass( 'current' );
					$( '#wpmc-next' ).removeClass( 'current' );
					$( '.woocommerce-NoticeGroup-checkout:not(wpmc-error)' ).hide();
				}

				// Last section
				if ( theIndex === self.$sections.length - 1 ) {
					$( '#wpmc-prev' ).addClass( 'current' );
					$( '#wpmc-submit' ).addClass( 'current' );
					self.$checkout_form.removeClass( 'processing' ).unblock();
				}

				// Show "previous" button 
				if ( theIndex != 0 ) {
					$( '#wpmc-prev' ).addClass( 'current' );
				}


				if ( $( '.wpmc-step-review.current' ).length > 0 ) {
					self.$coupon_form.show();
				}

				if ( $( '.wpmc-' + self.$before_form.data( 'step' ) + '.current' ).length > 0 ) {
					self.$before_form.show();
				}

				$( '.woocommerce-checkout' ).trigger( 'wpmc_after_switching_tab' );
			});
		}
	}
	wpmc_checkout.init();
});
