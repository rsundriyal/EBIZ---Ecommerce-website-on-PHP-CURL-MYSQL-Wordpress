<?php

if (!defined('ABSPATH')) exit; // exit if accessed directly

/**
 * SIP_Cookie_Check_Woocommerce_Shortcode class
 */
class SIP_Cookie_Check_Woocommerce_Shortcode {

  /**
   * __construct function
   *
   * @access public
   * @return void
   *
   */
  public function __construct() {

    // includes
    include_once('sip-cookie-check-woocommerce-functions.php');

    // add shortcode
    add_shortcode('sip-cookie-check', array($this,'sip_cookie_check_wc'));
    add_action('wp_enqueue_scripts', array($this, 'sip_cookie_check_wc_frontend_scripts'));
  }

  /**
   * syc handler function
   *
   * @access public
   * @return void
   *
   */
  public function sip_cookie_check_wc() {

    $cookieCallout = $this->checkCookies();
    echo '<div class="sip_cookie_check">' . $cookieCallout. '</div>';
  }

  /**
   * checkCookies function
   *
   * @access public
   * @param none
   * @return string
   *
   */
  public function checkCookies() { ?>
    <?php $tooltip_display = "" ;?>
    <?php $url = "" ;?>
    <?php if(get_option('sip-ccwc-affiliate-check-box') == "true") { ?>
      <?php $options = get_option('sip-ccwc-affiliate-radio'); ?>
      <?php if( 'value1' == $options['option_three'] ) { $url = "https://shopitpress.com/?utm_source=referral&utm_medium=credit&utm_campaign=sip-cookie-check-woocommerce" ; } ?>
      <?php if( 'value2' == $options['option_three'] ) { $url = "https://shopitpress.com/?offer=". esc_attr( get_option('sip-ccwc-affiliate-affiliate-username')) ; } ?>
      <?php $tooltip_display = '<a class="sip-ccwc-credit" href="'.$url.'" target="_blank" data-tooltip="Powered by SIP Cookie Check for WooCommerce"></a>'; ?> 
    <?php } ?>
    <?php
      $sip_cookie_warning_css = "";
      if( get_option('sip_ccwc_css_enable_desable', false) == false) {
        $sip_cookie_warning_css = "sip-check sip-danger";
      }
    ?>
    <script type="text/javascript">
      jQuery(document).ready(function(){
        jQuery(".sip_cookie_check").append(navigator.cookieEnabled?'':'<div class="<?php echo $sip_cookie_warning_css; ?>"><?php echo nl2br(get_option( 'sip_ccwc_message_editor' )) ?> &nbsp;&nbsp; <?php echo $tooltip_display; ?></div>')
      });
    </script>
  	<?php
  }

  public function sip_cookie_check_wc_frontend_scripts() {

    wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", false, null);
    wp_enqueue_script('jquery');
    wp_enqueue_style('sip-cookie-check-check-frontend', '' . SIP_CCWC_URL . '/assets/css/sip-cookie-check-woocommerce-frontend.css');

  }

} // end SIP_Cookie_Check_Woocommerce_Shortcode

new SIP_Cookie_Check_Woocommerce_Shortcode();
