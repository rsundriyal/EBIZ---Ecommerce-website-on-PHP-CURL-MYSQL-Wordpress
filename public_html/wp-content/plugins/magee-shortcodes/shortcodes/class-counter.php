<?php


class Magee_Counter {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_counter', array( $this, 'render' ) );
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
				'top_icon' => '',
				'top_icon_color' =>'',
				'left_icon' => '',
				'left_text' =>'',
				'counter_num' =>'',
				'right_text' =>'',
				'title'        =>'',
				'border' =>'0'
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$class .= ' box-border';
		$addclass = uniqid('color');
		$class   .= ' '.$addclass;
		$css_style = '';
		if( $top_icon_color)
		$css_style .= '.'.$addclass.' .counter-top-icon i{color:'.$top_icon_color.'}';
		$html  = '<style  type="text/css">'.$css_style.'</style>';
		
		if( $border == '1' ):
		$html .= '<div class="magee-counter-box '.esc_attr($class).'" id="'.esc_attr($id).'">';
		else:
		$html .= '<div class="magee-counter-box " id="'.esc_attr($id).'">';
		endif;
		if( $top_icon )
		    if( stristr($top_icon,'fa-')):
			$html .= '<div class="counter-top-icon"><i class="fa '.esc_attr($top_icon).'"></i></div>';
			else:
			$html .= '<div class="counter-top-icon"><img class="image-instead" src="'.esc_attr($top_icon).'" /></div>'; 
		    endif;   
		$html .= '<div class="counter">';
        if( $left_icon )       
		    if( stristr($left_icon,'fa-')):
			$html .= '<i class="fa '.esc_attr($left_icon).'"></i> '; 
			else:
			$html .= '<img class="image-instead" src="'.esc_attr($left_icon).'" />';
		    endif;                               
		if( $left_text )
		$html .= '<span class="unit">'.esc_attr($left_text).'</span>';
		if( $counter_num )
		$html .= '<span class="counter-num">'.esc_attr($counter_num).'</span>';
		if( $right_text )
		$html .= '<span class="unit">'.esc_attr($right_text).'</span>';
		
        $html .= '</div>';                                             
                                                
        $html .= '<h3 class="counter-title">'.esc_attr($title).'</h3>';
        $html .= '</div>';
											
		return $html;
	} 
	
}

new Magee_Counter();