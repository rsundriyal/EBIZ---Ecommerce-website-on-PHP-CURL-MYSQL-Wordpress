<?php
if ( !defined( 'ABSPATH' ) || ! defined( 'YITH_YWRAQ_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements helper functions for YITH Woocommerce Request A Quote
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @author  Yithemes
 */

if ( !function_exists( 'yith_ywraq_locate_template' ) ) {
    /**
     * Locate the templates and return the path of the file found
     *
     * @param string $path
     * @param array  $var
     *
     * @return void
     * @since 1.0.0
     */
    function yith_ywraq_locate_template( $path, $var = NULL ) {
        global $woocommerce;

        if ( function_exists( 'WC' ) ) {
            $woocommerce_base = WC()->template_path();
        }
        elseif ( defined( 'WC_TEMPLATE_PATH' ) ) {
            $woocommerce_base = WC_TEMPLATE_PATH;
        }
        else {
            $woocommerce_base = $woocommerce->plugin_path() . '/templates/';
        }

        $template_woocommerce_path = $woocommerce_base . $path;
        $template_path             = '/' . $path;
        $plugin_path               = YITH_YWRAQ_DIR . 'templates/' . $path;

        $located = locate_template( array(
            $template_woocommerce_path, // Search in <theme>/woocommerce/
            $template_path,             // Search in <theme>/
            $plugin_path                // Search in <plugin>/templates/
        ) );

        if ( !$located && file_exists( $plugin_path ) ) {
            return apply_filters( 'yith_ywraq_locate_template', $plugin_path, $path );
        }

        return apply_filters( 'yith_ywraq_locate_template', $located, $path );
    }
}

if ( !function_exists( 'yith_ywraq_get_product_meta' ) ) {
    function yith_ywraq_get_product_meta( $raq, $echo = true ) {
        /**
         * Return the product meta in a varion product
         *
         * @param array $raq
         * @param bool  $echo
         *
         * @return string
         * @since 1.0.0
         */
        $item_data = array();

        // Variation data
        if ( !empty( $raq['variation_id'] ) && is_array( $raq['variations'] ) ) {

            foreach ( $raq['variations'] as $name => $value ) {

                if ( '' === $value ) {
                    continue;
                }

                $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

                // If this is a term slug, get the term's nice name
                if ( taxonomy_exists( $taxonomy ) ) {
                    $term = get_term_by( 'slug', $value, $taxonomy );
                    if ( !is_wp_error( $term ) && $term && $term->name ) {
                        $value = $term->name;
                    }
                    $label = wc_attribute_label( $taxonomy );


                } else {
                    $custom_att = str_replace( 'attribute_', '', $name);

                    if ( $custom_att != '' ) {
                        $label = wc_attribute_label( $custom_att );
                    } else {
                        $label = $name;
                    }


                }

                $item_data[] = array(
                    'key'   => $label,
                    'value' => $value
                );

            }
        }

        $out = "";
        // Output flat or in list format
        if ( sizeof( $item_data ) > 0 ) {
            foreach ( $item_data as $data ) {
                if ( $echo ) {
                    echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . "\n";
                }
                else {
                    $out .= ' - ' . esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . ' ';
                }
            }
        }

        return $out;

    }
}


if ( !function_exists( 'yith_ywraq_get_product_meta_from_order_item' ) ) {
    function yith_ywraq_get_product_meta_from_order_item( $item_meta, $echo = true ) {
        /**
         * Return the product meta in a varion product
         *
         * @param array $raq
         * @param bool  $echo
         *
         * @return string
         * @since 1.0.0
         */
        $item_data = array();

        // Variation data
        if ( !empty( $item_meta ) ) {

            foreach ( $item_meta as $name => $val ) {

                if ( empty( $val ) ) {
                    continue;
                }

                $taxonomy = $name;

                // If this is a term slug, get the term's nice name
                if ( taxonomy_exists( $taxonomy ) ) {
                    $term = get_term_by( 'slug', $val[0], $taxonomy );
                    if ( !is_wp_error( $term ) && $term && $term->name ) {
                        $value = $term->name;
                    }
                    $label = wc_attribute_label( $taxonomy );

                    $item_data[] = array(
                        'key'   => $label,
                        'value' => $value
                    );

                }
            }
        }

        $out = "";
        // Output flat or in list format
        if ( sizeof( $item_data ) > 0 ) {
            foreach ( $item_data as $data ) {
                if ( $echo ) {
                    echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . "\n";
                }
                else {
                    $out .= ' - ' . esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . ' ';
                }
            }
        }

        return $out;

    }
}

/****** NOTICES *****/
/**
 * Get the count of notices added, either for all notices (default) or for one
 * particular notice type specified by $notice_type.
 *
 * @since 2.1
 * @param string $notice_type The name of the notice type - either error, success or notice. [optional]
 * @return int
 */
function yith_ywraq_notice_count( $notice_type = '' ) {
    $session = YITH_Request_Quote()->session_class;
    $notice_count = 0;
    $all_notices  = $session->get( 'yith_ywraq_notices', array() );

    if ( isset( $all_notices[$notice_type] ) ) {

        $notice_count = absint( sizeof( $all_notices[$notice_type] ) );

    } elseif ( empty( $notice_type ) ) {

        foreach ( $all_notices as $notices ) {
            $notice_count += absint( sizeof( $all_notices ) );
        }

    }

    return $notice_count;
}

/**
 * Add and store a notice
 *
 * @since 2.1
 * @param string $message The text to display in the notice.
 * @param string $notice_type The singular name of the notice type - either error, success or notice. [optional]
 */
function yith_ywraq_add_notice( $message, $notice_type = 'success' ) {

    $session = YITH_Request_Quote()->session_class;
    $notices = $session->get( 'yith_ywraq_notices', array() );

    // Backward compatibility
    if ( 'success' === $notice_type ) {
        $message = apply_filters( 'yith_ywraq_add_message', $message );
    }

    $notices[$notice_type][] = apply_filters( 'yith_ywraq_add_' . $notice_type, $message );

    $session->set( 'yith_ywraq_notices', $notices );

}

/**
 * Prints messages and errors which are stored in the session, then clears them.
 *
 * @since 2.1
 */
function yith_ywraq_print_notices() {

    $session = YITH_Request_Quote()->session_class;
    $all_notices  =$session->get( 'yith_ywraq_notices', array() );
    $notice_types = apply_filters( 'yith_ywraq_notice_types', array( 'error', 'success', 'notice' ) );

    foreach ( $notice_types as $notice_type ) {
        if ( yith_ywraq_notice_count( $notice_type ) > 0 ) {
            wc_get_template( "notices/{$notice_type}.php", array(
                'messages' => $all_notices[$notice_type]
            ) );
        }
    }

    yith_ywraq_clear_notices();
}

/**
 * Unset all notices
 *
 * @since 2.1
 */
function yith_ywraq_clear_notices() {
    $session = YITH_Request_Quote()->session_class;
    $session->set( 'yith_ywraq_notices', null );
}


/****** PREMIUM FUNCTIONS *****/


function ywraq_get_order_status_tag( $status ){
    switch( $status ){
        case 'ywraq-new':
            echo '<span class="raq_status new">'.__('new','yith-woocommerce-request-a-quote').'</span>';
            break;
        case 'ywraq-pending':
            echo '<span class="raq_status pending">'.__('pending','yith-woocommerce-request-a-quote').'</span>';
            break;
        case 'ywraq-expired':
            echo '<span class="raq_status expired">'.__('expired','yith-woocommerce-request-a-quote').'</span>';
            break;
        case 'ywraq-new':
            echo '<span class="raq_status new">'.__('new','yith-woocommerce-request-a-quote').'</span>';
            break;
        case 'ywraq-rejected':
            echo '<span class="raq_status rejected">'.__('rejected','yith-woocommerce-request-a-quote').'</span>';
            break;
        case 'pending':
            echo '<span class="raq_status accepted">'.__('accepted','yith-woocommerce-request-a-quote').'</span>';
            break;
        default:
            echo '<span class="raq_status accepted">'.__('accepted','yith-woocommerce-request-a-quote').'</span>';
    }
}
/****** HOOKS *****/
function yith_ywraq_show_button_in_single_page(){
    $general_show_btn = get_option('ywraq_show_btn_single_page');
    if ( $general_show_btn == 'yes' ){  //check if the product is in exclusion list
        global $product;
        $hide_quote_button = get_post_meta( $product->id, '_ywraq_hide_quote_button', true);
        if ( $hide_quote_button == 1 ) return 'no';
    }

    return $general_show_btn;
}

function yith_ywraq_show_button_in_other_pages( $setting_option ){

    if( $setting_option == 'no' ) return $setting_option;

    global $product;
    $hide_quote_button = get_post_meta( $product->id, '_ywraq_hide_quote_button', true);
    $general_show_btn = get_option('ywraq_show_btn_exclusion');

    if ( $general_show_btn == 'yes' ){  //check if the product is in exclusion list
        if ( $hide_quote_button == 1 ) return 'no';
    }
    return 'yes';
}
/**
 * Get list of forms by YIT Contact Form plugin
 *
 * @param   $array array
 * @since   1.0.0
 * @author  Emanuela Castorina
 * @return  array
 */
function yith_ywraq_get_contact_forms(){
    if( ! function_exists( 'YIT_Contact_Form' ) ){
        return array( '' => __( 'Plugin not activated or not installed', 'yith-woocommerce-request-a-quote' ) );
    }

    $posts = get_posts( array(
        'post_type' => YIT_Contact_Form()->contact_form_post_type
    ) );

    foreach( $posts as $post ){
        $array[ $post->post_name ] = $post->post_title;
    }

    if( $array == array() ) return array( '' => __( 'No contact form found', 'ywctm' ) );

    return $array;
}

/**
 * Get list of forms by Contact Form 7 plugin
 *
 * @param   $array array
 * @since   1.0.0
 * @author  Emanuela Castorina
 * @return  array
 */
function yith_ywraq_wpcf7_get_contact_forms(){
    if( ! function_exists( 'wpcf7_contact_form' ) ){
        return array( '' => __( 'Plugin not activated or not installed', 'yith-woocommerce-request-a-quote' ) );
    }

    $posts = WPCF7_ContactForm::find();

    foreach( $posts as $post ){
        $array[ $post->id() ] = $post->title();
    }

    if( $array == array() ) return array( '' => __( 'No contact form found', 'yith-woocommerce-request-a-quote' ) );

    return $array;
}


function yith_ywraq_email_custom_tags( $text, $tag, $html){

    if( $tag == 'yith-request-a-quote-list' ){
        return yith_ywraq_get_email_template($html);
    }
}

function yith_ywraq_get_email_template( $html ) {
    $raq_data['raq_content'] = YITH_Request_Quote()->get_raq_return();
    ob_start();
    if ( $html ) {
        wc_get_template( 'emails/request-quote-table.php', array(
            'raq_data' => $raq_data
        ) );
    }
    else {
        wc_get_template( 'emails/plain/request-quote-table.php', array(
            'raq_data' => $raq_data
        ) );
    }
    return ob_get_clean();
}

function yith_ywraq_quote_list_shortcode( $shortcodes ){
    $shortcodes['%yith-request-a-quote-list%'] =   yith_ywraq_get_email_template(true);
    return $shortcodes;
}
add_filter('yit_contact_form_shortcodes', 'yith_ywraq_quote_list_shortcode' );


function ywraq_get_token( $action, $order_id, $email){
    return wp_hash( $action.'|'. $order_id .'|'. $email, 'yith-woocommerce-request-a-quote' );
}

function ywraq_verify_token( $token, $action, $order_id, $email){
    $expected = wp_hash( $action.'|'. $order_id .'|'. $email, 'yith-woocommerce-request-a-quote' );
    if ( hash_equals( $expected, $token ) ) {
        return 1;
    }
    return 0;
}

function ywraq_get_browse_list_message(){
    return apply_filters( 'ywraq_product_added_view_browse_list' , __( 'Browse the list', 'yith-woocommerce-request-a-quote' ) );
}