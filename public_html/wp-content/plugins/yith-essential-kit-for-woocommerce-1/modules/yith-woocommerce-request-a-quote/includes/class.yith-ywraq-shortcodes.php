<?php
if ( !defined( 'ABSPATH' ) || ! defined( 'YITH_YWRAQ_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * YITH_YWRAQ_Shortcodes add shortcodes to the request quote list
 *
 * @class 	YITH_YWRAQ_Shortcodes
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @author  Yithemes
 */
class YITH_YWRAQ_Shortcodes {


    /**
     * Constructor for the shortcode class
     *
     */
    public function __construct() {

        add_shortcode( 'yith_ywraq_request_quote', array( $this, 'request_quote_list' ) );

    }

    public function request_quote_list( $atts, $content = null ) {

        $raq_content  = YITH_Request_Quote()->get_raq_return();
        $args         = array(
            'raq_content'   => $raq_content,
            'template_part' => 'view'
        );
        $args['args'] = $args;

        ob_start();

        yit_plugin_get_template( YITH_YWRAQ_DIR, 'request-quote.php', $args );

        return ob_get_clean();
    }


}

