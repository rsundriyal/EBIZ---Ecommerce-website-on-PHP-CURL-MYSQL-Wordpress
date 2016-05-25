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

/**
 * Implements sessions for YITH Live Chat
 *
 * @class   YLC_Session
 * @package Yithemes
 * @since   1.0.0
 * @author  Your Inspiration Themes
 *
 */
class YLC_Session {

    private $session = array();

    /**
     * Constructor
     *
     * @since   1.0.0
     * @return  mixed
     * @author  Alberto Ruggiero
     */
    public function __construct() {

        add_action( 'wp_login', array( $this, 'destroy_session' ) );
        add_action( 'wp_logout', array( $this, 'logout' ) );
        add_action( 'init', array( $this, 'init' ), - 1 );

    }

    /**
     * Set the instance of YLC_Session
     *
     * @since   1.0.0
     * @return  array
     * @author  Alberto Ruggiero
     */
    public function init() {

        $this->session = isset( $_SESSION['yith_live_chat'] ) && is_array( $_SESSION['yith_live_chat'] ) ? $_SESSION['yith_live_chat'] : array();

        return $this->session;
    }

    /**
     * Get session ID
     *
     * @since   1.0.0
     * @return  string
     * @author  Alberto Ruggiero
     */
    public function get_id() {
        return $this->session->session_id;
    }

    /**
     * Get a session variable
     *
     * @since   1.0.0
     *
     * @param   $key
     *
     * @return  string
     * @author  Alberto Ruggiero
     */
    public function get( $key ) {

        return isset( $this->session[$key] ) ? maybe_unserialize( $this->session[$key] ) : false;

    }

    /**
     * Set a session variable
     *
     * @since   1.0.0
     *
     * @param   $key
     * @param   $value
     *
     * @return  mixed
     * @author  Alberto Ruggiero
     */
    public function set( $key, $value ) {

        $this->session[$key]        = $value;
        $_SESSION['yith_live_chat'] = $this->session;

        return $this->session[$key];
    }

    /**
     * Destroy current session
     *
     * @since   1.0.0
     * @return  array
     * @author  Alberto Ruggiero
     */
    public function logout() {

        $this->destroy_session();

        $sess_user = array( 'user_disconnected' => true ); // We should know user disconnected by clicking logout!

        YITH_Live_Chat()->session->set( 'user_data', $sess_user ); // Update user in session

    }

    /**
     * Destroy Session
     *
     * @since   1.0.0
     * @return  void
     * @author  Alberto Ruggiero
     */
    public function destroy_session() {

        YITH_Live_Chat()->session->set( 'user_data', NULL );

        if ( isset( $_SESSION['yith_live_chat'] ) ) {

            unset( $_SESSION['yith_live_chat'] );

        }
    }

}