<?php 

/**
 * Create HTML dropdown list of Categories.
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class Dokan_Walker_Tag_Multi extends Walker {

    /**
     * @see Walker::$tree_type
     * @var string
     */
    var $tree_type = 'category';

    /**
     * @see Walker::$db_fields
     * @var array
     */
    var $db_fields = array('parent' => 'parent', 'id' => 'term_id');

    /**
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $category Category data object.
     * @param int $depth Depth of category. Used for padding.
     * @param array $args Uses 'selected' and 'show_count' keys, if they exist.
     */
    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $pad = str_repeat( '&nbsp;', $depth * 3 );

        $cat_name = apply_filters( 'list_cats', $category->name, $category );
        $output .= "\t<option class=\"level-$depth\" value=\"" . $category->term_id . "\"";
        if ( in_array( $category->term_id, $args['selected'] ) )
            $output .= ' selected="selected"';
        $output .= '>';
        $output .= $pad . $cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;(' . $category->count . ')';
        $output .= "</option>\n";
    }

}