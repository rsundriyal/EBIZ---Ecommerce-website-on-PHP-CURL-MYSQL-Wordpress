<?php
class Magee_Image_Frame {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_image_frame', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'id' =>'',
				'class' =>'',
				'src' =>'',
				'border_radius' =>'0',
				'light_box' => '',
				'link' =>'',
				'link_target' =>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($border_radius))
		$border_radius = $border_radius.'px';
		
		$addclass = uniqid('radius');
		$class .= ' '.$addclass;
		$css_style = '';
		$css_style .= '.'.$addclass.'{border-radius:'.$border_radius.';}';
		$html = '<style type="text/css">'.$css_style.'</style>';
		$html .= '<div class="img-frame rounded">';
		
        $html .= '<div class="img-box figcaption-middle text-center fade-in '.esc_attr($class).'" id="'.esc_attr($id).'">';
		if( $light_box == 'yes'):
						if( $link !='' ):
						$html .= '<a target="'.esc_attr($link_target).'" href="'.esc_url($link).'" rel="prettyPhoto[pp_gal]">
																		<img src="'.esc_url($src).'" class="feature-img ">
																		<div class="img-overlay dark">
																			<div class="img-overlay-container">
																				<div class="img-overlay-content">
																					<i class="fa fa-search"></i>
																				</div>
																			</div>
																		</div>
																	</a>';
						else:
						
						$html .= ' <img src="'.esc_url($src).'" class="feature-img">
																		<div class="img-overlay dark">
																			<div class="img-overlay-container">
																				<div class="img-overlay-content">
																				</div>
																			</div>
																		</div>';
						
						endif;
                                                    
		else:
		                if( $link !='' ):
						$html .= '<a target="'.esc_attr($link_target).'" href="'.esc_url($link).'">
																		<img src="'.esc_url($src).'" class="feature-img ">
																		<div class="img-overlay dark">
																			<div class="img-overlay-container">
																				<div class="img-overlay-content">
																					<i class="fa fa-link"></i>
																				</div>
																			</div>
																		</div>
																	</a>';
						else:
						
						$html .= ' <img src="'.esc_url($src).'" class="feature-img">
																		<div class="img-overlay dark">
																			<div class="img-overlay-container">
																				<div class="img-overlay-content">
																				</div>
																			</div>
																		</div>';
						
						endif;
		
		endif;											
        $html .= '</div></div>';

  	
		return $html;
	}
	
}

new Magee_Image_Frame();