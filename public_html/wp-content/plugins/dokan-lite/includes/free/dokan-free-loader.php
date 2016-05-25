<?php

/**
 * Dokan Free Feature Loader
 *
 * Load all free functionality in this class
 * if free folder exist then autometically load this class file
 *
 * @since 2.4
 *
 * @author weDevs <info@wedevs.com>
 */

class Dokan_Free_Loader {

    /**
     * Constructor for the Dokan_Free_Loader class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @return void
     */
    public function __construct() {

        $this->defined();

        $this->includes();

        $this->inistantiate();
    }

    public function defined() {
        define( 'DOKAN_FREE_DIR', dirname( __FILE__) );
        define( 'DOKAN_FREE_ADMIN_DIR', dirname( __FILE__).'/admin' );
    }

    /**
     * Load all includes file for Free
     *
     * @since 2.4
     *
     * @return void
     */
    public function includes() {

        if ( is_admin() ) {
            require_once DOKAN_FREE_ADMIN_DIR . '/admin.php';
        }
    }

    /**
     * Inistantiate all classes
     *
     * @since 2.4
     *
     * @return void
     */
    public function inistantiate() {

        if ( is_admin() ) {
            new Dokan_Free_Admin_Settings();
        }
    }
}

new Dokan_Free_Loader();