/**
 * admin.js
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

jQuery(document).ready(function($) {
    "use strict";

    var variation_form = $( document ).find( 'form.variations_form' ),
        get_mail = function(){

        var var_email_input = $(document).find( '#yith-wcwtl-email' ),
            var_email_link  = var_email_input.parents( '#yith-wcwtl-output' ).find( 'a.button' );

        var_email_input.on( 'input', function(e){

            var link_href  = var_email_link.attr( 'href' ),
                email_val  = var_email_input.val(),
                email_name = var_email_input.attr( 'name' );

            var_email_link.prop( 'href', link_href + '&' + email_name + '=' + email_val );
        });
    };


    variation_form.on( 'woocommerce_variation_has_changed', get_mail );
});