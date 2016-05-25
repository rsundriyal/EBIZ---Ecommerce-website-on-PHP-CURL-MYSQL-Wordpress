<?php
/*
  Plugin Name: Magee Shortcodes
  Plugin URI: http://www.mageewp.com/magee-shortcode.html
  Description: Magee Shortcodes is WordPress plugin that provides a pack of shortcodes. With Magee Shortcodes, you can easily create accordion, buttons, boxes, columns, social and much more. They allow you to create so many different page layouts. You could quickly and easily built your own custom pages using all the various shortcodes that Magee Shortcodes includes.
  Version: 1.5.3
  Author: MageeWP
  Author URI: http://www.mageewp.com
  Text Domain: magee-shortcodes
  Domain Path: /languages
  License: GPLv2 or later
*/
if ( ! defined( 'ABSPATH' ) ) return;
if(!class_exists('Magee_Core') && !defined( 'MAGEE_SHORTCODE_LIB_DIR') ):
define( 'MAGEE_SHORTCODES_PATH', __FILE__ );
define( 'MAGEE_SHORTCODES_DIR_PATH',  plugin_dir_path( __FILE__ ));
define( 'MAGEE_SHORTCODES_VER', '1.5.3' );

 require_once 'inc/core.php';
 //require_once 'inc/options.php';
 require_once 'inc/magee-slider.php';
 new Magee_Core;
 
 add_filter( 'the_content', array('Magee_Core','fix_shortcodes') );
 add_filter( 'the_content', array('Magee_Core','unrecognize_shortcodes') );
 endif;