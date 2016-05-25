<?php

/********************************
** adamrob.co.uk - 2OCT2014
** Parallax Scroll Wordpress Plugin
**
** For Help and Support please visit www.adamrob.co.uk
**
** Custom Post Type
********************************/

/***
** CREATE CUSTOM POST TYPE
***/

// Register the Custom Post Type
function register_cpt_parallax_scroll() {
 
    $labels = array(
        'name' => _x( 'Parallax Scroll', 'parallax_scroll' ),
        'singular_name' => _x( 'Parallax Scroll', 'parallax_scroll' ),
        'add_new' => _x( 'Add New', 'parallax_scroll' ),
        'add_new_item' => _x( 'Add New Parallax', 'parallax_scroll' ),
        'edit_item' => _x( 'Edit Parallax', 'parallax_scroll' ),
        'new_item' => _x( 'New Parallax', 'parallax_scroll' ),
        'view_item' => _x( 'View Parallax', 'parallax_scroll' ),
        'search_items' => _x( 'Search Parallax Items', 'parallax_scroll' ),
        'not_found' => _x( 'No parallax items found', 'parallax_scroll' ),
        'not_found_in_trash' => _x( 'No parallax items found in Trash', 'parallax_scroll' ),
        'parent_item_colon' => _x( 'Parent Parallax:', 'parallax_scroll' ),
        'menu_name' => _x( 'Parallax Scroll', 'parallax_scroll' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Parallax Scroll',
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'public' => false, //cam this be false??
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => NULL, //default pos below comments
        'menu_icon' => 'dashicons-slides',
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'page'
    );
 
    register_post_type( PARALLAX_POSTTYPE, $args );
}
add_action( 'init', 'register_cpt_parallax_scroll' );



/***
** ADD CUSTOM COLUMN TO POST TYPE
***/
function addnew_cols_parallax_scroll($parallax_scroll_columns) {
    //Create the columns required in admin
    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = _x('Parallax Name', 'column name');
    $new_columns['shortcode'] = __('Shortcode');
    $new_columns['author'] = __('Author'); 
    $new_columns['date'] = _x('Date', 'column name');
 
    return $new_columns;
}
add_filter('manage_edit-'.PARALLAX_POSTTYPE.'_columns', 'addnew_cols_parallax_scroll');


/***
** ADD CUSTOM COLUMN DATA
***/ 
function manage_parallax_scroll_columns($column_name, $id) {
    global $wpdb;
    switch ($column_name) {
    case 'shortcode':
        echo '['.PARALLAX_SHORTCODE.' id="' . $id . '"]';
            break;
 
    default:
        break;
    } // end switch
}
add_action('manage_'.PARALLAX_POSTTYPE.'_posts_custom_column', 'manage_parallax_scroll_columns', 10, 2);


?>