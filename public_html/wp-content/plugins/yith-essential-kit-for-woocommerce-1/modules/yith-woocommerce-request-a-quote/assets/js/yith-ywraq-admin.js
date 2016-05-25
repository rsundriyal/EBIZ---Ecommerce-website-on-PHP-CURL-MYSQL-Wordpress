/**
* Javascript functions to administrator pane
*
* @package YITH Woocommerce Request A Quote
* @since   1.0.0
* @version 1.0.0
* @author  Yithemes
*/
jQuery(document).ready(function($) {
    "use strict";

    var select          = $( document).find( '.yith-ywraq-chosen' );

    select.each( function() {
        $(this).chosen({
            width: '350px',
            disable_search: true,
            multiple: true
        })
    });  
});