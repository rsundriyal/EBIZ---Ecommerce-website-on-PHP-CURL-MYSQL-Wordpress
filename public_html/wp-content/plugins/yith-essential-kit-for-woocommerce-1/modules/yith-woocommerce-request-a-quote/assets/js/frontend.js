jQuery(document).ready( function($){
    "use strict";

    var $body = $('body'),
        $add_to_cart_el = $('.add-request-quote-button'),
        $remove_item = $('.yith-ywraq-item-remove');

    if( $body.hasClass('single-product') ){

        var $product_id = $('[name|="product_id"]'),
            product_id = $product_id.val(),
            button = $('.add-to-quote-'+product_id).find('a'),
            $button_wrap = button.parents('.yith-ywraq-add-to-quote'),
            $variation_id = $('[name|="variation_id"]');

        $variation_id.on('change', function(){

            if( $(this).val() == ''){
                button.parent().hide().removeClass('show');
            }else{
                $.ajax({
                    type   : 'POST',
                    url    : ywraq_frontend.ajaxurl,
                    dataType: 'json',
                    data   : 'action=yith_ywraq_action&ywraq_action=variation_exist&variation_id='+$variation_id.val()+'&product_id='+$product_id.val(),
                    success: function (response) {
                        if( response.result === true){
                            button.parent().hide().removeClass('show');
                            if( $('.yith_ywraq_add_item_browse-list-'+$product_id.val()).length == 0){
                                $button_wrap.append( '<div class="yith_ywraq_add_item_response-'+$product_id.val()+' yith_ywraq_add_item_response_message">' + response.message + '</div>');
                                $button_wrap.append( '<div class="yith_ywraq_add_item_browse-list-'+$product_id.val()+' yith_ywraq_add_item_browse_message"><a href="'+response.rqa_url+'">' + response.label_browse + '</a></div>');
                            }
                        }else{
                            $('.yith_ywraq_add_item_response-'+$product_id.val()).remove();
                            $('.yith_ywraq_add_item_browse-list-'+$product_id.val()).remove();
                            button.parent().show().addClass('show');
                        }
                    }
                });
            }

        });
    }


    $(document).on( 'click' ,'.add-request-quote-button', function(e){

        e.preventDefault();

        var $t = $(this),
            $t_wrap = $t.parents('.yith-ywraq-add-to-quote'),
            add_to_cart_info = 'ac';


        if ( $t.parents('ul.products').length > 0) {
            var $add_to_cart_el = $t.parents('li.product').find('input[name="add-to-cart"]'),
                $product_id_el = $t.parents('li.product').find('input[name="product_id"]');
        }else{
            var $add_to_cart_el = $t.parents('.product').find('input[name="add-to-cart"]'),
                $product_id_el = $t.parents('.product').find('input[name="product_id"]');
        }


        if ($add_to_cart_el.length > 0 && $product_id_el.length > 0) { //variable product
            add_to_cart_info = $('.cart').serialize();
        } else if ( $add_to_cart_el.length > 0 && $('.cart').length > 0) { //single product and form exists with cart class
            add_to_cart_info = $('.cart').serialize();
        } else if ( $add_to_cart_el.length == 0) { //shop page - archive page
            add_to_cart_info = 'quantity=1';
        }


        add_to_cart_info += '&action=yith_ywraq_action&ywraq_action=add_item&product_id='+$t.data('product_id')+'&wp_nonce='+$t.data('wp_nonce');
        if( add_to_cart_info.indexOf('add-to-cart') > 0){
            add_to_cart_info = add_to_cart_info.replace( 'add-to-cart', 'yith-add-to-cart');
        }

        $.ajax({
            type   : 'POST',
            url    : ywraq_frontend.ajaxurl,
            dataType: 'json',
            data   : add_to_cart_info,
            beforeSend: function(){
                $t.siblings( '.ajax-loading' ).css( 'visibility', 'visible' );
            },
            complete: function(){
                $t.siblings( '.ajax-loading' ).css( 'visibility', 'hidden' );
            },

            success: function (response) {
                if( response.result == 'true' || response.result == 'exists'){
                    $t.parent().hide().removeClass('show').addClass('addedd');
                    var prod_id = ( typeof $product_id_el.val() == 'undefined') ? '' : '-'+$product_id_el.val();
                    $t_wrap.append( '<div class="yith_ywraq_add_item_response'+ prod_id +' yith_ywraq_add_item_response_message">' + response.message + '</div>');
                    $t_wrap.append( '<div class="yith_ywraq_add_item_browse-list'+prod_id+' yith_ywraq_add_item_browse_message"><a href="'+response.rqa_url+'">' + response.label_browse + '</a></div>');


                }else if( response.result == 'false' ){
                    $t_wrap.append( '<div class="yith_ywraq_add_item_response-'+$product_id_el.val()+'">' + response.message + '</div>');
                }
            }
        });


    });


    /*Remove an item from rqa list*/
    $remove_item.on( 'click' , function(e){

        e.preventDefault();

        var $t = $(this),
            key = $t.data('remove-item'),
            form = $('#yith-ywraq-form'),
            remove_info = '';

        remove_info = 'action=yith_ywraq_action&ywraq_action=remove_item&key='+$t.data('remove-item')+'&wp_nonce='+$t.data('wp_nonce')+'&product_id='+$t.data('product_id');

        $.ajax({
            type   : 'POST',
            url    : ywraq_frontend.ajaxurl,
            dataType: 'json',
            data   : remove_info,
            beforeSend: function(){
                $t.siblings( '.ajax-loading' ).css( 'visibility', 'visible' );
            },
            complete: function(){
                $t.siblings( '.ajax-loading' ).css( 'visibility', 'hidden' );
            },

            success: function (response) {
                if( response === 1){
                    $("[data-remove-item='"+key+"']").parents('.cart_item').remove();
                    if( $('.cart_item').length === 0 ){
                        $('#yith-ywraq-form, #yith-ywraq-mail-form, .yith-ywraq-mail-form-wrapper').remove();
                        $('#yith-ywraq-message').text(ywraq_frontend.no_product_in_list);
                    }
                }
            }
        });
    });
});