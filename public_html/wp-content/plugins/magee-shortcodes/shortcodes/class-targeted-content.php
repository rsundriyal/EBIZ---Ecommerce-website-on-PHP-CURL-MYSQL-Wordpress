<?php
class Magee_Targeted_content {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_targeted_content', array( $this, 'render' ) );
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
				'type'      => '',
				'alternative'    => '',
			), $args
		);
		extract( $defaults );
		self::$args = $defaults;
		$html = '';
		switch(esc_attr($type)){
		case 'private':
		   if(current_user_can( 'publish_posts' ) ):
		        $html .= '<div class="content-private">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>'  ;
		   else:
		        $html .= '<div class="content-private-no">'.esc_attr($alternative).'</div>'  ;
		   endif;	
		break;
		case 'members':
		   if( is_user_logged_in()):
		        $html .= '<div class="content-members">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>'  ;
		   else:
		        $html .= '<div class="content-members-no">'.esc_attr($alternative).'</div>'  ;	
		   endif;	
		break;
		case 'guests':
		   if( !is_user_logged_in()):
		        $html .= '<div class="content-guests">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>'  ;
		   else:
		   	    $html .= '<div class="content-guests-no">'.esc_attr($alternative).'</div>'  ;	
		   endif;		
		break;
	    }
		return $html;		
	}
	
}

new Magee_Targeted_content();		