<?php	/* store.alisondarwin.com */


// Carga scripts personalizados
add_action( 'wp_enqueue_scripts', 'gcp_custom_scripts');
function gcp_custom_scripts() {
	
	// Script to load on all pages
	wp_register_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom.min.js', array('jquery'), '1.6', true );
	wp_enqueue_script( 'custom-script' );	

	if ( is_cart() ) { // Scripts to load on cart page
		wp_register_script( 'custom-cart-script', get_stylesheet_directory_uri() . '/js/custom-cart.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'custom-cart-script' );
	}

}

// Quita la pestaña 'sort by'
add_action( 'init', 'gpc_remove_tab_ordering_amp' );
function gpc_remove_tab_ordering_amp() {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 ); 
}

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
add_action( 'woocommerce_after_shipping_rate', 'woocommerce_free_shipping_label' ); 
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
					<span class="copyright">© <?php echo date('Y'); ?> <a href="https://store.alisondarwin.com">Tienda Oficial alison DARWIN</a></span>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	
}

// Quita los dashicons si no se muestra la barra de admin
add_action( 'wp_print_styles', function() {
    if ( ! is_admin_bar_showing() ) {
		wp_deregister_style( 'dashicons' );
	}
}, 100);


// Elimina los iconos que carga el plugin WP Menu Cart
add_action( 'wp_enqueue_scripts', 'gpc_remove_fontawesome', 20 );
function gpc_remove_fontawesome() {
	wp_dequeue_style( 'wpmenucart-icon' );
	wp_deregister_style( 'wpmenucart-icon' );

	wp_dequeue_style( 'wpmenucart-fontawesome' );
	wp_deregister_style( 'wpmenucart-fontawesome' );
}


// Añade los datos estructurados 'mpn' y 'brand' a los productos
add_filter( 'woocommerce_structured_data_product', 'gpc_add_structured_data_product' );
function gpc_add_structured_data_product( $markup ) {
	$markup['mpn'] = $markup['sku'];
	$markup['brand'] = 'alison DARWIN';

	return $markup;
}

// Sobreescribe la función que añade el campo de cupon en el checkout para no mostrarlo (los cupones se pueden añadir desde el carrito).
function woocommerce_checkout_coupon_form() {
	return;
}


// Genera un icono de carrito en SVG con el tamaño y color indicado
function gpc_svg_cart_icon($width = 25, $height = 25, $color = '#fff') {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="' . $color . '" viewBox="0 0 512 512"><path d="m164.960938 300.003906h.023437c.019531 0 .039063-.003906.058594-.003906h271.957031c6.695312 0 12.582031-4.441406 14.421875-10.878906l60-210c1.292969-4.527344.386719-9.394532-2.445313-13.152344-2.835937-3.757812-7.269531-5.96875-11.976562-5.96875h-366.632812l-10.722657-48.253906c-1.527343-6.863282-7.613281-11.746094-14.644531-11.746094h-90c-8.285156 0-15 6.714844-15 15s6.714844 15 15 15h77.96875c1.898438 8.550781 51.3125 230.917969 54.15625 243.710938-15.941406 6.929687-27.125 22.824218-27.125 41.289062 0 24.8125 20.1875 45 45 45h272c8.285156 0 15-6.714844 15-15s-6.714844-15-15-15h-272c-8.269531 0-15-6.730469-15-15 0-8.257812 6.707031-14.976562 14.960938-14.996094zm312.152343-210.003906-51.429687 180h-248.652344l-40-180zm0 0"></path><path d="m150 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"></path><path d="m362 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"></path></svg>';
}

// Añade un icono de carrito en svg al boton del carrito en la barra superior
add_filter( 'wpmenucart_menu_item_a_content', 'gpc_modify_cart_icon', 10, 4 );
function gpc_modify_cart_icon( $menu_item_a_content, $menu_item_icon, $cart_contents, $item_data ) {
	$menu_item_icon = gpc_svg_cart_icon();
	$cart_contents = $item_data['cart_contents_count'];
	$menu_item_a_content = $menu_item_icon . '<span class="cartcontents">' . $cart_contents . '</span>';
	
	return $menu_item_a_content;
}

$gpc_wpmenucart_menu_item_li = '';

// apply_filters( 'wpmenucart_menu_item_wrapper', $menu_item_li )
$gpc_change_position_cart = function ( $menu_item_li ) use ( &$gpc_wpmenucart_menu_item_li ) {
	$gpc_wpmenucart_menu_item_li = $menu_item_li;
	echo '<p hidden>' . $gpc_wpmenucart_menu_item_li . '</p>';
	return '';
};
add_filter( 'wpmenucart_menu_item_wrapper', $gpc_change_position_cart );

// Añade el logo al menu del header
$gpc_generate_menu_logo = function() use ( &$gpc_wpmenucart_menu_item_li ) {
	$html = '<div class="logo-menu"><a href="https://store.alisondarwin.com"><h1>alison DARWIN</h1></a></div>';
	$html .= $gpc_wpmenucart_menu_item_li;
	echo $html;
};
add_action( 'generate_inside_navigation' , $gpc_generate_menu_logo, 100 );


// Quita el texto "Menú" del header 
add_filter( 'generate_mobile_menu_label', 'gpc_remove_text_menu' );
function gpc_remove_text_menu( $text ) {
	$text = '';
	return $text;
}

// Cambia los iconos SVG del menu por iconos CSS
// $output = apply_filters( 'generate_svg_icon_element', $output, $icon ); [navigation.php]
add_filter( 'generate_svg_icon_element', 'gpc_modify_menu_icon', 10, 2 );
function gpc_modify_menu_icon($output, $icon) {
	if ($icon == 'menu-bars') {
		$output = '<span></span><span></span><span></span><span></span>';
	}
	return $output;
}


add_action( 'woocommerce_after_quantity_input_field', 'gpc_wc_add_vertical_qty_button' );
function gpc_wc_add_vertical_qty_button() {
	?>

	<span class="vertical-buttons">
		<span class="plus quantity-btn">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 306 306" xmlns:v="https://vecta.io/nano"><path d="M35.7 247.35L153 130.05l117.3 117.3 35.7-35.7-153-153-153 153z"></path></svg>
		</span>
		<span class="minus quantity-btn">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 306 306" xmlns:v="https://vecta.io/nano"><path d="M35.7 58.65L153 175.95l117.3-117.3 35.7 35.7-153 153-153-153z"></path></svg>
		</span>
	</span>

	<?php
}

// Oculta los campos de dirección de envío adicional hasta que el usuario pulse en el botón "Enviar a una dirección diferente"
// apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 )
add_filter( 'woocommerce_ship_to_different_address_checked', 'gpc_wc_hide_shipping_address');
function gpc_wc_hide_shipping_address() {
	return 0;
}

// apply_filters( 'woocommerce_product_single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $this );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'gpc_wc_add_to_cart_icon' );
function gpc_wc_add_to_cart_icon( $text ) {
	echo gpc_svg_cart_icon() . $text;
}


/*********** AMP ***********/

// Devuelve un booleano indicando si la página actual es AMP
function is_amp() {
	return (function_exists( 'is_amp_endpoint' ) && is_amp_endpoint());
}

// Cambios a hacer en páginas AMP
// add_action( 'wp', 'gcp_amp_changes' );
// function gcp_amp_changes() {

	if (is_amp()) {

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
			// global $product;
			// if( $product->is_in_stock() ) { }
			$url = get_permalink( get_option( 'woocommerce_cart_page_id' ) );
			return $url;
		}

		// Devuelve la información de disponibilidad (si está en stock) para cada variación del producto en formato JSON
		function gpc_get_variations_availability_json() {
			
			global $product; // Woocommerce global variable
			
			$variations_are_in_stock = []; // Array to store the variations availability
			
			foreach( $product->get_available_variations() as $variation ) { // Loop through all available variations
				
				$variation_attributes = implode ($variation['attributes'] ); // Get all attributes for variations

				$variations_are_in_stock[$variation_attributes] = $variation['is_in_stock']; // Array of bools specifying if a variations has stock or not.
				
			}

			return json_encode( $variations_are_in_stock ); // Returns an array with variations availabililty encoded in JSON format 

		}

		// Añade a la etiqueta <select> el atributo AMP "on" para asignar el valor seleccionado a la variable currentVariation
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'gpc_add_amp_attributes_select' );
		function gpc_add_amp_attributes_select( $html ) {
			$html = str_replace( '<select', '<select on="change:AMP.setState({currentVariation: event.value})"', $html);
			return $html;
		}

		// TODO: No funciona con 2 variaciones, hay que concatenarlas
		add_action( 'woocommerce_after_add_to_cart_quantity', 'gpc_wc_amp_add_product_availability' );
		function gpc_wc_amp_add_product_availability() {
			global $product;
			if ( $product->is_type( 'variable' ) ) :
			?>
			
			<amp-state id="variations_availability">
				<script type="application/json"><?php echo gpc_get_variations_availability_json(); ?></script>
			</amp-state>	
		
			<p class="stock out-of-stock" hidden [hidden]="variations_availability[currentVariation]">Agotado</p>
			
			<?php endif;
		}

		

		// Quita el atributo 'action' en las paginas traducidas AMP para solucionar el error: "The attribute 'action' may not appear in tag 'FORM [method=POST]'".
		// apply_filters( 'trp_translated_html', $final_html, $TRP_LANGUAGE, $language_code, $preview_mode );
		add_filter( 'trp_translated_html', 'gpc_amp_remove_action_attribute' );
		function gpc_amp_remove_action_attribute( $final_html ) {
			$final_html = str_replace( 'action=""', '', $final_html );
			return $final_html;
		}


	} // END is_amp()

	

?>
