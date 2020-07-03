<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		
		<ul class="tabs wc-tabs" role="tablist">
			<?php $tab_index = 1; ?>
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<li class="<?php echo esc_attr( $key ); ?>_tab <?php if( $key == 'description' ) echo 'active'; ?>" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>" tabindex="<?php echo $tab_index++; ?>"
				<?php if ( is_amp() ) : ?>
						on="tap:AMP.setState( { wc_tab_expanded: '<?php echo esc_attr( $key ); ?>' } )"	
						[class]=" (wc_tab_expanded == '<?php echo esc_attr( $key ); ?>') ? '<?php echo esc_attr( $key ); ?>_tab active' : '<?php echo esc_attr( $key ); ?>_tab' "
					<?php endif; ?>	
				>
					<a <?php if ( ! is_amp() ) : ?>href="#tab-<?php echo esc_attr( $key ); ?>"<?php endif; ?>>
						<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php $default_classes = 'woocommerce-Tabs-panel woocommerce-Tabs-panel--' . esc_attr( $key ) . 'panel entry-content wc-tab' ?>
			<div class="<?php echo ( $key == 'description' ) ? $default_classes . ' active' : $default_classes; ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>"
			<?php if ( is_amp() ) : ?>
					[class]=" (wc_tab_expanded == '<?php echo esc_attr( $key ); ?>') ? '<?php echo $default_classes . ' active'; ?>' : '<?php echo $default_classes ?>'"
				<?php endif; ?>	 
			>
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
