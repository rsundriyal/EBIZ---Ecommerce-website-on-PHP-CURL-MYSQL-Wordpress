<?php
class Magee_Promo_Box {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_promo_box', array( $this, 'render' ) );
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
				'style'                 =>'',
				'border_color'			=>'',
				'border_width'			=>'0',
				'border_position'		=>'left',
				'background_color'		=>'',
				'button_color'			=>'',
				'button_link'			=>'#',
				'button_icon'			=>'',
				'button_text'			=>'',
				'button_text_color'     =>'', 
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($border_width))
		$border_width = $border_width.'px';
		
		$uniq_class = uniqid('promo_box-');
		$action_class = uniqid('promo-action-');
		$class .= ' '.$uniq_class;
		$html   = '';
        if($button_text == ''){
		
		$html .= '<style type="text/css" scoped="scoped">.'.$action_class.'{display:none;}</style>' ;
		}
		$textstyle = sprintf('.'.$uniq_class.'.boxed{border-'.esc_attr($border_position).'-width: %s; background-color:%s;border-'.esc_attr($border_position).'-color:%s;}',$border_width,$background_color,$border_color);
		
		$css_style = '';
		if( $button_color !='' )
		$css_style .=sprintf('.'.$uniq_class.' .promo-action a{background-color:%s;',$button_color);
		if($button_text_color !='')
		$css_style .=sprintf('.'.$uniq_class.' .promo-action a{color:%s;',$button_text_color);
		
		if( $style == 'boxed'){
		$class .= ' boxed';
		$html .= sprintf( '<style type="text/css" scoped="scoped">%s </style>', $textstyle);	
		}
		
		if( $css_style !='' )
		$html .= sprintf( '<style type="text/css" scoped="scoped">%s </style>', $css_style);	
		
		
		$html .= '<div class="magee-promo-box '.esc_attr($class).'" id="'.esc_attr($id).'">
                                        <div class="promo-info">
                                            '. do_shortcode( Magee_Core::fix_shortcodes($content)).'
                                        </div>								
                                        <div class="promo-action '.$action_class.'">
                                            <a href="'.esc_url($button_link).'" class="btn-normal btn-lg">';
											if( stristr($button_icon,'fa-')):
		 							        $html .= '<i class="fa '.esc_attr($button_icon).'"></i>'; 
											else:
											$html .= '<img src="'.esc_attr($button_icon).'" class="image_instead"/>'; 
											endif;
		$html .= 						    esc_attr($button_text).'</a>
                                        </div>
                                    </div>';
		
		$html .= '<script>
	    jQuery(function($) {
	      if($("#magee-sc-form-preview").length>0){
				 $("#magee-sc-form-preview").contents().find(".promo-action a").on("click",function(e){
				    if($(this).attr("href") == "#"){
					   e.preventDefault();
				    }
				 });
		      }
		  });           
		</script>';
		return $html;
	}
	
}

new Magee_Promo_Box();