<?php

add_image_size( 'shop_isle_blog_image_size', 750, 500, true );
add_image_size( 'shop_isle_banner_homepage', 360, 235, true );

add_filter( 'image_size_names_choose', 'shop_isle_media_uploader_custom_sizes' );
function shop_isle_media_uploader_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'shop_isle_banner_homepage'		=> esc_html__( 'Shop isle Small Banner Homepage', 'shop-isle' ),
    ) );
}

/**
 * Setup.
 * Enqueue styles, register widget regions, etc.
 */
require get_template_directory() . '/inc/functions/setup.php';

/**
 * Structure.
 * Template functions used throughout the theme.
 */
require get_template_directory() . '/inc/structure/hooks.php';
require get_template_directory() . '/inc/structure/post.php';
require get_template_directory() . '/inc/structure/page.php';
require get_template_directory() . '/inc/structure/header.php';
require get_template_directory() . '/inc/structure/footer.php';
require get_template_directory() . '/inc/structure/comments.php';
require get_template_directory() . '/inc/structure/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/functions/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';
require get_template_directory() . '/inc/customizer/functions.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack/jetpack.php';

/**
 * Load WooCommerce compatibility files.
 */
if ( is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/woocommerce/hooks.php';
	require get_template_directory() . '/inc/woocommerce/functions.php';
	require get_template_directory() . '/inc/woocommerce/template-tags.php';
	require get_template_directory() . '/inc/woocommerce/integrations.php';
}


/**
 * Checkout page
 * Move the coupon fild and message info after the order table
**/
function shop_isle_coupon_after_order_table_js() {
	wc_enqueue_js( '
		$( $( ".woocommerce-info, .checkout_coupon" ).detach() ).appendTo( "#shop-isle-checkout-coupon" );
	');
}
add_action( 'woocommerce_before_checkout_form', 'shop_isle_coupon_after_order_table_js' );

function shop_isle_coupon_after_order_table() {
	echo '<div id="shop-isle-checkout-coupon"></div><div style="clear:both"></div>';
}
add_action( 'woocommerce_checkout_order_review', 'shop_isle_coupon_after_order_table' );


// Ensure cart contents update when products are added to the cart via AJAX )
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>

		<a href="<?php echo WC()->cart->get_cart_url() ?>" title="<?php _e( 'View your shopping cart','shop-isle' ); ?>" class="cart-contents">
			<span class="icon-basket"></span>
			<span class="cart-item-number"><?php echo trim( WC()->cart->get_cart_contents_count() ); ?></span>
		</a>

	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}