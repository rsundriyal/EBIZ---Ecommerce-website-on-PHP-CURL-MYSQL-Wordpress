<?php
class Magee_Section {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_section', array( $this, 'render' ) );
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
				'id' 					=>'',
				'class' 				=>'',
				'background_color' 		=>'',
				'background_image'		=>'',
				'background_repeat'		=>'',
				'background_position'	=>'',
				'background_parallax'   =>'',
				'border_size' 		    =>'',
				'border_color'			=>'',
				'border_style'			=>'',
				'padding_top'			=>'',
				'padding_bottom'		=>'',
				'padding_left'			=>'',
				'padding_right'			=>'',
				'contents_in_container' =>'yes',
				'top_separator'         => '',
				'bottom_separator'      => '',
				'full_height'           => ''
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$add_class  = uniqid('section-');
		$class     .= ' '.$add_class;
		$css_style  = '';
		$container  = '';
		if( $contents_in_container == 'yes' )
		$container  = 'container';
		else
		$container  = 'container-fullwidth';
		
		
		if( is_numeric($border_size) )
		$border_size = $border_size.'px';
		if( is_numeric($padding_top) )
		$padding_top = $padding_top.'px';
		if( is_numeric($padding_bottom) )
		$padding_bottom = $padding_bottom.'px';
		if( is_numeric($padding_left) )
		$padding_left = $padding_left.'px';
		if( is_numeric($padding_right) )
		$padding_right = $padding_right.'px';
		
		
		$top_separator_html      = '';
		$bottom_separator_html   = '';
		
		switch( $top_separator ){
			
			case "triangle":
			$top_separator_html      = '<div class="magee-section-separator ss-triangle-up"></div>';
			break;
			case "doublediagonal":
			$top_separator_html      = '<div class="magee-section-separator ss-doublediagonal"></div>';
			break;
			case "halfcircle":
			$top_separator_html      = '<div class="magee-section-separator ss-halfcircle-up"></div>';
			break;
			case "bigtriangle":
			if( $background_color ):
			$top_separator_html      .= '
			<style type="text/css">
                                     .'.$add_class.' .ss-bigtriangle-up svg path
                                      {
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;
			$top_separator_html      .= '<div class="magee-section-separator ss-bigtriangle-up">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 100 L50 2 L100 100 Z"></path>
                                        </svg>
                                    </div>';
		
			break;
			case "bighalfcircle":
			if( $background_color ):
			$top_separator_html      .= ' <style type="text/css">
                                        .'.$add_class.' .ss-bighalfcircle-up svg path{
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;
			$top_separator_html      .= '<div class="magee-section-separator ss-bighalfcircle-up">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 100 C 50 0 50 0 100 100 Z"></path>
                                        </svg>
                                    </div>';
			
			break;
			case "curl":
			if( $background_color ):
			$top_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-curl-up svg path{
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;				
			$top_separator_html     .= '<div class="magee-section-separator ss-curl-up">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 100 C 20 0 50 0 100 100 Z"></path>
                                        </svg>
                                    </div>';
			break;
			case "multitriangles":
			if( $background_color ):
			$top_separator_html      .= '<style type="text/css">
                                         .'.$add_class.' .ss-multitriangles-up::before{
                                            box-shadow: -50px 50px 0 '.$background_color.', 50px -50px 0 '.$background_color.'; 
                                        }
                                    </style>';
									
			endif;						
			$top_separator_html      .= '<div class="magee-section-separator ss-multitriangles-up"></div>';
			break;
			case "roundedsplit":
			$top_separator_html      = '<div class="magee-section-separator ss-roundedsplit-up"></div>';
			break;
			case "boxes":
			if( $background_color ):
			$top_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-boxes-up::before {
                                            background-image: -webkit-gradient(linear, 100% 0, 0 100%, color-stop(0.5, transparent), color-stop(0.5, '.$background_color.'));
                                            background-image: linear-gradient(to right, transparent 50%, '.$background_color.' 50%);
                                        }
                                    </style>';
			endif;						
			$top_separator_html      .= '<div class="magee-section-separator ss-boxes-up"></div>';
			break;
			case "zigzag":
			if( $background_color ):
			$top_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-zigzag-up::before {
                                            background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, transparent), color-stop(0.25, '.$background_color.'));
                                            background-image:
                                                linear-gradient(315deg, '.$background_color.' 25%, transparent 25%),
                                                linear-gradient( 45deg, '.$background_color.' 25%, transparent 25%);
                                        }
                                    </style>';
			endif;							
			$top_separator_html      .= '<div class="magee-section-separator ss-zigzag-up"></div>';
			break;
			
			case "clouds":
			if( $background_color ):
			$top_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-clouds-up svg path {
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;				
			$top_separator_html      .= '<div class="magee-section-separator ss-clouds-up">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M-5 100 Q 0 20 5 100 Z
                         M0 100 Q 5 0 10 100
                         M5 100 Q 10 30 15 100
                         M10 100 Q 15 10 20 100
                         M15 100 Q 20 30 25 100
                         M20 100 Q 25 -10 30 100
                         M25 100 Q 30 10 35 100
                         M30 100 Q 35 30 40 100
                         M35 100 Q 40 10 45 100
                         M40 100 Q 45 50 50 100
                         M45 100 Q 50 20 55 100
                         M50 100 Q 55 40 60 100
                         M55 100 Q 60 60 65 100
                         M60 100 Q 65 50 70 100
                         M65 100 Q 70 20 75 100
                         M70 100 Q 75 45 80 100
                         M75 100 Q 80 30 85 100
                         M80 100 Q 85 20 90 100
                         M85 100 Q 90 50 95 100
                         M90 100 Q 95 25 100 100
                         M95 100 Q 100 15 105 100 Z">
                                            </path>
                                        </svg>
                                    </div>';
			break;
			
			}
		
		switch( $bottom_separator ){
			
			case "triangle":
			$bottom_separator_html = '<div class="magee-section-separator ss-triangle-down"></div>';
			break;
			case "halfcircle":
			$bottom_separator_html = '<div class="magee-section-separator ss-halfcircle-down"></div>';
			break;
			case "bigtriangle":
			if( $background_color ):
			$bottom_separator_html = '<style type="text/css">
                                      .'.$add_class.' .ss-bigtriangle-down svg path {
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
				endif;					
			$bottom_separator_html .= '<div class="magee-section-separator ss-bigtriangle-down">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 102" preserveAspectRatio="none">
                                            <path d="M0 0 L50 100 L100 0 Z"></path>
                                        </svg>
                                    </div>';
			
			break;
			case "bighalfcircle":
			if( $background_color ):
			$bottom_separator_html      = ' <style type="text/css">
                                        .'.$add_class.' .ss-bighalfcircle-down svg path {
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;
			$bottom_separator_html .= '<div class="magee-section-separator ss-bighalfcircle-down">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 0 C 50 100 50 100 100 0 Z"></path>
                                        </svg>
                                    </div>';
			break;
			case "curl":
			if( $background_color ):
			$bottom_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-curl-down svg path {
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;	
			$bottom_separator_html .= '<div class="magee-section-separator ss-curl-down">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 0 C 50 100 80 100 100 0 Z"></path>
                                        </svg>
                                    </div>';
			break;
			case "multitriangles":
			if( $background_color ):
			$bottom_separator_html      .= '<style type="text/css">
                                         .'.$add_class.' .ss-multitriangles-down::after {
                                            box-shadow: -50px 50px 0 '.$background_color.', 50px -50px 0 '.$background_color.'; 
                                        }
                                    </style>';
									
			endif;	
			$bottom_separator_html .= '<div class="magee-section-separator ss-multitriangles-down"></div>';
			break;
			case "roundedcorners":
			$bottom_separator_html = '<div class="magee-section-separator ss-roundedcorners-down"></div>';
			break;
			case "foldedcorner":
			$bottom_separator_html = '<div class="magee-section-separator ss-foldedcorner"></div>';
			break;
			case "boxes":
			if( $background_color ):
			$bottom_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-boxes-up::before,
                                        .'.$add_class.' .ss-boxes-down::after {
                                            background-image: -webkit-gradient(linear, 100% 0, 0 100%, color-stop(0.5, transparent), color-stop(0.5, '.$background_color.'));
                                            background-image: linear-gradient(to right, transparent 50%, '.$background_color.' 50%);
                                        }
                                    </style>';
			endif;
			$bottom_separator_html .= ' <div class="magee-section-separator ss-boxes-down"></div>';
			break;
			case "zigzag":
			if( $background_color ):
			$bottom_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-zigzag-up::before {
                                            background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, transparent), color-stop(0.25, '.$background_color.'));
                                            background-image:
                                                linear-gradient(315deg, '.$background_color.' 25%, transparent 25%),
                                                linear-gradient( 45deg, '.$background_color.' 25%, transparent 25%);
                                        }
                                        .'.$add_class.' .ss-zigzag-down::after {
                                            background-image: -webkit-gradient(linear, 0 0, 300% 100%, color-stop(0.25, '.$background_color.'), color-stop(0.25, transparent));
                                            background-image: 
                                                linear-gradient(135deg, '.$background_color.' 25%, transparent 25%),
                                                linear-gradient(225deg, '.$background_color.' 25%, transparent 25%);
                                        }
                                    </style>';
			endif;				
			$bottom_separator_html .= '<div class="magee-section-separator ss-zigzag-down"></div>';
			break;
			case "stamp":
			if( $background_color ):
			$bottom_separator_html      .= '<style type="text/css">
                                        .'.$add_class.' .ss-stamp-down svg path {
                                            fill: '.$background_color.';
                                            stroke: '.$background_color.';
                                        }
                                    </style>';
			endif;					
			$bottom_separator_html .= ' <div class="magee-section-separator ss-stamp-down">
                                        <svg id="" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 0 Q 2.5 40 5 0 Q 7.5 40 10 0Q 12.5 40 15 0Q 17.5 40 20 0Q 22.5 40 25 0Q 27.5 40 30 0Q 32.5 40 35 0Q 37.5 40 40 0Q 42.5 40 45 0Q 47.5 40 50 0 Q 52.5 40 55 0Q 57.5 40 60 0Q 62.5 40 65 0Q 67.5 40 70 0Q 72.5 40 75 0Q 77.5 40 80 0Q 82.5 40 85 0Q 87.5 40 90 0Q 92.5 40 95 0Q 97.5 40 100 0 Z"></path>
                                        </svg>
                                    </div>';
			break;
			
		}


		

		if( $background_color )
		$css_style .= '.'.$add_class.'{ background-color:'.esc_attr($background_color).';}';
		if( $background_image )
		$css_style .= '.'.$add_class.'{ background-image: url('.esc_url($background_image).');}';
		if( $background_repeat )
		$css_style .= '.'.$add_class.'{ background-repeat:'.esc_attr($background_repeat).'; }';
		if( $background_position )
		$css_style .= '.'.$add_class.'{ background-position :'.esc_attr($background_position).';}';
		
		if( $border_size )
		$css_style .= '.'.$add_class.'{ border-size :'.esc_attr($border_size).';}';
		if( $border_color )
		$css_style .= '.'.$add_class.'{ border-color :'.esc_attr($border_color).';}';
		if( $border_style )
		$css_style .= '.'.$add_class.'{ border-style :'.esc_attr($border_style).';}';
		
		if( $padding_top )
		$css_style .= '.'.$add_class.'{ padding-top :'.esc_attr($padding_top).';}';
		if( $padding_bottom )
		$css_style .= '.'.$add_class.'{ padding-bottom :'.esc_attr($padding_bottom).';}';
		if( $padding_left )
		$css_style .= '.'.$add_class.'{ padding-left :'.esc_attr($padding_left).';}';
		if( $padding_right )
		$css_style .= '.'.$add_class.'{ padding-right :'.esc_attr($padding_right).';}';
		if( $background_parallax == 'yes' )
		$class  .= ' parallax-scrolling';
		
		$styles  = sprintf( '<style type="text/css" scoped="scoped">%s </style>',$css_style);		
		$content = do_shortcode( Magee_Core::fix_shortcodes($content));
		$html  = '';
		
		if( $top_separator == 'triangle' ){
		if ( $full_height == 'yes'):
		 $html   .= sprintf('%s<section class="section magee-section %s fullheight verticalmiddle" id="%s">%s<div class="section-content"><div class="%s">%s</div></div> %s</section>',$styles,esc_attr($class),esc_attr($id),$top_separator_html,$container,$content,$bottom_separator_html);
		else:
		$html   .= sprintf('%s<section class="section magee-section %s" id="%s">%s <div class="section-content"><div class="%s">%s</div></div> %s</section>',$styles,esc_attr($class),esc_attr($id),$top_separator_html,$container,$content,$bottom_separator_html);
		endif;
		
		}else{
		if ( $full_height == 'yes'):
        $html   .= sprintf('%s<section class="section magee-section %s fullheight verticalmiddle" id="%s"><div class="section-content"><div class="%s">%s</div></div> %s %s</section>',$styles,esc_attr($class),esc_attr($id),$container,$content,$top_separator_html,$bottom_separator_html);
		else:
		$html   .= sprintf('%s<section class="section magee-section %s" id="%s"> <div class="section-content"><div class="%s">%s</div></div>%s %s</section>',$styles,esc_attr($class),esc_attr($id),$container,$content,$top_separator_html,$bottom_separator_html);

		endif;
		}
		return $html;
	}
	
}

new Magee_Section();