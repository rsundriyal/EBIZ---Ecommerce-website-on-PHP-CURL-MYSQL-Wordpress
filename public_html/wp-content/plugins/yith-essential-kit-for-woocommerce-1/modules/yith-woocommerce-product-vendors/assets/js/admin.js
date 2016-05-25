(function ($) {

    /* WooCommerce Options Deps */
    $.fn.yith_wpv_option_deps = function( dep, type, disabled_value, readonly ){

        var main_option = $(this),
            disable     = $(dep).parents('tr'),
            get_value   = function( type ){
                if (type == 'checkbox') {
                    return main_option.attr('checked');
                }

                if (type == 'select') {
                    return main_option.val();
                }
            },

            value = get_value( type );

        var disable_opt = function(){
                disable.css('opacity', '0.3');
                disable.css( 'pointer-events', 'none' );
                if( readonly ){
                    disable.attr( 'readonly', 'readonly' );
                }
            },

            enable_opt = function(){
                disable.css('opacity', '1');
                disable.css( 'pointer-events', 'auto' );
                if( readonly ){
                    disable.removeAttr( 'readonly' );
                }
            };

        if (value == disabled_value) {
            disable_opt();
        }

        main_option.on('change', function () {
            value = get_value( type );
            if (value != disabled_value) {
                enable_opt();
            }

            else {
                disable_opt();
            }
        });

        main_option.add( $(dep)).trigger( 'yith_wcmv_after_option_deps' );
    }

    var button = $('#yith_wpv_vendors_skip_review_for_all'),
         $body = $('body');

    button.on('click', function (e) {
        var accept = confirm( yith_vendors.forceSkipMessage );
        if (accept) {
            $.ajax({
                url       : ajaxurl,
                data      : { action: 'wpv_vendors_force_skip_review_option' },
                beforeSend: function () {
                    $('.spinner').toggleClass('yith-visible');
                },
                success   : function (data) {
                    $('.spinner').toggleClass('yith-visible');
                }
            });
        }
    });

    // commission pay
    $('table.commissions').on( 'click', '.button.pay', function(){
        return confirm( yith_vendors.warnPay );
    });

    //PayPal Standard Fix
    var paypal_service = $('#payment_gateway'),
        payment_method = $('#payment_method'),
        paypal_deps = function(){
            if( paypal_service.val() == 'standard' ){
                payment_method.val( 'manual').trigger('change');
            }
        };

    paypal_service.on( 'change', paypal_deps );

    //Vendors options deps
    var vendor_name_style   = $('#yith_wpv_vendor_name_style'),
        vendor_order_refund = $('#yith_wpv_vendors_option_order_management');

    $('#yith_wpv_enable_product_amount').yith_wpv_option_deps( '#yith_wpv_vendors_product_limit', 'checkbox', undefined, false );
    $('#yith_wpv_report_abuse_link').yith_wpv_option_deps( '#yith_wpv_report_abuse_link_text', 'select', 'none', false );
    vendor_name_style.yith_wpv_option_deps( '#yith_vendors_color_name', 'select', 'theme', true );
    vendor_name_style.yith_wpv_option_deps( '#yith_vendors_color_name_hover', 'select', 'theme', true );
    $('#yith_wpv_vendors_my_account_registration').yith_wpv_option_deps( '#yith_wpv_vendors_my_account_registration_auto_approve', 'checkbox', undefined, false );
    vendor_order_refund.yith_wpv_option_deps( '#yith_wpv_vendors_option_order_synchronization', 'checkbox', undefined, false );
    vendor_order_refund.yith_wpv_option_deps( '#yith_wpv_vendors_option_order_refund_synchronization', 'checkbox', undefined, false );
    vendor_order_refund.yith_wpv_option_deps( '#yith_wpv_vendors_option_order_hide_customer', 'checkbox', undefined, false );
    vendor_order_refund.yith_wpv_option_deps( '#yith_wpv_vendors_option_order_hide_payment', 'checkbox', undefined, false );
    $('#yith_vendors_show_gravatar_image').yith_wpv_option_deps( '#yith_vendors_gravatar_image_size', 'select', 'disabled', false );
    $('#yith_wpv_vendors_option_editor_management').yith_wpv_option_deps( '#yith_wpv_vendors_option_editor_media', 'checkbox', undefined, false );
    paypal_service.yith_wpv_option_deps( payment_method, 'select', 'standard', true );
    payment_method.yith_wpv_option_deps( '#payment_minimum_withdrawals', 'select', 'manual', true );

    // Vendor taxonomy table
    var tax_table = $( '#the-list');

    var taxonomy_table_col = function( tax_table ) {
        tax_table.find('tr').each( function () {
                var t = $(this),
                    column_enable_sales = t.find('.column-enable_sales mark');

                if( column_enable_sales.hasClass( 'pending' ) ){
                    t.css( 'background-color', '#fef7f1' );
                    t.find( '.check-column').css( 'border-left', '4px solid #d54e21' );
                }

                if( column_enable_sales.hasClass( 'no-owner' ) ){
                    t.css( 'background-color', '#fffbf2' );
                    t.find( '.check-column').css( 'border-left', '4px solid #ffba00' );
                }
            }
        );
    }

    taxonomy_table_col( tax_table );

    // Vendor taxonomy bulk actions
    if( $body.hasClass( 'taxonomy-yith_shop_vendor' ) && typeof yith_vendors != 'undefined' ){
        var bulk_action_1   = $('#bulk-action-selector-top'),
            bulk_action_2   = $('#bulk-action-selector-bottom'),
            action_approve       = '<option value="approve">' + yith_vendors.approve + '</option>',
            action_enable_sales  = '<option value="enable_sales">' + yith_vendors.enable_sales + '</option>',
            action_disable_sales  = '<option value="disable_sales">' + yith_vendors.disable_sales + '</option>',
            actions = new Array( action_approve, action_enable_sales, action_disable_sales );

        for( var id in actions ){
            bulk_action_1.add( bulk_action_2 ).append( actions[ id ] );
        }
    }

    //Remove product reviews from product detail page
    if( yith_vendors_caps.reviews == 'no' && $body.hasClass('vendor_limited_access') && $body.hasClass('post-type-product') ){
        $('#commentsdiv').remove();
    }
}(jQuery));
