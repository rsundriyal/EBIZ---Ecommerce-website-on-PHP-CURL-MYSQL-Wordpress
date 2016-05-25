<?php
/**
 * Alchem Theme Customizer
 *
 * @package alchem
 */


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function alchem_customize_preview_js() {
	wp_enqueue_script( 'alchem_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'alchem_customize_preview_js' );
