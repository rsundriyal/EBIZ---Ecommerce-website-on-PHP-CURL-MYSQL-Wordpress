;(function($){

    var variantsHolder = $('#variants-holder');
    var product_gallery_frame;
    var product_featured_frame;
    var $image_gallery_ids = $('#product_image_gallery');
    var $product_images = $('#product_images_container ul.product_images');

    var Dokan_Editor = {

        /**
         * Constructor function
         */
        init: function() {

            product_type = 'simple';

            $('.product-edit-container').on('click', 'input[type=checkbox]#_downloadable', this.downloadable );
            $('.product-edit-container').on('change', '#_product_type', this.onChangeProductType );
            $('.product-edit-container').on('click', 'a.sale-schedule', this.showDiscountSchedule );

            // New Product Desing js
            $('.product-edit-new-container,.product-edit-container').on('click', '._discounted_price', this.newProductDesign.showDiscount );
            $('.product-edit-new-container').on('change', 'input[type=checkbox].sale-schedule', this.newProductDesign.showDiscountSchedule );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_manage_stock', this.newProductDesign.showManageStock );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_required_shipping', this.newProductDesign.showShippingWrapper );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_required_tax', this.newProductDesign.showTaxWrapper );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_downloadable', this.newProductDesign.downloadable );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_has_attribute', this.newProductDesign.showVariationSection );

            // variants
            $('#product-attributes').on('click', '.add-variant-category', this.variants.addCategory );
            $('#variants-holder').on('click', '.box-header .row-remove', this.variants.removeCategory );

            $('#variants-holder').on('click', '.item-action a.row-add', this.variants.addItem );
            $('#variants-holder').on('click', '.item-action a.row-remove', this.variants.removeItem );


            $('body, #variable_product_options').on( 'click', '.sale_schedule', this.variants.saleSchedule );
            $('body, #variable_product_options').on( 'click', '.cancel_sale_schedule', this.variants.cancelSchedule );
            $('#variable_product_options').on('woocommerce_variations_added', this.variants.onVariantAdded );
            this.variants.dates();
            this.variants.initSaleSchedule();

            // save attributes
            $('.save_attributes').on('click', this.variants.save);

            // gallery
            $('#dokan-product-images').on('click', 'a.add-product-images', this.gallery.addImages );
            $('#dokan-product-images').on( 'click', 'a.action-delete', this.gallery.deleteImage );
            $('#dokan-product-images').on( 'click', 'a.delete', this.gallery.deleteImage );
            this.gallery.sortable();

            // featured image
            $('.product-edit-new-container, .product-edit-container').on('click', 'a.dokan-feat-image-btn', this.featuredImage.addImage );
            $('.product-edit-new-container, .product-edit-container').on('click', 'a.dokan-remove-feat-image', this.featuredImage.removeImage );

            // download links

            // post status change
            $('.dokan-toggle-sidebar').on('click', 'a.dokan-toggle-edit', this.sidebarToggle.showStatus );
            $('.dokan-toggle-sidebar').on('click', 'a.dokan-toggle-save', this.sidebarToggle.saveStatus );
            $('.dokan-toggle-sidebar').on('click', 'a.dokan-toggle-cacnel', this.sidebarToggle.cancel );

            // new product design variations

            $('.dokan-variation-container').on('click', 'a.add_attribute_option', this.newProductDesign.addAttributeOption );
            $('.dokan-variation-container').on('click', 'button.remove_attribute', this.newProductDesign.removeAttributeOption );
            $('.dokan-variation-container').on('click', 'button.clear_attributes', this.newProductDesign.clearAttributeOptions );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_create_variation', this.newProductDesign.createVariationSection);
            // $('.product-edit-new-container').on('change', 'input[type=checkbox].dokan_create_variation', this.newProductDesign.createVariationWarning);
            $('.product-edit-new-container').on('click', 'a.edit_variation', this.newProductDesign.editSingleVariation );
            $('.product-edit-new-container').on('click', 'a.remove_variation', this.newProductDesign.removeSingleVariation );
            $('body').on( 'click', '.upload_image_button', this.newProductDesign.loadVariationImage );
            $('body, .product-edit-container').on('click', 'a.upload_file_button', this.fileDownloadable);
            $('body').on('click', 'a.add_single_attribute_option', this.newProductDesign.addSingleAttributeOption );
            $('body').on('click', 'button.remove_single_attribute', this.newProductDesign.removeSingleAttributeOption );
            $('body').on('click', 'tr.dokan-single-attribute-options button.clear_attributes', this.newProductDesign.clearSingleAttributeOptions );
            $('body').on('click', 'a.dokan_add_new_variation', this.newProductDesign.addSingleVariationOption );

            $('body').on('submit', 'form#dokan-single-attribute-form', this.newProductDesign.saveProductAttributes );
            $('body').on('submit', 'form#dokan-single-variation-form', this.newProductDesign.saveProductVariations );

            $('body').on('change', 'input.variable_is_downloadable', this.newProductDesign.showHideDownload );
            $('body').on('change', 'input.variable_manage_stock', this.newProductDesign.showHideMangeStock );
            $('body').on('change', 'input.variable_is_virtual', this.newProductDesign.showHideVirtual );

            $( '.product-edit-new-container').on('click', 'a.dokan_add_new_attribute', this.newProductDesign.addExtraAttributeOption )

            // // shipping
            $('.product-edit-new-container, #product-shipping').on('change', 'input[type=checkbox]#_overwrite_shipping', this.newProductDesign.shipping.showHideOverride );
            $('.product-edit-new-container').on('change', 'input[type=checkbox]#_disable_shipping', this.newProductDesign.shipping.disableOverride );
            $('#product-shipping').on('click', '#_disable_shipping', this.shipping.disableOverride );


            // File inputs
            $('body').on('click', 'a.insert-file-row', function(){
                $(this).closest('table').find('tbody').append( $(this).data( 'row' ) );
                return false;
            });

            $('body').on('click', 'a.delete', function(){
                $(this).closest('tr').remove();
                return false;
            });

            this.loadTagChosen();
            this.newProductDesign.shipping.showHideOverride();
            this.newProductDesign.shipping.disableOverride();
            this.shipping.disableOverride();
            $('#_disable_shipping').trigger('change');
            $('#_overwrite_shipping').trigger('change');

            this.loadTagIt();
            
            $('body').on('submit', 'form.dokan-product-edit-form', this.inputValidate);            
            
        },
        
        inputValidate: function( e ) {   
            e.preventDefault();
            
            if ( $( '#post_title' ).val().trim() == '' ) {
                $( '#post_title' ).focus();
                $( 'div.dokan-product-title-alert' ).removeClass('hidden');
                return;
            }else{
                $( 'div.dokan-product-title-alert' ).hide();
            }
            
            if ( $( 'select.product_cat' ).val() == -1 ) {                
                $( 'select.product_cat' ).focus();
                $( 'div.dokan-product-cat-alert' ).removeClass('hidden');
                return;
            }else{
                $( 'div.dokan-product-cat-alert' ).hide();
            }            
            $( 'input[type=submit]' ).attr( 'disabled', 'disabled' );
            this.submit();            
        },

        loadTagChosen: function() {
            $('select.product_tags').chosen();
        },

        loadTagIt: function() {
            if ( ! jQuery.fn.tagit ) {
                return;
            }
            
            $( 'input.dokan-attribute-option-values' ).each( function ( key, val ) {
                $( this ).tagit( {
                    availableTags: $( this ).data('preset_attr').split(','),
                    afterTagAdded: Dokan_Editor.tagIt.afterTagAdded,
                    afterTagRemoved: Dokan_Editor.tagIt.afterTagRemoved,
                    autocomplete: { delay: 1, minLength: 1 }
                });
            });
        },

        downloadable: function() {
            if ( $(this).prop('checked') ) {
                $(this).closest('aside').find('.dokan-side-body').removeClass('dokan-hide');
            } else {
                $(this).closest('aside').find('.dokan-side-body').addClass('dokan-hide');
            }
        },

        showDiscountSchedule: function(e) {
            e.preventDefault();

            $('.sale-schedule-container').slideToggle('fast');
        },

        onChangeProductType: function() {
            var selected = $('#_product_type').val();
            if ( selected === 'simple' ) {
                product_type = 'simple';
                $('aside.downloadable').removeClass('dokan-hide');
                $('.show_if_variable').addClass('dokan-hide');
                $('.show_if_simple').removeClass('dokan-hide');

            } else {
                // this is a variable type product
                product_type = 'variable';
                $('aside.downloadable').addClass('dokan-hide');
                $('.show_if_variable').removeClass('dokan-hide');
                $('.show_if_simple').addClass('dokan-hide');
            }
        },


        tagIt: {

            afterTagAdded: function(event, ui) {
                Dokan_Editor.reArrangeVariations();
            },

            afterTagRemoved: function(event, ui) {
                Dokan_Editor.reArrangeVariations();
            }
        },

        makeVariation: function() {
            var combination = [],
            arg = arguments[0],
            max = arg.length-1;

            function helper( arr, j ) {
                for ( var i=0, l = arg[j].length; i<l; i++ ) {

                    var a = arr.slice(0); // clone arr
                    a.push(arg[j][i]);
                    if ( j == max ) {
                        combination.push(a);
                    } else {
                        helper(a, j+1);
                    }
                }
            }

            helper([], 0);

            return combination;
        },

        reArrangeVariations: function() {

            if( $('input[type=checkbox]#_create_variation').is(':checked') ) {
                var data = [], data_val = [], arg;

                $( 'tr.dokan-attribute-options' ).each( function( i ) {
                    var attr = $(this).find('.dokan-attribute-option-values').tagit("assignedTags");
                    var attr_name = $(this).find( '.dokan-attribute-option-name' ).val();

                    if( attr.length ) {
                        data_val.push( attr_name );
                        data.push( attr );
                    } else {
                        $(this).find( '.dokan-attribute-option-name' ).val('');
                    }
                });

                if ( data.length ) {
                    var variations = {
                        variation_item : Dokan_Editor.makeVariation( data ),
                        variation_title: data_val
                    };

                    var variants_template = wp.template( 'dokan-variations' );
                    $('.dokan-variation-content-wrapper').html( variants_template( variations ) );
                } else {
                    $('.dokan-variation-content-wrapper').html('');
                };
            }

        },

        newProductDesign: {

            showDiscount: function() {
                var self = $(this),
                    checked = self.is(':checked'),
                    container = $('.special-price-container');

                if (checked) {
                    container.removeClass('dokan-hide');
                } else {
                    container.addClass('dokan-hide');
                }
            },

            showDiscountSchedule: function(e) {
                if ( $(this).is(':checked') ) {
                    $('.sale-schedule-container').slideDown('fast');
                } else {
                    $('.sale-schedule-container').slideUp('fast');
                }
            },

            showManageStock: function(e) {
                if ( $(this).is(':checked') ) {
                    $('.show_if_stock').slideDown('fast');
                } else {
                    $('.show_if_stock').slideUp('fast');
                }
            },

            showShippingWrapper: function(e) {
                if ( $(this).is(':checked') ) {
                    $('.show_if_needs_shipping').slideDown('fast');
                } else {
                    $('.show_if_needs_shipping').slideUp('fast');
                }
            },

            showTaxWrapper: function() {
                if ( $(this).is(':checked') ) {
                    $('.show_if_needs_tax').slideDown('fast');
                } else {
                    $('.show_if_needs_tax').slideUp('fast');
                }
            },

            downloadable: function() {
                if ( $(this).prop('checked') ) {
                    if ( $('.dokan-product-shipping-tax').hasClass('woocommerce-no-tax') ) {
                        $('.dokan-product-shipping-tax').addClass('dokan-hide');
                    };

                    $('.hide_if_downloadable').hide();
                    $(this).closest('div').find('.dokan-side-body').removeClass('dokan-hide');
                } else {

                    if ( $('.dokan-product-shipping-tax').hasClass('woocommerce-no-tax') ) {
                        $('.dokan-product-shipping-tax').removeClass('dokan-hide');
                    };

                    $('.hide_if_downloadable').show();
                    $(this).closest('div').find('.dokan-side-body').addClass('dokan-hide');
                }
            },

            showVariationSection: function() {
                if ( $(this).is(':checked') ) {
                    $(this).closest('.dokan-variation-container').find('.dokan-side-body').removeClass('dokan-hide');
                } else {
                    $(this).closest('.dokan-variation-container').find('.dokan-side-body').addClass('dokan-hide');
                }
            },

            addAttributeOption: function(e) {
                e.preventDefault();
                var self = $(this),
                    attr_wrap = self.closest('.dokan-attribute-content-wrapper').find('select#predefined_attribute');

                if ( attr_wrap.val() == '' ) {

                    attribute_option = self.closest('.dokan-attribute-content-wrapper')
                                        .find('tr.dokan-attribute-options')
                                        .first()
                                        .clone();

                    attribute_option.find('input').val('');

                    if ( attribute_option.find('input.dokan-attribute-option-name-label').length == 1 ) {
                        var $attrName = attribute_option.find('input.dokan-attribute-option-name'),
                            $attrNameLabel = attribute_option.find('input.dokan-attribute-option-name-label');

                        $attrName.remove();
                        $attrNameLabel.removeAttr('disabled data-attribute_name')
                                    .attr('name','attribute_names[]')
                                    .addClass('dokan-attribute-option-name')
                                    .removeClass('dokan-attribute-option-name-label');
                        attribute_option.find('input[name="attribute_is_taxonomy[]"]').val('0');
                    }

                    attribute_option.insertBefore( $('table.dokan-attribute-options-table').find( 'tr.dokan-attribute-is-variations' ) );
                    attribute_option.find( 'ul.tagit' ).remove();
                    
                    var new_field = attribute_option.find('.dokan-attribute-option-values');
                    new_field.removeAttr('data-preset_attr')
                             .attr('value', '');
 
                    new_field.tagit({                            
                        afterTagAdded: Dokan_Editor.tagIt.afterTagAdded,
                        afterTagRemoved: Dokan_Editor.tagIt.afterTagRemoved,                            
                    });
                } else {

                    var data = {
                            action: 'dokan_get_pre_attribute',
                            name : attr_wrap.val()
                        },
                        flag = true;

                    self.closest('.dokan-attribute-content-wrapper').find('.dokan-attribute-option-name-label').each( function( i, val ) {
                        if( $(val).data('attribute_name') == attr_wrap.val() ) {
                            alert( dokan.duplicates_attribute_messg );
                            flag = false;
                            attr_wrap.val('');
                        }
                    });

                    if ( !flag ) {
                        return;
                    }
                    self.closest('.dokan-attribute-content-wrapper').find('span.dokan-loading').removeClass('dokan-hide');
                    $.post( dokan.ajaxurl, data, function( resp ) {
                        if ( resp.success ) {
                            var wrap_data = (resp.data).trim();
                            attr_wrap.val('');
                            $(wrap_data).insertBefore($('table.dokan-attribute-options-table').find( 'tr.dokan-attribute-is-variations' ));
                            
                            $( 'input.dokan-attribute-option-values' ).each( function ( key, val ) {
                                $( this ).tagit( {
                                    availableTags: $( this ).data('preset_attr').split(','),
                                    afterTagAdded: Dokan_Editor.tagIt.afterTagAdded,
                                    afterTagRemoved: Dokan_Editor.tagIt.afterTagRemoved,
                                    autocomplete: { delay: 1, minLength: 1 }
                                });
                            });
                            self.closest('.dokan-attribute-content-wrapper').find('span.dokan-loading').addClass('dokan-hide');
                        };
                    });
                }
            },

            removeAttributeOption: function(e) {
                e.preventDefault();
                var self = $(this),
                    row = self.closest('tbody').find('tr.dokan-attribute-options').length;

                if( row < 2 ) {
                    return false;
                }

                self.closest('tr').remove();
                Dokan_Editor.reArrangeVariations();
            },
            clearAttributeOptions : function(e , option) {
                e.preventDefault();
                
                var self = $(this),
                    input = self.closest('tr.dokan-attribute-options').find('td input.dokan-attribute-option-values');
                input.tagit("removeAll");
                input.focus();
                console.log(input);
            },
            clearSingleAttributeOptions : function(e , option) {
                e.preventDefault();
                
                var self = $(this),
                    input = self.closest('tr.dokan-single-attribute-options').find('td input.dokan-single-attribute-option-values');
                input.tagit("removeAll");
                $(input).focus();
                console.log(input);
            },
             
            createVariationSection: function() {
                if ( $(this).is(':checked') ) {
                    $('.hide_if_variation').hide();
                    $('#_manage_stock').trigger('change');
                    Dokan_Editor.reArrangeVariations();
                    if ( $(this).hasClass( 'dokan_create_variation' ) ) {
                        $('.dokan-variation-remove-warning').slideUp();
                    };
                } else {
                    $('.hide_if_variation').show();
                    $('#_manage_stock').trigger('change');
                    $('.dokan-variation-content-wrapper').html('');

                    if ( $(this).hasClass( 'dokan_create_variation' ) ) {
                        var alert = '<div class="dokan-alert dokan-alert-warning dokan-variation-remove-warning"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+dokan.variation_unset_warning+'</div>';
                        $(this).closest('label').before( alert ).slideDown();
                    };
                }
            },

            editSingleVariation: function(e) {
                e.preventDefault();

                var self = $(this),
                    variation_data = self.closest('tr').data('variation_data');

                var variant_single_template = wp.template( 'dokan-single-variations' );
                var variation_single = variant_single_template( variation_data );

                $.magnificPopup.open({
                    items: {
                        src: variation_single.trim(),
                        type: 'inline'
                    },
                    callbacks: {
                        open: function() {
                            Dokan_Editor.variants.dates();
                            $('.sale_schedule').trigger('click');
                            $('input.variable_is_downloadable, input.variable_is_virtual, input.variable_manage_stock' ).change();
                            $( 'body' ).find( 'select.variation_select_fileld' ).each( function(i, el) {
                                var data_selected_val = $(el).data('selected_data');

                                if( data_selected_val ) {
                                    $(el).find('option').each( function( key, el_option ) {

                                        if( $(el_option).attr('value') == data_selected_val ) {
                                            $(el_option).attr( 'selected', 'selected' );
                                        }
                                    });
                                }
                            });
                            $('.tips').tooltip();
                        }
                    }
                });

            },

            removeSingleVariation: function(e) {
                e.preventDefault();

                if ( confirm( dokan.delete_confirm ) ) {
                    var self = $(this),
                        data = {
                            action : 'dokan_remove_single_variation_item',
                            variation_id : self.data('variation_id')
                        },
                        loadUrl = window.location.href;


                    $('.dokan-variation-container').addClass('dokan-blur-effect');
                    $('.dokan-variation-container').append('<div class="dokan-variation-loader"></div>');

                    $.post( dokan.ajaxurl, data, function( resp ) {
                        if( resp.success ) {
                            $('.dokan-variation-container').load(loadUrl+' .dokan-variation-container', function() {
                                $('#_create_variation').trigger('change');
                                $('.dokan-variation-container').removeClass('dokan-blur-effect');
                                $('.dokan-variation-container').remove('.dokan-variation-loader');
                            });
                        }
                    });
                }
            },

            showHideDownload: function(){

                $(this).closest('.woocommerce_variation').find('.show_if_variation_downloadable').hide();

                if ($(this).is(':checked')) {
                    $(this).closest('.woocommerce_variation').find('.show_if_variation_downloadable').show();
                }

            },

            showHideMangeStock: function(){

                $(this).closest('.woocommerce_variation').find('.show_if_variation_manage_stock').hide();

                if ($(this).is(':checked')) {
                    $(this).closest('.woocommerce_variation').find('.show_if_variation_manage_stock').show();
                }

            },

            showHideVirtual: function(){

                $(this).closest('.woocommerce_variation').find('.hide_if_variation_virtual').show();

                if ($(this).is(':checked')) {
                    $(this).closest('.woocommerce_variation').find('.hide_if_variation_virtual').hide();
                }

            },

            loadVariationImage: function(e) {
                e.preventDefault();
                var variable_image_frame;
                var $button                = $(this);
                var post_id                = $button.attr('rel');
                var $parent                = $button.closest('.upload_image');
                setting_variation_image    = $parent;
                placeholder_iamge          = $parent.find('span.variation_placeholder_image').data('placeholder_image');
                setting_variation_image_id = post_id;

                e.preventDefault();

                if ( $button.is('.dokan-img-remove') ) {

                    setting_variation_image.find( '.upload_image_id' ).val( '' );
                    setting_variation_image.find( 'img' ).attr( 'src', placeholder_iamge );
                    setting_variation_image.find( '.upload_image_button' ).removeClass( 'dokan-img-remove' );

                } else {

                    // If the media frame already exists, reopen it.
                    if ( variable_image_frame ) {
                        variable_image_frame.uploader.uploader.param( 'post_id', setting_variation_image_id );
                        variable_image_frame.open();
                        return;
                    } else {
                        wp.media.model.settings.post.id = setting_variation_image_id;
                        wp.media.model.settings.type = 'dokan';
                    }

                    // Create the media frame.
                    variable_image_frame = wp.media.frames.variable_image = wp.media({
                        // Set the title of the modal.
                        title: 'Choose an image',
                        button: {
                            text: 'Set variation image'
                        }
                    });

                    // When an image is selected, run a callback.
                    variable_image_frame.on( 'select', function() {

                        attachment = variable_image_frame.state().get('selection').first().toJSON();

                        setting_variation_image.find( '.upload_image_id' ).val( attachment.id );
                        setting_variation_image.find( '.upload_image_button' ).addClass( 'dokan-img-remove' );
                        setting_variation_image.find( 'img' ).attr( 'src', attachment.url );

                        wp.media.model.settings.post.id = wp_media_post_id;
                    });

                    // Finally, open the modal.
                    variable_image_frame.open();
                }

            },

            addExtraAttributeOption: function(e) {
                e.preventDefault();
                var self = $(this),
                    data = {
                        attribute_data : self.data('product_attributes'),
                        attribute_taxonomies : self.data('predefined_attr')
                    },
                    attribute_option = wp.template( 'dokan-single-attribute' ),
                    attribute_single = attribute_option( data );

                $.magnificPopup.open({

                    items: {
                        src: attribute_single.trim(),
                        type: 'inline',
                    },
                    callbacks: {
                        open: function() {
                            $('.tips').tooltip();
                            
                            var $attribute_options = $( 'body' ).find('.dokan-single-attribute-option-values');
                            
                            $attribute_options.each( function ( key, val ) {
                                $( this ).tagit( {
                                    availableTags: $( this ).data('preset_attr').split(','),
                                    afterTagAdded: Dokan_Editor.tagIt.afterTagAdded,
                                    afterTagRemoved: Dokan_Editor.tagIt.afterTagRemoved,
                                    autocomplete: { delay: 1, minLength: 1 , appendTo : 'div.white-popup' }
                                });
                            });
                        }
                    },

                });
            },

            addSingleAttributeOption: function(e) {
                e.preventDefault();

                var self = $(this),
                    attr_wrap = self.closest('table.dokan-single-attribute-options-table').find('select#predefined_attribute');

                if ( attr_wrap.val() == '' ) {
                    attribute_option = self.closest('table.dokan-single-attribute-options-table')
                                        .find('tr.dokan-single-attribute-options')
                                        .first()
                                        .clone();

                    attribute_option.find('input').val('');

                    if ( attribute_option.find('input.dokan-single-attribute-option-name-label').length == 1 ) {
                        var $attrName  = attribute_option.find('input.dokan-single-attribute-option-name'),
                            $attrNameLabel = attribute_option.find('input.dokan-single-attribute-option-name-label');
                        $attrName.remove();
                        $attrNameLabel.removeAttr('disabled data-attribute_name')
                                .attr('name','attribute_names[]')
                                .addClass('dokan-single-attribute-option-name')
                                .removeClass('dokan-single-attribute-option-name-label');
                        attribute_option.find('input[name="attribute_is_taxonomy[]"]').val('0');
                    }

                    $('table.dokan-single-attribute-options-table').find( 'tbody' ).append( attribute_option );
                    attribute_option.find( 'ul.tagit' ).remove();
                    
                    var new_field = attribute_option.find('input.dokan-single-attribute-option-values');                  
                   
                    new_field.removeAttr('data-preset_attr')
                             .attr('value', '');
                         
                    new_field.tagit({                            
                        afterTagAdded: Dokan_Editor.tagIt.afterTagAdded,
                        afterTagRemoved: Dokan_Editor.tagIt.afterTagRemoved,                            
                    });


                } else {

                    var data = {
                            action: 'dokan_get_pre_attribute',
                            name : attr_wrap.val(),
                            from : 'popup'
                        },
                        flag = true;

                    self.closest('table.dokan-single-attribute-options-table').find('.dokan-single-attribute-option-name-label').each( function( i, val ) {
                        if( $(val).data('attribute_name') == attr_wrap.val() ) {
                            alert( dokan.duplicates_attribute_messg );
                            flag = false;
                            attr_wrap.val('');
                        }
                    });

                    if ( !flag ) {
                        return;
                    }
                    self.closest('table.dokan-single-attribute-options-table').find('span.dokan-loading').removeClass('dokan-hide');
                    $.post( dokan.ajaxurl, data, function( resp ) {
                        if ( resp.success ) {
                            var wrap_data = (resp.data).trim();
                            attr_wrap.val('');
                            $('table.dokan-single-attribute-options-table').find( 'tbody' ).append( wrap_data );
                            
                            $( 'input.dokan-single-attribute-option-values' ).each( function ( key, val ) {
                                $( this ).tagit( {
                                    availableTags: $( this ).data('preset_attr').split(','),
                                    afterTagAdded: Dokan_Editor.tagIt.afterTagAdded,
                                    afterTagRemoved: Dokan_Editor.tagIt.afterTagRemoved,
                                    autocomplete: { delay: 1, minLength: 1 , appendTo: 'div.white-popup' }
                                } );
                            } );
                            self.closest('.dokan-single-attribute-options-table').find('span.dokan-loading').addClass('dokan-hide');
                        };
                    });
                }
            },

            removeSingleAttributeOption: function(e) {
                e.preventDefault();

                e.preventDefault();
                var self = $(this);

                var row = self.closest('tbody').find('tr').length;

                if( row < 2 ) {
                    return false;
                }

                self.closest('tr').remove();
            },

            saveProductAttributes: function(e) {
                e.preventDefault();
                var self = $(this),
                    data = {
                        action : 'dokan_save_attributes_options',
                        formdata: $(this).serialize()
                    },
                    loadUrl = window.location.href;

                self.find('.dokan-save-single-attr-loader').removeClass('dokan-hide');
                $.post( dokan.ajaxurl, data, function( resp ) {
                    if( resp.success ) {
                        $('.dokan-variation-container').addClass('dokan-blur-effect');
                        $('.dokan-variation-container').append('<div class="dokan-variation-loader"></div>');

                        $.magnificPopup.close();

                        $('.dokan-variation-container').load(loadUrl+' .dokan-variation-container', function() {
                            $('#_create_variation').trigger('change');
                            $('.dokan-variation-container').removeClass('dokan-blur-effect');
                            $('.dokan-variation-container').remove('.dokan-variation-loader');
                        });
                    }
                });
            },

            addSingleVariationOption: function(e) {
                e.preventDefault();

                var self = $(this),
                    data = {
                        action : 'dokan_add_new_variations_options',
                        post_id: self.data('post_id'),
                        menu_order: self.closest('.dokan-variation-container').find( 'table.dokan-variations-table tbody tr').size(),
                    },
                    loadUrl = window.location.href;

                self.closest('.dokan-variation-action-wrapper').find('.dokan-loading').removeClass('dokan-hide');
                $('.dokan-variation-container').addClass('dokan-blur-effect');
                $('.dokan-variation-container').append('<div class="dokan-variation-loader"></div>');
                $.post( dokan.ajaxurl, data, function( resp ) {
                    $('.dokan-variation-container').load( loadUrl+' .dokan-variation-container', function() {
                        $('#_create_variation').trigger('change');
                        self.closest('.dokan-variation-action-wrapper').find('.dokan-loading').addClass('dokan-hide');
                        $('.dokan-variation-container').removeClass('dokan-blur-effect');
                        $('.dokan-variation-container').remove('.dokan-variation-loader');
                    });
                });

            },

            saveProductVariations: function(e) {
                e.preventDefault();

                var self = $(this),
                    data = {
                        action : 'dokan_save_variations_options',
                        formdata: $(this).serialize()
                    },
                    loadUrl = window.location.href;

                self.find('.dokan-loading').removeClass('dokan-hide');

                $.post( dokan.ajaxurl, data, function( resp ) {
                    if( resp.success ) {
                        $('.dokan-variation-container').addClass('dokan-blur-effect');
                        $('.dokan-variation-container').append('<div class="dokan-variation-loader"></div>');

                        $.magnificPopup.close();

                        $('.dokan-variation-container').load(loadUrl+' .dokan-variation-container', function() {
                            $('#_create_variation').trigger('change');
                            $('.dokan-variation-container').removeClass('dokan-blur-effect');
                            $('.dokan-variation-container').remove('.dokan-variation-loader');
                        });
                    }
                });
            },

            shipping: {
                showHideOverride: function() {
                    if ( $('#_overwrite_shipping').is(':checked') ) {
                        $('.show_if_override').show();
                    } else {
                        $('.show_if_override').hide();
                    }
                },

                disableOverride: function() {
                    if ( $('#_disable_shipping').is(':checked') ) {
                        $('.show_if_needs_shipping').show();
                        $( '#_overwrite_shipping').trigger('change')
                    } else {
                        $('.show_if_needs_shipping').hide();
                    }
                }
            }
        },

        variants: {
            addCategory: function (e) {
                e.preventDefault();

                var product_types = $('#_product_type').val();
                var check = $(this).closest('p.toolbar').find('select.select-attribute').val();
                var row = $('.inputs-box').length;

                if ( check == '' ) {

                    var category = _.template( $('#tmpl-sc-category').html(), { row: row } );

                    variantsHolder.append(category).children(':last').hide().fadeIn();

                } else {

                    var data = {
                        row: row,
                        name: check,
                        type: product_types,
                        action: 'dokan_pre_define_attribute',
                    };

                    $('#product-attributes .toolbar').block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });

                    $.post( dokan.ajaxurl, data, function(resp) {
                        if ( resp.success ) {
                            variantsHolder.append(resp.data).children(':last').hide().fadeIn();
                        }
                        $('#product-attributes .toolbar').unblock();

                    });
                }

                if ( product_type === 'simple' ) {
                    variantsHolder.find('.show_if_variable').hide();
                }

            },

            removeCategory: function (e) {
                e.preventDefault();

                if ( confirm('Sure?') ) {
                    $(this).parents('.inputs-box').fadeOut(function() {
                        $(this).remove();
                    });
                }
            },

            addItem: function (e) {
                e.preventDefault();

                var self = $(this),
                    wrap = self.closest('.inputs-box'),
                    list = self.closest('ul.option-couplet');

                var col = list.find('li').length,
                    row = wrap.data('count');


                var template = _.template( $('#tmpl-sc-category-item').html() );
                self.closest('li').after(template({'row': row, 'col': col}));
            },

            removeItem: function (e) {
                e.preventDefault();

                var options = $(this).parents('ul').find('li');

                // don't remove if only one option is there
                if ( options.length > 1 ) {
                    $(this).parents('li').fadeOut(function() {
                        $(this).remove();
                    });
                }
            },

            save: function() {

                var data = {
                    post_id: $(this).data('id'),
                    data:  $('.woocommerce_attributes').find('input, select, textarea').serialize(),
                    action:  'dokan_save_attributes'
                };

                var this_page = window.location.toString();

                // $('#variants-holder').block({ message: 'saving...' });
                $('#variants-holder').block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
                $.post(ajaxurl, data, function(resp) {

                    $('#variable_product_options').block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
                    $('#variable_product_options').load( this_page + ' #variable_product_options_inner', function() {
                        $('#variable_product_options').unblock();
                    } );

                    // fire change events for varaiations
                    $('input.variable_is_downloadable, input.variable_is_virtual, input.variable_manage_stock').trigger('change');

                    $('#variants-holder').unblock();
                });
            },

            initSaleSchedule: function() {
                // Sale price schedule
                $('.sale_price_dates_fields').each(function() {

                    var $these_sale_dates = $(this);
                    var sale_schedule_set = false;
                    var $wrap = $these_sale_dates.closest( 'div, table' );

                    $these_sale_dates.find('input').each(function(){
                        if ( $(this).val() != '' )
                            sale_schedule_set = true;
                    });

                    if ( sale_schedule_set ) {

                        $wrap.find('.sale_schedule').hide();
                        $wrap.find('.sale_price_dates_fields').show();

                    } else {

                        $wrap.find('.sale_schedule').show();
                        $wrap.find('.sale_price_dates_fields').hide();

                    }

                });
            },

            saleSchedule: function() {
                var $wrap = $(this).closest( 'div, table' );

                $(this).hide();
                $wrap.find('.cancel_sale_schedule').show();
                $wrap.find('.sale_price_dates_fields').show();

                return false;
            },

            cancelSchedule: function() {
                var $wrap = $(this).closest( 'div, table' );

                $(this).hide();
                $wrap.find('.sale_schedule').show();
                $wrap.find('.sale_price_dates_fields').hide();
                $wrap.find('.sale_price_dates_fields').find('input').val('');

                return false;
            },

            dates: function() {
                var dates = $( ".sale_price_dates_fields input" ).datepicker({
                    defaultDate: "",
                    dateFormat: "yy-mm-dd",
                    numberOfMonths: 1,
                    onSelect: function( selectedDate ) {
                        var option = $(this).is('#_sale_price_dates_from, .sale_price_dates_from') ? "minDate" : "maxDate";

                        var instance = $( this ).data( "datepicker" ),
                            date = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings );
                        dates.not( this ).datepicker( "option", option, date );
                    }
                });
            },

            onVariantAdded: function() {
                Dokan_Editor.variants.dates();
            }
        },

        gallery: {

            addImages: function(e) {
                e.preventDefault();

                var attachment_ids = $image_gallery_ids.val();

                if ( product_gallery_frame ) {
                    product_gallery_frame.open();
                    return;
                }

                // Create the media frame.
                product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    // Set the title of the modal.
                    title: 'Add Images to Product Gallery',
                    button: {
                        text: 'Add to gallery',
                    },
                    multiple: true
                });

                // When an image is selected, run a callback.
                product_gallery_frame.on( 'select', function() {

                    var selection = product_gallery_frame.state().get('selection');

                    selection.map( function( attachment ) {

                        attachment = attachment.toJSON();

                        if ( attachment.id ) {
                            attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

                            $product_images.append('\
                                <li class="image" data-attachment_id="' + attachment.id + '">\
                                    <img src="' + attachment.url + '" />\
                                    <a href="#" class="action-delete">&times;</a>\
                                </li>');
                        }

                    } );

                    $image_gallery_ids.val( attachment_ids );
                });

                product_gallery_frame.open();
            },

            deleteImage: function(e) {
                e.preventDefault();

                $(this).closest('li.image').remove();

                var attachment_ids = '';

                $('#product_images_container ul li.image').css('cursor','default').each(function() {
                    var attachment_id = $(this).attr( 'data-attachment_id' );
                    attachment_ids = attachment_ids + attachment_id + ',';
                });

                $image_gallery_ids.val( attachment_ids );

                return false;
            },

            sortable: function() {
                // Image ordering
                $product_images.sortable({
                    items: 'li.image',
                    cursor: 'move',
                    scrollSensitivity:40,
                    forcePlaceholderSize: true,
                    forceHelperSize: false,
                    helper: 'clone',
                    opacity: 0.65,
                    placeholder: 'dokan-sortable-placeholder',
                    start:function(event,ui){
                        ui.item.css('background-color','#f6f6f6');
                    },
                    stop:function(event,ui){
                        ui.item.removeAttr('style');
                    },
                    update: function(event, ui) {
                        var attachment_ids = '';

                        $('#product_images_container ul li.image').css('cursor','default').each(function() {
                            var attachment_id = jQuery(this).attr( 'data-attachment_id' );
                            attachment_ids = attachment_ids + attachment_id + ',';
                        });

                        $image_gallery_ids.val( attachment_ids );
                    }
                });
            }
        },

        featuredImage: {

            addImage: function(e) {
                e.preventDefault();

                var self = $(this);

                if ( product_featured_frame ) {
                    product_featured_frame.open();
                    return;
                }

                product_featured_frame = wp.media({
                    // Set the title of the modal.
                    title: 'Upload featured image',
                    button: {
                        text: 'Set featured image',
                    }
                });

                product_featured_frame.on('select', function() {
                    var selection = product_featured_frame.state().get('selection');

                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();

                        // set the image hidden id
                        self.siblings('input.dokan-feat-image-id').val(attachment.id);

                        // set the image
                        var instruction = self.closest('.instruction-inside');
                        var wrap = instruction.siblings('.image-wrap');

                        // wrap.find('img').attr('src', attachment.sizes.thumbnail.url);
                        wrap.find('img').attr('src', attachment.url);

                        instruction.addClass('dokan-hide');
                        wrap.removeClass('dokan-hide');
                    });
                });

                product_featured_frame.open();
            },

            removeImage: function(e) {
                e.preventDefault();

                var self = $(this);
                var wrap = self.closest('.image-wrap');
                var instruction = wrap.siblings('.instruction-inside');

                instruction.find('input.dokan-feat-image-id').val('0');
                wrap.addClass('dokan-hide');
                instruction.removeClass('dokan-hide');
            }
        },

        fileDownloadable: function(e) {
                e.preventDefault();

                var self = $(this),
                    downloadable_frame;

                if ( downloadable_frame ) {
                    downloadable_frame.open();
                    return;
                }

                downloadable_frame = wp.media({
                    title: 'Choose a file',
                    button: {
                        text: 'Insert file URL',
                    },
                    multiple: true
                });

                downloadable_frame.on('select', function() {
                    var selection = downloadable_frame.state().get('selection');

                    selection.map( function( attachment ) {
                        attachment = attachment.toJSON();

                        self.closest('tr').find('input.wc_file_url').val(attachment.url);
                    });
                });

                downloadable_frame.on( 'ready', function() {
                    downloadable_frame.uploader.options.uploader.params = {
                        type: 'downloadable_product'
                    };
                });

                downloadable_frame.open();
        },

        sidebarToggle: {
            showStatus: function(e) {
                var container = $(this).siblings('.dokan-toggle-select-container');

                if (container.is(':hidden')) {
                    container.slideDown('fast');

                    $(this).hide();
                }

                return false;
            },

            saveStatus: function(e) {
                var container = $(this).closest('.dokan-toggle-select-container');

                container.slideUp('fast');
                container.siblings('a.dokan-toggle-edit').show();

                // update the text
                var text = $('option:selected', container.find('select.dokan-toggle-select')).text();
                container.siblings('.dokan-toggle-selected-display').html(text);

                return false;
            },

            cancel: function(e) {
                var container = $(this).closest('.dokan-toggle-select-container');

                container.slideUp('fast');
                container.siblings('a.dokan-toggle-edit').show();

                return false;
            }
        },

        shipping: {
            disableOverride: function() {
                if ( $('#_disable_shipping').is(':checked') ) {
                    $('.hide_if_disable').hide();
                } else {
                    $('.hide_if_disable').show();
                    Dokan_Editor.newProductDesign.shipping.showHideOverride();
                }

            }
        }
    };

    // On DOM ready
    $(function() {
        Dokan_Editor.init();
        $('#_product_type').trigger('change');
        $('.sale-schedule').trigger('change');
        $('#_manage_stock').trigger('change');
        $('#_required_shipping').trigger('change');
        $('#_disable_shipping').trigger('change');
        $('#_required_tax').trigger('change');
        $('#_has_attribute').trigger('change');
        $('#_create_variation').trigger('change');
        $('input[type=checkbox].dokan_create_variation').trigger('change');
        $('#_downloadable').trigger('change');
        $('input.variable_is_downloadable, input.variable_is_virtual, input.variable_manage_stock' ).change();
    });

})(jQuery);