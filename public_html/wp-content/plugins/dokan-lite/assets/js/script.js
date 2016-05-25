jQuery(function($) {

    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });

    $('.tips').tooltip();

    // set dashboard menu height
    var dashboardMenu = $('ul.dokan-dashboard-menu'),
        contentArea = $('.dokan-dashboard-content');

    if ( $(window).width() > 767) {
        if ( contentArea.height() > dashboardMenu.height() ) {
            dashboardMenu.css({ height: contentArea.height() });
        }
    }

    function showTooltip(x, y, contents) {
        jQuery('<div class="chart-tooltip">' + contents + '</div>').css({
            top: y - 16,
            left: x + 20
        }).appendTo("body").fadeIn(200);
    }

    var prev_data_index = null;
    var prev_series_index = null;

    jQuery(".chart-placeholder").bind("plothover", function(event, pos, item) {
        if (item) {
            if (prev_data_index != item.dataIndex || prev_series_index != item.seriesIndex) {
                prev_data_index = item.dataIndex;
                prev_series_index = item.seriesIndex;

                jQuery(".chart-tooltip").remove();

                if (item.series.points.show || item.series.enable_tooltip) {

                    var y = item.series.data[item.dataIndex][1];

                    tooltip_content = '';

                    if (item.series.prepend_label)
                        tooltip_content = tooltip_content + item.series.label + ": ";

                    if (item.series.prepend_tooltip)
                        tooltip_content = tooltip_content + item.series.prepend_tooltip;

                    tooltip_content = tooltip_content + y;

                    if (item.series.append_tooltip)
                        tooltip_content = tooltip_content + item.series.append_tooltip;

                    if (item.series.pie.show) {

                        showTooltip(pos.pageX, pos.pageY, tooltip_content);

                    } else {

                        showTooltip(item.pageX, item.pageY, tooltip_content);

                    }

                }
            }
        } else {
            jQuery(".chart-tooltip").remove();
            prev_data_index = null;
        }
    });

});

// Dokan Register

jQuery(function($) {
    $('.user-role input[type=radio]').on('change', function() {
        var value = $(this).val();

        if ( value === 'seller') {
            $('.show_if_seller').slideDown();
            if ( $( '.tc_check_box' ).length > 0 )
                $('input[name=register]').attr('disabled','disabled');
        } else {            
            $('.show_if_seller').slideUp();
            if ( $( '.tc_check_box' ).length > 0 )
                $( 'input[name=register]' ).removeAttr( 'disabled' );
        }
    });
    
   $( '.tc_check_box' ).on( 'click', function () {
        var chk_value = $( this ).val();
        console.log( chk_value );
        if ( $( this ).prop( "checked" ) ) {
            $( 'input[name=register]' ).removeAttr( 'disabled' );
            $( 'input[name=dokan_migration]' ).removeAttr( 'disabled' );
        } else {
            $( 'input[name=register]' ).attr( 'disabled', 'disabled' );
            $( 'input[name=dokan_migration]' ).attr( 'disabled', 'disabled' );
        }
    } );
    
    if ( $( '.tc_check_box' ).length > 0 ){
        $( 'input[name=dokan_migration]' ).attr( 'disabled', 'disabled' );
    }

    $('#company-name').on('focusout', function() {
        var value = $(this).val().toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
        $('#seller-url').val(value);
        $('#url-alart').text( value );
        $('#seller-url').focus();
    });

    $('#seller-url').keydown(function(e) {
        var text = $(this).val();

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 91, 109, 110, 173, 189, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                return;
        }

        if ((e.shiftKey || (e.keyCode < 65 || e.keyCode > 90) && (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105) ) {
            e.preventDefault();
        }
    });

    $('#seller-url').keyup(function(e) {
        $('#url-alart').text( $(this).val() );
    });

    $('#shop-phone').keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 91, 107, 109, 110, 187, 189, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }

        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $('#seller-url').on('focusout', function() {
        var self = $(this),
        data = {
            action : 'shop_url',
            url_slug : self.val(),
            _nonce : dokan.nonce,
        };

        if ( self.val() === '' ) {
            return;
        }

        var row = self.closest('.form-row');
        row.block({ message: null, overlayCSS: { background: '#fff url(' + dokan.ajax_loader + ') no-repeat center', opacity: 0.6 } });

        $.post( dokan.ajaxurl, data, function(resp) {

            if ( resp == 0){
                $('#url-alart').removeClass('text-success').addClass('text-danger');
                $('#url-alart-mgs').removeClass('text-success').addClass('text-danger').text(dokan.seller.notAvailable);
            } else {
                $('#url-alart').removeClass('text-danger').addClass('text-success');
                $('#url-alart-mgs').removeClass('text-danger').addClass('text-success').text(dokan.seller.available);
            }

            row.unblock();

        } );

    });
});

//dokan settings

(function($) {

    $.validator.setDefaults({ ignore: ":hidden" });

    var validatorError = function(error, element) {
        var form_group = $(element).closest('.form-group');
        form_group.addClass('has-error').append(error);
    };

    var validatorSuccess = function(label, element) {
        $(element).closest('.form-group').removeClass('has-error');
    };

    var Dokan_Settings = {
        init: function() {
            var self = this;

            //image upload
            $('a.dokan-banner-drag').on('click', this.imageUpload);
            $('a.dokan-remove-banner-image').on('click', this.removeBanner);

            $('a.dokan-gravatar-drag').on('click', this.gragatarImageUpload);
            $('a.dokan-remove-gravatar-image').on('click', this.removeGravatar);

            this.validateForm(self);

            return false;
        },


        imageUpload: function(e) {
            e.preventDefault();

            var file_frame,
                self = $(this);

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery( this ).data( 'uploader_title' ),
                button: {
                    text: jQuery( this ).data( 'uploader_button_text' )
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();

                var wrap = self.closest('.dokan-banner');
                wrap.find('input.dokan-file-field').val(attachment.id);
                wrap.find('img.dokan-banner-img').attr('src', attachment.url);
                self.parent().siblings('.image-wrap', wrap).removeClass('dokan-hide');

                self.parent('.button-area').addClass('dokan-hide');
            });

            // Finally, open the modal
            file_frame.open();

        },
        gragatarImageUpload: function(e) {
            e.preventDefault();

            var file_frame,
                self = $(this);

            // If the media frame already exists, reopen it.
            if ( file_frame ) {
                file_frame.open();
                return;
            }

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: jQuery( this ).data( 'uploader_title' ),
                button: {
                    text: jQuery( this ).data( 'uploader_button_text' )
                },
                multiple: false
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                var attachment = file_frame.state().get('selection').first().toJSON();

                var wrap = self.closest('.dokan-gravatar');
                wrap.find('input.dokan-file-field').val(attachment.id);
                wrap.find('img.dokan-gravatar-img').attr('src', attachment.url);
                self.parent().siblings('.gravatar-wrap', wrap).removeClass('dokan-hide');
                self.parent('.gravatar-button-area').addClass('dokan-hide');

            });

            // Finally, open the modal
            file_frame.open();

        },

        submitSettings: function(form_id) {

            if ( typeof tinyMCE != 'undefined' ) {
                tinyMCE.triggerSave();
            }

            var self = $( "form#" + form_id ),
                form_data = self.serialize() + '&action=dokan_settings&form_id=' + form_id;

            self.find('.ajax_prev').append('<span class="dokan-loading"> </span>');
            $.post(dokan.ajaxurl, form_data, function(resp) {

                self.find('span.dokan-loading').remove();
                $('html,body').animate({scrollTop:100});

               if ( resp.success ) {
                    // Harcoded Customization for template-settings function
                      $('.dokan-ajax-response').html( $('<div/>', {
                        'class': 'dokan-alert dokan-alert-success',
                        'html': '<p>' + resp.data.msg + '</p>',
                    }) );

                    $('.dokan-ajax-response').append(resp.data.progress);

                }else {
                    $('.dokan-ajax-response').html( $('<div/>', {
                        'class': 'dokan-alert dokan-alert-danger',
                        'html': '<p>' + resp.data + '</p>'
                    }) );
                }
            });
        },

        validateForm: function(self) {

            $("form#settings-form, form#profile-form, form#store-form, form#payment-form").validate({
                //errorLabelContainer: '#errors'
                submitHandler: function(form) {
                    self.submitSettings( form.getAttribute('id') );
                },
                errorElement: 'span',
                errorClass: 'error',
                errorPlacement: validatorError,
                success: validatorSuccess
            });

        },

        removeBanner: function(e) {
            e.preventDefault();

            var self = $(this);
            var wrap = self.closest('.image-wrap');
            var instruction = wrap.siblings('.button-area');

            wrap.find('input.dokan-file-field').val('0');
            wrap.addClass('dokan-hide');
            instruction.removeClass('dokan-hide');
        },

        removeGravatar: function(e) {
            e.preventDefault();

            var self = $(this);
            var wrap = self.closest('.gravatar-wrap');
            var instruction = wrap.siblings('.gravatar-button-area');

            wrap.find('input.dokan-file-field').val('0');
            wrap.addClass('dokan-hide');
            instruction.removeClass('dokan-hide');
        },
    };

    var Dokan_Withdraw = {

        init: function() {
            var self = this;

            this.withdrawValidate(self);
        },

        withdrawValidate: function(self) {
            $('form.withdraw').validate({
                //errorLabelContainer: '#errors'

                errorElement: 'span',
                errorClass: 'error',
                errorPlacement: validatorError,
                success: validatorSuccess
            })
        }
    };

    var Dokan_Coupons = {
        init: function() {
            var self = this;
            this.couponsValidation(self);
        },

        couponsValidation: function(self) {
            $("form.coupons").validate({
                errorElement: 'span',
                errorClass: 'error',
                errorPlacement: validatorError,
                success: validatorSuccess
            });
        }
    };

    var Dokan_Seller = {
        init: function() {
            this.validate(this);
        },

        validate: function(self) {
            // e.preventDefault();

            $('form#dokan-form-contact-seller').validate({
                errorPlacement: validatorError,
                success: validatorSuccess,
                submitHandler: function(form) {

                    $(form).block({ message: null, overlayCSS: { background: '#fff url(' + dokan.ajax_loader + ') no-repeat center', opacity: 0.6 } });

                    var form_data = $(form).serialize();
                    $.post(dokan.ajaxurl, form_data, function(resp) {
                        $(form).unblock();

                        if ( typeof resp.data !== 'undefined' ) {
                            $(form).find('.ajax-response').html(resp.data);
                        }

                        $(form).find('input[type=text], input[type=email], textarea').val('').removeClass('valid');
                    });
                }
            });
        }
    };

    var Dokan_Add_Seller = {
        init: function() {
            this.validate(this);
        },

        validate: function(self) {

            $('form.register').validate({
                errorPlacement: validatorError,
                success: validatorSuccess,
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    };

    $(function() {
        Dokan_Settings.init();
        Dokan_Withdraw.init();
        Dokan_Coupons.init();
        Dokan_Seller.init();
        Dokan_Add_Seller.init();
    });

})(jQuery);

// Shipping tab js
(function($){
    $(document).ready(function(){

        $('.dokan-shipping-location-wrapper').on('change', '.dps_country_selection', function() {
            var self = $(this),
                data = {
                    country_id : self.find(':selected').val(),
                    action  : 'dps_select_state_by_country'
                };

                if ( self.val() == '' || self.val() == 'everywhere' ) {
                    self.closest('.dps-shipping-location-content').find('table.dps-shipping-states tbody').html('');
                } else {
                    $.post( dokan.ajaxurl, data, function(response) {
                        if( response.success ) {
                            self.closest('.dps-shipping-location-content').find('table.dps-shipping-states tbody').html(response.data);
                        }
                    });
                }
        });

    });
})(jQuery);


(function($){

    $(document).ready(function(){

        $('.dps-main-wrapper').on('click', 'a.dps-shipping-add', function(e) {
            e.preventDefault();

            html = $('#dps-shipping-hidden-lcoation-content');
            var row = $(html).first().clone().appendTo($('.dokan-shipping-location-wrapper')).show();
            $('.dokan-shipping-location-wrapper').find('.dps-shipping-location-content').first().find('a.dps-shipping-remove').show();

            $('.tips').tooltip();

            row.removeAttr('id');
            row.find('input,select').val('');
            row.find('a.dps-shipping-remove').show();
        });

        $('.dokan-shipping-location-wrapper').on('click', 'a.dps-shipping-remove', function(e) {
            e.preventDefault();
            $(this).closest('.dps-shipping-location-content').remove();
            $dpsElm = $('.dokan-shipping-location-wrapper').find('.dps-shipping-location-content');

            if( $dpsElm.length == 1) {
                $dpsElm.first().find('a.dps-shipping-remove').hide();
            }
        });

        $('.dokan-shipping-location-wrapper').on('click', 'a.dps-add', function(e) {
            e.preventDefault();

            var row = $(this).closest('tr').first().clone().appendTo($(this).closest('table.dps-shipping-states'));
            row.find('input,select').val('');
            row.find('a.dps-remove').show();
            $('.tips').tooltip();
        });

        $('.dokan-shipping-location-wrapper').on('click', 'a.dps-remove', function(e) {
            e.preventDefault();

            if( $(this).closest('table.dps-shipping-states').find( 'tr' ).length == 1 ){
                //console.log($(this).closest('.dps-shipping-location-content').find('input,select'));
                $(this).closest('.dps-shipping-location-content').find('td.dps_shipping_location_cost').show();
            }

            $(this).closest('tr').remove();


        });

        $('.dokan-shipping-location-wrapper').on('change keyup', '.dps_state_selection', function() {
            var self = $(this);

            if( self.val() == '' || self.val() == '-1' ) {
                self.closest('.dps-shipping-location-content').find('td.dps_shipping_location_cost').show();
            } else {
                self.closest('.dps-shipping-location-content').find('td.dps_shipping_location_cost').hide();
            }
        });

        $('.dokan-shipping-location-wrapper .dps_state_selection').trigger('change');
        $('.dokan-shipping-location-wrapper .dps_state_selection').trigger('keyup');

        $wrap = $('.dokan-shipping-location-wrapper').find('.dps-shipping-location-content');

        if( $wrap.length == 1) {
            $wrap.first().find('a.dps-shipping-remove').hide();
        }

    });

})(jQuery);

// For Announcement scripts;
(function($){

    $(document).ready(function(){
        $( '.dokan-announcement-wrapper' ).on( 'click', 'a.remove_announcement', function(e) {
            e.preventDefault();

            if( confirm( dokan.delete_confirm ) ) {

                var self = $(this),
                    data = {
                        'action' : 'dokan_announcement_remove_row',
                        'row_id' : self.data('notice_row'),
                        '_wpnonce' : dokan.nonce
                    };
                self.closest('.dokan-announcement-wrapper-item').append('<span class="dokan-loading" style="position:absolute;top:2px; right:15px"> </span>');
                var row_count = $('.dokan-announcement-wrapper-item').length;
                $.post( dokan.ajaxurl, data, function(response) {
                    if( response.success ) {
                        self.closest('.dokan-announcement-wrapper-item').find( 'span.dokan-loading' ).remove();
                        self.closest('.dokan-announcement-wrapper-item').fadeOut(function(){
                            $(this).remove();
                            if( row_count == 1 ) {
                                $( '.dokan-announcement-wrapper' ).html( response.data );
                            }
                        });
                    } else {
                        alert( dokan.wrong_message );
                    }
                });
            }

        });
    });

})(jQuery);
//dokan store seo form submit
(function($){

    var wrapper = $( '.dokan-store-seo-wrapper' );
    var Dokan_Store_SEO = {

        init : function() {
            wrapper.on( 'submit', 'form#dokan-store-seo-form', this.form.validate );
        },

        form : {

            validate : function(e){
                e.preventDefault();

                var self = $( this ),
                data = {
                    action: 'dokan_seo_form_handler',
                    data: self.serialize(),
                };
                //console.log(data.data);
                Dokan_Store_SEO.form.submit( data );

                return false;
            },

            submit : function( data ){
                var feedback = $('#dokan-seo-feedback');
                feedback.fadeOut();

                $.post( dokan.ajaxurl, data, function ( resp ) {
                    if ( resp.success == true ) {
                        feedback.html(resp.data);
                        feedback.removeClass('dokan-hide');
                        feedback.addClass('dokan-alert-success');
                        feedback.fadeIn();
                    } else {
                        feedback.html(resp.data);
                        feedback.addClass('dokan-alert-danger');
                        feedback.removeClass('dokan-hide');
                        feedback.fadeIn();
                    }
                } )
            }

        },
    };

    $(function() {
        Dokan_Store_SEO.init();
    });

})(jQuery);

//localize Validation messages
(function($){
    var dokan_messages = DokanValidateMsg;

    dokan_messages.maxlength   = $.validator.format( dokan_messages.maxlength_msg );
    dokan_messages.minlength   = $.validator.format( dokan_messages.minlength_msg );
    dokan_messages.rangelength = $.validator.format( dokan_messages.rangelength_msg );
    dokan_messages.range       = $.validator.format( dokan_messages.range_msg );
    dokan_messages.max         = $.validator.format( dokan_messages.max_msg );
    dokan_messages.min         = $.validator.format( dokan_messages.min_msg );

    $.validator.messages = dokan_messages;

    $(document).on('click','#dokan_store_tnc_enable',function(e) {
        if($(this).is(':checked')) {
            $('#dokan_tnc_text').show();
        }else {
            $('#dokan_tnc_text').hide();
        }
    }).ready(function(e){
        if($('#dokan_store_tnc_enable').is(':checked')) {
            $('#dokan_tnc_text').show();
        }else {
            $('#dokan_tnc_text').hide();
        }
    });

})(jQuery);
