<?php

/**
 * Database Version Update
 */

//Add support to YITH Product Vendors db version 1.0.1
function yith_vendors_update_db_1_0_1() {
    $vendors_db_option = get_option( 'yith_product_vendors_db_version', '1.0.0' );
    if ( $vendors_db_option && version_compare( $vendors_db_option, '1.0.1', '<' ) ) {
        global $wpdb;

        $sql = "SELECT woocommerce_term_id as vendor_id, meta_value as user_id
                    FROM {$wpdb->woocommerce_termmeta} as wtm
                    WHERE wtm.meta_key = %s
                    AND woocommerce_term_id IN (
                        SELECT DISTINCT term_id as vendor_id
                        FROM {$wpdb->term_taxonomy} as tt
                        WHERE tt.taxonomy = %s
                    )";

        $results = $wpdb->get_results( $wpdb->prepare( $sql, 'owner', YITH_Vendors()->get_taxonomy_name() ) );

        foreach ( $results as $result ) {
            $user = get_user_by( 'id', $result->user_id );

            if ( $user ) {
                update_woocommerce_term_meta( $result->vendor_id, 'registration_date', get_date_from_gmt( $user->user_registered ) );
                update_woocommerce_term_meta( $result->vendor_id, 'registration_date_gmt', $user->user_registered );
                if( defined( 'YITH_WPV_PREMIUM' ) ){
                    $user->add_cap( 'view_woocommerce_reports' );
                }
            }
        }

        update_option( 'yith_product_vendors_db_version', '1.0.1' );
    }
}

//Add support to YITH Product Vendors db version 1.0.2
function yith_vendors_update_db_1_0_2() {
    $vendors_db_option = get_option( 'yith_product_vendors_db_version', '1.0.0' );
    if ( $vendors_db_option && version_compare( $vendors_db_option, '1.0.2', '<' ) ) {
        global $wpdb;

        $sql = "ALTER TABLE `{$wpdb->prefix}yith_vendors_commissions` CHANGE `rate` `rate` DECIMAL(5,4) NOT NULL";
        $wpdb->query( $sql );

        update_option( 'yith_product_vendors_db_version', '1.0.2' );
    }
}

//Add support to YITH Product Vendors db version 1.0.3
function yith_vendors_update_db_1_0_3(){
    $vendors_db_option = get_option( 'yith_product_vendors_db_version', '1.0.0' );
    if ( $vendors_db_option && version_compare( $vendors_db_option, '1.0.3', '<' ) ) {
        /**
         * Create "Become a Vendor" and Terms and Conditions Pages
         */
         if( defined( 'YITH_WPV_PREMIUM' ) ){
             YITH_Vendors_Admin_Premium::create_plugins_page();
         }

        /**
         * Show Gravatar Option
         */
        $vendors = YITH_Vendors()->get_vendors();
        foreach( $vendors as $vendor ){
            if( empty( $vendor->show_gravatar ) )  {
                $vendor->show_gravatar = 'yes';
            }
        }
        update_option( 'yith_product_vendors_db_version', '1.0.3' );
    }
}

//Add support to YITH Product Vendors plugin version 1.8.1
function yith_vendors_update_db_1_0_4() {
    $vendors_db_option = get_option( 'yith_product_vendors_db_version', '1.0.0' );
    if ( $vendors_db_option && version_compare( $vendors_db_option, '1.0.4', '<' ) ) {
        /**
         * Create "Become a vendor" and "Terms and conditions" Pages
         */
        if( defined( 'YITH_WPV_PREMIUM' ) ){
            YITH_Vendors_Admin_Premium::create_plugins_page();
        }
        update_option( 'yith_product_vendors_db_version', '1.0.4' );
    }
}

//Add support to YITH Product Vendors plugin version 1.9.6
function yith_vendors_update_db_1_0_5() {
    $vendors_db_option = get_option( 'yith_product_vendors_db_version', '1.0.0' );
    if ( $vendors_db_option && version_compare( $vendors_db_option, '1.0.5', '<' ) ) {
        /**
         * Create new DB table yith_vendors_payments and yith_vendors_payments_relathionship
         */
        if( defined( 'YITH_WPV_PREMIUM' ) ){
            YITH_Commissions::create_transaction_table();
        }
        update_option( 'yith_product_vendors_db_version', '1.0.5' );
    }
}

add_action( 'admin_init', 'yith_vendors_update_db_1_0_1' );
add_action( 'admin_init', 'yith_vendors_update_db_1_0_2' );
add_action( 'admin_init', 'yith_vendors_update_db_1_0_3' );
add_action( 'admin_init', 'yith_vendors_update_db_1_0_4' );
add_action( 'admin_init', 'yith_vendors_update_db_1_0_5' );

/**
 * Plugin Version Update
 */
//Add support to YITH Product Vendors plugin version 1.8.1
function yith_vendors_plugin_update_1_8_1() {
    $plugin_version = get_option( 'yith_wcmv_version', '1.0.0' );
    if ( version_compare( $plugin_version, YITH_Vendors()->version, '<' ) ) {
        // _money_spent and _order_count may be out of sync - clear them
        delete_metadata( 'user', 0, '_money_spent', '', true );
        delete_metadata( 'user', 0, '_order_count', '', true );
    }
}

//priority set to 20 after vendor register taxonomy
add_action( 'admin_init', 'yith_vendors_plugin_update_1_8_1', 20 );

/**
 * Regenerate Vendor Role Capabilities fter update by FTP
 */

function yith_vendors_plugin_update() {
    $plugin_version = get_option( 'yith_wcmv_version', '1.0.0' );
    if ( version_compare( $plugin_version, YITH_Vendors()->version, '<' ) ) {
        /* Check if Vendor Role Exists */
        YITH_Vendors::add_vendor_role();
        /* Add Vendor Role to vendor owner and admins */
        YITH_Vendors::setup( 'add_role' );
        update_option( 'yith_wcmv_version', YITH_Vendors()->version );
    }
}
//priority set to 30 after vendor register taxonomy and other actions
add_action( 'admin_init', 'yith_vendors_plugin_update', 30 );

// Deprecated hook yith_wcmv_show_vendor_profile. Look: includes/class.yith-vendors-admin-premium.php:185
add_filter( 'yith_wcmv_hide_vendor_profile', 'yith_deprecated_show_vendor_profile_hook', 9999 );
function yith_deprecated_show_vendor_profile_hook( $value ){
    return apply_filters( 'yith_wcmv_show_vendor_profile', $value );
}

