/**
 * Frontend
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Colors and Labels Variations
 * @version 1.0.0
 */

(function ($, window, document) {

    $.fn.yith_wccl = function () {
        var form = this;
        var last_change = form.data('last_change');
        var select = form.find('.variations select');


        this.clean = function () {
            form.find('.select_box').remove();

            return this;
        };

        this.generateOutput = function () {

            select.each(function () {
                var t = $(this),
                    type = $(this).data('type');

                var select_box = $('<div />', {
                    'class': 'select_box_' + type + ' select_box ' + t.attr('name')
                }).insertAfter(t);

                t.removeData('last_content');

                t.find('option').each(function () {
                    if ( $(this).data('value') ) {
                        var classes = 'select_option_' + type + ' select_option';
                        var value = $(this).data('value');
                        var o = $(this);

                        var option = $('<div/>', {
                            'class': classes
                        }).data('value', $(this).attr('value'))
                            .data('option', o.clone(true))
                            .appendTo(select_box)
                            .off('click')
                            .on('click', function (e) {
                                if ($(this).hasClass('selected')) {
                                    t.val('').change();
                                } else {
                                    e.preventDefault();
                                    t.val(o.val()).change();
                                }
                            });

                        if (type == 'colorpicker') {
                            option.append($('<span/>', {
                                'css': {
                                    'background': value
                                }
                            }));
                        } else if (type == 'image') {
                            option.append($('<img/>', {
                                'src': value
                            }));
                        } else if (type == 'label') {
                            option.append($('<span/>', {
                                'text': value
                            }));
                        }
                    }
                });
            }).filter(function () {
                    return $(this).data('type') != 'select'
                }).hide();

            return form;
        };

        this.onSelect = function () {

            select.each(function () {
                var value = $(this).val();
                var options = $(this).next('.select_box'); // get next elem

                // else get siblings
                if( ! options.length ){
                    options = $(this).siblings('.select_box');
                }
                // reset class
                options = options.find('.select_option').removeClass('selected');

                if (value) {
                    options
                        .filter(function () {
                            return $(this).data('value') == value
                        })
                        .addClass('selected');
                }
            });

            return form;
        };

        this.updateOptions = function () {
            var variations;

            if( (typeof yith_wccl_arg != 'undefined') && ! yith_wccl_arg.is_wc24 ) {

                form.find('.variations select').each(function (index, el) {

                    var s = $(this),
                        selected = s.val(),
                        attribute_options = s.data('active_options') ? s.data('active_options') : s.data('attribute_options');

                    if ( ! attribute_options ) return false;

                    if (selected != '') {
                        $.each( attribute_options, function (index, option_html) {
                            s.append(option_html);
                        });
                    } else {
                        s.data('active_options', s.find('option').get());
                    }

                });
            }

            return form;
        };

        return this
            .updateOptions()
            .clean()
            .generateOutput()
            .onSelect();
    };


    jQuery(function ($) {

        var form = $('.variations_form');
        var select = form.find('.variations select');

        $(document).on('yith_wccl_change check_variations', form,function () {
            $(this).yith_wccl();
        }).trigger('yith_wccl_change');


        $(document).on('change', select, function () {
            form.data('last_change', $(this).attr('name'));
            $(this).data('last_content', $(this).siblings('.select_box').clone(true));
        });

        $(document).on('click', '.reset_variations', function () {
            select.removeData('last_content');
            form.removeData('last_change');
        });

        select.trigger('focusin');

    });

})(jQuery, window, document);

