		<section class="module">
			<div class="container">

				<div class="row">
				
					<?php
					
					$shop_isle_contact_page_form_shortcode = get_theme_mod('shop_isle_contact_page_form_shortcode');
					
					if(!empty($shop_isle_contact_page_form_shortcode)):

						echo '<div class="col-sm-6 contact-page-form">';

							echo do_shortcode($shop_isle_contact_page_form_shortcode);
							
						echo '</div>';
						
					endif;	

					echo '<div class="col-sm-6">';

						the_content();

					echo '</div>';
					
					?>

				</div><!-- .row -->

			</div>
		</section>
		<!-- Contact end -->

		<!-- Map start -->
		<?php
			$shop_isle_contact_page_map_shortcode = get_theme_mod('shop_isle_contact_page_map_shortcode');
			if( !empty($shop_isle_contact_page_map_shortcode) ):
				echo '<section id="map-section">';
					echo '<div id="map">'.do_shortcode($shop_isle_contact_page_map_shortcode).'</div>';
				echo '</section>';
			endif;
		?>
		<!-- Map end -->