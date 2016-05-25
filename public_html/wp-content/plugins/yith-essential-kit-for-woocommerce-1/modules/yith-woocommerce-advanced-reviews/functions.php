<?php

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists ( "yith_define" ) ) {
    /**
     * Defined a constant if not already defined
     *
     * @param string $name  The constant name
     * @param mixed  $value The value
     */
    function yith_define ( $name, $value = true ) {
        if ( ! defined ( $name ) ) {
            define ( $name, $value );
        }
    }
}
