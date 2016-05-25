<?php
/**
 * The header for our theme.
 *
 * @package shop-isle
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php shop_isle_html_tag_schema(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php do_action( 'shop_isle_before_header' ); ?>

	<!-- Preloader -->
	<?php
	
	global $wp_customize;
	
	/* Preloader */
	if(is_front_page() && !isset( $wp_customize ) && get_option( 'show_on_front' ) != 'page' ): 	
	
		$shop_isle_disable_preloader = get_theme_mod('shop_isle_disable_preloader');
		
		if( isset($shop_isle_disable_preloader) && ($shop_isle_disable_preloader != 1) ):
		
			echo '<div class="page-loader">';
				echo '<div class="loader">'.__('Loading...','shop-isle').'</div>';
			echo '</div>';
		
		endif;
		
	endif;
	
	
	
	?>
	
	<?php do_action( 'shop_isle_header' ); ?>

	<?php do_action( 'shop_isle_after_header' ); ?>
