<?php
class Magee_Flip_Box {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_flip_box', array( $this, 'render' ) );
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
				'direction'					=>'horizontal',
				'front_paddings'					=>'',
				'front_background'				=>'',
				'front_color'		=>'',
				'back_paddings'		=>'',
				'back_background'				=>'',
				'back_color'					=>'',
			), $args
		);
		
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($front_paddings))
		$front_paddings = $front_paddings.'px';
		if(is_numeric($back_paddings))
		$back_paddings = $back_paddings.'px';
		
		$uniq_class = uniqid('flip_box-');
		$class .= ' '.$uniq_class;
		$class .= ' '.$direction;
		$html   = '';
		if( $content ):
		
		$contentsplit  = explode("|||",$content);
		$front_content = isset($contentsplit[0])?$contentsplit[0]:'';
		$back_content = isset($contentsplit[1])?$contentsplit[1]:'';
		
		$html = '<style type="text/css" scoped="scoped">.'.$uniq_class.' .flipbox-front{background-color:'.$front_background.';}.'.$uniq_class.' .flipbox-front .flipbox-content{padding:'.$front_paddings.';}.'.$uniq_class.' .flipbox-back{background-color:'.$back_background.';}.'.$uniq_class.' .flipbox-back .flipbox-content{padding:'.$back_paddings.';}</style>';
		$html .= '<div class="magee-flipbox-wrap '.$class.'" id="'.$id.'">
                                                <div class="magee-flipbox">
                                                    <div class="flipbox-front">
                                                        <div class="flipbox-content">
                                                            '. do_shortcode( Magee_Core::fix_shortcodes($front_content)).'
                                                        </div>
                                                    </div>
                                                    <div class="flipbox-back">
                                                        <div class="flipbox-content">
                                                           '. do_shortcode( Magee_Core::fix_shortcodes($back_content)).'
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
		
		endif;
		
		return $html;
	}
	
}

new Magee_Flip_Box();