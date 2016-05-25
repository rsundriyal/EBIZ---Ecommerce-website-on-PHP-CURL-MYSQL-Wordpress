<?php

/**
 * Theme Customizer functions
 *
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'shop_isle_customize_preview_js' ) ) {
	function shop_isle_customize_preview_js() {

		wp_enqueue_script( 'shop_isle_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '', true );

	}
}

/**
 * Binds JS scripts for Theme Customizer.
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'shop_isle_customizer_script' ) ) {
	function shop_isle_customizer_script() {

		wp_enqueue_script( 'shop_isle_customizer_script', get_template_directory_uri() . '/js/shop_isle_customizer.js', array("jquery","jquery-ui-draggable"),'', true );

		wp_localize_script( 'shop_isle_customizer_script', 'objectL10n', array(

			'documentation' => __( 'Documentation', 'shop-isle' ),
			'support' 				=> __( 'Support Forum','shop-isle' ),

		) );

	}
}

/**
 * Sanitizes a hex color. Identical to core's sanitize_hex_color(), which is not available on the wp_head hook.
 *
 * Returns either '', a 3 or 6 digit hex color (with #), or null.
 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'shop_isle_sanitize_hex_color' ) ) {
	function shop_isle_sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
        }

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
        }

		return null;
	}
}

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'shop_isle_sanitize_choices' ) ) {
    function shop_isle_sanitize_choices( $input, $setting ) {
        global $wp_customize;

        $control = $wp_customize->get_control( $setting->id );

        if ( array_key_exists( $input, $control->choices ) ) {
            return $input;
        } else {
            return $setting->default;
        }
    }
}

/**
 * Sanitizes text
 *
 * @since  1.0.0
 */
if ( ! function_exists( 'shop_isle_sanitize_text' ) ) {
	function shop_isle_sanitize_text( $input ) {

		return wp_kses_post( force_balance_tags( $input ) );

	}
}

if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Repeater drag and drop controler
	 *
	 * @since  1.0.0
	 */
	class Shop_Isle_Repeater_Controler extends WP_Customize_Control {

		private $options = array();

		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
			$this->options = $args;
		}
		public function render_content() {

			$this_default = json_decode($this->setting->default);

			$values = $this->value();
			$json = json_decode($values);
			if(!is_array($json)) $json = array($values);
			$it = 0;

			$options = $this->options;
			if( !empty($options['shop_isle_image_control']) ) {
				$shop_isle_image_control = $options['shop_isle_image_control'];
			} else {
				$shop_isle_image_control = false;
			}
			if( !empty($options['shop_isle_text_control']) ) {
				$shop_isle_text_control = $options['shop_isle_text_control'];
			} else {
				$shop_isle_text_control = false;
			}
			if( !empty($options['shop_isle_subtext_control']) ) {
				$shop_isle_subtext_control = $options['shop_isle_subtext_control'];
			} else {
				$shop_isle_subtext_control = false;
			}
			if( !empty($options['shop_isle_link_control']) ) {
				$shop_isle_link_control = $options['shop_isle_link_control'];
			} else {
				$shop_isle_link_control = false;
			}
			if( !empty($options['shop_isle_label_control']) ) {
				$shop_isle_label_control = $options['shop_isle_label_control'];
			} else {
				$shop_isle_label_control = false;
			}
			if( !empty($options['shop_isle_description_control']) ) {
				$shop_isle_description_control = $options['shop_isle_description_control'];
			} else {
				$shop_isle_description_control = false;
			}



			if( !empty($options['shop_isle_box_label']) ) {
				$shop_isle_box_label = $options['shop_isle_box_label'];
			} else {
				$shop_isle_box_label = __('Slide','shop-isle');
			}

			if( !empty($options['shop_isle_box_add_label']) ) {
				$shop_isle_box_add_label = $options['shop_isle_box_add_label'];
			} else {
				$shop_isle_box_add_label = __('Add new slide','shop-isle');
			}

			if(!empty($options['shop_isle_icon_control'])){
                $shop_isle_icon_control = $options['shop_isle_icon_control'];
				$icons_array = array( 'No Icon','arrow_up', 'arrow_down', 'arrow_left', 'arrow_right', 'arrow_left-up', 'arrow_right-up', 'arrow_right-down', 'arrow_left-down', 'arrow-up-down', 'arrow_up-down_alt', 'arrow_left-right_alt', 'arrow_left-right', 'arrow_expand_alt2', 'arrow_expand_alt', 'arrow_condense', 'arrow_expand', 'arrow_move', 'arrow_carrot-up', 'arrow_carrot-down', 'arrow_carrot-left', 'arrow_carrot-right', 'arrow_carrot-2up', 'arrow_carrot-2down', 'arrow_carrot-2left', 'arrow_carrot-2right', 'arrow_carrot-up_alt2', 'arrow_carrot-down_alt2', 'arrow_carrot-left_alt2', 'arrow_carrot-right_alt2', 'arrow_carrot-2up_alt2', 'arrow_carrot-2down_alt2', 'arrow_carrot-2left_alt2', 'arrow_carrot-2right_alt2', 'arrow_triangle-up', 'arrow_triangle-down', 'arrow_triangle-left', 'arrow_triangle-right', 'arrow_triangle-up_alt2', 'arrow_triangle-down_alt2', 'arrow_triangle-left_alt2', 'arrow_triangle-right_alt2', 'arrow_back', 'icon_minus-06', 'icon_plus', 'icon_close', 'icon_check', 'icon_minus_alt2', 'icon_plus_alt2', 'icon_close_alt2', 'icon_check_alt2', 'icon_zoom-out_alt', 'icon_zoom-in_alt', 'icon_search', 'icon_box-empty', 'icon_box-selected', 'icon_minus-box', 'icon_plus-box', 'icon_box-checked', 'icon_circle-empty', 'icon_circle-slelected', 'icon_stop_alt2', 'icon_stop', 'icon_pause_alt2', 'icon_pause', 'icon_menu', 'icon_menu-square_alt2', 'icon_menu-circle_alt2', 'icon_ul', 'icon_ol', 'icon_adjust-horiz', 'icon_adjust-vert', 'icon_document_alt', 'icon_documents_alt', 'icon_pencil', 'icon_pencil-edit_alt', 'icon_pencil-edit', 'icon_folder-alt', 'icon_folder-open_alt', 'icon_folder-add_alt', 'icon_info_alt', 'icon_error-oct_alt', 'icon_error-circle_alt', 'icon_error-triangle_alt', 'icon_question_alt2', 'icon_question', 'icon_comment_alt', 'icon_chat_alt', 'icon_vol-mute_alt', 'icon_volume-low_alt', 'icon_volume-high_alt', 'icon_quotations', 'icon_quotations_alt2', 'icon_clock_alt', 'icon_lock_alt', 'icon_lock-open_alt', 'icon_key_alt', 'icon_cloud_alt', 'icon_cloud-upload_alt', 'icon_cloud-download_alt', 'icon_image', 'icon_images', 'icon_lightbulb_alt', 'icon_gift_alt', 'icon_house_alt', 'icon_genius', 'icon_mobile', 'icon_tablet', 'icon_laptop', 'icon_desktop', 'icon_camera_alt', 'icon_mail_alt', 'icon_cone_alt', 'icon_ribbon_alt', 'icon_bag_alt', 'icon_creditcard', 'icon_cart_alt', 'icon_paperclip', 'icon_tag_alt', 'icon_tags_alt', 'icon_trash_alt', 'icon_cursor_alt', 'icon_mic_alt', 'icon_compass_alt', 'icon_pin_alt', 'icon_pushpin_alt', 'icon_map_alt', 'icon_drawer_alt', 'icon_toolbox_alt', 'icon_book_alt', 'icon_calendar', 'icon_film', 'icon_table', 'icon_contacts_alt', 'icon_headphones', 'icon_lifesaver', 'icon_piechart', 'icon_refresh', 'icon_link_alt', 'icon_link', 'icon_loading', 'icon_blocked', 'icon_archive_alt', 'icon_heart_alt', 'icon_star_alt', 'icon_star-half_alt', 'icon_star', 'icon_star-half', 'icon_tools', 'icon_tool', 'icon_cog', 'icon_cogs', 'arrow_up_alt', 'arrow_down_alt', 'arrow_left_alt', 'arrow_right_alt', 'arrow_left-up_alt', 'arrow_right-up_alt', 'arrow_right-down_alt', 'arrow_left-down_alt', 'arrow_condense_alt', 'arrow_expand_alt3', 'arrow_carrot_up_alt', 'arrow_carrot-down_alt', 'arrow_carrot-left_alt', 'arrow_carrot-right_alt', 'arrow_carrot-2up_alt', 'arrow_carrot-2dwnn_alt', 'arrow_carrot-2left_alt', 'arrow_carrot-2right_alt', 'arrow_triangle-up_alt', 'arrow_triangle-down_alt', 'arrow_triangle-left_alt', 'arrow_triangle-right_alt', 'icon_minus_alt', 'icon_plus_alt', 'icon_close_alt', 'icon_check_alt', 'icon_zoom-out', 'icon_zoom-in', 'icon_stop_alt', 'icon_menu-square_alt', 'icon_menu-circle_alt', 'icon_document', 'icon_documents', 'icon_pencil_alt', 'icon_folder', 'icon_folder-open', 'icon_folder-add', 'icon_folder_upload', 'icon_folder_download', 'icon_info', 'icon_error-circle', 'icon_error-oct', 'icon_error-triangle', 'icon_question_alt', 'icon_comment', 'icon_chat', 'icon_vol-mute', 'icon_volume-low', 'icon_volume-high', 'icon_quotations_alt', 'icon_clock', 'icon_lock', 'icon_lock-open', 'icon_key', 'icon_cloud', 'icon_cloud-upload', 'icon_cloud-download', 'icon_lightbulb', 'icon_gift', 'icon_house', 'icon_camera', 'icon_mail', 'icon_cone', 'icon_ribbon', 'icon_bag', 'icon_cart', 'icon_tag', 'icon_tags', 'icon_trash', 'icon_cursor', 'icon_mic', 'icon_compass', 'icon_pin', 'icon_pushpin', 'icon_map', 'icon_drawer', 'icon_toolbox', 'icon_book', 'icon_contacts', 'icon_archive', 'icon_heart', 'icon_profile', 'icon_group', 'icon_grid-2x2', 'icon_grid-3x3', 'icon_music', 'icon_pause_alt', 'icon_phone', 'icon_upload', 'icon_download', 'social_facebook', 'social_twitter', 'social_pinterest', 'social_googleplus', 'social_tumblr', 'social_tumbleupon', 'social_wordpress', 'social_instagram', 'social_dribbble', 'social_vimeo', 'social_linkedin', 'social_rss', 'social_deviantart', 'social_share', 'social_myspace', 'social_skype', 'social_youtube', 'social_picassa', 'social_googledrive', 'social_flickr', 'social_blogger', 'social_spotify', 'social_delicious', 'social_facebook_circle', 'social_twitter_circle', 'social_pinterest_circle', 'social_googleplus_circle', 'social_tumblr_circle', 'social_stumbleupon_circle', 'social_wordpress_circle', 'social_instagram_circle', 'social_dribbble_circle', 'social_vimeo_circle', 'social_linkedin_circle', 'social_rss_circle', 'social_deviantart_circle', 'social_share_circle', 'social_myspace_circle', 'social_skype_circle', 'social_youtube_circle', 'social_picassa_circle', 'social_googledrive_alt2', 'social_flickr_circle', 'social_blogger_circle', 'social_spotify_circle', 'social_delicious_circle', 'social_facebook_square', 'social_twitter_square', 'social_pinterest_square', 'social_googleplus_square', 'social_tumblr_square', 'social_stumbleupon_square', 'social_wordpress_square', 'social_instagram_square', 'social_dribbble_square', 'social_vimeo_square', 'social_linkedin_square', 'social_rss_square', 'social_deviantart_square', 'social_share_square', 'social_myspace_square', 'social_skype_square', 'social_youtube_square', 'social_picassa_square', 'social_googledrive_square', 'social_flickr_square', 'social_blogger_square', 'social_spotify_square', 'social_delicious_square', 'icon_printer', 'icon_calulator', 'icon_building', 'icon_floppy', 'icon_drive', 'icon_search-2', 'icon_id', 'icon_id-2', 'icon_puzzle', 'icon_like', 'icon_dislike', 'icon_mug', 'icon_currency', 'icon_wallet', 'icon_pens', 'icon_easel', 'icon_flowchart', 'icon_datareport', 'icon_briefcase', 'icon_shield', 'icon_percent', 'icon_globe', 'icon_globe-2', 'icon_target', 'icon_hourglass', 'icon_balance', 'icon_rook', 'icon_printer-alt', 'icon_calculator_alt', 'icon_building_alt', 'icon_floppy_alt', 'icon_drive_alt', 'icon_search_alt', 'icon_id_alt', 'icon_id-2_alt', 'icon_puzzle_alt', 'icon_like_alt', 'icon_dislike_alt', 'icon_mug_alt', 'icon_currency_alt', 'icon_wallet_alt', 'icon_pens_alt', 'icon_easel_alt', 'icon_flowchart_alt', 'icon_datareport_alt', 'icon_briefcase_alt', 'icon_shield_alt', 'icon_percent_alt', 'icon_globe_alt', 'icon_clipboard');


            } else {
                 $shop_isle_icon_control = false;
            }
	 ?>

			<div class="shop_isle_general_control_repeater shop_isle_general_control_droppable">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php
						if(empty($json)) {
					?>
							<div class="shop_isle_general_control_repeater_container">
								<div class="shop-isle-customize-control-title"><?php echo $shop_isle_box_label; ?></div>
								<label>
								<?php
										if($shop_isle_icon_control ==true){
                                ?>
                                            <span class="customize-control-title"><?php _e('Icon','shop-isle')?></span>
                                            <select name="<?php echo esc_attr($this->id); ?>" class="shop_isle_icon_control">
                                                <?php
                                                    foreach($icons_array as $contact_icon) {
                                                        echo '<option value="'.esc_attr($contact_icon).'">'.esc_attr($contact_icon).'</option>';
                                                    }
                                                ?>
                                            </select>
                                <?php   }

										if($shop_isle_image_control ==true){ ?>
											<span class="customize-control-title"><?php _e('Image','shop-isle'); ?></span>
											<p class="shop_isle_image_control">
												<input type="text" class="widefat custom_media_url">
												<input type="button" class="button button-primary custom_media_button_shop_isle" value="<?php _e('Upload Image','shop-isle'); ?>" />
											</p>
									<?php
										}

										if($shop_isle_text_control==true){ ?>
											<span class="customize-control-title"><?php _e('Title','shop-isle'); ?></span>
											<input type="text" class="shop_isle_text_control" placeholder="<?php _e('Title','shop-isle'); ?>"/>
									<?php
										}

										if($shop_isle_subtext_control==true){ ?>
											<span class="customize-control-title"><?php _e('Subtitle','shop-isle'); ?></span>
											<input type="text" value="<?php if(!empty($icon->subtext)) {echo esc_attr($icon->subtext);} ?>" class="shop_isle_subtext_control" placeholder="<?php _e('Subtitle','shop-isle'); ?>"/>
									<?php }

										if($shop_isle_description_control==true){ ?>
											<span class="customize-control-title"><?php _e('Description','shop-isle'); ?></span>
											<input type="text" value="<?php if(!empty($icon->description)) {echo esc_attr($icon->description);} ?>" class="shop_isle_description_control" placeholder="<?php _e('Description','shop-isle'); ?>"/>
									<?php }

										if($shop_isle_label_control==true){ ?>
											<span class="customize-control-title"><?php _e('Button Label','shop-isle'); ?></span>
											<input type="text" value="<?php if(!empty($icon->label)) echo esc_attr($icon->label); ?>" class="shop_isle_label_control" placeholder="<?php _e('Button Label','shop-isle'); ?>"/>
									<?php }

										if($shop_isle_link_control==true){ ?>
											<span class="customize-control-title"><?php _e('Button Link','shop-isle'); ?></span>
											<input type="text" class="shop_isle_link_control" placeholder="<?php _e('Button Link','shop-isle'); ?>"/>
									<?php } ?>
									<input type="hidden" class="shop_isle_box_id" value="<?php if(!empty($icon->id)) echo esc_attr($icon->id); ?>">
									<button type="button" class="shop_isle_general_control_remove_field button" style="display:none;"><?php _e('Delete field','shop-isle'); ?></button>
								</label>
							</div>
					<?php
						} else {
							if ( !empty($this_default) && empty($json)) {
								foreach($this_default as $icon){
					?>
									<div class="shop_isle_general_control_repeater_container shop_isle_draggable">
										<div class="shop-isle-customize-control-title"><?php echo $shop_isle_box_label; ?></div>
										<label>
										<?php
											if($shop_isle_icon_control==true){ ?>
                                                    <span class="customize-control-title"><?php _e('Icon','shop-isle')?></span>
                                                    <select name="<?php echo esc_attr($this->id); ?>" class="shop_isle_icon_control">
                                                        <?php
                                                            foreach($icons_array as $contact_icon) {
                                                                if($icon->icon_value == $contact_icon){
                                                                    echo '<option value="'.esc_attr($contact_icon).'" selected="selected">'.esc_attr($contact_icon).'</option>';
                                                                } else {
                                                                    echo '<option value="'.esc_attr($contact_icon).'">'.esc_attr($contact_icon).'</option>';
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                        <?php
                                                }


												if($shop_isle_image_control==true){ ?>
														<span class="customize-control-title"><?php _e('Image','shop-isle'); ?></span>
														<p class="shop_isle_image_control">
															<input type="text" class="widefat custom_media_url" value="<?php if(!empty($icon->image_url)) {echo esc_attr($icon->image_url);} ?>">
															<input type="button" class="button button-primary custom_media_button_shop_isle" value="<?php _e('Upload Image','shop-isle'); ?>" />
														</p>
											<?php	}

													if($shop_isle_text_control==true){ ?>
														<span class="customize-control-title"><?php _e('Title','shop-isle'); ?></span>
														<input type="text" value="<?php if(!empty($icon->text)) {echo esc_attr($icon->text);} ?>" class="shop_isle_text_control" placeholder="<?php _e('Title','shop-isle'); ?>"/>
											<?php	}

													if($shop_isle_subtext_control==true){?>
														<span class="customize-control-title"><?php _e('Subtitle','shop-isle'); ?></span>
														<input type="text" value="<?php if(!empty($icon->subtext)) {echo esc_attr($icon->subtext);} ?>" class="shop_isle_subtext_control" placeholder="<?php _e('Subtitle','shop-isle'); ?>"/>
												<?php }

													if($shop_isle_description_control==true){ ?>
														<span class="customize-control-title"><?php _e('Description','shop-isle'); ?></span>
														<input type="text" value="<?php if(!empty($icon->description)) {echo esc_attr($icon->description);} ?>" class="shop_isle_description_control" placeholder="<?php _e('Description','shop-isle'); ?>"/>
												<?php }

													if($shop_isle_label_control==true){ ?>
														<span class="customize-control-title"><?php _e('Button Label','shop-isle'); ?></span>
														<input type="text" value="<?php if(!empty($icon->label)) echo esc_attr($icon->label); ?>" class="shop_isle_label_control" placeholder="<?php _e('Button Label','shop-isle'); ?>"/>
												<?php }

													if($shop_isle_link_control){ ?>
														<span class="customize-control-title"><?php _e('Button Link','shop-isle'); ?></span>
														<input type="text" value="<?php if(!empty($icon->link)) echo esc_url($icon->link); ?>" class="shop_isle_link_control" placeholder="<?php _e('Button Link','shop-isle'); ?>"/>
											<?php	} ?>
													<input type="hidden" class="shop_isle_box_id" value="<?php if(!empty($icon->id)) echo esc_attr($icon->id); ?>">
													<button type="button" class="shop_isle_general_control_remove_field button" <?php if ($it == 0) echo 'style="display:none;"'; ?>><?php _e('Delete field','shop-isle'); ?></button>
										</label>

									</div>

					<?php
									$it++;
								}
							} else {
								foreach($json as $icon){
						?>
									<div class="shop_isle_general_control_repeater_container shop_isle_draggable">
										<div class="shop-isle-customize-control-title"><?php echo $shop_isle_box_label; ?></div>
										<label>
										<?php
										if($shop_isle_icon_control==true){ ?>
                                                <span class="customize-control-title"><?php _e('Icon','shop-isle')?></span>
                                                <select name="<?php echo esc_attr($this->id); ?>" class="shop_isle_icon_control">
                                                <?php
                                                    foreach($icons_array as $contact_icon) {
                                                        if($icon->icon_value == $contact_icon){
                                                            echo '<option value="'.esc_attr($contact_icon).'" selected="selected">'.esc_attr($contact_icon).'</option>';
                                                        } else {
                                                            echo '<option value="'.esc_attr($contact_icon).'">'.esc_attr($contact_icon).'</option>';
                                                        }
                                                    }
                                                ?>
                                                </select>
                                        <?php
                                            }


											if($shop_isle_image_control == true){ ?>
												<span class="customize-control-title"><?php _e('Image','shop-isle'); ?></span>
												<p class="shop_isle_image_control">
													<input type="text" class="widefat custom_media_url" value="<?php if(!empty($icon->image_url)) {echo esc_attr($icon->image_url);} ?>">
													<input type="button" class="button button-primary custom_media_button_shop_isle" value="<?php _e('Upload Image','shop-isle'); ?>" />
												</p>
										<?php }

											if($shop_isle_text_control==true ){?>
												<span class="customize-control-title"><?php _e('Title','shop-isle'); ?></span>
												<input type="text" value="<?php if(!empty($icon->text)) {echo esc_attr($icon->text);} ?>" class="shop_isle_text_control" placeholder="<?php _e('Title','shop-isle'); ?>"/>
											<?php }

											if($shop_isle_subtext_control==true){?>
												<span class="customize-control-title"><?php _e('Subtitle','shop-isle'); ?></span>
												<input type="text" value="<?php if(!empty($icon->subtext)) {echo esc_attr($icon->subtext);} ?>" class="shop_isle_subtext_control" placeholder="<?php _e('Subtitle','shop-isle'); ?>"/>
										<?php }

											if($shop_isle_description_control==true){ ?>
												<span class="customize-control-title"><?php _e('Description','shop-isle'); ?></span>
												<input type="text" value="<?php if(!empty($icon->description)) {echo esc_attr($icon->description);} ?>" class="shop_isle_description_control" placeholder="<?php _e('Description','shop-isle'); ?>"/>
										<?php }

											if($shop_isle_label_control==true){ ?>
												<span class="customize-control-title"><?php _e('Button Label','shop-isle'); ?></span>
												<input type="text" value="<?php if(!empty($icon->label)) echo esc_attr($icon->label); ?>" class="shop_isle_label_control" placeholder="<?php _e('Button Label','shop-isle'); ?>"/>
									<?php }

											if($shop_isle_link_control){ ?>
												<span class="customize-control-title"><?php _e('Button Link','shop-isle'); ?></span>
												<input type="text" value="<?php if(!empty($icon->link)) echo esc_url($icon->link); ?>" class="shop_isle_link_control" placeholder="<?php _e('Button Link','shop-isle'); ?>"/>
											<?php } ?>

											<input type="hidden" class="shop_isle_box_id" value="<?php if(!empty($icon->id)) echo esc_attr($icon->id); ?>">
											<button type="button" class="shop_isle_general_control_remove_field button" <?php if ($it == 0) echo 'style="display:none;"'; ?>><?php _e('Delete field','shop-isle'); ?></button>
										</label>

									</div>
						<?php
									$it++;
								}
							}
						}

					if ( !empty($this_default) && empty($json)) {	?>
						<input type="hidden" id="shop_isle_<?php echo $options['section']; ?>_repeater_colector" <?php $this->link(); ?> class="shop_isle_repeater_colector" value="<?php echo esc_textarea( $this_default ); ?>" />
				<?php } else {	?>
						<input type="hidden" id="shop_isle_<?php echo $options['section']; ?>_repeater_colector" <?php $this->link(); ?> class="shop_isle_repeater_colector" value="<?php echo esc_textarea( $this->value() ); ?>" />
				<?php } ?>
				</div>

				<button type="button" class="button add_field shop_isle_general_control_new_field"><?php echo $shop_isle_box_add_label; ?></button>

				<?php

		}

	}

endif;
