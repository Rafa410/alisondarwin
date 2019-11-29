<?php

// Sobreescribe scripts
add_action( 'wp_enqueue_scripts', 'override_scripts', 100 );
function override_scripts() {
	if (is_front_page()) {
		wp_dequeue_script( 'wptime-plugin-preloader-script' );
		wp_enqueue_script( 'custom_preloader_script', get_stylesheet_directory_uri().'/js/preloader-script.js', array( 'jquery' ), null, false);
	}
	
	wp_dequeue_script( 'google-recaptcha' );
	wp_enqueue_script( 'custom_google-recaptcha', get_stylesheet_directory_uri().'/js/external-js/api.js', array(), null, false ); 
}	

// Carga scripts personalizados
add_action( 'wp_enqueue_scripts', 'customScripts');
function customScripts() {
	
	// Pagina de inicio
	if (is_front_page()) {
		wp_register_script('home-page', get_stylesheet_directory_uri(). '/js/home-page.js', array('jquery'), '1.0', true );
		wp_enqueue_script('home-page');	
	}
	// wp_enqueue_script( 'jquery-ui-datepicker' );
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
					<span class="copyright">© <?php echo date('Y'); ?> alison DARWIN</span>
				</div>
			</div>
		</footer><!-- .site-info -->
		<?php
	
}


// Quita los dashicons si no se muestra la barra de admin
add_action( 'wp_print_styles', function() {
    if (!is_admin_bar_showing()) wp_deregister_style( 'dashicons' );
}, 100);



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

// Añade async="false" a varios scripts para evitar errores [NO ESTÁ EN USO ACTUALMENTE]
/*function async_false_cloudflare($tag, $handle) {
		if ($handle === '') {
			return str_replace(' src', ' data-cfasync="false" src', $tag);		
		}
		return $tag;
}*/
//add_filter('script_loader_tag', 'async_false_cloudflare', 10, 2);

?>
