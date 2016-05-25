<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if we don't see the uninstall flag
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Global DB object
global $wpdb;

// Clean up our options
delete_option( 'bu_search_meta_keys' );

// Clean up our MySQL table
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}better_user_search_meta_keys" );