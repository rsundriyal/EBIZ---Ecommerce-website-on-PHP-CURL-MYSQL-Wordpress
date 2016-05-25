<?php
class Magee_Dummy_Text {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_dummy_text', array( $this, 'render' ) );
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
				'style' 			    =>'',
				'class' 				=>'',
				'id' 				    =>'',
				'amount'          		=>''
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$source = simplexml_load_file( 'http://www.lipsum.com/feed/xml?what=' . esc_attr($style). '&amount=' . esc_attr($amount) . '&start=0' );
		$html = '<div class="'.esc_attr($class).'" id="'.esc_attr($id).'">'.wpautop(str_replace("\n","\n\n",$source->lipsum)).'</div>' ;
		return  $html;
	}
	
}

new Magee_Dummy_Text();		