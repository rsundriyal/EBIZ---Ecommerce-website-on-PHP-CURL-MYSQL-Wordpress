<?php
/**
 * Template functions used for the site footer.
 *
 */

if ( ! function_exists( 'shop_isle_footer_widgets' ) ) {
	/**
	 * Display the footer widgets
	 * @since  1.0.0
	 * @return void
	 */
	function shop_isle_footer_widgets() {
		?>
		<!-- Widgets start -->

	<?php if ( is_active_sidebar( 'sidebar-footer-area-1' ) || is_active_sidebar( 'sidebar-footer-area-2' ) || is_active_sidebar( 'sidebar-footer-area-3' ) || is_active_sidebar( 'sidebar-footer-area-4' ) ) : ?>

		<div class="module-small bg-dark shop_isle_footer_sidebar">
			<div class="container">
				<div class="row">

					<?php if ( is_active_sidebar( 'sidebar-footer-area-1' ) ) : ?>
						<div class="col-sm-6 col-md-3 footer-sidebar-wrap">
							<?php dynamic_sidebar('sidebar-footer-area-1'); ?>
						</div>
					<?php endif; ?>
					<!-- Widgets end -->

					<?php if ( is_active_sidebar( 'sidebar-footer-area-2' ) ) : ?>
						<div class="col-sm-6 col-md-3 footer-sidebar-wrap">
							<?php dynamic_sidebar('sidebar-footer-area-2'); ?>
						</div>
					<?php endif; ?>
					<!-- Widgets end -->

					<?php if ( is_active_sidebar( 'sidebar-footer-area-3' ) ) : ?>
						<div class="col-sm-6 col-md-3 footer-sidebar-wrap">
							<?php dynamic_sidebar('sidebar-footer-area-3'); ?>
						</div>
					<?php endif; ?>
					<!-- Widgets end -->


					<?php if ( is_active_sidebar( 'sidebar-footer-area-4' ) ) : ?>
						<div class="col-sm-6 col-md-3 footer-sidebar-wrap">
							<?php dynamic_sidebar('sidebar-footer-area-4'); ?>
						</div>
					<?php endif; ?>
					<!-- Widgets end -->

				</div><!-- .row -->
			</div>
		</div>

	<?php endif; ?>

		<?php
	}
}

if ( ! function_exists( 'shop_isle_footer_copyright_and_socials' ) ) {
	/**
	 * Display the theme copyright and socials
	 * @since  1.0.0
	 * @return void
	 */
	function shop_isle_footer_copyright_and_socials() {

		?>
		<!-- Footer start -->
		<footer class="footer bg-dark">
			<!-- Divider -->
			<hr class="divider-d">
			<!-- Divider -->
			<div class="container">

				<div class="row">

					<?php
					/* Copyright */
					$shop_isle_copyright = get_theme_mod('shop_isle_copyright',__( '&copy; Themeisle, All rights reserved', 'shop-isle' ));
					if( !empty($shop_isle_copyright) ):
						echo '<div class="col-sm-6">';
							echo '<p class="copyright font-alt">'.$shop_isle_copyright.'</p>';
							$shop_isle_site_info_hide = get_theme_mod('shop_isle_site_info_hide');
							if( isset($shop_isle_site_info_hide) && $shop_isle_site_info_hide != 1 ): ?>
							<p class="shop-isle-poweredby-box"><a class="shop-isle-poweredby" href="http://themeisle.com/themes/shop-isle/" rel="nofollow">ShopIsle </a><?php _e('powered by','shop-isle'); ?><a class="shop-isle-poweredby" href="http://wordpress.org/" rel="nofollow"> WordPress</a></p>
							<?php
							endif;
						echo '</div>';
					endif;

					/* Socials icons */

					$shop_isle_socials = get_theme_mod('shop_isle_socials',json_encode(array( array('icon_value' => 'social_facebook' ,'link' => '#' ),array('icon_value' => 'social_twitter' ,'link' => '#'), array('icon_value' => 'social_dribbble' ,'link' => '#'), array('icon_value' => 'social_skype' ,'link' => '#') )));

					if( !empty( $shop_isle_socials ) ):

						$shop_isle_socials_decoded = json_decode($shop_isle_socials);

						if( !empty($shop_isle_socials_decoded) ):

							echo '<div class="col-sm-6">';

								echo '<div class="footer-social-links">';

									foreach($shop_isle_socials_decoded as $shop_isle_social):

										if( !empty($shop_isle_social->icon_value) && !empty($shop_isle_social->link) ) {
									
											if (function_exists ( 'icl_t' ) && !empty($shop_isle_social->id)){


											
												$shop_isle_social_icon_value = icl_t( 'Social '.$shop_isle_social->id, 'Social icon', $shop_isle_social->icon_value );
												
												$shop_isle_social_link = icl_t( 'Social '.$shop_isle_social->id, 'Social link', $shop_isle_social->link );
												
												
												
												echo '<a href="'. esc_url( $shop_isle_social_link ) .'"><span class="'.$shop_isle_social_icon_value.'"></span></a>';		
												
											} else {
												
												echo '<a href="'.esc_url($shop_isle_social->link).'"><span class="'.$shop_isle_social->icon_value.'"></span></a>';					
											}
									
										}

									endforeach;

								echo '</div>';

							echo '</div>';

						endif;

					endif;
					?>
				</div><!-- .row -->

			</div>
		</footer>
		<!-- Footer end -->
		<?php
	}
}


if ( ! function_exists( 'shop_isle_footer_wrap_open' ) ) {
	/**
	 * Display the theme copyright and socials
	 * @since  1.0.0
	 * @return void
	 */
	function shop_isle_footer_wrap_open() {
		echo '</div><div class="bottom-page-wrap">';
	}

}


if ( ! function_exists( 'shop_isle_footer_wrap_close' ) ) {
	/**
	 * Display the theme copyright and socials
	 * @since  1.0.0
	 * @return void
	 */
	function shop_isle_footer_wrap_close() {
		echo '</div><!-- .bottom-page-wrap -->';
	}

}