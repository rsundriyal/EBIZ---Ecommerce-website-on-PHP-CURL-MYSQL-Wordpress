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

if ( !function_exists( 'ylc_sanitize_text' ) ) {

    /**
     * Sanitize strings
     *
     * @since   1.0.0
     *
     * @param   $string
     * @param   $html
     *
     * @return  string
     * @author  Alberto ruggiero
     */
    function ylc_sanitize_text( $string, $html = false ) {
        if ( $html ) {
            return html_entity_decode( addslashes( $string ) );
        }
        else {
            return addslashes( $string );
        }
    }

}

if ( !function_exists( 'ylc_get_plugin_options' ) ) {

    /**
     * Get plugin options
     *
     * @since   1.0.0
     * @return  array
     * @author  Alberto ruggiero
     */
    function ylc_get_plugin_options() {

        $user_prefix = '';
        $user_type   = 'visitor';

        if ( defined( 'YLC_OPERATOR' ) && is_admin() ) {

            $user_prefix = 'ylc-op-';
            $user_type   = 'operator';

        }
        elseif ( is_user_logged_in() ) {

            $user_prefix = 'usr-';

        }

        $options = array(
            'app_id'    => esc_html( YITH_Live_Chat()->options['firebase-appurl'] ),
            'user_info' => array(
                'user_id'      => $user_prefix . YITH_Live_Chat()->user->ID,
                'user_name'    => apply_filters( 'ylc_nickname', YITH_Live_Chat()->user->display_name ),
                'user_email'   => YITH_Live_Chat()->user->user_email,
                'gravatar'     => md5( YITH_Live_Chat()->user->user_email ),
                'user_type'    => $user_type,
                'avatar_type'  => apply_filters( 'ylc_avatar_type', 'default' ),
                'avatar_image' => apply_filters( 'ylc_avatar_image', '' ),
                'current_page' => YITH_Live_Chat()->user->current_page,
                'user_ip'      => YITH_Live_Chat()->user->user_ip
            ),
        );

        if ( !is_admin() && defined( 'YLC_PREMIUM' ) ) {
            $options['styles'] = apply_filters( 'ylc_plugin_opts_premium', array() );
        }

        ylc_print_plugin_options( $options );

    }

}

if ( !function_exists( 'ylc_print_plugin_options' ) ) {

    /**
     * Print plugin options
     *
     * @since   1.0.0
     *
     * @param   $options
     * @param   $property
     *
     * @return  array
     * @author  Alberto ruggiero
     */
    function ylc_print_plugin_options( $options, $property = null ) {

        $total_opts = count( $options );

        if ( $property ) {
            echo $property . ": {\n\t\t\t\t";
        }

        $i = 1;

        foreach ( $options as $option_key => $option_value ) {

            $comma = ( $i < $total_opts ) ? ",\n\t\t\t" : "\n";

            if ( !is_array( $option_value ) ) {                                        // Print single line option

                $val = ( is_int( $option_value ) || is_numeric( $option_value ) ) ? $option_value : "'$option_value'";  // Sanitize value

                echo $option_key . ': ' . $val . $comma;                                                                    // Print option

            }
            else {                                                                                                        // Print array option

                ylc_print_plugin_options( $option_value, $option_key );

            }

            $i ++;
        }

        if ( $property ) {
            echo "},\n\t\t\t";
        }

    }

}

if ( !function_exists( 'ylc_get_current_page' ) ) {

    /**
     * Get the current page name
     *
     * @since   1.0.0
     * @return  string
     * @author  Alberto ruggiero
     */
    function ylc_get_current_page() {

        global $pagenow;

        if ( !empty( $_GET['page'] ) ) {

            return $_GET['page'];
        }
        else {
            return $pagenow;
        }

    }

}

if ( !function_exists( 'ylc_set_firebase_security' ) ) {

    /**
     * Sets firebase security rules
     *
     * @since   1.0.0
     * @return  void
     * @author  Alberto ruggiero
     */
    function ylc_set_firebase_security() {

        $options = YITH_Live_Chat()->options;

        if ( !empty( $options['firebase-appurl'] ) && !empty( $options['firebase-appsecret'] ) ) {

            $ylc_security_version = get_option( 'ylc_security_version' );

            if ( empty( $ylc_security_version ) || version_compare( $ylc_security_version, YLC_VERSION, '<' ) ) {

                require_once YLC_DIR . '/includes/firebase/firebaseInterface.php';
                require_once YLC_DIR . '/includes/firebase/firebaseLib.php';

                $rules_json = file_get_contents( YLC_DIR . 'assets/ylc-rules.json' );
                $path       = 'https://' . esc_html( $options['firebase-appurl'] ) . '.firebaseio.com/';
                $firebase   = new FirebaseLib( $path, esc_html( $options['firebase-appsecret'] ) );

                $resp = json_decode( $firebase->set( '/.settings/rules', $rules_json ) );

                if ( !empty( $resp->status ) ) {

                    if ( $resp->status == 'ok' ) {
                        update_option( 'ylc_security_version', YLC_VERSION );
                    }

                }

            }

        }

    }

    add_action( 'admin_init', 'ylc_set_firebase_security' );

}

if ( !function_exists( 'ylc_set_defaults' ) ) {

    /**
     * Sets default options on database
     *
     * @since   1.1.0
     * @return  void
     * @author  Alberto ruggiero
     */
    function ylc_set_defaults() {

        $ylc_options_version = get_option( 'ylc_options_version' );

        if ( empty( $ylc_options_version ) || version_compare( $ylc_options_version['number'], YLC_VERSION, '<' ) || ( $ylc_options_version['version'] == 'free' && defined( 'YLC_PREMIUM' ) ) ) {

            $existing_options = get_option( 'yit_' . YITH_Live_Chat()->_options_name . '_options' );
            $default_options  = YITH_Live_Chat()->defaults;

            $options = empty( $existing_options ) ? $default_options : array_merge( $default_options, $existing_options );

            update_option( 'yit_' . YITH_Live_Chat()->_options_name . '_options', $options );

            $ylc_options_version = array(
                'number'  => YLC_VERSION,
                'version' => defined( 'YLC_PREMIUM' ) ? 'premium' : 'free'
            );

            update_option( 'ylc_options_version', $ylc_options_version );

        }

    }

    add_action( 'init', 'ylc_set_defaults' );


}