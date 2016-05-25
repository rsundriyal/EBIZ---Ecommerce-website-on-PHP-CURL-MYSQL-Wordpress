<?php
class Magee_Featurebox {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_featurebox', array( $this, 'render' ) );
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
				'style' => 1, // 1-4
				'title_font_size' =>'',
				'title_color' =>'',
				'icon_circle' => 'no',
				'icon_size'=>'', 
				'title'=>'',
				'icon' => '',
				'alignment'=>'left', // left,right (style2/style3)
				'icon_animation_type'=>'',
				'icon_color'=>'',
				'icon_background_color'=>'',
				'icon_border_color'=>'',
				'icon_border_width'=>'',
				'flip_icon'=>'none', // none/horizontal/vertical
				//'rotate_icon'=>'0',
				'spinning_icon'=>'no',
				'icon_image'=>'',
				'icon_image_width'=>'',
				'icon_image_height'=>'',
				'link_url'=>'',
				'link_target'=>'',
				'link_text'=>'',
				'link_color'=>'',
				'content_color'=>'',
				'content_box_background_color' =>'',//(style 4)
				
			), $args
		);
		
		
		extract( $defaults );
		self::$args = $defaults;
		
		$uniq_class =  uniqid('feature-box-');
		$css_style  = '';
		$icon_class = '';
		$icon_box_class = '';
		$class     .= ' '.$uniq_class;
		
		if( is_numeric($title_font_size))
		$title_font_size = $title_font_size.'px';
		if( is_numeric($icon_border_width))
		$icon_border_width = $icon_border_width.'px';
		if( is_numeric($icon_size))
		$icon_size = $icon_size.'px';
		if(is_numeric($icon_image_width))
        $icon_image_width = $icon_image_width.'px';
		if(is_numeric($icon_image_height))
		$icon_image_height = $icon_image_height.'px';		
		
		if( $title_font_size )
		$css_style .= '.'.$uniq_class.' h3 {font-size:'.$title_font_size.';}';
		if( $title_color )
		$css_style .= '.'.$uniq_class.' h3 {color:'.$title_color.';}';
        if( $icon_circle == 'yes' )
		$icon_box_class .= ' icon-circle';
		if( $spinning_icon == 'yes' )
		$icon_class .= ' fa-spin';
		
		
		if( $icon_color )
		$css_style .= '.'.$uniq_class.' .icon-box{color:'.$icon_color.';}';
		if( $icon_background_color )
		$css_style .= '.'.$uniq_class.' .icon-box{background-color:'.$icon_background_color.';}';
		if( $icon_border_color )
		$css_style .= '.'.$uniq_class.' .icon-box{border-color:'.$icon_border_color.';}';
		if( $icon_border_width )
		$css_style .= '.'.$uniq_class.' .icon-box{border-width:'.$icon_border_width.';}';
		if( $link_color )
		$css_style .= '.'.$uniq_class.' .feature-link{color:'.$link_color.';}';
		if( $content_color )
		$css_style .= '.'.$uniq_class.' .feature-content,.'.$uniq_class.' .feature-content p{color:'.$content_color.';}';
		
		if( $content_box_background_color )
		$css_style .= '.'.$uniq_class.'.style4{background-color:'.$content_box_background_color.';}';
		
		if( $icon_size )
		$css_style .= '.'.$uniq_class.' .icon-box{font-size:'.$icon_size.';}';
		
		
		if( $flip_icon =='horizontal' )
		$icon_class .=' fa-flip-horizontal';
		if( $flip_icon =='vertical' )
		$icon_class .=' fa-flip-vertical';
		
			
		
		if( ($style == 2 || $style == 3) && $alignment == 'right' )
		$class .= ' reverse';
		
             $html  = '<style  type="text/css">'.$css_style.'</style>';
			 $html .= '<div class="magee-feature-box style'.esc_attr($style).' '.esc_attr($class).'" id="'.esc_attr($id).'" data-os-animation="fadeOut">';
			 if( $link_url )
             $html .= ' <a class="feature-box-icon-link"  href="'.esc_url($link_url).'" target="'.esc_attr($link_target).'">';
             if( $icon_image !='' ){
             $html .= '<img class="feature-box-icon" src="'.esc_url($icon_image).'" alt="" style="width:'.$icon_image_width.'; height:'.$icon_image_height.';">';
			 }
             else{
				 if( $icon !=''){
				 
             $html .= '<div class="icon-box '.$icon_box_class.'" data-animation="'.esc_attr($icon_animation_type).'"> <i class="feature-box-icon fa '.esc_attr($icon).' '.$icon_class.' "></i></div>';
				 }
			 }
			  if( $link_url )
            $html .= '</a>';
			 if( $link_url )
            $html .= '<a href="'.esc_url($link_url).'" target="'.esc_attr($link_target).'">';
			$html .= '<h3>'.esc_attr($title).'</h3>';
			 if( $link_url )
			$html .= '</a>';
			
            $html .= '<div class="feature-content"><p>'. do_shortcode( Magee_Core::fix_shortcodes($content)).'</p><a href="'.esc_url($link_url).'" target="'.esc_attr($link_target).'" class="feature-link">'.esc_attr($link_text).'</a></div></div>';
		
	
  	
		return $html;
	}
	
}

new Magee_Featurebox();