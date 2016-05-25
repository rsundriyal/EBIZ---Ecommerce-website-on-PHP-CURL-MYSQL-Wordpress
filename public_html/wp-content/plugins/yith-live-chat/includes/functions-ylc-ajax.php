<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( !function_exists( 'ylc_ajax_callback' ) ) {

    /**
     * Manage AJAX Callbacks
     *
     * @since   1.0.0
     * @return  array
     * @author  Alberto Ruggiero
     */
    function ylc_ajax_callback() {

        // Response var
        $resp = array();

        try {

            // Handling the supported actions:
            switch ( $_GET['mode'] ) {

                case 'get_token':
                    $resp = ylc_ajax_get_token();
                    break;

                case 'save_chat':
                    $resp = ylc_ajax_save_chat( $_POST );
                    break;

                case 'offline_form':
                    $resp = ylc_ajax_offline_form( $_REQUEST );
                    break;

                case 'chat_evaluation':
                    $resp = ylc_ajax_evaluation( $_POST );
                    break;
                default:
                    throw new Exception( 'Wrong action: ' . @$_REQUEST['mode'] );
            }

        } catch ( Exception $e ) {
            $resp['err_code'] = $e->getCode();
            $resp['error']    = $e->getMessage();
        }

        // Response output
        header( "Content-Type: application/json" );

        echo json_encode( $resp );

        exit;

    }

    add_action( 'wp_ajax_ylc_ajax_callback', 'ylc_ajax_callback' );
    add_action( 'wp_ajax_nopriv_ylc_ajax_callback', 'ylc_ajax_callback' );

}

if ( !function_exists( 'ylc_ajax_get_token' ) ) {

    /**
     * Get token
     *
     * @since   1.0.0
     * @return  array
     * @author  Alberto Ruggiero
     */
    function ylc_ajax_get_token() {

        $token = YITH_Live_Chat()->user_auth();

        return array( 'token' => $token );
    }

}

if ( !function_exists( 'ylc_ajax_save_chat' ) ) {

    /**
     * Save chat transcripts if premium active
     *
     * @since   1.0.0
     *
     * @param   $data
     *
     * @return  array
     * @author  Alberto Ruggiero
     */
    function ylc_ajax_save_chat( $data ) {

        $msg = array( 'msg' => __( 'Successfully closed!', 'yith-live-chat' ) );

        if ( defined( 'YLC_PREMIUM' ) ) {

            $msg = ylc_save_chat_data( $data );
        }

        return $msg;
    }

}