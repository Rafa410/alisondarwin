<?php

// Devuelve un booleano indicando si la página actual es AMP
function is_amp() {
        return (function_exists( 'is_amp_endpoint' ) && is_amp_endpoint());
}

// Cambios a hacer en páginas AMP
if (is_amp()) {

	/** Quita la pestaña 'sort by' **/
	add_action( 'init', 'gpc_remove_tab_ordering_amp' );
	function gpc_remove_tab_ordering_amp() {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 ); 
	}
	
	/** Override del viewport en páginas AMP, para añadir 'minimum-scale=1' **/
	add_action( 'wp_head', 'generate_add_viewport' );
	function generate_add_viewport() {
		echo apply_filters( 'generate_meta_viewport', '<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1">' ); // WPCS: XSS ok.	
	}	

	/***** Override a la función que genera el menú en el móvil para que sea compatible con AMP *****/
	function generate_navigation_position() {
		?>

		<nav id="site-navigation" <?php generate_do_element_classes( 'navigation' ); ?> <?php generate_do_microdata( 'navigation' ); ?>
		<?php if ( is_amp() ) : ?>
				[class]=" siteNavigationMenuExpanded ? 'main-navigation toggled' : 'main-navigation' "
			<?php endif; ?>
		>

			<?php if ( is_amp() ) : ?>
				<amp-state id="siteNavigationMenuExpanded">
					<script type="application/json">false</script>
				</amp-state>
			<?php endif; ?>

			<div <?php generate_do_element_classes( 'inside_navigation' ); ?>>
				<?php
				/**
				 * generate_inside_navigation hook.
				 *
				 * @since 0.1
				 *
				 * @hooked generate_navigation_search - 10
				 * @hooked generate_mobile_menu_search_icon - 10
				 */
				do_action( 'generate_inside_navigation' );
				?>
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"
				
				<?php if ( is_amp() ) : ?>
					on="tap:AMP.setState( { siteNavigationMenuExpanded: ! siteNavigationMenuExpanded } )"
					[aria-expanded]="siteNavigationMenuExpanded ? 'true' : 'false'"
				<?php endif; ?>
				
				>
					<?php
					/**
					 * generate_inside_mobile_menu hook.
					 *
					 * @since 0.1
					 */
					do_action( 'generate_inside_mobile_menu' );

					generate_do_svg_icon( 'menu-bars', true );

					$mobile_menu_label = apply_filters( 'generate_mobile_menu_label', __( 'Menu', 'generatepress' ) );

					if ( $mobile_menu_label ) {
						printf(
							'<span class="mobile-menu">%s</span>',
							$mobile_menu_label
						);
					} else {
						printf(
							'<span class="screen-reader-text">%s</span>',
							__( 'Menu', 'generatepress' )
						);
					}
					?>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container' => 'div',
						'container_class' => 'main-nav',
						'container_id' => 'primary-menu',
						'menu_class' => '',
						'fallback_cb' => 'generate_menu_fallback',
						'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', generate_get_element_classes( 'menu' ) ) . '">%3$s</ul>',
					)
				);

				/**
				 * generate_after_primary_menu hook.
				 *
				 * @since 2.3
				 */
				do_action( 'generate_after_primary_menu' );
				?>
			</div><!-- .inside-navigation -->
		</nav><!-- #site-navigation -->

		<?php
	} // END fuction generate_navigation_position()
	
	// Elimina el plugin cookie-law-info de las páginas AMP
	add_filter( 'cli_show_cookie_bar_only_on_selected_pages', 'gpc_filter_cookie_law_info_amp');
	function gpc_filter_cookie_law_info_amp($notify_html) {
		$notify_html = '';
		return $notify_html;
	}

	add_filter( 'woocommerce_add_to_cart_redirect', 'gpc_redirect_checkout_add_to_cart' );
	function gpc_redirect_checkout_add_to_cart( $url ) { // TODO: Comprobar si queda stock
		$url = get_permalink( get_option( 'woocommerce_cart_page_id' ) );
		return $url;
	}

	// Devuelve la información de disponibilidad (si está en stock) para cada variación del producto en formato JSON
	function gpc_get_variations_availability_json() {
		
		global $product; // Woocommerce global variable
		
		$variations_are_in_stock = []; // Array to store the variations availability
		
		foreach ( $product->get_available_variations() as $variation ) { // Loop through all available variations
			
			/*$variation_id = $variation['variation_id']; // Get variation ID
			$variation_obj = new WC_Product_variation( $variation_id ); // Create new Product Variation Object with variation ID
			$variation_attributes = implode( $variation_obj->get_variation_attributes() ); // Get variation name from Object
			*/
			$variation_attributes = implode ($variation['attributes'] );

			$variations_are_in_stock[$variation_attributes] = $variation['is_in_stock']; // $variation['is_in_stock'] return boolean
			

		}

		return json_encode( $variations_are_in_stock ); // Returns an array with variations availabililty encoded in JSON format 

	}
	
	// Añade a la etiqueta <select> el atributo AMP "on" para asignar el valor seleccionado a la variable currentVariation
	add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'gpc_add_amp_attributes_select' );
	function gpc_add_amp_attributes_select( $html ) {
		$html = str_replace( '<select', '<select on="change:AMP.setState({currentVariation: event.value})"', $html);
		return $html;
	}

	// NEXT

} // END is_amp()

// Sobreescribe el script del plugin Multi Step Checkout
add_action( 'wp_enqueue_scripts', 'gpc_override_multistep_checkout_script', 100 );
function gpc_override_multistep_checkout_script() {
	if (is_checkout()) {
		wp_dequeue_script ( 'wpmc' );
		wp_enqueue_script( 'multistep_checkout', get_stylesheet_directory_uri().'/js/multistep-checkout.min.js', array( 'jquery' ), '1.1' , true );
	}
}	

/*
// Añade el formulario de registro al plugin WP Multi step checkout
function add_registration_form_wpmc() {
	echo '<p class="testing">test</p>';
}
add_action( 'wmsc_step_content_login', 'add_registration_form_wpmc' , 15); 
*/

// Cambiar el tipo de algunos de los campos en el checkout de WooCommerce
add_filter('woocommerce_checkout_fields','gpc_change_field_type_checkout');
function gpc_change_field_type_checkout($fields){
    $fields['billing']['billing_postcode']['type'] = 'tel';
	$fields['shipping']['shipping_postcode']['type'] = 'tel';
    return $fields;
}

// Override function que añade la etiqueda de envío gratis en el resumen de carrito y en el checkout
function woocommerce_free_shipping_label( $method ) {
	$has_cost  = 0 < $method->cost;
	$hide_cost = $has_cost && in_array( $method->get_method_id(), array( 'free_shipping', 'local_pickup' ), false );
	if ( ! $has_cost && ! $hide_cost ) {
		echo ' <i class="free-shipping">¡Gratis!</i> ';	
	}
}


// Genera un footer personalizado
add_action( 'generate_footer', 'gpc_generate_custom_footer' );
function gpc_generate_custom_footer() {
	
	?>
		<footer class="site-info" <?php generate_do_microdata( 'footer' ); ?>>
			<div class="inside-site-info <?php if ( 'full-width' !== generate_get_option( 'footer_inner_width' ) ) : ?>grid-container grid-parent<?php endif; ?>">
				<?php
				/**
				 * generate_before_copyright hook.
				 * @hooked generate_footer_bar - 15
				 */
				do_action( 'generate_before_copyright' );
				?>
				<div class="copyright-bar">
					<span class="copyright">© <?php echo date('Y'); ?> Tienda Oficial alison DARWIN</span>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	
}

// Quita los dashicons si no se muestra la barra de admin
add_action( 'wp_print_styles', function() {
    if (!is_admin_bar_showing()) wp_deregister_style( 'dashicons' );
}, 100);


?>
