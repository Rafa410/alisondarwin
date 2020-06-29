<?php	/* alisondarwin.com */

// Sobreescribe scripts
add_action( 'wp_enqueue_scripts', 'override_scripts', 100 );
function override_scripts() {
	$isMobile = preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
	
	if (is_front_page()) {
		wp_dequeue_script( 'jquery-ui-datepicker' ); // MEC datepicker.js
	}
	
	wp_dequeue_script( 'google-recaptcha' );
	if ( !$isMobile ) {
		wp_enqueue_script( 'custom-google-recaptcha', get_stylesheet_directory_uri().'/js/external-js/api.js', array(), null, true );
	}

	wp_dequeue_script( 'swiper' ); // Elementor swiper.js

	if ( !is_admin() ) {
		wp_dequeue_script( 'mec-select2-script' ); // MEC select2.js
		wp_dequeue_style( 'mec-select2-style' ); // MEC select2.css
		wp_dequeue_script( 'wp-color-picker' ); // MEC color-picker.js
		wp_dequeue_style( 'wp-color-picker' ); // MEC color-picker.css
	}
	// wp_dequeue_script( 'mec-owl-carousel-script' ); // MEC owl.carousel.js (Used in frontend.js)
	
	
}	

// Carga scripts personalizados
add_action( 'wp_enqueue_scripts', 'custom_scripts');
function custom_scripts() {
	
	// Todas las páginas
	wp_register_script('custom-js', get_stylesheet_directory_uri(). '/js/custom.min.js', array('jquery'), '1.1', true );
	wp_enqueue_script('custom-js');

	// Pagina de inicio
	if (is_front_page()) {
		wp_register_script('home-page', get_stylesheet_directory_uri(). '/js/home-page.min.js', array('jquery'), '1.2', true );
		wp_enqueue_script('home-page');	

		// wp_register_script( 'custom-preloader', get_stylesheet_directory_uri() . '/js/preloader-script.js', array('jquery'), '1.0' );
		// wp_enqueue_script( 'custom-preloader' );
	}

}


// Genera un footer personalizado
add_action( 'generate_footer', 'generate_custom_footer' );
function generate_custom_footer() {
	
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
					<span class="copyright">© <?php echo date('Y'); ?> <a href="https://www.alisondarwin.com">alison DARWIN</a></span>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	
}


// Quita los dashicons si no se muestra la barra de admin
add_action( 'wp_print_styles', 'remove_dashicons' , 100);
function remove_dashicons() {
    if ( ! is_admin_bar_showing() ) {
		wp_deregister_style( 'dashicons' );
	}
}



// Añade nuevo widget 'contenido'
add_action( 'widgets_init', 'generatepress_agregar_nueva_zona_widgets' );
function generatepress_agregar_nueva_zona_widgets() {

	register_sidebar( array(
		'name'          => 'Contenido',
		'id'            => 'content-widget',
		'description'   => 'Añade widgets aquí para que aparezcan como contenido principal',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	
}


// Quita el campo URL de los comentarios en eventos
add_filter( 'comment_form_default_fields', 'gcp_custom_comment_form_fields', 100 );
function gcp_custom_comment_form_fields( $fields ) {
	unset($fields['url']);
	return $fields;
}

// Añade el logo al menu del header
add_action( 'generate_inside_navigation' , 'gpc_generate_menu_logo' );
function gpc_generate_menu_logo() {
	$html = '<div class="logo-menu"><a href="https://www.alisondarwin.com"><h1>alison DARWIN</h1></a></div>';
	echo $html;
}

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


// Remove elementor eicons
// add_action( 'wp_enqueue_scripts', 'remove_elementor_eicons', 20 );
// function remove_elementor_eicons() { 
// 	if ( !is_admin() ) {
// 		wp_deregister_style( 'elementor-icons' );
// 	}
// }

// Añade async="false" a varios scripts para evitar errores [NO ESTÁ EN USO ACTUALMENTE]
/*function async_false_cloudflare($tag, $handle) {
		if ($handle === '') {
			return str_replace(' src', ' data-cfasync="false" src', $tag);		
		}
		return $tag;
}*/
//add_filter('script_loader_tag', 'async_false_cloudflare', 10, 2);

?>
