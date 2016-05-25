<?php
if( ! function_exists( 'yith_wpml_get_translated_id' ) ) {
    /**
     * Get the id of the current translation of the post/custom type
     *
     * @since  2.0.0
     * @author Andrea Frascaspata <andrea.frascaspata@yithemes.com>
     */
    function yith_wpml_get_translated_id( $id, $post_type ) {

        if ( function_exists( 'icl_object_id' ) ) {

            $id = icl_object_id( $id, $post_type, true );

        }

        return $id;
    }
}