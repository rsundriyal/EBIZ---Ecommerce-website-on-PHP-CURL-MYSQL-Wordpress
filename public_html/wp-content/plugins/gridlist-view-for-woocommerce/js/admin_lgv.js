(function ($){
    $(document).ready( function () {

        /*BUTTONS*/

        $(document).on( 'click', '.berocket_lgv_button_test', function ( event ) {
            event.preventDefault();
        });

        /*PRODUCT COUNT*/

        $(document).on( 'change', '.br_lgv_product_count_spliter', function ( event ) {
            $('.br_lgv_product_count.split').text( $(this).val() );
        });
        $(document).on( 'change', '.lgv_admin_settings.product_count .text_before, .lgv_admin_settings.product_count .text_after', function ( event ) {
            if ( $(this).hasClass( 'text_before' ) ) {
                $('span.text_before').text( $(this).val() );
            } else if ( $(this).hasClass( 'text_after' ) ) {
                $('span.text_after').text( $(this).val() );
            }
        });

        /*LIST STYLE*/

        $(document).on( 'click', '.br_lgv_selector label', function ( event ) {
            $(this).parent().parent().find($( '.br_lgv_selector_block' ) ).hide();
            $(this).parent().parent().find($( '.br_lgv_selector_block.'+$(this).prev().val() ) ).show();
        });
        $(document).scroll( function ( event ) {
            if( $('.berocket_lgv_additional_data:visible').length > 0 ) {
                $block = $('.berocket_lgv_additional_data:visible');
                pos_top = $(document).scrollTop() - $block.parents('.br_lgv_liststyle').offset().top;
                pos_top += 40;
                if ( pos_top + $block.height() > $block.parents('.br_lgv_liststyle').height() ) {
                    pos_top = $block.parents('.br_lgv_liststyle').height() - $block.height();
                }
                if ( pos_top < 0 ) {
                    pos_top = 0;
                }
                $block.css( 'top', pos_top );
            }
        });
        
        $('.br_lgv_liststyle').on( 'click', '.berocket_lgv_additional_data a', function ( event ) {
            event.preventDefault();
        });
        $('.br_lgv_liststyle').on( 'mouseenter', '.lgv_highlight', function ( event ){
            event.stopPropagation();
            $('.lgv_highlight').removeClass( 'lgv_yellow' );
            $(this).addClass( 'lgv_yellow' );
        });
        $('.br_lgv_liststyle').on( 'mouseleave', '.lgv_highlight', function ( event ){
            event.stopPropagation();
            $(this).removeClass( 'lgv_yellow' );
            to_element = event.toElement || event.relatedTarget;
            $(to_element).trigger( 'mouseenter' );
        });
        $('.br_lgv_liststyle').on( 'click', '.lgv_highlight', function ( event ){
            event.stopPropagation();
            $('.lgv_editor').hide(300);
            $('.'+$(this).data('editor')).show(300);
        });
        setTimeout(function() { 
            $('.br_lgv_liststyle_preview').each( function ( i, o ) {
                $(o).css( 'height', $(o).find('.berocket_lgv_additional_data').height() );
                $(o).parent().css( 'min-height', $(o).find('.berocket_lgv_additional_data').height() );
                $('.lgv_display_none').hide();
            });
        }, 500);
        $(window).resize( function () {
            $('.br_lgv_liststyle_preview').each( function ( i, o ) {
                $(o).css( 'height', $(o).find('.berocket_lgv_additional_data').height() );
                $(o).parent().css( 'min-height', $(o).find('.berocket_lgv_additional_data').height() );
            });
        });
        $('.br_lgv_liststyle_preview').on( 'click', '.lgv_toggle_next', function ( event ) {
            setTimeout(function() { 
                $('.br_lgv_liststyle_preview').each( function ( i, o ) {
                    $(o).css( 'height', $(o).find('.berocket_lgv_additional_data').height() );
                    $(o).parent().css( 'min-height', $(o).find('.berocket_lgv_additional_data').height() );
                });
            }, 300);
        });
        $('.color-changer').each(function (i,o){
            $(o).css('backgroundColor', $(o).data('color'));
            $(o).colpick({
                layout: 'hex',
                submit: 0,
                color: $(o).data('color'),
                onChange: function(hsb,hex,rgb,el,bySetColor) {
                    $(el).css('backgroundColor', '#'+hex).parent().css('backgroundColor', '#'+hex);
                }
            })
        });

        /*STYLER*/

        $(document).on( 'change', '.lgv_admin_settings input, .lgv_admin_settings select', function ( event ) {
            event.preventDefault();
            set_buttons( $(this), $(this).parents('.lgv_editor').data('button_class') );
            $('.br_lgv_liststyle_preview').each( function ( i, o ) {
                $(o).css( 'height', $(o).find('.berocket_lgv_additional_data').height() );
                $(o).parent().css( 'min-height', $(o).find('.berocket_lgv_additional_data').height() );
            });
        });
        $(document).on( 'click', '.set_default', function ( event ) {
            $(this).parent( 'div' ).find('select, input, textarea').each( function ( i, o ) {
                if ( ! $(o).hasClass( 'set_default' ) ) {
                    
                    if( $(o).attr('type') == 'checkbox' ) {
                        if( $(o).data('default') == 1 ) {
                            $(o).prop( 'checked', true );
                        } else {
                            $(o).prop( 'checked', false );
                        }
                    } else {
                        $(o).val( $(o).data('default') ).trigger( 'change' );
                    }
                    if ( $(o).data( 'type' ) == 'color' ) {
                        $(o).prev().colpickSetColor( $(o).data('default') );
                    }
                }
            });
        });
        $(document).on( 'click', '.set_all_default', function ( event ) {
            $(this).parent().find( '.set_default' ).trigger( 'click' );
        });
        $(document).on( 'mousemove', '.box-shadow .x, .box-shadow .y, .box-shadow .radius, .box-shadow .size', function ( event ) {
            $(this).next().find( 'span.value_container' ).text( $(this).val() );
        });
        $('.colorpicker_field').each(function (i,o){
            $(o).css('backgroundColor', $(o).data('color'));
            $(o).colpick({
                layout: 'hex',
                submit: 0,
                color: $(o).data('color'),
                onChange: function(hsb,hex,rgb,el,bySetColor) {
                    $(el).css('backgroundColor', '#'+hex).next().val('#'+hex).trigger('change');
                }
            })
        });
        $(document).on( 'submit', '.lgv_submit_form', function( event ) {
            if ( $(this).find( '.lgv_admin_settings.buttons' ).length > 0 ) {
                $button_normal = $('<input type="hidden" name="br_lgv_buttons_page_option[button_style][normal]" value="'+$( '.berocket_lgv_button_test.normal' ).attr('style')+'">');
                $button_hover = $('<input type="hidden" name="br_lgv_buttons_page_option[button_style][hover]" value="'+$( '.berocket_lgv_button_test.hover' ).attr('style')+'">');
                $button_selected = $('<input type="hidden" name="br_lgv_buttons_page_option[button_style][selected]" value="'+$( '.berocket_lgv_button_test.selected' ).attr('style')+'">');
                $(this).append( $button_normal );
                $(this).append( $button_hover );
                $(this).append( $button_selected );
            } else if ( $(this).find( '.lgv_admin_settings.product_count' ).length > 0 ) {
                $button_normal = $('<input type="hidden" name="br_lgv_product_count_option[button_style][normal]" value="'+$( '.br_lgv_product_count.normal' ).attr('style')+'">');
                $button_hover = $('<input type="hidden" name="br_lgv_product_count_option[button_style][hover]" value="'+$( '.br_lgv_product_count.hover' ).attr('style')+'">');
                $button_selected = $('<input type="hidden" name="br_lgv_product_count_option[button_style][selected]" value="'+$( '.br_lgv_product_count.selected' ).attr('style')+'">');
                $button_split = $('<input type="hidden" name="br_lgv_product_count_option[button_style][split]" value="'+$( '.br_lgv_product_count.split' ).attr('style')+'">');
                $button_text = $('<input type="hidden" name="br_lgv_product_count_option[button_style][text]" value="'+$( '.br_lgv_product_count.text' ).attr('style')+'">');
                $(this).append( $button_normal );
                $(this).append( $button_hover );
                $(this).append( $button_selected );
                $(this).append( $button_split );
                $(this).append( $button_text );
            } else if ( $(this).find( '.br_lgv_liststyle' ).length > 0 ) {
                $('.lgv_highlight, .lgv_no_highlight').each( function ( i, o ) {
                    $button = $('<input type="hidden" name="br_lgv_liststyle_option[button_style]['+i+'][style]" value="'+$(o).attr('style')+'">');
                    $(this).append( $button );
                    $button = $('<input type="hidden" name="br_lgv_liststyle_option[button_style]['+i+'][button]" value="'+$(o).data('button')+'">');
                    $(this).append( $button );
                    if ( $(o).data('modifier') != 'none' ) {
                        modifier = $(o).data('modifier');
                    } else {
                        modifier = '';
                    }
                    $button = $('<input type="hidden" name="br_lgv_liststyle_option[button_style]['+i+'][modifier]" value="'+modifier+'">');
                    $(this).append( $button );
                });
            }
        });
        $(document).on( 'click', '.lgv_toggle_next', function ( event ) {
            event.preventDefault();
            if( $(this).data('select') == 'parent' ) {
                $block = $(this).parent();
            } else {
                $block = $(this);
            }
            if( $(this).data('find') == 'nextchild' ) {
                $block = $block.next().child();
            } else {
                $block = $block.next();
            }
            $("html, body").animate({ scrollTop: ( $(this).offset().top - 100 )+"px" });
            $block.toggle(200);
        });
        $(document).on( 'change', '.lgv_class_set', function ( event ) {
            default_class = $(this).data( 'default_class' );
            $( '.'+default_class ).removeClass().addClass( default_class ).addClass( $(this).val() );
        });
        $(document).on( 'change', '.lgv_img_advanced_float_value', function ( event ) {
            setTimeout(function(){ set_margin_text_block( '.lgv_img_advanced', '.lgv_img_advanced + div', $('.lgv_img_advanced_width_value').val(), $('.lgv_img_advanced_width_ex').val() ); }, 20);
        });
        $(document).on( 'change', '.lgv_img_advanced_width_value, .lgv_img_advanced_width_ex', function ( event ) {
            setTimeout(function(){ set_margin_text_block( '.lgv_img_advanced', '.lgv_img_advanced + div', $('.lgv_img_advanced_width_value').val(), $('.lgv_img_advanced_width_ex').val() ); }, 20);
        });
        setTimeout(function(){ set_margin_text_block( '.lgv_img_advanced', '.lgv_img_advanced + div', $('.lgv_img_advanced_width_value').val(), $('.lgv_img_advanced_width_ex').val() ); }, 20);
    });
})(jQuery);
function set_margin_text_block( $block_float, $block_text, value, ex ) {
    if( ex != 'initial' && ex != 'inherit' ) {
        width = value+ex;
        $block_float = jQuery($block_float);
        $block_text  = jQuery($block_text);
        $block_text.css('margin', 0);
        if ( $block_float.css('float') == 'left' ) {
            $block_text.css('margin-left', width);
        } else if ( $block_float.css('float') == 'right' ) {
            $block_text.css('margin-right', width);
        }
        $block_text.parent().hide().show(0);
    }
}
function set_buttons($button, button_class) {
    value = $button.val();
    if ( $button.data('type') == 'int' ) {
        value = parseInt(value);
    } else if ( $button.data('type') == 'float' ) {
        value = parseFloat(value);
    }
    if ( value || value === 0 ) {
        $button.val( value );
        selector = button_class;
        if ( $button.parents('.lgv_editor_info').data('button_type') != 'all' ) {
            selector += '.'+$button.parents('.lgv_editor_info').data('button_type');
        }
        if ( $button.parents( 'div' ).data( 'type' ) == 'box-shadow' ) {
            seted_value = '';
            jQuery( 'div.box-shadow.'+$button.parents('.lgv_editor_info').data('button_type') ).each( function ( i, o ) {
                if ( i != 0 ) {
                    seted_value += ',';
                }
                if ( jQuery(o).find('.inset').prop('checked') ) {
                    seted_value += 'inset ';
                }
                seted_value += jQuery(o).find('.x').val()+'px ';
                seted_value += jQuery(o).find('.y').val()+'px ';
                seted_value += jQuery(o).find('.radius').val()+'px ';
                seted_value += jQuery(o).find('.size').val()+'px ';
                seted_value += jQuery(o).find('.color').val();
            });
        } else if ( $button.data('type') == 'color' ) {
            if ( jQuery( '.'+$button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_value').length > 1 ) {
                seted_value = jQuery( '.'+$button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_value').val()+' linear-gradient('
                jQuery( '.'+$button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_value').each( function ( i, o ) {
                    if( i == 0 ) {
                        seted_value += jQuery(o).val();
                    } else {
                        seted_value += ','+jQuery(o).val();
                    }
                });
                seted_value += ')';
            } else {
                seted_value = $button.val();
            }
        } else {
            seted_value = jQuery( '.'+$button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_value').val();
            if ( jQuery( '.'+$button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_ex').hasClass($button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_ex') ) {
                ex_val = jQuery( '.'+$button.parents('.lgv_editor_info').data('button_type')+'_'+$button.data('option')+'_ex').val();
                if ( ex_val == 'initial' || ex_val == 'inherit' ) {
                    seted_value = ex_val;
                } else {
                    seted_value += ex_val;
                }
            }
        }
        jQuery(selector).css( $button.data('option'), seted_value );
        $button.next().find( 'span.value_container' ).text( $button.val() );
    }
}
function add_to_cart_position( $button ) {
    jQuery('.lgv_addtocart_pos').hide();
    jQuery('.lgv_pos_'+$button.val()).show();
}
function out_of_stock_position( $button ) {
    jQuery('.lgv_out_of_stock_button').hide();
    jQuery('.lgv_out_of_stock_'+$button.val()).show();
}