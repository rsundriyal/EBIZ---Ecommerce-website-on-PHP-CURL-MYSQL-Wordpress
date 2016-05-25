<?php
class Magee_Pullquote {

    public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_pullquote', array( $this, 'render' ) );
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
				'align'                 =>'',	
			), $args
		);
        extract( $defaults );
		self::$args = $defaults;
		$style = '';
		$html = '';
		if($align == 'left'):
		$html .='<blockquote id="'.esc_attr($id).'" class="'.esc_attr($class).'">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</blockquote>' ;
        else:
		$html .='<blockquote id="'.esc_attr($id).'" class="blockquote-reverse '.esc_attr($class).'">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</blockquote>' ;
		endif;
		
		
		return $html;
   }
}

new Magee_Pullquote();