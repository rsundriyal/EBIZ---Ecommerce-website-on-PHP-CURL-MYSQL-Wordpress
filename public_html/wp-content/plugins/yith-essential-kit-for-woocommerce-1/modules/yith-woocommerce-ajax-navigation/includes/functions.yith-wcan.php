<?php
/**
 * Functions
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.3.2
 */

if ( ! defined( 'YITH_WCAN' ) ) {
    exit;
} // Exit if accessed directly


/**
 * Return a dropdown with Woocommerce attributes
 */
function yith_wcan_dropdown_attributes( $selected, $echo = true ) {
    $attributes = YITH_WCAN_Helper::attribute_taxonomies();
    $options    = "";

    foreach ( $attributes as $attribute ) {
        $options .= "<option name='{$attribute}'" . selected( $attribute, $selected, false ) . ">{$attribute}</option>";
    }

    if ( $echo ) {
        echo $options;
    }
    else {
        return $options;
    }
}


/**
 * Print the widgets options already filled
 *
 * @param $type      string list|colors|label
 * @param $attribute woocommerce taxonomy
 * @param $id        id used in the <input />
 * @param $name      base name used in the <input />
 * @param $values    array of values (could be empty if this is an ajax call)
 *
 * @return string
 */
function yith_wcan_attributes_table( $type, $attribute, $id, $name, $values = array(), $echo = true ) {
    $return = '';

    $terms = get_terms( 'pa_' . $attribute, array( 'hide_empty' => '0' ) );

    if ( 'list' == $type ) {
        $return = '<input type="hidden" name="' . $name . '[colors]" value="" /><input type="hidden" name="' . $name . '[labels]" value="" />';
    }

    elseif ( 'color' == $type ) {
        if ( ! empty( $terms ) ) {
            $return = sprintf( '<table><tr><th>%s</th><th>%s</th></tr>', __( 'Term', 'yith-woocommerce-ajax-navigation' ), __( 'Color', 'yith-woocommerce-ajax-navigation' ) );

            foreach ( $terms as $term ) {
                $return .= "<tr><td><label for='{$id}{$term->term_id}'>{$term->name}</label></td><td><input type='text' id='{$id}{$term->term_id}' name='{$name}[colors][{$term->term_id}]' value='" . ( isset( $values[$term->term_id] ) ? $values[$term->term_id] : '' ) . "' size='3' class='yith-colorpicker' /></td></tr>";
            }

            $return .= '</table>';
        }

        $return .= '<input type="hidden" name="' . $name . '[labels]" value="" />';
    }

    elseif ( 'multicolor' == $type ) {
        if ( ! empty( $terms ) ) {
            $return = sprintf( '<table class="yith-wcan-multicolor"><tr><th>%s</th><th>%s</th><th>%s</th></tr>', __( 'Term', 'yith-woocommerce-ajax-navigation' ), _x( 'Color 1', 'For multicolor: I.E. white and red T-Shirt', 'yith-woocommerce-ajax-navigation' ), _x( 'Color 2', 'For multicolor: I.E. white and red T-Shirt', 'yith-woocommerce-ajax-navigation' ) );

            foreach ( $terms as $term ) {

                $return .= "<tr>";

                $return .= "<td><label for='{$id}{$term->term_id}'>{$term->name}</label></td>";

                $return .= "<td><input type='text' id='{$id}{$term->term_id}_1' name='{$name}[multicolor][{$term->term_id}][]' value='" . ( isset( $values[$term->term_id][0] ) ? $values[$term->term_id][0] : '' ) . "' size='3' class='yith-colorpicker multicolor' /></td>";
                $return .= "<td><input type='text' id='{$id}{$term->term_id}_2' name='{$name}[multicolor][{$term->term_id}][]' value='" . ( isset( $values[$term->term_id][1] ) ? $values[$term->term_id][1] : '' ) . "' size='3' class='yith-colorpicker multicolor' /></td>";

                $return .= '</tr>';
            }

            $return .= '</table>';
        }

        $return .= '<input type="hidden" name="' . $name . '[labels]" value="" />';
    }

    elseif ( 'label' == $type ) {
        if ( ! empty( $terms ) ) {
            $return = sprintf( '<table><tr><th>%s</th><th>%s</th></tr>', __( 'Term', 'yith-woocommerce-ajax-navigation' ), __( 'Labels', 'yith-woocommerce-ajax-navigation' ) );

            foreach ( $terms as $term ) {
                $return .= "<tr><td><label for='{$id}{$term->term_id}'>{$term->name}</label></td><td><input type='text' id='{$id}{$term->term_id}' name='{$name}[labels][{$term->term_id}]' value='" . ( isset( $values[$term->term_id] ) ? $values[$term->term_id] : '' ) . "' size='3' /></td></tr>";
            }

            $return .= '</table>';
        }

        $return .= '<input type="hidden" name="' . $name . '[colors]" value="" />';
    }

    if ( $echo ) {
        echo $return;
    }

    return $return;
}


/**
 * Can the widget be displayed?
 *
 * @return bool
 */
function yith_wcan_can_be_displayed() {
    global $woocommerce, $_attributes_array;

    if (
        is_active_widget( false, false, 'yith-woo-ajax-navigation', true ) ||
        is_active_widget( false, false, 'yith-woo-ajax-navigation-sort-by', true ) ||
        is_active_widget( false, false, 'yith-woo-ajax-navigation-stock-on-sale', true ) ||
        is_active_widget( false, false, 'yith-woo-ajax-navigation-list-price-filter', true )
    ) {
        return true;
    }
    else {
        return false;
    }
}


if ( ! function_exists( 'yit_curPageURL' ) ) {
    /**
     * Retrieve the current complete url
     *
     * @since 1.0
     */
    function yit_curPageURL() {
        $pageURL = 'http';
        if ( isset( $_SERVER["HTTPS"] ) AND $_SERVER["HTTPS"] == "on" ) {
            $pageURL .= "s";
        }

        $pageURL .= "://";

        if ( isset( $_SERVER["SERVER_PORT"] ) AND $_SERVER["SERVER_PORT"] != "80" ) {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        }
        else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }

        return $pageURL;
    }
}

if ( ! function_exists( 'yit_reorder_terms_by_parent' ) ) {
    /**
     * Sort the array of terms associating the child to the parent terms
     *
     * @param $terms mixed|array
     *
     * @return mixed!array
     * @since 1.3.1
     */
    function yit_reorder_terms_by_parent( $terms, $taxonomy ) {

        /* Extract Child Terms */
        $child_terms  = array();
        $terms_count  = 0;
        $parent_terms = array();

        foreach ( $terms as $array_key => $term ) {

            if ( $term->parent != 0 ) {

                $term_parent = $term->parent;
                while( true ){
                    $temp_parent_term = get_term_by( 'id', $term_parent, $taxonomy );
                    if( $temp_parent_term->parent != 0 ){
                        $term_parent = $temp_parent_term->parent;
                    }

                    else {
                        break;
                    }
                }

                if ( isset( $child_terms[$term_parent] ) && $child_terms[$term_parent] != null ) {
                    $child_terms[$term_parent] = array_merge( $child_terms[$term_parent], array( $term ) );
                }
                else {
                    $child_terms[$term_parent] = array( $term );
                }

            }
            else {
                $parent_terms[$terms_count] = $term;
            }
            $terms_count ++;
        }

        if( 'product' == yith_wcan_get_option( 'yith_wcan_ajax_shop_terms_order', 'alphabetical' ) && ! is_wp_error( $parent_terms ) ){
            usort( $parent_terms, 'yit_terms_sort' );
        }

        /* Reorder Therms */
        $terms_count = 0;
        $terms       = array();

        foreach ( $parent_terms as $term ) {

            $terms[$terms_count] = $term;

            /* The term as child */
            if ( array_key_exists( $term->term_id, $child_terms ) ) {

                if( 'product' == yith_wcan_get_option( 'yith_wcan_ajax_shop_terms_order', 'alphabetical' ) && ! is_wp_error( $child_terms[$term->term_id] ) ){
                    usort( $child_terms[$term->term_id], 'yit_terms_sort' );
                }

                foreach ( $child_terms[$term->term_id] as $child_term ) {
                    $terms_count ++;
                    $terms[$terms_count] = $child_term;
                }
            }
            $terms_count ++;
        }

        return $terms;
    }
}

if ( ! function_exists( 'yit_get_terms' ) ) {
    /**
     * Get the array of objects terms
     *
     * @param $type A type of term to display
     *
     * @return $terms mixed|array
     *
     * @since  1.3.1
     */
    function yit_get_terms( $case, $taxonomy, $instance = false ) {

        $exclude = apply_filters( 'yith_wcan_exclude_terms', array(), $instance );
        $include = apply_filters( 'yith_wcan_include_terms', array(), $instance );
        $reordered = false;

        switch ( $case ) {

            case 'all':
                $terms = get_terms( $taxonomy, array( 'hide_empty' => true, 'exclude' => $exclude ) );
                break;

            case 'hierarchical':
                $terms = get_terms( $taxonomy, array( 'hide_empty' => true, 'exclude' => $exclude ) );
                if( ! in_array( $instance['type'], apply_filters( 'yith_wcan_display_type_list', array( 'list' ) ) ) ) {
                    $terms = yit_reorder_terms_by_parent( $terms, $taxonomy );
                    $reordered = true;
                }
                break;

            case 'parent' :
                $terms = get_terms( $taxonomy, array( 'hide_empty' => true, 'parent' => false, 'exclude' => $exclude ) );
                break;

            default:
                $args = array( 'hide_empty' => true, 'exclude' => $exclude, 'include' => $include );
                if ( 'parent' == $instance['display'] ) {
                    $args['parent'] = false;
                }

                $terms = get_terms( $taxonomy, $args );

                if ( 'hierarchical' == $instance['display'] ) {
                    if( ! in_array( $instance['type'], apply_filters( 'yith_wcan_display_type_list', array( 'list' ) ) ) ) {
                        $terms = yit_reorder_terms_by_parent( $terms, $taxonomy );
                        $reordered = true;
                    }
                }
                break;
        }

        if( 'product' == yith_wcan_get_option( 'yith_wcan_ajax_shop_terms_order', 'alphabetical' ) && 'hierarchical' != $instance['display'] && ! is_wp_error( $terms ) && ! $reordered ){
            usort( $terms, 'yit_terms_sort' );
        }

        return apply_filters( 'yith_wcan_get_terms_list', $terms, $taxonomy, $instance );
    }
}

if ( ! function_exists( 'yit_term_is_child' ) ) {
    /**
     * Return true if the term is a child, false otherwise
     *
     * @param $term The term object
     *
     * @return bool
     *
     * @since 1.3.1
     */
    function yit_term_is_child( $term ) {
        return ( isset( $term->parent ) && $term->parent != 0 ) ? true : false;
    }
}

if ( ! function_exists( 'yit_term_is_parent' ) ) {
    /**
     * Return true if the term is a parent, false otherwise
     *
     * @param $term The term object
     *
     * @return bool
     *
     * @since 1.3.1
     */
    function yit_term_is_parent( $term ) {

        return ( isset( $term->parent ) && $term->parent == 0 ) ? true : false;
    }
}

if ( ! function_exists( 'yit_term_has_child' ) ) {
    /**
     * Return true if the term has a child, false otherwise
     *
     * @param $term     The term object
     * @param $taxonomy the taxonomy to search
     *
     * @return bool
     *
     * @since 1.3.1
     */
    function yit_term_has_child( $term, $taxonomy ) {
        global $woocommerce;
        $count       = 0;
        $child_terms = get_terms( $taxonomy, array( 'child_of' => $term->term_id ) );

        if( ! is_wp_error( $child_terms ) ){
            foreach ( $child_terms as $child_term ) {
                $_products_in_term = get_objects_in_term( $child_term->term_id, $taxonomy );
                $count += sizeof( array_intersect( $_products_in_term, $woocommerce->query->filtered_product_ids ) );
            }
        }

        return empty( $count ) ? false : true;
    }
}

if ( ! function_exists( 'yith_wcan_get_option' ) ) {
    /**
     * Retreive the plugin option
     *
     * @param mixed|bool $option_name The option name. If false return alla options array
     *
     *
     * @return mixed|array|string The option(s)
     *
     * @since    1.3.1
     */
    function yith_wcan_get_option( $option_name = false, $default = false ) {
        $options = get_option( 'yit_wcan_options' );

        if ( ! $option_name ) {
            return $options;
        }

        return isset( $options[$option_name] ) ? $options[$option_name] : $default;
    }
}

if ( ! function_exists( 'yit_get_filter_args' ) ) {
    /**
     * Retreive the filter query args option
     *
     * @return array The option(s)
     *
     * @since    1.4
     */
    function yit_get_filter_args( $check_price_filter = true ) {
        $filter_value = array();
        $regexs       = array( '/^filter_[a-zA-Z0-9]/', '/^query_type_[a-zA-Z0-9]/', '/product_tag/' );

        /* Support to YITH WooCommerce Brands */
        if ( defined( 'YITH_WCBR_PREMIUM_INIT' ) && YITH_WCBR_PREMIUM_INIT ) {
            $brands_taxonomy = YITH_WCBR::$brands_taxonomy;
            $regexs[]        = "/{$brands_taxonomy}/";
        }

        if ( ! empty( $_GET ) ) {
            foreach ( $regexs as $regex ) {
                foreach ( $_GET as $query_var => $value ) {
                    if ( preg_match( $regex, $query_var ) ) {
                        $filter_value[$query_var] = $value;
                    }
                }
            }
        }

        if ( $check_price_filter ) {
            // WooCommerce Price Filter
            if ( isset( $_GET['min_price'] ) ) {
                $link = $filter_value['min_price'] = $_GET['min_price'];
            }

            if ( isset( $_GET['max_price'] ) ) {
                $link = $filter_value['max_price'] = $_GET['max_price'];
            }
        }

        // WooCommerce In Stock/On Sale filters
        if ( isset( $_GET['instock_filter'] ) ) {
            $link = $filter_value['instock_filter'] = $_GET['instock_filter'];
        }

        if ( isset( $_GET['onsale_filter'] ) ) {
            $link = $filter_value['onsale_filter'] = $_GET['onsale_filter'];
        }

        if ( isset( $_GET['orderby'] ) ) {
            $link = $filter_value['orderby'] = $_GET['orderby'];
        }

        if ( isset( $_GET['product_tag'] ) ) {
            $link = $filter_value['product_tag'] = urlencode( $_GET['product_tag'] );
        }

        return $filter_value;
    }
}

if ( ! function_exists( 'yit_check_active_price_filter' ) ) {
    /**
     * Check if there is an active price filter
     *
     * @return bool True if the the filter is active, false otherwise
     *
     * @since    1.4
     */
    function yit_check_active_price_filter( $min_price, $max_price ) {
        return isset( $_GET['min_price'] ) && $_GET['min_price'] == $min_price && isset( $_GET['max_price'] ) && $_GET['max_price'] == $max_price;
    }
}

if ( ! function_exists( 'yit_remove_price_filter_query_args' ) ) {
    /**
     * Remove min_price and max_price query args from filters array value
     *
     * @return array The array params
     *
     * @since    1.4
     */
    function yit_remove_price_filter_query_args( $filter_value ) {
        foreach ( array( 'min_price', 'max_price' ) as $remove ) {
            unset( $filter_value[$remove] );
        }

        return $filter_value;
    }
}

if ( ! function_exists( 'yit_get_woocommerce_layered_nav_link' ) ) {
    /**
     * Get current layered link
     *
     * @return string|bool The new link
     *
     * @since    1.4
     * @author Andrea Grillo <andrea.grillo@yithemes.com>
     */
    function yit_get_woocommerce_layered_nav_link() {
        $return = false;
        if ( defined( 'SHOP_IS_ON_FRONT' ) || ( is_shop() && ! is_product_category()  ) ) {
            $taxonomy           = get_query_var( 'taxonomy' );
            $brands_taxonomy    = yit_get_brands_taxonomy();
            $return             = get_post_type_archive_link( 'product' );
            if( ! empty( $brands_taxonomy ) && $brands_taxonomy == $taxonomy ){
                $return = add_query_arg( array( $taxonomy => get_query_var( 'term' ) ), $return );
            }
            return apply_filters( 'yith_wcan_untrailingslashit', true ) ? untrailingslashit( $return ) : $return;
        }

        elseif ( is_product_category() ) {
            $return = get_term_link( get_queried_object()->slug, 'product_cat' );
            return apply_filters( 'yith_wcan_untrailingslashit', true ) ? untrailingslashit( $return ) : $return;
        }

        else {
            $taxonomy           = get_query_var( 'taxonomy' );
            $brands_taxonomy    = yit_get_brands_taxonomy();

            if( ! empty( $brands_taxonomy ) && $brands_taxonomy == $taxonomy ){
                $return = add_query_arg( array( $taxonomy => get_query_var( 'term' ) ), get_post_type_archive_link( 'product' ) );
            }

            else {
                $return = get_term_link( get_query_var( 'term' ), $taxonomy );
            }

            return apply_filters( 'yith_wcan_untrailingslashit', true ) ? untrailingslashit( $return ) : $return;
        }

        return $return;
    }
}

if ( ! function_exists( 'yit_wcan_localize_terms' ) ) {
    /**
     * Get current layered link
     *
     * @param $term_id      The term id
     * @param $taxonomy     The taxonomy name
     *
     * @return string The new term_id
     *
     * @since    1.4
     * @author   Andrea Grillo <andrea.grillo@yithemes.com>
     */

    function yit_wcan_localize_terms( $term_id, $taxonomy ) {
        /* === WPML Support === */
        global $sitepress;
        if ( ! empty( $sitepress ) && function_exists( 'wpml_object_id_filter' ) ) {
            $term_id = wpml_object_id_filter( $term_id, $taxonomy, true, $sitepress->get_default_language() );
        }

        return $term_id;
    }

}

if ( ! function_exists( 'yit_wcan_get_product_taxonomy' ) ) {
    /**
     * Get the product taxonomy array
     * @return array product taxonomy array
     *
     * @since    2.2
     * @author   Andrea Grillo <andrea.grillo@yithemes.com>
     */

    function yit_wcan_get_product_taxonomy() {
        global $_attributes_array;
        $product_taxonomies = ! empty( $_attributes_array ) ? $_attributes_array : get_object_taxonomies( 'product' );
        return array_merge( $product_taxonomies, apply_filters( 'yith_wcan_product_taxonomy_type', array() ) );
    }

}

if( ! function_exists( 'yit_terms_sort' ) ){

    function yit_terms_sort( $a, $b ){
        $result = 0;
        if ( $a->count < $b->count ) {
            $result = 1;
        }

        elseif ( $a->count > $b->count ) {
            $result = - 1;
        }
        return $result;
    }
}

if( ! function_exists( 'yit_get_brands_taxonomy' ) ){
    /**
     * Get the product brands taxonomy name
     *
     * @return string the product brands taxonomy name if YITH WooCommerce Brands addons is currently activated
     *
     * @since    2.7.6
     * @author   Andrea Grillo <andrea.grillo@yithemes.com>
     */
    function yit_get_brands_taxonomy(){
        $taxonomy = '';

        //Support to YITH WooCommerce Brands Add-on
        if( defined( 'YITH_WCBR_PREMIUM_INIT' ) && YITH_WCBR_PREMIUM_INIT ){
            $taxonomy = YITH_WCBR::$brands_taxonomy;
        }

        //Support to Ultimate WooCommerce Brands PRO
        elseif( class_exists( 'MGWB' ) ){
            $taxonomy = "product_brand";
        }
        return $taxonomy;
    }
}

if( ! function_exists( 'yit_reorder_hierachical_categories' ) ) {
    /**
     * Enable multi level taxonomies management
     *
     * @return array the full terms array
     *
     * @since    2.8.1
     * @author   Andrea Grillo <andrea.grillo@yithemes.com>
     */
    function yit_reorder_hierachical_categories( $parent_term_id, $taxonomy = 'product_cat' ) {
        $childs = get_terms(
            $taxonomy,
            array(
                'parent'       => $parent_term_id,
                'hierarchical' => true,
                'hide_empty'   => false
            )
        );

        if ( !empty( $childs ) ) {
            $temp = array();
            foreach ( $childs as $child ) {
                $temp[$child->term_id] = yit_reorder_hierachical_categories( $child->term_id, $taxonomy );
            }
            return $temp;
        }

        else {
            return array();
        }
    }
}

if( ! function_exists( 'remove_premium_query_arg' ) ) {
    /**
     * Remove Premium query args
     *
     * @return array the full terms array
     *
     * @since    2.8.1
     * @author   Andrea Grillo <andrea.grillo@yithemes.com>
     */
    function remove_premium_query_arg( $link ) {
        $reset           = array( 'orderby', 'onsale_filter', 'instock_filter', 'product_tag', 'product_cat' );
        $brands_taxonomy = yit_get_brands_taxonomy();
        if ( ! empty( $brands_taxonomy ) ) {
            $reset[] = $brands_taxonomy;
        }

        return remove_query_arg( $reset, $link );
    }
}

if( ! function_exists( 'yit_is_filtered_uri' ) ){
    /**
     * Get is the current uri are filtered
     *
     * @return bool true if the url are filtered, false otherwise
     *
     * @since    2.8.6
     * @author   Andrea Grillo <andrea.grillo@yithemes.com>
     */
    function yit_is_filtered_uri(){
        global $_chosen_attributes;
        $brands = yit_get_brands_taxonomy();
        $show_all_categories_link_enabled = 'yes' == yith_wcan_get_option( 'yith_wcan_enable_see_all_categories_link', 'no' );
        //check if current page is filtered
        $is_filtered_uri = isset( $_GET['product_cat'] ) || count( $_chosen_attributes ) > 0 || isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) || isset( $_GET['orderby'] ) || isset( $_GET['instock_filter'] ) || isset( $_GET['onsale_filter'] ) || isset( $_GET['product_tag'] ) || isset( $_GET[ $brands ] );

        return apply_filters( 'yit_wcan_is_filtered_uri', $is_filtered_uri );
    }

}