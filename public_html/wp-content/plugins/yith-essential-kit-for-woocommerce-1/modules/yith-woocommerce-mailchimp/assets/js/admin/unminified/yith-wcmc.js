/**
 * General admin panel handling
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
 * @version 1.0.0
 */

jQuery( document ).ready( function( $ ){
    var list_select = $( '#yith_wcmc_mailchimp_list, #yith_wcmc_shortcode_mailchimp_list, #yith_wcmc_widget_mailchimp_list, #yith_wcmc_export_list'),
        group_select = $( '#yith_wcmc_mailchimp_groups, #yith_wcmc_shortcode_mailchimp_groups, #yith_wcmc_shortcode_mailchimp_groups_selectable, #yith_wcmc_widget_mailchimp_groups, #yith_wcmc_widget_mailchimp_groups_selectable');

    // add updater button
    list_select.after( $( '<a>').addClass( 'button button-secondary ajax-mailchimp-updater ajax-mailchimp-updater-list').attr( 'id', 'yith_wmcm_mailchimp_list_updater').attr( 'href', '#').text( yith_wcmc.labels.update_list_button ));
    group_select.after( $( '<a>').addClass( 'button button-secondary ajax-mailchimp-updater ajax-mailchimp-updater-group').attr( 'id', 'yith_wcmc_mailchimp_group_updater').attr( 'href', '#').text( yith_wcmc.labels.update_group_button ));

    var handle_lists = function( ev ){
            var t = $(this),
                list = t.prev( 'select'),
                selected_option = list.find( 'option:selected' ).val();

            ev.preventDefault();

            $.ajax({
                beforeSend: function(){
                    t.block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });


                },
                complete: function(){
                    t.unblock();
                },
                data: {
                    request: 'lists/list',
                    force_update: true,
                    args: {
                        sort_field: 'web'
                    },
                    action: yith_wcmc.actions.do_request_via_ajax_action,
                    yith_wcmc_ajax_request_nonce: yith_wcmc.ajax_request_nonce
                },
                dataType: 'json',
                method: 'POST',
                success: function( lists ){
                    var new_options = '',
                        i = 0;

                    if( lists.data.length != 0 ){
                        for( i in lists.data ){
                            new_options += '<option value="' + lists.data[i].id + '" ' + ( ( selected_option == lists.data[i].id ) ? 'selected="selected"' : '' ) + ' >' + lists.data[i].name + '</option>';
                        }
                    }

                    list.html( new_options );

                    if( new_options.length == 0 ){
                        list.prop( 'disabled' );
                    }
                    else{
                        list.removeProp( 'disabled' );
                    }

                },
                url: ajaxurl
            });
        },
        handle_groups = function( ev ){
            var t = $( this).hasClass( 'ajax-mailchimp-updater-group' ) ? $(this).prev( 'select' ) : $(this).parents('tr').next().find('select'),
                row = t.closest( 'td'),
                list_id = t.closest('tr').siblings().find('.list-select').find( 'option:selected' ).val(),
                selected_options_dom = t.find( 'option:selected'),
                selected_options = [];

            selected_options_dom.each( function( i, v ){
                selected_options[i] = $(v).val();
            } );

            ev.preventDefault();

            if( list_id.length == 0 ){
                t.prop( 'disabled' );
            }
            else{
                t.removeProp( 'disabled' );
            }

            $.ajax({
                beforeSend: function(){
                    row.block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                },
                complete: function(){
                    row.unblock();
                },
                data: {
                    request: 'lists/interest-groupings',
                    force_update: true,
                    args: {
                        id: list_id
                    },
                    action: yith_wcmc.actions.do_request_via_ajax_action,
                    yith_wcmc_ajax_request_nonce: yith_wcmc.ajax_request_nonce
                },
                dataType: 'json',
                method: 'POST',
                success: function( groups ){
                    var new_options = '',
                        i = 0;

                    if( groups.length != 0 ){
                        for( i in groups ){
                            var j = 0,
                                interest_group = groups[i];

                            if( interest_group.groups.length != 0 ){
                                for( j in interest_group.groups ){
                                    var group = interest_group.groups[j];

                                    new_options += '<option value="' + interest_group.id + '-' + group.name + '" ' + ( ( $.inArray( interest_group.id + '-' + group.name, selected_options ) > -1 ) ? 'selected="selected"' : '' ) + ' >' + interest_group.name + ' - ' + group.name + '</option>';
                                }
                            }
                        }
                    }

                    t.html( new_options );

                    if( new_options.length == 0 ){
                        t.prop( 'disabled' );
                    }
                    else{
                        t.removeProp( 'disabled' );
                    }

                    t.select2();
                },
                url: ajaxurl
            });
        },
        add_updater_functions = function(){
            $( document ).off( 'click', '.ajax-mailchimp-updater-list' );
            $( document ).off( 'click', '.ajax-mailchimp-updater-group' );
            $( document ).off( 'change', '.list-select' );

            // add updater button handler
            $( document ).on( 'click', '.ajax-mailchimp-updater-list', handle_lists );
            $( document ).on( 'click', '.ajax-mailchimp-updater-group', handle_groups );
            $( document ).on( 'change', '.list-select', function(){
                var t = $(this).parents('tr').siblings().find('.ajax-mailchimp-updater-group').click();
            } );
        };

    add_updater_functions();
    $( 'body').on( 'add_updater_handler', add_updater_functions );

    // add dependencies handler
    $( '#yith_wcmc_checkout_trigger').on( 'change', function(){
        var t = $(this),
            subscription_checkbox = $( '#yith_wcmc_subscription_checkbox'),
            double_optin = $( '#yith_wcmc_double_optin' );

        if( t.val() != 'never' ){
            subscription_checkbox.parents( 'tr' ).show();
            double_optin.parents( 'tr').show();
            $( '#yith_wcmc_email_type').parents( 'tr').show();
            $( '#yith_wcmc_subscription_checkbox_label' ).parents( 'tr' ).show();
            $( '#yith_wcmc_subscription_checkbox_position' ).parents( 'tr' ).show();
            $( '#yith_wcmc_subscription_checkbox_default' ).parents( 'tr' ).show();
            $( '#yith_wcmc_update_existing').parents( 'tr').show();
            $( '#yith_wcmc_replace_interests').parents( 'tr').show();
            $( '#yith_wcmc_send_welcome').parents( 'tr').show();

            subscription_checkbox.change();
            double_optin.change();
        }
        else{
            subscription_checkbox.parents( 'tr' ).hide();
            double_optin.parents( 'tr').hide();
            $( '#yith_wcmc_email_type').parents( 'tr').hide();
            $( '#yith_wcmc_subscription_checkbox_label' ).parents( 'tr' ).hide();
            $( '#yith_wcmc_subscription_checkbox_position' ).parents( 'tr' ).hide();
            $( '#yith_wcmc_subscription_checkbox_default' ).parents( 'tr' ).hide();
            $( '#yith_wcmc_update_existing').parents( 'tr').hide();
            $( '#yith_wcmc_replace_interests').parents( 'tr').hide();
            $( '#yith_wcmc_send_welcome').parents( 'tr').hide();
        }
    }).change();
    $( '#yith_wcmc_ecommerce360_enable').on( 'change', function(){
        var t = $(this),
            cookie_lifetime = $( '#yith_wcmc_ecommerce360_cookie_lifetime');

        if( t.is(':checked') ){
            cookie_lifetime.parents( 'tr').show();
        }
        else{
            cookie_lifetime.parents( 'tr').hide();
        }
    }).change();

    $( '#yith_wcmc_subscription_checkbox' ).on( 'change', function(){
        var t = $(this);

        if( ! t.is(':visible') ){
            return;
        }

        if( t.is( ':checked' ) ){
            $( '#yith_wcmc_subscription_checkbox_label' ).parents( 'tr' ).show();
            $( '#yith_wcmc_subscription_checkbox_position' ).parents( 'tr' ).show();
            $( '#yith_wcmc_subscription_checkbox_default' ).parents( 'tr' ).show();
        }
        else{
            $( '#yith_wcmc_subscription_checkbox_label' ).parents( 'tr' ).hide();
            $( '#yith_wcmc_subscription_checkbox_position' ).parents( 'tr' ).hide();
            $( '#yith_wcmc_subscription_checkbox_default' ).parents( 'tr' ).hide();
        }
    }).change();
    $( '#yith_wcmc_double_optin').on( 'change', function(){
        var t = $(this);

        if( ! t.is(':visible') ){
            return;
        }

        if( t.is( ':checked' ) ) {
            $( '#yith_wcmc_send_welcome').parents( 'tr').hide();
        }
        else{
            $( '#yith_wcmc_send_welcome').parents( 'tr').show();
        }
    }).change();
    $( '#yith_wcmc_shortcode_double_optin').on( 'change', function(){
        var t = $(this);

        if( ! t.is(':visible') ){
            return;
        }

        if( t.is( ':checked' ) ) {
            $( '#yith_wcmc_shortcode_send_welcome').parents( 'tr').hide();
        }
        else{
            $( '#yith_wcmc_shortcode_send_welcome').parents( 'tr').show();
        }
    }).change();
    $( '#yith_wcmc_widget_double_optin').on( 'change', function(){
        var t = $(this);

        if( ! t.is(':visible') ){
            return;
        }

        if( t.is( ':checked' ) ) {
            $( '#yith_wcmc_widget_send_welcome').parents( 'tr').hide();
        }
        else{
            $( '#yith_wcmc_widget_send_welcome').parents( 'tr').show();
        }
    }).change();
} );