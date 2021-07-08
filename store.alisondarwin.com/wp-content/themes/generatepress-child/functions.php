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

// Añade Google Tag Manager al head
add_action( 'wp_head', 'gpc_load_google_tag_manager', 100 );
function gpc_load_google_tag_manager() {
	?>
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'/wp-content/themes/generatepress-child/js/external-js/gtm.js';f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MT9LNBG');</script>
	<!-- End Google Tag Manager -->

	<?php
}

// Añade Google Tag Manager (noscript) y selector de idioma al inicio del <body>
add_action( 'wp_body_open', 'gpc_body_open_content', 1 );
function gpc_body_open_content() {
	?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MT9LNBG"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<aside id="language-switcher">
		<div class="grid-container">
					
			<?php 
				$current_language = get_locale();
				if (substr($current_language, 0, 2) == 'en') {
					echo '<i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="30" height="25"><g fill="#c8414b"><path d="M0 385c0 22 17 39 38 39h436c21 0 38-17 38-39v-32H0v32zM474 88H38c-21 0-38 17-38 39v32h512v-32c0-22-17-39-38-39z"/></g><path fill="#ffd250" d="M0 159h512v194H0z"/><path d="M216 256l8-34c0-3-2-6-5-6h-5c-4 0-6 3-5 6l7 34z" fill="#c8414b"/><path fill="#f5f5f5" d="M207 238h18v75h-18z"/><path fill="#fab446" d="M203 230h27v8h-27z"/><g fill="#c8414b"><path d="M185 256h45v9h-45zM230 291l-27-9v-8l27 8zM84 256l7-34c1-3-1-6-5-6h-5c-3 0-5 3-5 6l8 34z"/></g><path d="M115 230c-5 0-9 3-9 8v58c0 10 10 31 44 31s44-21 44-31v-58c0-5-4-8-9-8h-70z" fill="#f5f5f5"/><g fill="#c8414b"><path d="M150 274h-44v-36c0-5 4-8 9-8h35v44zM150 274h44v22a22 22 0 01-44 0v-22z"/></g><path d="M106 274h44v22a22 22 0 01-44 0v-22z" fill="#fab446"/><g fill="#c8414b"><path d="M141 313v-39h-9v43c4 0 7-2 9-4zM124 317v-43h-9v39c2 2 5 4 9 4z"/></g><path fill="#ffb441" d="M115 256h26v9h-26z"/><g fill="#fab446"><path d="M115 238h26v9h-26z"/><path d="M119 244h18v16h-18z"/></g><path fill="#f5f5f5" d="M75 238h18v75H75z"/><g fill="#fab446"><path d="M71 309h26v9H71zM71 230h26v8H71z"/></g><path fill="#5064aa" d="M66 318h36v9H66z"/><path fill="#fab446" d="M207 309h27v9h-27z"/><path fill="#5064aa" d="M199 318h35v9h-35z"/><path fill="#fab446" d="M124 221h53v9h-53z"/><path fill="#ffb441" d="M146 194h9v27h-9z"/><g fill="#f5f5f5"><path d="M141 207a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 9 4 4 0 000-9z"/><path d="M159 207a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 9 4 4 0 000-9z"/><path d="M177 216a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 8 4 4 0 000-8zM124 216a13 13 0 110-26 13 13 0 010 26zm0-17a4 4 0 100 8 4 4 0 000-8z"/></g><path d="M177 291v5a4 4 0 01-9 0v-5h9m8-9h-26v14a13 13 0 0026 0v-14z" fill="#fab446"/><path d="M172 265c-5 0-9-4-9-9v-9c0-5 4-9 9-9s9 4 9 9v9c0 5-4 9-9 9z" fill="#ffa0d2"/><circle cx="150.1" cy="273.6" r="13.2" fill="#5064aa"/><path fill="#fab446" d="M146 177h9v26h-9z"/><path d="M124 221l-9-9 5-5c8-8 19-13 30-13s22 5 30 13l5 5-8 9h-53z" fill="#c8414b"/><g fill="#ffd250"><circle cx="150.1" cy="211.9" r="4.4"/><circle cx="132.4" cy="211.9" r="4.4"/><circle cx="167.7" cy="211.9" r="4.4"/></g><g fill="#c8414b"><path d="M71 256h44v9H71zM71 291l26-9v-8l-26 8z"/></g></svg></i>';
				}
				else if ( (substr($current_language, 0, 2) == 'es') || (substr($current_language, 3) == 'ES') ) {
					echo '<i><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30" width="30" height="15"><clipPath id="a"><path d="M0 0v30h60V0z"/></clipPath><clipPath id="b"><path d="M30 15h30v15zv15H0zH0V0zV0h30z"/></clipPath><g clip-path="url(#a)"><path d="M0 0v30h60V0z" fill="#012169"/><path d="M0 0l60 30m0-30L0 30" stroke="#fff" stroke-width="6"/><path d="M0 0l60 30m0-30L0 30" clip-path="url(#b)" stroke="#C8102E" stroke-width="4"/><path d="M30 0v30M0 15h60" stroke="#fff" stroke-width="10"/><path d="M30 0v30M0 15h60" stroke="#C8102E" stroke-width="6"/></g></svg></i>';
				}
			?>		

			<span>Do you want to switch to the English website?</span>
			<svg id="switch-language" fill="#00b100" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M0 12.116l2.053-1.897c2.401 1.162 3.924 2.045 6.622 3.969 5.073-5.757 8.426-8.678 14.657-12.555l.668 1.536c-5.139 4.484-8.902 9.479-14.321 19.198-3.343-3.936-5.574-6.446-9.679-10.251z"></path></svg>
			<svg id="close-language-switcher" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="20" height="20"><path fill="#f15b6c" d="M82 25.275L74.726 18.001 50 42.727 25.276 17.996 18.003 25.268 42.727 50 18 74.727 25.274 82.001 50 57.275 74.722 82.003 81.996 74.732 57.273 50.002z"></path><path fill="#1f212b" d="M74.722,83.003L74.722,83.003c-0.265,0-0.52-0.105-0.707-0.293L50,58.689l-24.02,24.019c-0.391,0.391-1.023,0.391-1.414,0l-7.274-7.274c-0.391-0.391-0.391-1.023,0-1.414L41.313,50L17.296,25.975c-0.391-0.391-0.391-1.024,0-1.414l7.273-7.271c0.188-0.188,0.442-0.293,0.707-0.293l0,0c0.265,0,0.52,0.105,0.707,0.293L50,41.312l24.019-24.019c0.391-0.391,1.023-0.391,1.414,0l7.274,7.274c0.391,0.391,0.391,1.023,0,1.414l-24.02,24.02l24.016,24.023c0.391,0.391,0.391,1.024,0,1.414l-7.273,7.271C75.242,82.898,74.987,83.003,74.722,83.003z M50,56.275L50,56.275c0.265,0,0.52,0.105,0.707,0.293l24.015,24.021l5.859-5.857L56.566,50.709c-0.391-0.391-0.391-1.023,0-1.414l24.02-24.02l-5.86-5.86L50.707,43.434c-0.188,0.188-0.442,0.293-0.707,0.293l0,0c-0.265,0-0.52-0.105-0.707-0.293L25.276,19.411l-5.859,5.857l24.018,24.024c0.391,0.391,0.391,1.023,0,1.414L19.414,74.727l5.86,5.86l24.02-24.019C49.481,56.38,49.735,56.275,50,56.275z"></path><path fill="#1f212b" d="M74.5 75c-.128 0-.256-.049-.354-.146l-1-1c-.195-.195-.195-.512 0-.707s.512-.195.707 0l1 1c.195.195.195.512 0 .707C74.756 74.951 74.628 75 74.5 75zM71.5 72c-.128 0-.256-.049-.354-.146l-2-2c-.195-.195-.195-.512 0-.707s.512-.195.707 0l2 2c.195.195.195.512 0 .707C71.756 71.951 71.628 72 71.5 72zM67.5 68c-.128 0-.256-.049-.354-.146l-17.5-17.5c-.195-.195-.195-.512 0-.707l21.5-21.5c.195-.195.512-.195.707 0s.195.512 0 .707L50.707 50l17.146 17.146c.195.195.195.512 0 .707C67.756 67.951 67.628 68 67.5 68zM73.5 27c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l1-1c.195-.195.512-.195.707 0s.195.512 0 .707l-1 1C73.756 26.951 73.628 27 73.5 27zM26.5 27c-.128 0-.256-.049-.354-.146l-1-1c-.195-.195-.195-.512 0-.707s.512-.195.707 0l1 1c.195.195.195.512 0 .707C26.756 26.951 26.628 27 26.5 27zM30.5 31c-.128 0-.256-.049-.354-.146l-2-2c-.195-.195-.195-.512 0-.707s.512-.195.707 0l2 2c.195.195.195.512 0 .707C30.756 30.951 30.628 31 30.5 31z"></path><path fill="#1f212b" d="M28.5 72c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707L49.293 50 32.146 32.854c-.195-.195-.195-.512 0-.707s.512-.195.707 0l17.5 17.5c.195.195.195.512 0 .707l-21.5 21.5C28.756 71.951 28.628 72 28.5 72zM25.5 75c-.128 0-.256-.049-.354-.146-.195-.195-.195-.512 0-.707l1-1c.195-.195.512-.195.707 0s.195.512 0 .707l-1 1C25.756 74.951 25.628 75 25.5 75z"></path></svg>
		</div>
	</aside>

	<?php
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


// Quita el footer predeterminado
add_action( 'init', 'gpc_remove_default_footer' );
function gpc_remove_default_footer() {
	remove_action( 'generate_footer', 'generate_construct_footer' );
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
	$html = '<div class="logo-menu"><a href="' . ( is_shop() ? 'https://www.alisondarwin.com' : 'https://store.alisondarwin.com' ) . '"><h1>alison DARWIN</h1></a></div>';
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
	
	<?php if( is_amp() ) : ?>
		<amp-state id="product_qty">
			<script type="application/json">1</script>
		</amp-state>
	<?php endif; ?>

	<span class="vertical-buttons">
		<span class="plus quantity-btn" 
			<?php if( is_amp() ) : ?>
				on="tap:AMP.setState( { product_qty: ( product_qty >= max_value ) ? product_qty : +product_qty + 1 } )"
			<?php endif; ?>
		>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 306 306" xmlns:v="https://vecta.io/nano" width="8"><path d="M35.7 247.35L153 130.05l117.3 117.3 35.7-35.7-153-153-153 153z"></path></svg>
		</span>
		<span class="minus quantity-btn"
			<?php if( is_amp() ) : ?>
				on="tap:AMP.setState( { product_qty: ( product_qty <= min_value ) ? product_qty : product_qty - 1 } )"
			<?php endif; ?>
		>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 306 306" xmlns:v="https://vecta.io/nano" width="8"><path d="M35.7 58.65L153 175.95l117.3-117.3 35.7 35.7-153 153-153-153z"></path></svg>
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

// Quita el boton añadir al carrito en la página principal de la tienda
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 20 );


// Override a la función para mostrar "Agotado" cuando todas las variaciones están sin stock
function woocommerce_single_variation() {
	global $product; 
	// TODO
	$classes =  'woocommerce-variation single_variation';
	if ( is_variable_product_out_of_stock($product) ) {
		$classes .= ' sold-out';
	}
	echo "<div class='$classes'></div>";
}

function is_variable_product_out_of_stock( $product ) {
    $children_count = 0;
    $variation_ids  = $product->get_visible_children();

    foreach( $variation_ids as $variation_id ) {
        $variation = wc_get_product($variation_id);
            
        if( ! $variation->is_in_stock() ) {
            $children_count++;
        }
    }
    
    return (count($variation_ids) == $children_count);
}


/*********** AMP ***********/

// Devuelve un booleano indicando si la página actual es AMP
function is_amp() {
	return (function_exists( 'is_amp_endpoint' ) && is_amp_endpoint());
}

// Cambios a hacer en páginas AMP
// add_action( 'wp', 'gcp_amp_changes' );
// function gcp_amp_changes() {

	// if (is_amp()) { // TODO: No funciona porque se llama a la funcion demasiado pronto

		/** Override del viewport en páginas AMP, para añadir 'minimum-scale=1' **/
		add_filter( 'generate_meta_viewport',  'gpc_amp_generate_meta_viewport' );
		function gpc_amp_generate_meta_viewport( $meta_viewport ) {
			if (is_amp()) {
				$meta_viewport = '<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1">';
			}
			return $meta_viewport;
		}	

		// Añade la clase 'fixed' al header ya que no se puede hacer con JS en AMP 
		// apply_filters( "generate_{$context}_class", $classes, $class );
		add_filter( 'generate_navigation_class', 'gpc_amp_add_toggled_class', 15 );
		function gpc_amp_add_toggled_class( $classes ) {
			if (is_amp()) {
				$classes[] = 'fixed';
			}
			return $classes;
		}

		/***** Override a la función que genera el menú en el móvil para que sea compatible con AMP *****/
		function generate_navigation_position() {
			?>

			<nav id="site-navigation" <?php generate_do_element_classes( 'navigation' ); ?> <?php generate_do_microdata( 'navigation' ); ?>
			<?php if ( is_amp() ) : ?>
					[class]=" siteNavigationMenuExpanded ? 'main-navigation fixed toggled' : 'main-navigation fixed' "
				<?php endif; ?>
			>

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
						on="tap:AMP.setState( { siteNavigationMenuExpanded: !siteNavigationMenuExpanded } )"
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
			if (is_amp()) {
				$notify_html = '';
			}
			return $notify_html;
		}

		add_filter( 'woocommerce_add_to_cart_redirect', 'gpc_redirect_checkout_add_to_cart' ); // TODO: No se ejecuta en páginas AMP
		function gpc_redirect_checkout_add_to_cart( $url ) { // TODO: Comprobar si queda stock
			// global $product;
			// if( $product->is_in_stock() ) { }
			if (is_amp()) {
				$url = get_permalink( get_option( 'woocommerce_cart_page_id' ) );
				return $url;
			}
		}

		// Devuelve la información de disponibilidad (si está en stock) para cada variación del producto en formato JSON
		function gpc_get_variations_availability_json() {
			
			global $product; // Woocommerce global variable
			
			$variations_availability = []; // Array of bools to store variations availability (In stock or out of stock)
			$count_attributes;

			foreach( $product->get_available_variations() as $variation ) { // Loop through all available variations
				$variation_attributes = $variation['attributes'];
				$count_attributes = count( $variation_attributes ); // Count number of attributes of current variation

				if ( $count_attributes == 1 ) {
					$variation_attributes = implode( $variation_attributes );
					$variations_availability[$variation_attributes] = $variation['is_in_stock'];
				}
				elseif ( $count_attributes == 2) {
					$variation_attributes = array_values( $variation_attributes );
					$variations_availability[$variation_attributes[0]][$variation_attributes[1]] = $variation['is_in_stock'];
				}
			}

			$variations_availability['count'] = $count_attributes;

			return json_encode( $variations_availability ); // Returns an array with variations availabililty encoded in JSON format 
		}

		// Añade a la etiqueta <select> el atributo AMP "on" para asignar el valor seleccionado a la variable currentVariation
		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'gpc_add_amp_attributes_select', 15, 2 );
		function gpc_add_amp_attributes_select( $html, $args ) {
			if (is_amp()) {
				$id = $args['id'] ? $args['id'] : sanitize_title( $args['attribute'] );

				if ( $id == 'pa_talla' ) {
					$html = str_replace(
						'id="pa_talla"', 
						'id="pa_talla" on="change:AMP.setState( { currentSize: event.value } )"', 
						$html
					);
				}
				elseif ( $id == 'pa_color' ) {
					$html = str_replace( 
						'id="pa_color"', 
						'id="pa_color" on="change:AMP.setState( { currentColor: event.value } )"', 
						$html
					);
				}
			}
			return $html;
		}

		// Añade la información de disponibilidad para cada variación del producto en formato JSON
		add_action( 'woocommerce_after_add_to_cart_quantity', 'gpc_wc_amp_add_product_availability' );
		function gpc_wc_amp_add_product_availability() {
			global $product;
			if ( is_amp() && $product->is_type( 'variable' ) ) :
			?>
			
			<amp-state id="variations_availability">
				<script type="application/json">
					<?php echo gpc_get_variations_availability_json(); ?>
				</script>
			</amp-state>	
			
			<?php endif;
		}

		// Muestra un mensaje cuando el producto está sin stock
		add_action( 'woocommerce_before_single_variation', 'gpc_amp_out_of_stock_msg' );
		function gpc_amp_out_of_stock_msg() {
			if ( is_amp() ) :
			?>

			<p class="stock out-of-stock" hidden 
				[hidden]="( variations_availability['count'] < 2 ) ? variations_availability[currentSize] : variations_availability[currentSize][currentColor]">
					Agotado
			</p>

			<?php endif;
		}

		// Muestra por defecto la pestaña de 'Descripción'
		add_action( 'woocommerce_product_after_tabs', 'gpc_amp_default_state_tabs');
		function gpc_amp_default_state_tabs() {
			if ( is_amp() ) :
			?>

			<amp-state id="wc_tab_expanded">
				<script type="application/json">"description"</script>
			</amp-state>

			<?php endif;
		}


		// Quita el atributo 'action' en las paginas traducidas AMP para solucionar el error: "The attribute 'action' may not appear in tag 'FORM [method=POST]'".
		// apply_filters( 'trp_translated_html', $final_html, $TRP_LANGUAGE, $language_code, $preview_mode );
		add_filter( 'trp_translated_html', 'gpc_amp_remove_action_attribute' );
		function gpc_amp_remove_action_attribute( $final_html ) {
			if ( is_amp() ) {
				$final_html = str_replace( 'action=""', '', $final_html );
			}
			return $final_html;
		}


	// } // END is_amp()

	

?>
