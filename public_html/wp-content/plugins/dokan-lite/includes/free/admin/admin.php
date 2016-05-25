<?php

/**
 * Class Dokan_Free_Admin_Settings
 *
 * Class for load Admin functionality for Pro Version
 *
 * @since 2.4
 *
 * @author weDevs <info@wedevs.com>
 */
class Dokan_Free_Admin_Settings {

    /**
     * Constructor for the Dokan_Free_Admin_Settings class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @return void
     */
    public function __construct() {
        add_action( 'dokan_admin_menu', array( $this, 'load_admin_settings' ), 10, 2 );
        add_action( 'wp_before_admin_bar_render', array( $this, 'render_free_admin_toolbar' ) );
    }

    /**
     * Load Admin Pro settings
     *
     * @since 2.4
     *
     * @param  string $capability
     * @param  intiger $menu_position
     *
     * @return void
     */
    public function load_admin_settings( $capability, $menu_position ) {

        add_submenu_page( 'dokan', __( 'PRO Features', 'dokan' ), __( 'PRO Features', 'dokan' ), $capability, 'dokan-pro-features', array($this, 'pro_features') );
    }

    /**
     * Seller Listing template
     *
     * @since 2.4
     *
     * @return void
     */
    function pro_features() {
        include dirname(__FILE__) . '/pro-features.php';
    }

    function render_free_admin_toolbar() {

        global $wp_admin_bar;

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $wp_admin_bar->add_menu( array(
            'id'     => 'dokan-pro-features',
            'parent' => 'dokan',
            'title'  => __( 'PRO Features', 'dokan' ),
            'href'   => admin_url( 'admin.php?page=dokan-pro-features' )
        ) );
    }

} // End of Dokan_Free_Admin_Settings class;