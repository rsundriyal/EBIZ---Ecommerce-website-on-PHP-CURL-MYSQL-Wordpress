<?php
class Magee_Divider {

	public static $args;
    private  $id;
	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_divider', array( $this, 'render' ) );
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
				'style'					=>'normal',
				'align'                 =>'',
				'width'					=>'100',
				'margin_top'			=>'',
				'margin_bottom'			=>'',
				'border_size'			=>'',
				'border_color'			=>'',
				'icon'					=>'fa-leaf',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($width)) 
		$width = $width.'px';
		if(is_numeric($margin_top))
		$margin_top = $margin_top.'px';
		if(is_numeric($margin_bottom))
		$margin_bottom = $margin_bottom.'px';
		if(is_numeric($border_size))
		$border_size = $border_size.'px';
		
		$uniq_class = uniqid('divider-');
		
		$class .= ' divider';
		$class .= ' '.$uniq_class;
		
		// normal/shadow/dotted/dashed/double line/double dashed/double dotted/image/icon/back_to_top/title_left/
		switch( $style ){
			case "normal":
			$class .= ' divider-border';
			break;
			case "shadow":
			$class .= ' divider-shadow';
			break;
			case "dotted":
			$class .= ' divider-border dotted';
			break;
			case "dashed":
			$class .= ' divider-border dashed';
			break;
			case "double_line":
			$class .= ' divider divider-border double-line';
			break;
			case "double_dashed":
			$class .= ' divider-border dashed double-line';
			break;
			case "double_dotted":
			$class .= ' divider-border dotted double-line';
			break;
			case "icon":
			$class .= ' divider-icon center';
			break;
			case "back_to_top":
			$class .= ' divider-back-to-top';
			break;
			case "image":
			$class .= '  divider-image';
			break;
			
			}
            if( $align == 'center' )
			$class .= ' center';
		
		$textstyle = sprintf('.'.$uniq_class.'{ margin-top: %s;margin-bottom:%s;width:%s;}.'.$uniq_class.' .divider-border{border-bottom-width:%s; border-color:%s;}.'.$uniq_class.' .double-line.divider-inner-item .divider-inner{border-top-width: %s; border-bottom-width: %s;}.'.$uniq_class.' .divider-border.divider-inner-item .divider-inner{ border-bottom-width: %s;}',$margin_top,$margin_bottom,$width,$border_size,$border_color,$border_size,$border_size,$border_size);
		
		$styles = sprintf( '<style type="text/css" scoped="scoped">%s </style>', $textstyle);	
		
		
		$html = '<div class="'.esc_attr($class).'" id="'.esc_attr($id).'" style="margin-top:; margin-bottom:;"><div class="divider-inner divider-border"></div></div>';
		if( $style == 'icon' ):				
        $html = '<div class="'.esc_attr($class).'" id="'.esc_attr($id).'" style="margin-top:; margin-bottom:;">
		<div class="divider-inner">
		    <div class="divider-inner-item divider-border double-line">
				<div class="divider-inner"></div>
			</div>
			<div class="divider-inner-item divider-inner-icon">';
			if( stristr($icon,'fa-')):
			$html .= '<i class="fa '.esc_attr($icon).'"></i>';
			else:
			$html .= '<img class="image-instead" src="'.esc_attr($icon).'"/>';
			endif;
			$html .= '</div>
			<div class="divider-inner-item divider-border double-line">
			     <div class="divider-inner"></div>
			</div>
		</div>
	    </div>';
		endif;
		if( $style == 'back_to_top' )	
		$html = '<div class="'.esc_attr($class).'" id="'.esc_attr($id).'">
		<div class="divider-inner divider-border">
		   <div class="divider-inner-item divider-border">
			 <div class="divider-inner"></div>
		   </div>
		   <div class="divider-inner-item divider-inner-back-to-top">
			 <a href="#" class="magee-back-to-top"><i class="fa fa-arrow-up"></i></a>
		   </div>
		</div>
		</div>';							
		
		$html = $styles.$html;
    
		return $html;
	}
	
}

new Magee_Divider();