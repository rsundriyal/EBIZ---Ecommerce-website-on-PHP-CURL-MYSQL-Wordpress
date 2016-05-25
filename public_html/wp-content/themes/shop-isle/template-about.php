<?php
/**
 * The template for displaying about us page.
 *
 * Template Name: About us page
 *
 */

get_header(); ?>
	<!-- Wrapper start -->
	<div class="main">
	
		<!-- Header section start -->
		
		<?php
			$shop_isle_header_image = get_header_image();
			if( !empty($shop_isle_header_image) ) {
				echo '<section class="page-header-module module bg-dark" data-background="'.$shop_isle_header_image.'">';
			} else {
				echo '<section class="page-header-module module bg-dark">';
			}
		?>
				<div class="container">

						<div class="row">

							<div class="col-sm-10 col-sm-offset-1">

								<h1 class="module-title font-alt"><?php the_title(); ?></h1>

								<?php

								/* Header description */

								$shop_isle_shop_id = get_the_ID();

								if( !empty($shop_isle_shop_id) ) {

									$shop_isle_page_description = get_post_meta($shop_isle_shop_id, 'shop_isle_page_description');

									if( !empty($shop_isle_page_description[0]) ) {
										echo '<div class="module-subtitle font-serif mb-0">'.$shop_isle_page_description[0].'</div>';
									}

								}
								?>

							</div>

						</div><!-- .row -->

					</div><!-- .container -->
				</section><!-- .page-header-module -->
				<!-- Header section end -->
				
				<!-- About start -->
				<?php
				
					if ( have_posts() ) { 
						while ( have_posts() ) { 
							
							the_post();
					
							$shop_isle_content_aboutus = get_the_content();
						
						}
					}	
					
					if( trim($shop_isle_content_aboutus) != "" ) {
						
						echo '<section class="module">';
						
							echo '<div class="container">';

								echo '<div class="row">';

									echo '<div class="col-sm-12">';

										the_content();

									echo '</div>';

								echo '</div>';

							echo '</div>';
							
						echo '</section>';
						
					}
				?>
				
				<!-- About end -->
				
				<!-- Divider -->
				<hr class="divider-w">
				<!-- Divider -->

				<!-- Team start -->
				<section class="module">
					<div class="container">
					
						<?php
							$shop_isle_our_team_title = get_theme_mod('shop_isle_our_team_title', __( 'Meet our team', 'shop-isle' ));
							$shop_isle_our_team_subtitle = get_theme_mod('shop_isle_our_team_subtitle',__( 'An awesome way to introduce the members of your team.', 'shop-isle' ));
							
							if( !empty($shop_isle_our_team_title) || !empty($shop_isle_our_team_subtitle) ) {
							
								echo '<div class="row">';
									echo '<div class="col-sm-6 col-sm-offset-3">';
									
										if( !empty($shop_isle_our_team_title) ) {
											echo '<h2 class="module-title font-alt meet-out-team-title">'.$shop_isle_our_team_title.'</h2>';
										}
										
										if( !empty($shop_isle_our_team_subtitle) ) {
											echo '<div class="module-subtitle font-serif meet-out-team-subtitle">';
												echo $shop_isle_our_team_subtitle;
											echo '</div>';
										}

									echo '</div>';

								echo '</div><!-- .row -->';
								
							}
							
							$shop_isle_team_members = get_theme_mod('shop_isle_team_members',json_encode(array( array('image_url' => get_template_directory_uri().'/assets/images/team1.jpg' , 'text' => 'Eva Bean', 'subtext' => 'Developer', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.' ),array('image_url' => get_template_directory_uri().'/assets/images/team2.jpg' ,'text' => 'Maria Woods', 'subtext' => 'Designer', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.' ), array('image_url' => get_template_directory_uri().'/assets/images/team3.jpg' , 'text' => 'Booby Stone', 'subtext' => 'Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.'), array('image_url' => get_template_directory_uri().'/assets/images/team4.jpg' , 'text' => 'Anna Neaga', 'subtext' => 'Art Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.') )));
								
								if( !empty( $shop_isle_team_members ) ) {
												
									$shop_isle_team_members_decoded = json_decode($shop_isle_team_members);
												
									if( !empty($shop_isle_team_members_decoded) ) {
										
										echo '<div class="row">';
													
											echo '<div class="hero-slider">';
													
												echo '<ul class="slides">';
												
													foreach($shop_isle_team_members_decoded as $shop_isle_team_member) {
														
														echo '<div class="col-sm-6 col-md-3 mb-sm-20 fadeInUp">';
														
															echo '<div class="team-item">';
															
																echo '<div class="team-image">';
																
																	if( !empty($shop_isle_team_member->image_url) ){
																	
																		if( !empty($shop_isle_team_member->text) ) {
																			
																			if (function_exists ( 'icl_t' ) && !empty($shop_isle_team_member->id)){
																				$shop_isle_team_member_image_url = icl_t( 'Team member '.$shop_isle_team_member->id, 'Team member image', $shop_isle_team_member->image_url );
																				$shop_isle_team_member_text = icl_t( 'Team member '.$shop_isle_team_member->id, 'Team member name', $shop_isle_team_member->text );
																				echo '<img src="'. esc_url( $shop_isle_team_member_image_url ).'" alt="'.esc_html($shop_isle_team_member_text).'">';
																			} else {
																				echo '<img src="'. esc_url( $shop_isle_team_member->image_url ).'" alt="'.esc_html($shop_isle_team_member->text).'">';
																			}

																		} else {
																			if (function_exists ( 'icl_t' ) && !empty($shop_isle_team_member->id)){
																				$shop_isle_team_member_image_url = icl_t( 'Team member '.$shop_isle_team_member->id, 'Team member image', $shop_isle_team_member->image_url );
																				echo '<img src="'. esc_url( $shop_isle_team_member_image_url ).'" alt="">';
																			} else {
																				echo '<img src="'. esc_url( $shop_isle_team_member_image_url ).'" alt="">';
																			}
																		}
																		
																	}


																	if( !empty($shop_isle_team_member->description) ) {
																		echo '<div class="team-detail">';
																		
																			if (function_exists ( 'icl_t' ) && !empty($shop_isle_team_member->id)){
																				$shop_isle_team_member_description = icl_t( 'Team member '.$shop_isle_team_member->id, 'Team member description', $shop_isle_team_member->description );
																				echo '<p class="font-serif">'.$shop_isle_team_member_description.'</p>';
																			} else {
																				echo '<p class="font-serif">'.$shop_isle_team_member->description.'</p>';
																			}	
																		echo '</div><!-- .team-detail -->';
																	}	
																echo '</div><!-- .team-image -->';
																
																echo '<div class="team-descr font-alt">';
																	if( !empty($shop_isle_team_member->text) ) {
																		if (function_exists ( 'icl_t' ) && !empty($shop_isle_team_member->id)){
																			$shop_isle_team_member_text = icl_t( 'Team member '.$shop_isle_team_member->id, 'Team member name', $shop_isle_team_member->text );
																			echo '<div class="team-name">'.$shop_isle_team_member_text.'</div>';
																		} else {
																			echo '<div class="team-name">'.$shop_isle_team_member->text.'</div>';
																		}	
																	}
																	if( !empty($shop_isle_team_member->subtext) ) {
																		if (function_exists ( 'icl_t' ) && !empty($shop_isle_team_member->id)){
																			$shop_isle_team_member_subtext = icl_t( 'Team member '.$shop_isle_team_member->id, 'Team member job', $shop_isle_team_member->subtext );
																			echo '<div class="team-role">'.$shop_isle_team_member_subtext.'</div>';
																		} else {
																			echo '<div class="team-role">'.$shop_isle_team_member->subtext.'</div>';
																		}	
																	}
																echo '</div><!-- .team-descr -->';
															
															echo '</div><!-- .team-item -->';
														
														echo '</div><!-- .col-sm-6 col-md-3 mb-sm-20 fadeInUp -->';
														
													}
												
												echo '</ul>';
														
											echo '</div>';
										
										echo '</div>';
										
										
									}
								}
							
							
								
						?>	
						
					</div>
					
				</section>
				<!-- Team end -->
				
				<!-- Video start -->
		<?php
			$shop_isle_about_page_video_background = get_theme_mod('shop_isle_about_page_video_background',get_template_directory_uri().'/assets/images/background-video.jpg');
			if( !empty($shop_isle_about_page_video_background) ):
				echo '<section class="module bg-dark-60 about-page-video" data-background="'.$shop_isle_about_page_video_background.'">';
			else:
				echo '<section class="module bg-dark-60 about-page-video">';
			endif;
		?>
		
			<div class="container">

				<div class="row">

					<div class="col-sm-12">

						<div class="video-box">
							<?php
								$shop_isle_about_page_video_link = get_theme_mod('shop_isle_about_page_video_link');
								if( !empty($shop_isle_about_page_video_link) ):
									echo '<div class="video-box-icon">';
										echo '<a href="'.$shop_isle_about_page_video_link.'" class="video-pop-up"><span class="social_youtube_square"></span></a>';
									echo '</div>';
								endif;
								if( empty($shop_isle_about_page_video_link) && isset( $wp_customize ) ):
									echo '<div class="video-box-icon shop_isle_hidden_if_not_customizer">';
										echo '<a href="'.$shop_isle_about_page_video_link.'" class="video-pop-up"><span class="social_youtube_square"></span></a>';
									echo '</div>';
								endif;
								
								$shop_isle_about_page_video_title = get_theme_mod('shop_isle_about_page_video_title',__( 'Presentation', 'shop-isle' ));
								$shop_isle_about_page_video_subtitle = get_theme_mod('shop_isle_about_page_video_subtitle',__( 'What the video about our new products', 'shop-isle' ));
								
								if( !empty($shop_isle_about_page_video_title) ):
									echo '<div class="video-title font-alt">'.$shop_isle_about_page_video_title.'</div>';
								endif;
								
								if( !empty($shop_isle_about_page_video_subtitle) ):
									echo '<div class="video-subtitle font-alt">'.$shop_isle_about_page_video_subtitle.'</div>';
								endif;
								
							?>
							
						</div>

					</div>

				</div><!-- .row -->

			</div>
		</section>
		<!-- Video end -->

		<!-- Features start -->
		<section class="module">
			<div class="container">

				<?php
				
				$shop_isle_our_advantages_title = get_theme_mod('shop_isle_our_advantages_title',__( 'Our advantages', 'shop-isle' ));
				if( !empty($shop_isle_our_advantages_title) ):
					echo '<div class="row">';
						echo '<div class="col-sm-6 col-sm-offset-3">';
							echo '<h2 class="module-title font-alt our_advantages">'.$shop_isle_our_advantages_title.'</h2>';
						echo '</div>';
					echo '</div>';	
				endif;	
				
				$shop_isle_advantages = get_theme_mod('shop_isle_advantages',json_encode(array( array('icon_value' => 'icon_lightbulb' , 'text' => __('Ideas and concepts','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_tools' , 'text' => __('Designs & interfaces','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_cogs' , 'text' => __('Highly customizable','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_like', 'text' => __('Easy to use','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')))));
					
				if( !empty( $shop_isle_advantages ) ):
									
					$shop_isle_advantages_decoded = json_decode($shop_isle_advantages);
									
					if( !empty($shop_isle_advantages_decoded) ):
										
						echo '<div class="row multi-columns-row">';
									
							foreach($shop_isle_advantages_decoded as $shop_isle_advantage):
											
								echo '<div class="col-sm-6 col-md-3 col-lg-3">';

									echo '<div class="features-item">';
									
									
										if( !empty($shop_isle_advantage->icon_value) ):
											echo '<div class="features-icon">';
											
												if (function_exists ( 'icl_t' ) && !empty($shop_isle_advantage->id)){
													$shop_isle_advantage_icon_value = icl_t( 'Advantage '.$shop_isle_advantage->id, 'Advantage icon',$shop_isle_advantage->icon_value );
													echo '<span class="'.$shop_isle_advantage_icon_value.'"></span>';
												} else {
													echo '<span class="'.$shop_isle_advantage->icon_value.'"></span>';
												}
												
											echo '</div>';
										endif;	

										if( !empty($shop_isle_advantage->text) ):
										
											if (function_exists ( 'icl_t' ) && !empty($shop_isle_advantage->id)){
												$shop_isle_advantage_text = icl_t( 'Advantage '.$shop_isle_advantage->id, 'Advantage text', $shop_isle_advantage->text );
												echo '<h3 class="features-title font-alt">'.$shop_isle_advantage_text.'</h3>';	
											} else {
												echo '<h3 class="features-title font-alt">'.$shop_isle_advantage->text.'</h3>';
											}
										endif;	

										if( !empty($shop_isle_advantage->subtext) ):
											if (function_exists ( 'icl_t' ) && !empty($shop_isle_advantage->id)){
												$shop_isle_advantage_subtext = icl_t( 'Advantage '.$shop_isle_advantage->id ,'Advantage subtext', $shop_isle_advantage->subtext );
												echo $shop_isle_advantage_subtext;
											} else {
												echo $shop_isle_advantage->subtext;
											}	
										endif;	
									echo '</div>';

								echo '</div>';
					
							endforeach;
									
						echo '</div>';
									
					endif;
							
				endif;
				
				?>

			</div><!-- .container -->
		</section>
		<!-- Features end -->
	
<?php get_footer(); ?>