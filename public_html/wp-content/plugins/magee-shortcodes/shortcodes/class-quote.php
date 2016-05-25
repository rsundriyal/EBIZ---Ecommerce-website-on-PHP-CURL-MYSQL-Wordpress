<?php
class Magee_Quote {

    public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_quote', array( $this, 'render' ) );
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
				'cite'                  =>'',
				'url'                   =>'',
			), $args
		);
        extract( $defaults );
		self::$args = $defaults;
		$cite_link = '';
		if(esc_url($url) && esc_attr($cite))
		$cite_link = '<cite><a href="' . $url . '" target="_blank">'.$cite.'</a></cite>';
		$html ='<div class="magee-blockquote '.esc_attr($class).'" id="'.esc_attr($id).'">';
		$html .='<blockquote><p>'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</p>';
		$html .= '<footer>'.$cite_link.'</footer>' ;
		$html .='</blockquote>'; 
		$html .='</div>';
        return $html;
   }
}

new Magee_Quote();