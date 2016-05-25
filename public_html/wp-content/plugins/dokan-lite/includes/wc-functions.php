<?php

/**
 * Show the variable product options.
 *
 * @access public
 * @return void
 */
function dokan_variable_product_type_options() {
    global $post, $woocommerce;

    $attributes = maybe_unserialize( get_post_meta( $post->ID, '_product_attributes', true ) );

    // See if any are set
    $variation_attribute_found = false;
    if ( $attributes ) foreach( $attributes as $attribute ) {
        if ( isset( $attribute['is_variation'] ) ) {
            $variation_attribute_found = true;
            break;
        }
    }

    // Get tax classes
    $tax_classes           = array_filter( array_map('trim', explode( "\n", get_option( 'woocommerce_tax_classes' ) ) ) );
    $tax_class_options     = array();
    $tax_class_options[''] = __( 'Standard', 'dokan' );

    if ( $tax_classes ) {
        foreach ( $tax_classes as $class ) {
            $tax_class_options[ sanitize_title( $class ) ] = esc_attr( $class );
        }
    }

    // var_dump( $attributes, $tax_classes, $tax_class_options );
    ?>
    <div id="variable_product_options" class="wc-metaboxes-wrapper">
        <div id="variable_product_options_inner">

        <?php if ( ! $variation_attribute_found ) : ?>

            <div id="message" class="inline woocommerce-message">
                <div class="squeezer">
                    <h4><?php _e( 'Before adding variations, add and save some attributes on the <strong>Attributes</strong> tab.', 'dokan' ); ?></h4>

                    <p class="submit"><a class="button-primary" href="http://docs.woothemes.com/document/product-variations/" target="_blank"><?php _e( 'Learn more', 'dokan' ); ?></a></p>
                </div>
            </div>

        <?php else : ?>

            <div class="woocommerce_variations wc-metaboxes">
                <?php
                // Get parent data
                $parent_data = array(
                    'id'                => $post->ID,
                    'attributes'        => $attributes,
                    'tax_class_options' => $tax_class_options,
                    'sku'               => get_post_meta( $post->ID, '_sku', true ),
                    'weight'            => get_post_meta( $post->ID, '_weight', true ),
                    'length'            => get_post_meta( $post->ID, '_length', true ),
                    'width'             => get_post_meta( $post->ID, '_width', true ),
                    'height'            => get_post_meta( $post->ID, '_height', true ),
                    'tax_class'         => get_post_meta( $post->ID, '_tax_class', true )
                );

                if ( ! $parent_data['weight'] )
                    $parent_data['weight'] = '0.00';

                if ( ! $parent_data['length'] )
                    $parent_data['length'] = '0';

                if ( ! $parent_data['width'] )
                    $parent_data['width'] = '0';

                if ( ! $parent_data['height'] )
                    $parent_data['height'] = '0';

                // Get variations
                $args = array(
                    'post_type'     => 'product_variation',
                    'post_status'   => array( 'private', 'publish' ),
                    'numberposts'   => -1,
                    'orderby'       => 'menu_order',
                    'order'         => 'asc',
                    'post_parent'   => $post->ID
                );
                $variations = get_posts( $args );
                $loop = 0;

                if ( $variations )  {

                    foreach ( $variations as $variation ) {

                        $variation_id           = absint( $variation->ID );
                        $variation_post_status  = esc_attr( $variation->post_status );
                        $variation_data         = get_post_meta( $variation_id );
                        $variation_data['variation_post_id'] = $variation_id;

                        // Grab shipping classes
                        $shipping_classes = get_the_terms( $variation_id, 'product_shipping_class' );
                        $shipping_class = ( $shipping_classes && ! is_wp_error( $shipping_classes ) ) ? current( $shipping_classes )->term_id : '';

                        $variation_fields = array(
                            '_sku',
                            '_stock',
                            '_manage_stock',
                            '_stock_status',
                            '_regular_price',
                            '_sale_price',
                            '_weight',
                            '_length',
                            '_width',
                            '_height',
                            '_download_limit',
                            '_download_expiry',
                            '_downloadable_files',
                            '_downloadable',
                            '_virtual',
                            '_thumbnail_id',
                            '_sale_price_dates_from',
                            '_sale_price_dates_to'
                        );

                        foreach ( $variation_fields as $field ) {
                            $$field = isset( $variation_data[ $field ][0] ) ? maybe_unserialize( $variation_data[ $field ][0] ) : '';
                        }

                        $_backorders = isset( $variation_data['_backorders'][0] ) ? $variation_data['_backorders'][0] : null;

                        $_tax_class = isset( $variation_data['_tax_class'][0] ) ? $variation_data['_tax_class'][0] : null;
                        $image_id   = absint( $_thumbnail_id );
                        $image      = $image_id ? wp_get_attachment_thumb_url( $image_id ) : '';

                        // Locale formatting
                        $_regular_price = wc_format_localized_price( $_regular_price );
                        $_sale_price    = wc_format_localized_price( $_sale_price );
                        $_weight        = wc_format_localized_decimal( $_weight );
                        $_length        = wc_format_localized_decimal( $_length );
                        $_width         = wc_format_localized_decimal( $_width );
                        $_height        = wc_format_localized_decimal( $_height );

                        // Stock BW compat
                        if ( '' !== $_stock ) {
                            $_manage_stock = 'yes';
                        }

                        include DOKAN_INC_DIR . '/woo-views/variation-admin-html.php';

                        $loop++;
                    }

                }
                ?>
            </div> <!-- .woocommerce_variations -->

            <p class="toolbar">

                <button type="button" class="dokan-btn dokan-btn-sm dokan-btn-success button-primary add_variation" <?php disabled( $variation_attribute_found, false ); ?>><?php _e( 'Add Variation', 'dokan' ); ?></button>

                <button type="button" class="dokan-btn dokan-btn-sm dokan-btn-default link_all_variations" <?php disabled( $variation_attribute_found, false ); ?>><?php _e( 'Link all variations', 'dokan' ); ?></button>

                <strong><?php _e( 'Default selections:', 'dokan' ); ?></strong>
                <?php
                    $default_attributes = maybe_unserialize( get_post_meta( $post->ID, '_default_attributes', true ) );
                    foreach ( $attributes as $attribute ) {

                        // Only deal with attributes that are variations
                        if ( ! $attribute['is_variation'] )
                            continue;

                        // Get current value for variation (if set)
                        $variation_selected_value = isset( $default_attributes[ sanitize_title( $attribute['name'] ) ] ) ? $default_attributes[ sanitize_title( $attribute['name'] ) ] : '';

                        // Name will be something like attribute_pa_color
                        echo '<select name="default_attribute_' . sanitize_title( $attribute['name'] ) . '"><option value="">' . __( 'No default', 'dokan' ) . ' ' . esc_html( wc_attribute_label( $attribute['name'] ) ) . '&hellip;</option>';

                        // Get terms for attribute taxonomy or value if its a custom attribute
                        if ( $attribute['is_taxonomy'] ) {

                            $post_terms = wp_get_post_terms( $post->ID, $attribute['name'] );

                            foreach ( $post_terms as $term )
                                echo '<option ' . selected( $variation_selected_value, $term->slug, false ) . ' value="' . esc_attr( $term->slug ) . '">' . apply_filters( 'woocommerce_variation_option_name', esc_html( $term->name ) ) . '</option>';

                        } else {

                            $options = array_map( 'trim', explode( '|', $attribute['value'] ) );

                            foreach ( $options as $option )
                                echo '<option ' . selected( sanitize_title( $variation_selected_value ), sanitize_title( $option ), false ) . ' value="' . esc_attr( sanitize_title( $option ) ) . '">' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) )  . '</option>';

                        }

                        echo '</select>';
                    }
                ?>
            </p> <!-- .toolbar -->

        <?php endif; ?>
    </div>
</div>
    <?php
    /**
     * Product Type Javascript
     */
    ob_start();
    ?>
    jQuery(function($){

        var variation_sortable_options = {
            items:'.woocommerce_variation',
            cursor:'move',
            axis:'y',
            handle: 'h3',
            scrollSensitivity:40,
            forcePlaceholderSize: true,
            helper: 'clone',
            opacity: 0.65,
            placeholder: 'wc-metabox-sortable-placeholder',
            start:function(event,ui){
                ui.item.css('background-color','#f6f6f6');
            },
            stop:function(event,ui){
                ui.item.removeAttr('style');
                variation_row_indexes();
            }
        };

        // Add a variation
        jQuery('#variable_product_options').on('click', 'button.add_variation', function(){

            jQuery('.woocommerce_variations').block({ message: null, overlayCSS: { background: '#fff url(<?php echo $woocommerce->plugin_url(); ?>/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.6 } });

            var loop = jQuery('.woocommerce_variation').size();

            var data = {
                action: 'dokan_add_variation',
                post_id: <?php echo $post->ID; ?>,
                loop: loop,
                security: '<?php echo wp_create_nonce("add-variation"); ?>'
            };

            jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {

                jQuery('.woocommerce_variations').append( response );
                jQuery(".tips").tooltip();

                jQuery('input.variable_is_downloadable, input.variable_is_virtual').change();

                jQuery('.woocommerce_variations').unblock();
                jQuery('#variable_product_options').trigger('woocommerce_variations_added');
            });

            return false;

        });

        jQuery('#variable_product_options').on('click', 'button.link_all_variations', function(){

            var answer = confirm('<?php echo esc_js( __( 'Are you sure you want to link all variations? This will create a new variation for each and every possible combination of variation attributes (max 50 per run).', 'dokan' ) ); ?>');

            if (answer) {

                jQuery('#variable_product_options').block({ message: null, overlayCSS: { background: '#fff url(<?php echo $woocommerce->plugin_url(); ?>/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.6 } });

                var data = {
                    action: 'dokan_link_all_variations',
                    post_id: <?php echo $post->ID; ?>,
                    security: '<?php echo wp_create_nonce("link-variations"); ?>'
                };

                jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {

                    var count = parseInt( response );

                    if (count==1) {
                        alert( count + ' <?php echo esc_js( __( "variation added", 'dokan' ) ); ?>');
                    } else if (count==0 || count>1) {
                        alert( count + ' <?php echo esc_js( __( "variations added", 'dokan' ) ); ?>');
                    } else {
                        alert('<?php echo esc_js( __( "No variations added", 'dokan' ) ); ?>');
                    }

                    if (count>0) {
                        var this_page = window.location.toString();

                        this_page = this_page.replace( 'post-new.php?', 'post.php?post=<?php echo $post->ID; ?>&action=edit&' );

                        $('#variable_product_options').load( this_page + ' #variable_product_options_inner', function() {
                            $('#variable_product_options').unblock();
                            jQuery('#variable_product_options').trigger('woocommerce_variations_added');
                        } );
                    } else {
                        $('#variable_product_options').unblock();
                    }

                });
            }
            return false;
        });

        jQuery('#variable_product_options').on('click', 'button.remove_variation', function(e){
            e.preventDefault();
            var answer = confirm('<?php echo esc_js( __( 'Are you sure you want to remove this variation?', 'dokan' ) ); ?>');
            if (answer){

                var el = jQuery(this).parent().parent();

                var variation = jQuery(this).attr('rel');

                if (variation>0) {

                    jQuery(el).block({ message: null, overlayCSS: { background: '#fff url(<?php echo $woocommerce->plugin_url(); ?>/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.6 } });

                    var data = {
                        action: 'dokan_remove_variation',
                        variation_ids: variation,
                    };

                    jQuery.post('<?php echo admin_url('admin-ajax.php'); ?>', data, function(response) {
                        // Success
                        jQuery(el).fadeOut('300', function(){
                            jQuery(el).remove();
                        });
                    });

                } else {
                    jQuery(el).fadeOut('300', function(){
                        jQuery(el).remove();
                    });
                }

            }
            return false;
        });

        jQuery('#variable_product_options').on('change', 'input.variable_is_downloadable', function(){

            jQuery(this).closest('.woocommerce_variation').find('.show_if_variation_downloadable').hide();

            if (jQuery(this).is(':checked')) {
                jQuery(this).closest('.woocommerce_variation').find('.show_if_variation_downloadable').show();
            }

        });

        jQuery('#variable_product_options').on('change', 'input.variable_manage_stock', function(){

            jQuery(this).closest('.woocommerce_variation').find('.show_if_variation_manage_stock').hide();

            if (jQuery(this).is(':checked')) {
                jQuery(this).closest('.woocommerce_variation').find('.show_if_variation_manage_stock').show();
            }

        });

        jQuery('#variable_product_options').on('change', 'input.variable_is_virtual', function(){

            jQuery(this).closest('.woocommerce_variation').find('.hide_if_variation_virtual').show();

            if (jQuery(this).is(':checked')) {
                jQuery(this).closest('.woocommerce_variation').find('.hide_if_variation_virtual').hide();
            }

        });


        jQuery('input.variable_is_downloadable, input.variable_is_virtual, input.variable_manage_stock' ).change();

        // Ordering
        $('#variable_product_options').on( 'woocommerce_variations_added', function() {
            $('.woocommerce_variations').sortable( variation_sortable_options );
        } );

        $('.woocommerce_variations').sortable( variation_sortable_options );

        function variation_row_indexes() {
            $('.woocommerce_variations .woocommerce_variation').each(function(index, el){
                $('.variation_menu_order', el).val( parseInt( $(el).index('.woocommerce_variations .woocommerce_variation') ) );
            });
        };

        // Uploader
        var variable_image_frame;
        var setting_variation_image_id;
        var setting_variation_image;
        var wp_media_post_id = wp.media.model.settings.post.id;

        wp.media.view.settings.post = <?php echo json_encode( array( 'param' => 'dokan', 'post_id' => $post->ID ) ); // big juicy hack. ?>;

        jQuery('#variable_product_options').on('click', '.upload_image_button', function( event ) {

            console.log('choose file');

            var $button                = jQuery( this );
            var post_id                = $button.attr('rel');
            var $parent                = $button.closest('.upload_image');
            setting_variation_image    = $parent;
            setting_variation_image_id = post_id;

            event.preventDefault();

            if ( $button.is('.remove') ) {

                setting_variation_image.find( '.upload_image_id' ).val( '' );
                setting_variation_image.find( 'img' ).attr( 'src', '<?php echo woocommerce_placeholder_img_src(); ?>' );
                setting_variation_image.find( '.upload_image_button' ).removeClass( 'remove' );

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
                    title: '<?php echo esc_js( __( 'Choose an image', 'dokan' ) ); ?>',
                    button: {
                        text: '<?php echo esc_js( __( 'Set variation image', 'dokan' ) ); ?>'
                    }
                });

                // When an image is selected, run a callback.
                variable_image_frame.on( 'select', function() {

                    attachment = variable_image_frame.state().get('selection').first().toJSON();

                    setting_variation_image.find( '.upload_image_id' ).val( attachment.id );
                    setting_variation_image.find( '.upload_image_button' ).addClass( 'remove' );
                    setting_variation_image.find( 'img' ).attr( 'src', attachment.url );

                    wp.media.model.settings.post.id = wp_media_post_id;
                });

                // Finally, open the modal.
                variable_image_frame.open();
            }
        });

        // Restore ID
        jQuery('a.add_media').on('click', function() {
            wp.media.model.settings.post.id = wp_media_post_id;
        } );

    });
    <?php
    $javascript = ob_get_clean();
    wc_enqueue_js( $javascript );
}

/**
 * Save the product data meta box.
 *
 * @access public
 * @param mixed $post_id
 * @return void
 */
function dokan_process_product_meta( $post_id ) {
    global $wpdb, $woocommerce, $woocommerce_errors;

    // Add any default post meta
    add_post_meta( $post_id, 'total_sales', '0', true );

    // Get types
    $product_type       = empty( $_POST['_product_type'] ) ? 'simple' : sanitize_title( stripslashes( $_POST['_product_type'] ) );
    $is_downloadable    = isset( $_POST['_downloadable'] ) ? 'yes' : 'no';
    $is_virtual         = ( $is_downloadable == 'yes' ) ? 'yes' : 'no';

    // Product type + Downloadable/Virtual
    wp_set_object_terms( $post_id, $product_type, 'product_type' );
    update_post_meta( $post_id, '_downloadable', $is_downloadable );
    update_post_meta( $post_id, '_virtual', $is_virtual );
    update_post_meta( $post_id, '_has_attribute', 'no' );
    update_post_meta( $post_id, '_create_variation', 'no' );

    // Gallery Images
    $attachment_ids = array_filter( explode( ',', woocommerce_clean( $_POST['product_image_gallery'] ) ) );
    update_post_meta( $post_id, '_product_image_gallery', implode( ',', $attachment_ids ) );


    $_POST['_visibility'] = isset( $_POST['_visibility'] ) ? $_POST['_visibility'] : '';
    $_POST['_purchase_note'] = isset( $_POST['_purchase_note'] ) ? $_POST['_purchase_note'] : '';

    // Update post meta
    if ( isset( $_POST['_regular_price'] ) ) {
        update_post_meta( $post_id, '_regular_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
    }

    if ( isset( $_POST['_sale_price'] ) ) {
        update_post_meta( $post_id, '_sale_price', ( $_POST['_sale_price'] === '' ? '' : wc_format_decimal( $_POST['_sale_price'] ) ) );
    }

    if ( isset( $_POST['_tax_status'] ) )
        update_post_meta( $post_id, '_tax_status', stripslashes( $_POST['_tax_status'] ) );

    if ( isset( $_POST['_tax_class'] ) )
        update_post_meta( $post_id, '_tax_class', stripslashes( $_POST['_tax_class'] ) );

    update_post_meta( $post_id, '_visibility', stripslashes( $_POST['_visibility'] ) );
    update_post_meta( $post_id, '_purchase_note', stripslashes( $_POST['_purchase_note'] ) );

    // Dimensions
    if ( $is_virtual == 'no' ) {
        update_post_meta( $post_id, '_weight', stripslashes( $_POST['_weight'] ) );
        update_post_meta( $post_id, '_length', stripslashes( $_POST['_length'] ) );
        update_post_meta( $post_id, '_width', stripslashes( $_POST['_width'] ) );
        update_post_meta( $post_id, '_height', stripslashes( $_POST['_height'] ) );
    } else {
        update_post_meta( $post_id, '_weight', '' );
        update_post_meta( $post_id, '_length', '' );
        update_post_meta( $post_id, '_width', '' );
        update_post_meta( $post_id, '_height', '' );
    }

    //Save shipping meta data
    update_post_meta( $post_id, '_disable_shipping', stripslashes( isset( $_POST['_disable_shipping'] ) ? $_POST['_disable_shipping'] : 'no' ) );

    if ( isset( $_POST['_overwrite_shipping'] ) && $_POST['_overwrite_shipping'] == 'yes' ) {
        update_post_meta( $post_id, '_overwrite_shipping', stripslashes( $_POST['_overwrite_shipping'] ) );
    } else {
        update_post_meta( $post_id, '_overwrite_shipping', 'no' );
    }

    update_post_meta( $post_id, '_additional_price', stripslashes( isset( $_POST['_additional_price'] ) ? $_POST['_additional_price'] : '' ) );
    update_post_meta( $post_id, '_additional_qty', stripslashes( isset( $_POST['_additional_qty'] ) ? $_POST['_additional_qty'] : '' ) );
    update_post_meta( $post_id, '_dps_processing_time', stripslashes( isset( $_POST['_dps_processing_time'] ) ? $_POST['_dps_processing_time'] : '' ) );

    // Save shipping class
    $product_shipping_class = $_POST['product_shipping_class'] > 0 && $product_type != 'external' ? absint( $_POST['product_shipping_class'] ) : '';
    wp_set_object_terms( $post_id, $product_shipping_class, 'product_shipping_class');

    // Unique SKU
    $sku                = get_post_meta($post_id, '_sku', true);
    $new_sku            = woocommerce_clean( stripslashes( $_POST['_sku'] ) );
    if ( $new_sku == '' ) {
        update_post_meta( $post_id, '_sku', '' );
    } elseif ( $new_sku !== $sku ) {
        if ( ! empty( $new_sku ) ) {
            if (
                $wpdb->get_var( $wpdb->prepare("
                    SELECT $wpdb->posts.ID
                    FROM $wpdb->posts
                    LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)
                    WHERE $wpdb->posts.post_type = 'product'
                    AND $wpdb->posts.post_status = 'publish'
                    AND $wpdb->postmeta.meta_key = '_sku' AND $wpdb->postmeta.meta_value = '%s'
                 ", $new_sku ) )
                ) {
                $woocommerce_errors[] = __( 'Product SKU must be unique.', 'dokan' );
            } else {
                update_post_meta( $post_id, '_sku', $new_sku );
            }
        } else {
            update_post_meta( $post_id, '_sku', '' );
        }
    }

    // Save Attributes
    $attributes = array();

    if ( isset( $_POST['attribute_names'] ) ) {
        $attribute_names = $_POST['attribute_names'];
        $attribute_values = $_POST['attribute_values'];
        update_post_meta( $post_id, '_has_attribute', 'yes' );

        if ( isset( $_POST['attribute_visibility'] ) )
            $attribute_visibility = $_POST['attribute_visibility'];

        if ( isset( $_POST['attribute_variation'] ) )
            $attribute_variation = $_POST['attribute_variation'];

        $attribute_is_taxonomy = $_POST['attribute_is_taxonomy'];
        $attribute_position = $_POST['attribute_position'];

        $attribute_names_count = sizeof( $attribute_names );

        for ( $i=0; $i < $attribute_names_count; $i++ ) {
            if ( ! $attribute_names[ $i ] )
                continue;

            $is_visible     = isset( $attribute_visibility[ $i ] ) ? 1 : 0;
            $is_variation   = isset( $attribute_variation[ $i ] ) ? 1 : 0;
            $is_taxonomy    = $attribute_is_taxonomy[ $i ] ? 1 : 0;

            if ( $is_taxonomy ) {

                if ( isset( $attribute_values[ $i ] ) ) {

                    // Select based attributes - Format values (posted values are slugs)
                    if ( is_array( $attribute_values[ $i ] ) ) {
                        $values = array_map( 'sanitize_title', $attribute_values[ $i ] );

                    // Text based attributes - Posted values are term names - don't change to slugs
                    } else {
                        $values = array_map( 'stripslashes', array_map( 'strip_tags', explode( '|', $attribute_values[ $i ] ) ) );
                    }

                    // Remove empty items in the array
                    $values = array_filter( $values, 'strlen' );

                } else {
                    $values = array();
                }

                // Update post terms
                if ( taxonomy_exists( $attribute_names[ $i ] ) )
                    wp_set_object_terms( $post_id, $values, $attribute_names[ $i ] );

                if ( $values ) {
                    // Add attribute to array, but don't set values
                    $attributes[ sanitize_title( $attribute_names[ $i ] ) ] = array(
                        'name'          => woocommerce_clean( $attribute_names[ $i ] ),
                        'value'         => '',
                        'position'      => $attribute_position[ $i ],
                        'is_visible'    => $is_visible,
                        'is_variation'  => $is_variation,
                        'is_taxonomy'   => $is_taxonomy
                    );
                }

            } elseif ( isset( $attribute_values[ $i ] ) ) {

                // Text based, separate by pipe
                $values = implode( ' | ', array_map( 'woocommerce_clean', $attribute_values[$i] ) );

                // Custom attribute - Add attribute to array and set the values
                $attributes[ sanitize_title( $attribute_names[ $i ] ) ] = array(
                    'name'          => woocommerce_clean( $attribute_names[ $i ] ),
                    'value'         => $values,
                    'position'      => $attribute_position[ $i ],
                    'is_visible'    => $is_visible,
                    'is_variation'  => $is_variation,
                    'is_taxonomy'   => $is_taxonomy
                );
            }

         }
    }

    if ( ! function_exists( 'attributes_cmp' ) ) {
        function attributes_cmp( $a, $b ) {
            if ( $a['position'] == $b['position'] ) return 0;
            return ( $a['position'] < $b['position'] ) ? -1 : 1;
        }
    }
    uasort( $attributes, 'attributes_cmp' );

    update_post_meta( $post_id, '_product_attributes', $attributes );

    // Sales and prices
    if ( in_array( $product_type, array( 'variable' ) ) ) {

        // Variable products have no prices
        update_post_meta( $post_id, '_regular_price', '' );
        update_post_meta( $post_id, '_sale_price', '' );
        update_post_meta( $post_id, '_sale_price_dates_from', '' );
        update_post_meta( $post_id, '_sale_price_dates_to', '' );
        update_post_meta( $post_id, '_price', '' );

    } else {

        $date_from = isset( $_POST['_sale_price_dates_from'] ) ? $_POST['_sale_price_dates_from'] : '';
        $date_to   = isset( $_POST['_sale_price_dates_to'] ) ? $_POST['_sale_price_dates_to'] : '';

        // Dates
        if ( $date_from ) {
            update_post_meta( $post_id, '_sale_price_dates_from', strtotime( $date_from ) );
        } else {
            update_post_meta( $post_id, '_sale_price_dates_from', '' );
        }

        if ( $date_to ) {
            update_post_meta( $post_id, '_sale_price_dates_to', strtotime( $date_to ) );
        } else {
            update_post_meta( $post_id, '_sale_price_dates_to', '' );
        }

        if ( $date_to && ! $date_from ) {
            update_post_meta( $post_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );
        }

        // Update price if on sale
        if ( '' !== $_POST['_sale_price'] && '' == $date_to && '' == $date_from ) {
            update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_sale_price'] ) );
        } else {
            update_post_meta( $post_id, '_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
        }

        if ( '' !== $_POST['_sale_price'] && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
            update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_sale_price'] ) );
        }

        if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
            update_post_meta( $post_id, '_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
            update_post_meta( $post_id, '_sale_price_dates_from', '' );
            update_post_meta( $post_id, '_sale_price_dates_to', '' );
        }

        // reset price is discounted checkbox was not checked
        if ( ! isset( $_POST['_discounted_price'] ) ) {
            update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_regular_price'] ) );
            update_post_meta( $post_id, '_regular_price', wc_format_decimal( $_POST['_regular_price'] ) );
            update_post_meta( $post_id, '_sale_price', '' );
        }
    }

    //enable reviews
    if ( $_POST['_enable_reviews'] == 'yes' ) {
        $comment_status = 'open';
    } else {
        $comment_status = 'closed';
    }
    // Update the post into the database
    wp_update_post( array(
        'ID'           => $post_id,
        'comment_status' => $comment_status,
    ) );

    $_POST['_sold_individually'] = isset( $_POST['_sold_individually'] ) ? $_POST['_sold_individually'] : false;
    // Sold Individuall
    update_post_meta( $post_id, '_sold_individually', $_POST['_sold_individually'] );


    // Stock Data
    if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {

        $manage_stock = 'no';
        $backorders   = 'no';
        $stock        = '';
        $stock_status = wc_clean( $_POST['_stock_status'] );

        if ( 'external' === $product_type ) {

            $stock_status = 'instock';

        } elseif ( 'variable' === $product_type ) {

            // Stock status is always determined by children so sync later
            $stock_status = '';

            if ( ! empty( $_POST['_manage_stock'] ) && $_POST['_manage_stock'] == 'yes' ) {
                $manage_stock = 'yes';
                $backorders   = wc_clean( $_POST['_backorders'] );
            }

        } elseif ( 'grouped' !== $product_type && ! empty( $_POST['_manage_stock'] ) ) {
            $manage_stock = $_POST['_manage_stock'];
            $backorders   = wc_clean( $_POST['_backorders'] );
        }

        update_post_meta( $post_id, '_manage_stock', $manage_stock );
        update_post_meta( $post_id, '_backorders', $backorders );

        if ( $stock_status ) {
            wc_update_product_stock_status( $post_id, $stock_status );
        }

        if ( ! empty( $_POST['_manage_stock'] ) ) {
            wc_update_product_stock( $post_id, wc_stock_amount( $_POST['_stock'] ) );
        } else {
            update_post_meta( $post_id, '_stock', '' );
        }

    } else {
        wc_update_product_stock_status( $post_id, wc_clean( $_POST['_stock_status'] ) );
    }


    // Upsells
    if ( isset( $_POST['upsell_ids'] ) ) {
        $upsells = array();
        $ids = $_POST['upsell_ids'];
        foreach ( $ids as $id )
            if ( $id && $id > 0 )
                $upsells[] = $id;

        update_post_meta( $post_id, '_upsell_ids', $upsells );
    } else {
        delete_post_meta( $post_id, '_upsell_ids' );
    }

    // Cross sells
    if ( isset( $_POST['crosssell_ids'] ) ) {
        $crosssells = array();
        $ids = $_POST['crosssell_ids'];
        foreach ( $ids as $id )
            if ( $id && $id > 0 )
                $crosssells[] = $id;

        update_post_meta( $post_id, '_crosssell_ids', $crosssells );
    } else {
        delete_post_meta( $post_id, '_crosssell_ids' );
    }

    // Downloadable options
    if ( $is_downloadable == 'yes' ) {

        $_download_limit = absint( $_POST['_download_limit'] );
        if ( ! $_download_limit )
            $_download_limit = ''; // 0 or blank = unlimited

        $_download_expiry = absint( $_POST['_download_expiry'] );
        if ( ! $_download_expiry )
            $_download_expiry = ''; // 0 or blank = unlimited

        // file paths will be stored in an array keyed off md5(file path)
        if ( isset( $_POST['_wc_file_urls'] ) ) {
            $files = array();

            $file_names    = isset( $_POST['_wc_file_names'] ) ? array_map( 'wc_clean', $_POST['_wc_file_names'] ) : array();
            $file_urls     = isset( $_POST['_wc_file_urls'] ) ? array_map( 'esc_url_raw', array_map( 'trim', $_POST['_wc_file_urls'] ) ) : array();
            $file_url_size = sizeof( $file_urls );

            for ( $i = 0; $i < $file_url_size; $i ++ ) {
                if ( ! empty( $file_urls[ $i ] ) )
                    $files[ md5( $file_urls[ $i ] ) ] = array(
                        'name' => $file_names[ $i ],
                        'file' => $file_urls[ $i ]
                    );
            }

            // grant permission to any newly added files on any existing orders for this product prior to saving
            do_action( 'woocommerce_process_product_file_download_paths', $post_id, 0, $files );

            update_post_meta( $post_id, '_downloadable_files', $files );
        }

        update_post_meta( $post_id, '_download_limit', $_download_limit );
        update_post_meta( $post_id, '_download_expiry', $_download_expiry );

        if ( isset( $_POST['_download_limit'] ) )
            update_post_meta( $post_id, '_download_limit', esc_attr( $_download_limit ) );
        if ( isset( $_POST['_download_expiry'] ) )
            update_post_meta( $post_id, '_download_expiry', esc_attr( $_download_expiry ) );
    }

    // Save variations
    if ( $product_type == 'variable' )
        dokan_save_variations( $post_id );

    // Do action for product type
    do_action( 'woocommerce_process_product_meta_' . $product_type, $post_id );
    do_action( 'dokan_process_product_meta', $post_id );

    // Clear cache/transients
    wc_delete_product_transients( $post_id );
}

function dokan_new_process_product_meta( $post_id ) {
    global $wpdb, $woocommerce, $woocommerce_errors;

    // Add any default post meta
    add_post_meta( $post_id, 'total_sales', '0', true );

    // Get types
    $product_type       = ( isset( $_POST['_create_variation'] ) && $_POST['_create_variation'] == 'yes' ) ? 'variable' : 'simple';
    $is_downloadable    = isset( $_POST['_downloadable'] ) ? 'yes' : 'no';
    $is_virtual         = ( $is_downloadable == 'yes' ) ? 'yes' : 'no';
    $_required_tax      = ( isset( $_POST['_required_tax'] ) && $_POST['_required_tax'] == 'yes' ) ? 'yes' : 'no';
    $_has_attribute     = ( isset( $_POST['_has_attribute'] ) && $_POST['_has_attribute'] == 'yes' ) ? 'yes' : 'no';
    $_create_variation  = ( isset( $_POST['_create_variation'] ) && $_POST['_create_variation'] == 'yes' ) ? 'yes' : 'no';

    // Save has variation and create variations flag
    update_post_meta( $post_id, '_required_tax', $_required_tax );
    update_post_meta( $post_id, '_has_attribute', $_has_attribute );
    update_post_meta( $post_id, '_create_variation', $_create_variation );

    // Product type + Downloadable/Virtual
    wp_set_object_terms( $post_id, $product_type, 'product_type' );
    update_post_meta( $post_id, '_downloadable', $is_downloadable );
    update_post_meta( $post_id, '_virtual', $is_virtual );

    // Gallery Images
    $attachment_ids = array_filter( explode( ',', woocommerce_clean( $_POST['product_image_gallery'] ) ) );
    update_post_meta( $post_id, '_product_image_gallery', implode( ',', $attachment_ids ) );

    // Update post meta
    if ( isset( $_POST['_regular_price'] ) ) {
        update_post_meta( $post_id, '_regular_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
    }

    if ( isset( $_POST['_sale_price'] ) ) {
        update_post_meta( $post_id, '_sale_price', ( $_POST['_sale_price'] === '' ? '' : wc_format_decimal( $_POST['_sale_price'] ) ) );
    }

    // Save extra product options like purchase note, visibility

    $_POST['_visibility'] = isset( $_POST['_visibility'] ) ? $_POST['_visibility'] : '';
    $_POST['_purchase_note'] = isset( $_POST['_purchase_note'] ) ? $_POST['_purchase_note'] : '';

    update_post_meta( $post_id, '_purchase_note', stripslashes( $_POST['_purchase_note'] ) );
    update_post_meta( $post_id, '_visibility', stripslashes( $_POST['_visibility'] ) );

    $_POST['_enable_reviews'] = isset( $_POST['_enable_reviews'] ) ? $_POST['_enable_reviews'] : '';
    //enable reviews
    if ( $_POST['_enable_reviews'] == 'yes' ) {
        $comment_status = 'open';
    } else {
        $comment_status = 'closed';
    }
    // Update the post into the database
    wp_update_post( array(
        'ID'           => $post_id,
        'comment_status' => $comment_status,
    ) );

    $_POST['_sold_individually'] = isset( $_POST['_sold_individually'] ) ? $_POST['_sold_individually'] : false;
    // Sold Individuall
    update_post_meta( $post_id, '_sold_individually', $_POST['_sold_individually'] );


    if ( isset( $_POST['_required_tax'] ) && $_POST['_required_tax'] == 'yes' ) {
        if ( isset( $_POST['_tax_status'] ) )
            update_post_meta( $post_id, '_tax_status', stripslashes( $_POST['_tax_status'] ) );

        if ( isset( $_POST['_tax_class'] ) )
            update_post_meta( $post_id, '_tax_class', stripslashes( $_POST['_tax_class'] ) );
    } else {
        update_post_meta( $post_id, '_tax_status', 'none' );
    }

    if ( 'yes' == get_option( 'woocommerce_calc_shipping' ) ) {

        // Save Shipping meta data if enable shipping
        if ( $is_virtual == 'no' ) {
            update_post_meta( $post_id, '_weight', isset( $_POST['_weight'] ) ? stripslashes( $_POST['_weight'] ) : '' );
            update_post_meta( $post_id, '_length', isset( $_POST['_length'] ) ? stripslashes( $_POST['_length'] ) : '' );
            update_post_meta( $post_id, '_width', isset( $_POST['_width'] ) ? stripslashes( $_POST['_width'] ) : '' );
            update_post_meta( $post_id, '_height', isset( $_POST['_height'] ) ? stripslashes( $_POST['_height'] ) : '' );
        } else {
            update_post_meta( $post_id, '_weight', '' );
            update_post_meta( $post_id, '_length', '' );
            update_post_meta( $post_id, '_width', '' );
            update_post_meta( $post_id, '_height', '' );
        }
        //Save shipping meta data
        //
        update_post_meta( $post_id, '_disable_shipping', stripslashes( isset( $_POST['_disable_shipping'] ) ? 'no' : 'yes' ) );

        if ( isset( $_POST['_overwrite_shipping'] ) && $_POST['_overwrite_shipping'] == 'yes' ) {
            update_post_meta( $post_id, '_overwrite_shipping', stripslashes( $_POST['_overwrite_shipping'] ) );
        } else {
            update_post_meta( $post_id, '_overwrite_shipping', 'no' );
        }

        update_post_meta( $post_id, '_additional_price', stripslashes( isset( $_POST['_additional_price'] ) ? $_POST['_additional_price'] : '' ) );
        update_post_meta( $post_id, '_additional_qty', stripslashes( isset( $_POST['_additional_qty'] ) ? $_POST['_additional_qty'] : '' ) );
        update_post_meta( $post_id, '_dps_processing_time', stripslashes( isset( $_POST['_dps_processing_time'] ) ? $_POST['_dps_processing_time'] : '' ) );

        // Save shipping class
        if ( isset( $_POST['product_shipping_class'] ) ) {
            $product_shipping_class = $_POST['product_shipping_class'] > 0 && $product_type != 'external' ? absint( $_POST['product_shipping_class'] ) : '';
            wp_set_object_terms( $post_id, $product_shipping_class, 'product_shipping_class');
        }
    }

    // Unique SKU
    $_POST['_sku'] = isset( $_POST['_sku'] ) ? $_POST['_sku'] : '';
    $sku     = get_post_meta($post_id, '_sku', true);
    $new_sku = woocommerce_clean( stripslashes( $_POST['_sku'] ) );
    if ( $new_sku == '' ) {
        update_post_meta( $post_id, '_sku', '' );
    } elseif ( $new_sku !== $sku ) {
        if ( ! empty( $new_sku ) ) {
            if (
                $wpdb->get_var( $wpdb->prepare("
                    SELECT $wpdb->posts.ID
                    FROM $wpdb->posts
                    LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id)
                    WHERE $wpdb->posts.post_type = 'product'
                    AND $wpdb->posts.post_status = 'publish'
                    AND $wpdb->postmeta.meta_key = '_sku' AND $wpdb->postmeta.meta_value = '%s'
                 ", $new_sku ) )
                ) {
                $woocommerce_errors[] = __( 'Product SKU must be unique.', 'dokan' );
            } else {
                update_post_meta( $post_id, '_sku', $new_sku );
            }
        } else {
            update_post_meta( $post_id, '_sku', '' );
        }
    }

    // Save Product Attributes options
    if( $_has_attribute == 'yes') {
        $attributes = get_post_meta( $post_id, '_product_attributes', true ) ? get_post_meta( $post_id, '_product_attributes', true ) : array();
        $use_as_variation = ( isset( $_POST['_create_variation'] ) ) ? 1 : 0;
        $attr_tax = $attr_pos = $attr_visible = $attr_variation = array();

        if ( isset( $_POST['attribute_names'] ) ) {
            $attribute_names = $_POST['attribute_names'];
            $attr_values = $_POST['attribute_values'];

            foreach ( $attribute_names as $key => $value ) {
                $attr_pos[$key]       = $key;
                $attr_visible[$key]   = 1;
                $attr_variation[$key] = $use_as_variation;
                $attribute_values[$key] = explode(',', $attr_values[$key] );
            }

            $attribute_visibility = $attr_visible;
            $attribute_variation = $attr_variation;
            $attribute_is_taxonomy = $_POST['attribute_is_taxonomy'];
            $attribute_position = $attr_pos;

            $attribute_names_count = sizeof( $attribute_names );

            for ( $i=0; $i < $attribute_names_count; $i++ ) {
                if ( ! $attribute_names[ $i ] )
                    continue;

                $is_visible     = isset( $attribute_visibility[ $i ] ) ? 1 : 0;
                $is_variation   = isset( $attribute_variation[ $i ] ) ? 1 : 0;
                $is_taxonomy    = $attribute_is_taxonomy[ $i ] ? 1 : 0;

                if ( $is_taxonomy ) {

                    if ( isset( $attribute_values[ $i ] ) ) {

                        // Select based attributes - Format values (posted values are slugs)
                        if ( is_array( $attribute_values[ $i ] ) ) {
                            $values = array_map( 'sanitize_title', $attribute_values[ $i ] );

                        // Text based attributes - Posted values are term names - don't change to slugs
                        } else {
                            $values = array_map( 'stripslashes', array_map( 'strip_tags', explode( ',', $attribute_values[ $i ] ) ) );
                        }

                        // Remove empty items in the array
                        $values = array_filter( $values, 'strlen' );

                    } else {
                        $values = array();
                    }

                    // Update post terms
                    if ( taxonomy_exists( $attribute_names[ $i ] ) )
                        wp_set_object_terms( $post_id, $values, $attribute_names[ $i ] );

                    if ( $values ) {
                        // Add attribute to array, but don't set values
                        $attributes[ sanitize_title( $attribute_names[ $i ] ) ] = array(
                            'name'          => woocommerce_clean( $attribute_names[ $i ] ),
                            'value'         => '',
                            'position'      => $attribute_position[ $i ],
                            'is_visible'    => $is_visible,
                            'is_variation'  => $is_variation,
                            'is_taxonomy'   => $is_taxonomy
                        );
                    }

                } elseif ( isset( $attribute_values[ $i ] ) ) {

                    // Text based, separate by pipe
                    $values = implode( ' | ', array_map( 'woocommerce_clean', $attribute_values[$i] ) );

                    // Custom attribute - Add attribute to array and set the values
                    $attributes[ sanitize_title( $attribute_names[ $i ] ) ] = array(
                        'name'          => woocommerce_clean( $attribute_names[ $i ] ),
                        'value'         => $values,
                        'position'      => $attribute_position[ $i ],
                        'is_visible'    => $is_visible,
                        'is_variation'  => $is_variation,
                        'is_taxonomy'   => $is_taxonomy
                    );
                }
            }
        }

        if ( ! function_exists( 'attributes_cmp' ) ) {
            function attributes_cmp( $a, $b ) {
                if ( $a['position'] == $b['position'] ) return 0;
                return ( $a['position'] < $b['position'] ) ? -1 : 1;
            }
        }

        uasort( $attributes, 'attributes_cmp' );
        update_post_meta( $post_id, '_product_attributes', $attributes );
    }

    // Sales and prices
    if ( in_array( $product_type, array( 'variable' ) ) ) {

        // Variable products have no prices
        update_post_meta( $post_id, '_regular_price', '' );
        update_post_meta( $post_id, '_sale_price', '' );
        update_post_meta( $post_id, '_sale_price_dates_from', '' );
        update_post_meta( $post_id, '_sale_price_dates_to', '' );
        update_post_meta( $post_id, '_price', '' );

    } else {

        $date_from = isset( $_POST['_sale_price_dates_from'] ) ? $_POST['_sale_price_dates_from'] : '';
        $date_to   = isset( $_POST['_sale_price_dates_to'] ) ? $_POST['_sale_price_dates_to'] : '';

        // Dates
        if ( $date_from ) {
            update_post_meta( $post_id, '_sale_price_dates_from', strtotime( $date_from ) );
        } else {
            update_post_meta( $post_id, '_sale_price_dates_from', '' );
        }

        if ( $date_to ) {
            update_post_meta( $post_id, '_sale_price_dates_to', strtotime( $date_to ) );
        } else {
            update_post_meta( $post_id, '_sale_price_dates_to', '' );
        }

        if ( $date_to && ! $date_from ) {
            update_post_meta( $post_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );
        }

        $_POST['_sale_price'] = isset( $_POST['_sale_price'] ) ? $_POST['_sale_price'] : '';
        // Update price if on sale
        if ( '' !== $_POST['_sale_price'] && '' == $date_to && '' == $date_from ) {
            update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_sale_price'] ) );
        } else {
            update_post_meta( $post_id, '_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
        }

        if ( '' !== $_POST['_sale_price'] && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
            update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_sale_price'] ) );
        }

        if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
            update_post_meta( $post_id, '_price', ( $_POST['_regular_price'] === '' ) ? '' : wc_format_decimal( $_POST['_regular_price'] ) );
            update_post_meta( $post_id, '_sale_price_dates_from', '' );
            update_post_meta( $post_id, '_sale_price_dates_to', '' );
        }

        // reset price is discounted checkbox was not checked
        if ( isset( $_POST['_sale_price'] ) && empty( $_POST['_sale_price'] ) ) {
            update_post_meta( $post_id, '_price', wc_format_decimal( $_POST['_regular_price'] ) );
            update_post_meta( $post_id, '_regular_price', wc_format_decimal( $_POST['_regular_price'] ) );
            update_post_meta( $post_id, '_sale_price', '' );
        }
    }

    // Product Stock manage Data
    if ( 'yes' === get_option( 'woocommerce_manage_stock' ) ) {
        $_POST['_stock_status'] = isset( $_POST['_stock_status'] ) ? $_POST['_stock_status'] : '';
        $manage_stock = 'no';
        $backorders   = 'no';
        $stock        = '';
        $stock_status = wc_clean( $_POST['_stock_status'] );

        if ( 'external' === $product_type ) {

            $stock_status = 'instock';

        } elseif ( 'variable' === $product_type ) {

            // Stock status is always determined by children so sync later
            $stock_status = '';

            if ( ! empty( $_POST['_manage_stock'] ) && $_POST['_manage_stock'] == 'yes' ) {
                $manage_stock = 'yes';
                $backorders   = wc_clean( $_POST['_backorders'] );
            }

        } elseif ( 'grouped' !== $product_type && ! empty( $_POST['_manage_stock'] ) ) {
            $manage_stock = $_POST['_manage_stock'];
            $backorders   = wc_clean( $_POST['_backorders'] );
        }

        update_post_meta( $post_id, '_manage_stock', $manage_stock );
        update_post_meta( $post_id, '_backorders', $backorders );

        if ( $stock_status ) {
            wc_update_product_stock_status( $post_id, $stock_status );
        }

        if ( ! empty( $_POST['_manage_stock'] ) ) {
            wc_update_product_stock( $post_id, wc_stock_amount( $_POST['_stock'] ) );
        } else {
            update_post_meta( $post_id, '_stock', '' );
        }

    } else {
        wc_update_product_stock_status( $post_id, wc_clean( $_POST['_stock_status'] ) );
    }


    // Upsells product meta
    if ( isset( $_POST['upsell_ids'] ) ) {
        $upsells = array();
        $ids = $_POST['upsell_ids'];
        foreach ( $ids as $id )
            if ( $id && $id > 0 )
                $upsells[] = $id;

        update_post_meta( $post_id, '_upsell_ids', $upsells );
    } else {
        delete_post_meta( $post_id, '_upsell_ids' );
    }

    // Cross sells product meta
    if ( isset( $_POST['crosssell_ids'] ) ) {
        $crosssells = array();
        $ids = $_POST['crosssell_ids'];
        foreach ( $ids as $id )
            if ( $id && $id > 0 )
                $crosssells[] = $id;

        update_post_meta( $post_id, '_crosssell_ids', $crosssells );
    } else {
        delete_post_meta( $post_id, '_crosssell_ids' );
    }

    // Downloadable options
    if ( 'yes' == $is_downloadable ) {

        $_download_limit = absint( $_POST['_download_limit'] );
        if ( ! $_download_limit ) {
            $_download_limit = ''; // 0 or blank = unlimited
        }

        $_download_expiry = absint( $_POST['_download_expiry'] );
        if ( ! $_download_expiry ) {
            $_download_expiry = ''; // 0 or blank = unlimited
        }

        // file paths will be stored in an array keyed off md5(file path)
        $files = array();

        if ( isset( $_POST['_wc_file_urls'] ) ) {
            $file_names         = isset( $_POST['_wc_file_names'] ) ? $_POST['_wc_file_names'] : array();
            $file_urls          = isset( $_POST['_wc_file_urls'] )  ? wp_unslash( array_map( 'trim', $_POST['_wc_file_urls'] ) ) : array();
            $file_url_size      = sizeof( $file_urls );
            $allowed_file_types = apply_filters( 'woocommerce_downloadable_file_allowed_mime_types', get_allowed_mime_types() );

            for ( $i = 0; $i < $file_url_size; $i ++ ) {
                if ( ! empty( $file_urls[ $i ] ) ) {
                    // Find type and file URL
                    if ( 0 === strpos( $file_urls[ $i ], 'http' ) ) {
                        $file_is  = 'absolute';
                        $file_url = esc_url_raw( $file_urls[ $i ] );
                    } elseif ( '[' === substr( $file_urls[ $i ], 0, 1 ) && ']' === substr( $file_urls[ $i ], -1 ) ) {
                        $file_is  = 'shortcode';
                        $file_url = wc_clean( $file_urls[ $i ] );
                    } else {
                        $file_is = 'relative';
                        $file_url = wc_clean( $file_urls[ $i ] );
                    }

                    $file_name = wc_clean( $file_names[ $i ] );
                    $file_hash = md5( $file_url );

                    // Validate the file extension
                    if ( in_array( $file_is, array( 'absolute', 'relative' ) ) ) {
                        $file_type  = wp_check_filetype( strtok( $file_url, '?' ), $allowed_file_types );
                        $parsed_url = parse_url( $file_url, PHP_URL_PATH );
                        $extension  = pathinfo( $parsed_url, PATHINFO_EXTENSION );

                        if ( ! empty( $extension ) && ! in_array( $file_type['type'], $allowed_file_types ) ) {
                            WC_Admin_Meta_Boxes::add_error( sprintf( __( 'The downloadable file %s cannot be used as it does not have an allowed file type. Allowed types include: %s', 'dokan' ), '<code>' . basename( $file_url ) . '</code>', '<code>' . implode( ', ', array_keys( $allowed_file_types ) ) . '</code>' ) );
                            continue;
                        }
                    }

                    // Validate the file exists
                    if ( 'relative' === $file_is ) {
                        $_file_url = $file_url;
                        if ( '..' === substr( $file_url, 0, 2 ) || '/' !== substr( $file_url, 0, 1 ) ) {
                            $_file_url = realpath( ABSPATH . $file_url );
                        }

                        if ( ! apply_filters( 'woocommerce_downloadable_file_exists', file_exists( $_file_url ), $file_url ) ) {
                            WC_Admin_Meta_Boxes::add_error( sprintf( __( 'The downloadable file %s cannot be used as it does not exist on the server.', 'dokan' ), '<code>' . $file_url . '</code>' ) );
                            continue;
                        }
                    }

                    $files[ $file_hash ] = array(
                        'name' => $file_name,
                        'file' => $file_url
                    );
                }
            }
        }

        // grant permission to any newly added files on any existing orders for this product prior to saving
        dokan_process_product_file_download_paths( $post_id, 0, $files );

        update_post_meta( $post_id, '_downloadable_files', $files );
        update_post_meta( $post_id, '_download_limit', $_download_limit );
        update_post_meta( $post_id, '_download_expiry', $_download_expiry );

        if ( isset( $_POST['_download_type'] ) ) {
            update_post_meta( $post_id, '_download_type', wc_clean( $_POST['_download_type'] ) );
        }
    }

    // Save variations
    if ( $product_type == 'variable' ) {
        dokan_new_save_variations( $post_id );
    } else {
        // Get variations
        $args = array(
            'post_type'     => 'product_variation',
            'post_status'   => array( 'private', 'publish' ),
            'numberposts'   => -1,
            'post_parent'   => $post_id
        );

        $variations = get_posts( $args );

        if( $variations ) {
            foreach ( $variations as $variation ) {
                $variation_id  = absint( $variation->ID );
                wp_delete_post( $variation_id );
            }
        }
    }

    // Do action for product type
    do_action( 'woocommerce_process_product_meta_' . $product_type, $post_id );
    do_action( 'dokan_process_product_meta', $post_id );

    // Clear cache/transients
    wc_delete_product_transients( $post_id );
}

function dokan_new_save_variations( $post_id ) {
    global $woocommerce, $wpdb;

    $variation_ids = array();
    $attributes    = (array) maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );

    if ( isset( $_POST['variable_sku'] ) ) {

        $variable_post_id               = isset( $_POST['variable_post_id'] ) ? $_POST['variable_post_id'] : $variation_ids ;
        $variable_sku                   = isset( $_POST['variable_sku'] ) ? $_POST['variable_sku'] : array();
        $variable_regular_price         = isset( $_POST['variable_regular_price'] ) ? $_POST['variable_regular_price'] : array();
        $variable_sale_price            = isset( $_POST['variable_sale_price'] ) ? $_POST['variable_sale_price'] : array();
        $upload_image_id                = isset( $_POST['upload_image_id'] ) ? $_POST['upload_image_id'] : array();
        $variable_download_limit        = isset( $_POST['variable_download_limit'] ) ? $_POST['variable_download_limit'] : array();
        $variable_download_expiry       = isset( $_POST['variable_download_expiry'] ) ? $_POST['variable_download_expiry'] : array();
        $variable_shipping_class        = isset( $_POST['variable_shipping_class'] ) ? $_POST['variable_shipping_class'] : array();
        $variable_tax_class             = isset( $_POST['variable_tax_class'] ) ? $_POST['variable_tax_class'] : array();
        $variable_menu_order            = isset( $_POST['variation_menu_order'] ) ? $_POST['variation_menu_order'] : array();
        $variable_sale_price_dates_from = isset( $_POST['variable_sale_price_dates_from'] ) ? $_POST['variable_sale_price_dates_from'] : array();
        $variable_sale_price_dates_to   = isset( $_POST['variable_sale_price_dates_to'] ) ? $_POST['variable_sale_price_dates_to'] : array();

        $variable_weight                = isset( $_POST['variable_weight'] ) ? $_POST['variable_weight'] : array();
        $variable_length                = isset( $_POST['variable_length'] ) ? $_POST['variable_length'] : array();
        $variable_width                 = isset( $_POST['variable_width'] ) ? $_POST['variable_width'] : array();
        $variable_height                = isset( $_POST['variable_height'] ) ? $_POST['variable_height'] : array();
        $variable_stock                 = isset( $_POST['variable_stock'] ) ? $_POST['variable_stock'] : array();
        $variable_manage_stock          = isset( $_POST['variable_manage_stock'] ) ? $_POST['variable_manage_stock'] : array();
        $variable_stock_status          = isset( $_POST['variable_stock_status'] ) ? $_POST['variable_stock_status'] : array();
        $variable_backorders            = isset( $_POST['variable_backorders'] ) ? $_POST['variable_backorders'] : array();

        $variable_enabled               = isset( $_POST['variable_enabled'] ) ? $_POST['variable_enabled'] : array();
        $variable_is_virtual            = isset( $_POST['variable_is_virtual'] ) ? $_POST['variable_is_virtual'] : array();
        $variable_is_downloadable       = isset( $_POST['variable_is_downloadable'] ) ? $_POST['variable_is_downloadable'] : array();

        if( isset( $_POST['dokan_create_new_variations'] ) && $_POST['dokan_create_new_variations'] == 'yes' ) {
            $max_loop = max( array_keys( $variable_menu_order ) );

            for ( $i = 0; $i <= $max_loop; $i ++ ) {
                $post_status = isset( $variable_enabled[ $i ] ) ? 'publish' : 'private';
                $variation_ids = dokan_create_new_variation( $post_id, $post_status );
                $variable_post_id[]               = $variation_ids;
                $variable_sale_price[]            = '';
                $upload_image_id[]                = '';
                $variable_download_limit[]        = '';
                $variable_download_expiry[]       = '';
                $variable_shipping_class[]        = '';
                $variable_sale_price_dates_from[] = '';
                $variable_sale_price_dates_to[]   = '';
            }
        }


        $max_loop = max( array_keys( $variable_post_id ) );

        for ( $i = 0; $i <= $max_loop; $i ++ ) {

            if ( ! isset( $variable_post_id[ $i ] ) )
                continue;

            $variation_id = absint( $variable_post_id[ $i ] );

            if( isset( $_POST['_variation_product_update'] ) && $_POST['_variation_product_update'] == 'yes' ) {

                $regular_price  = wc_format_decimal( $variable_regular_price[ $i ] );
                update_post_meta( $variation_id, '_regular_price', $regular_price );
                update_post_meta( $variation_id, '_sku', wc_clean( $variable_sku[ $i ] ) );
                update_post_meta( $variation_id, '_thumbnail_id', absint( $upload_image_id[ $i ] ) );

                $post_status = isset( $variable_enabled[ $i ] ) ? 'publish' : 'private';

                $variation_post_title = sprintf( __( 'Variation #%s of %s', 'dokan' ), absint( $variation_id ), esc_html( get_the_title( $post_id ) ) );
                $wpdb->update( $wpdb->posts, array( 'post_status' => $post_status, 'post_title' => $variation_post_title, 'menu_order' => $variable_menu_order[ $i ] ), array( 'ID' => $variation_id ) );

                // Update taxonomies - don't use wc_clean as it destroys sanitized characters
                $updated_attribute_keys = array();
                foreach ( $attributes as $attribute ) {

                    if ( $attribute['is_variation'] ) {
                        $attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );
                        $value         = isset( $_POST[ $attribute_key ][ $i ] ) ? sanitize_title( stripslashes( $_POST[ $attribute_key ][ $i ] ) ) : '';
                        $updated_attribute_keys[] = $attribute_key;
                        update_post_meta( $variation_id, $attribute_key, $value );
                    }
                }

                // Remove old taxonomies attributes so data is kept up to date - first get attribute key names
                $delete_attribute_keys = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE 'attribute_%%' AND meta_key NOT IN ( '" . implode( "','", $updated_attribute_keys ) . "' ) AND post_id = %d;", $variation_id ) );

                foreach ( $delete_attribute_keys as $key ) {
                    delete_post_meta( $variation_id, $key );
                }

            } else {

                // Virtal/Downloadable
                $is_downloadable = isset( $variable_is_downloadable[ $i ] ) ? 'yes' : 'no';

                if ( isset( $variable_is_virtual[ $i ] ) ) {
                    $is_virtual = 'yes';
                } else {

                    if ( $is_downloadable == 'yes' ) {
                        $is_virtual = 'yes';
                    } else {
                        $is_virtual = 'no';
                    }
                }

                // Enabled or disabled
                $post_status = isset( $variable_enabled[ $i ] ) ? 'publish' : 'private';
                $manage_stock        = isset( $variable_manage_stock[ $i ] ) ? 'yes' : 'no';

                // Generate a useful post title
                $variation_post_title = sprintf( __( 'Variation #%s of %s', 'dokan' ), absint( $variation_id ), esc_html( get_the_title( $post_id ) ) );

                // Update or Add post
                if ( ! $variation_id ) {

                    $variation = array(
                        'post_title'    => $variation_post_title,
                        'post_content'  => '',
                        'post_status'   => $post_status,
                        'post_author'   => get_current_user_id(),
                        'post_parent'   => $post_id,
                        'post_type'     => 'product_variation',
                        'menu_order'    => $variable_menu_order[ $i ]
                    );

                    $variation_id = wp_insert_post( $variation );

                    do_action( 'woocommerce_create_product_variation', $variation_id );

                } else {

                    $wpdb->update( $wpdb->posts, array( 'post_status' => $post_status, 'post_title' => $variation_post_title, 'menu_order' => $variable_menu_order[ $i ] ), array( 'ID' => $variation_id ) );

                    do_action( 'woocommerce_update_product_variation', $variation_id );

                }

                // Only continue if we have a variation ID
                if ( ! $variation_id ) {
                    continue;
                }

                // Update post meta
                update_post_meta( $variation_id, '_sku', wc_clean( $variable_sku[ $i ] ) );
                //update_post_meta( $variation_id, '_stock', wc_clean( $variable_stock[ $i ] ) );
                update_post_meta( $variation_id, '_thumbnail_id', absint( $upload_image_id[ $i ] ) );
                update_post_meta( $variation_id, '_virtual', wc_clean( $is_virtual ) );
                update_post_meta( $variation_id, '_downloadable', wc_clean( $is_downloadable ) );
                update_post_meta( $variation_id, '_manage_stock', $manage_stock );

                // Only update stock status to user setting if changed by the user, but do so before looking at stock levels at variation level
                if ( ! empty( $variable_stock_status[ $i ] ) ) {
                    wc_update_product_stock_status( $variation_id, $variable_stock_status[ $i ] );
                }

                if ( 'yes' === $manage_stock ) {
                    update_post_meta( $variation_id, '_backorders', wc_clean( $variable_backorders[ $i ] ) );
                    wc_update_product_stock( $variation_id, wc_stock_amount( $variable_stock[ $i ] ) );
                } else {
                    delete_post_meta( $variation_id, '_backorders' );
                    delete_post_meta( $variation_id, '_stock' );
                }

                if ( isset( $variable_weight[ $i ] ) )
                    update_post_meta( $variation_id, '_weight', ( $variable_weight[ $i ] === '' ) ? '' : wc_format_decimal( $variable_weight[ $i ] ) );
                if ( isset( $variable_length[ $i ] ) )
                    update_post_meta( $variation_id, '_length', ( $variable_length[ $i ] === '' ) ? '' : wc_format_decimal( $variable_length[ $i ] ) );
                if ( isset( $variable_width[ $i ] ) )
                    update_post_meta( $variation_id, '_width', ( $variable_width[ $i ] === '' ) ? '' : wc_format_decimal( $variable_width[ $i ] ) );
                if ( isset( $variable_height[ $i ] ) )
                    update_post_meta( $variation_id, '_height', ( $variable_height[ $i ] === '' ) ? '' : wc_format_decimal( $variable_height[ $i ] ) );


                // Price handling
                $regular_price  = wc_format_decimal( $variable_regular_price[ $i ] );
                $sale_price     = ( $variable_sale_price[ $i ] === '' ? '' : wc_format_decimal( $variable_sale_price[ $i ] ) );
                $date_from      = wc_clean( $variable_sale_price_dates_from[ $i ] );
                $date_to        = wc_clean( $variable_sale_price_dates_to[ $i ] );

                update_post_meta( $variation_id, '_regular_price', $regular_price );
                update_post_meta( $variation_id, '_sale_price', $sale_price );

                // Save Dates
                if ( $date_from )
                    update_post_meta( $variation_id, '_sale_price_dates_from', strtotime( $date_from ) );
                else
                    update_post_meta( $variation_id, '_sale_price_dates_from', '' );

                if ( $date_to )
                    update_post_meta( $variation_id, '_sale_price_dates_to', strtotime( $date_to ) );
                else
                    update_post_meta( $variation_id, '_sale_price_dates_to', '' );

                if ( $date_to && ! $date_from )
                    update_post_meta( $variation_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );

                // Update price if on sale
                if ( $sale_price != '' && $date_to == '' && $date_from == '' )
                    update_post_meta( $variation_id, '_price', $sale_price );
                else
                    update_post_meta( $variation_id, '_price', $regular_price );

                if ( $sale_price != '' && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) )
                    update_post_meta( $variation_id, '_price', $sale_price );

                if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
                    update_post_meta( $variation_id, '_price', $regular_price );
                    update_post_meta( $variation_id, '_sale_price_dates_from', '' );
                    update_post_meta( $variation_id, '_sale_price_dates_to', '' );
                }

                if ( isset( $variable_tax_class[ $i ] ) && $variable_tax_class[ $i ] !== 'parent' )
                    update_post_meta( $variation_id, '_tax_class', wc_clean( $variable_tax_class[ $i ] ) );
                else
                    delete_post_meta( $variation_id, '_tax_class' );

                if ( $is_downloadable == 'yes' ) {
                    update_post_meta( $variation_id, '_download_limit', wc_clean( $variable_download_limit[ $i ] ) );
                    update_post_meta( $variation_id, '_download_expiry', wc_clean( $variable_download_expiry[ $i ] ) );

                    $files         = array();
                    $file_names    = isset( $_POST['_wc_variation_file_names'][ $variation_id ] ) ? array_map( 'wc_clean', $_POST['_wc_variation_file_names'][ $variation_id ] ) : array();
                    $file_urls     = isset( $_POST['_wc_variation_file_urls'][ $variation_id ] ) ? array_map( 'esc_url_raw', array_map( 'trim', $_POST['_wc_variation_file_urls'][ $variation_id ] ) ) : array();
                    $file_url_size = sizeof( $file_urls );

                    for ( $ii = 0; $ii < $file_url_size; $ii ++ ) {
                        if ( ! empty( $file_urls[ $ii ] ) )
                            $files[ md5( $file_urls[ $ii ] ) ] = array(
                                'name' => $file_names[ $ii ],
                                'file' => $file_urls[ $ii ]
                            );
                    }

                    // grant permission to any newly added files on any existing orders for this product prior to saving
                    do_action( 'woocommerce_process_product_file_download_paths', $post_id, $variation_id, $files );

                    update_post_meta( $variation_id, '_downloadable_files', $files );
                } else {
                    update_post_meta( $variation_id, '_download_limit', '' );
                    update_post_meta( $variation_id, '_download_expiry', '' );
                    update_post_meta( $variation_id, '_downloadable_files', '' );
                }

                // Save shipping class
                $variable_shipping_class[ $i ] = ! empty( $variable_shipping_class[ $i ] ) ? (int) $variable_shipping_class[ $i ] : '';
                wp_set_object_terms( $variation_id, $variable_shipping_class[ $i ], 'product_shipping_class');

                // Update taxonomies - don't use wc_clean as it destroys sanitized characters
                $updated_attribute_keys = array();
                foreach ( $attributes as $attribute ) {

                    if ( $attribute['is_variation'] ) {
                        $attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );
                        $value         = isset( $_POST[ $attribute_key ][ $i ] ) ? sanitize_title( stripslashes( $_POST[ $attribute_key ][ $i ] ) ) : '';
                        $updated_attribute_keys[] = $attribute_key;
                        update_post_meta( $variation_id, $attribute_key, $value );
                    }
                }

                // Remove old taxonomies attributes so data is kept up to date - first get attribute key names
                $delete_attribute_keys = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE 'attribute_%%' AND meta_key NOT IN ( '" . implode( "','", $updated_attribute_keys ) . "' ) AND post_id = %d;", $variation_id ) );

                foreach ( $delete_attribute_keys as $key ) {
                    delete_post_meta( $variation_id, $key );
                }

                do_action( 'woocommerce_save_product_variation', $variation_id, $i );
            }
        }
    }

    // Update parent if variable so price sorting works and stays in sync with the cheapest child
    WC_Product_Variable::sync( $post_id );

    // Update default attribute options setting
    $default_attributes = array();

    foreach ( $attributes as $attribute ) {
        if ( $attribute['is_variation'] ) {

            // Don't use wc_clean as it destroys sanitized characters
            if ( isset( $_POST[ 'default_attribute_' . sanitize_title( $attribute['name'] ) ] ) )
                $value = sanitize_title( trim( stripslashes( $_POST[ 'default_attribute_' . sanitize_title( $attribute['name'] ) ] ) ) );
            else
                $value = '';

            if ( $value )
                $default_attributes[ sanitize_title( $attribute['name'] ) ] = $value;
        }
    }

    update_post_meta( $post_id, '_default_attributes', $default_attributes );
}

function dokan_create_new_variation( $post_id, $post_status ) {

    // Created posts will all have the following data
    $variation_post_data = array(
        'post_title'   => 'Product #' . $post_id . ' Variation',
        'post_content' => '',
        'post_status'  => $post_status,
        'post_author'  => get_current_user_id(),
        'post_parent'  => $post_id,
        'post_type'    => 'product_variation'
    );

    $variations_ids = wp_insert_post( $variation_post_data );


    return $variations_ids;

}

function dokan_save_variations( $post_id ) {
    global $woocommerce, $wpdb;

    $attributes = (array) maybe_unserialize( get_post_meta( $post_id, '_product_attributes', true ) );
    update_post_meta( $post_id, '_create_variation', 'yes' );

    if ( isset( $_POST['variable_sku'] ) ) {

        $variable_post_id               = $_POST['variable_post_id'];
        $variable_sku                   = $_POST['variable_sku'];
        $variable_regular_price         = $_POST['variable_regular_price'];
        $variable_sale_price            = $_POST['variable_sale_price'];
        $upload_image_id                = $_POST['upload_image_id'];
        $variable_download_limit        = $_POST['variable_download_limit'];
        $variable_download_expiry       = $_POST['variable_download_expiry'];
        $variable_shipping_class        = $_POST['variable_shipping_class'];
        $variable_tax_class             = isset( $_POST['variable_tax_class'] ) ? $_POST['variable_tax_class'] : array();
        $variable_menu_order            = $_POST['variation_menu_order'];
        $variable_sale_price_dates_from = $_POST['variable_sale_price_dates_from'];
        $variable_sale_price_dates_to   = $_POST['variable_sale_price_dates_to'];

        $variable_weight                = isset( $_POST['variable_weight'] ) ? $_POST['variable_weight'] : array();
        $variable_length                = isset( $_POST['variable_length'] ) ? $_POST['variable_length'] : array();
        $variable_width                 = isset( $_POST['variable_width'] ) ? $_POST['variable_width'] : array();
        $variable_height                = isset( $_POST['variable_height'] ) ? $_POST['variable_height'] : array();
        $variable_stock                 = isset( $_POST['variable_stock'] ) ? $_POST['variable_stock'] : array();
        $variable_manage_stock          = isset( $_POST['variable_manage_stock'] ) ? $_POST['variable_manage_stock'] : array();
        $variable_stock_status          = isset( $_POST['variable_stock_status'] ) ? $_POST['variable_stock_status'] : array();
        $variable_backorders            = isset( $_POST['variable_backorders'] ) ? $_POST['variable_backorders'] : array();

        $variable_enabled               = isset( $_POST['variable_enabled'] ) ? $_POST['variable_enabled'] : array();
        $variable_is_virtual            = isset( $_POST['variable_is_virtual'] ) ? $_POST['variable_is_virtual'] : array();
        $variable_is_downloadable       = isset( $_POST['variable_is_downloadable'] ) ? $_POST['variable_is_downloadable'] : array();

        $max_loop = max( array_keys( $_POST['variable_post_id'] ) );

        for ( $i = 0; $i <= $max_loop; $i ++ ) {

            if ( ! isset( $variable_post_id[ $i ] ) )
                continue;

            $variation_id = absint( $variable_post_id[ $i ] );

            // Virtal/Downloadable
            $is_downloadable = isset( $variable_is_downloadable[ $i ] ) ? 'yes' : 'no';

            if ( isset( $variable_is_virtual[ $i ] ) ) {
                $is_virtual = 'yes';
            } else {

                if ( $is_downloadable == 'yes' ) {
                    $is_virtual = 'yes';
                } else {
                    $is_virtual = 'no';
                }
            }
            // $is_virtual = isset(  ) ? 'yes' : 'no';

            // Enabled or disabled
            $post_status = isset( $variable_enabled[ $i ] ) ? 'publish' : 'private';
            $parent_manage_stock = isset( $_POST['_manage_stock'] ) ? 'yes' : 'no';
            $manage_stock        = isset( $variable_manage_stock[ $i ] ) ? 'yes' : 'no';

            // Generate a useful post title
            $variation_post_title = sprintf( __( 'Variation #%s of %s', 'dokan' ), absint( $variation_id ), esc_html( get_the_title( $post_id ) ) );

            // Update or Add post
            if ( ! $variation_id ) {

                $variation = array(
                    'post_title'    => $variation_post_title,
                    'post_content'  => '',
                    'post_status'   => $post_status,
                    'post_author'   => get_current_user_id(),
                    'post_parent'   => $post_id,
                    'post_type'     => 'product_variation',
                    'menu_order'    => $variable_menu_order[ $i ]
                );

                $variation_id = wp_insert_post( $variation );

                do_action( 'woocommerce_create_product_variation', $variation_id );

            } else {

                $wpdb->update( $wpdb->posts, array( 'post_status' => $post_status, 'post_title' => $variation_post_title, 'menu_order' => $variable_menu_order[ $i ] ), array( 'ID' => $variation_id ) );

                do_action( 'woocommerce_update_product_variation', $variation_id );

            }

            // Only continue if we have a variation ID
            if ( ! $variation_id ) {
                continue;
            }

            // Update post meta
            update_post_meta( $variation_id, '_sku', wc_clean( $variable_sku[ $i ] ) );
            //update_post_meta( $variation_id, '_stock', wc_clean( $variable_stock[ $i ] ) );
            update_post_meta( $variation_id, '_thumbnail_id', absint( $upload_image_id[ $i ] ) );
            update_post_meta( $variation_id, '_virtual', wc_clean( $is_virtual ) );
            update_post_meta( $variation_id, '_downloadable', wc_clean( $is_downloadable ) );
            update_post_meta( $variation_id, '_manage_stock', $manage_stock );

            // Only update stock status to user setting if changed by the user, but do so before looking at stock levels at variation level
            if ( ! empty( $variable_stock_status[ $i ] ) ) {
                wc_update_product_stock_status( $variation_id, $variable_stock_status[ $i ] );
            }

            if ( 'yes' === $manage_stock ) {
                update_post_meta( $variation_id, '_backorders', wc_clean( $variable_backorders[ $i ] ) );
                wc_update_product_stock( $variation_id, wc_stock_amount( $variable_stock[ $i ] ) );
            } else {
                delete_post_meta( $variation_id, '_backorders' );
                delete_post_meta( $variation_id, '_stock' );
            }

            if ( isset( $variable_weight[ $i ] ) )
                update_post_meta( $variation_id, '_weight', ( $variable_weight[ $i ] === '' ) ? '' : wc_format_decimal( $variable_weight[ $i ] ) );
            if ( isset( $variable_length[ $i ] ) )
                update_post_meta( $variation_id, '_length', ( $variable_length[ $i ] === '' ) ? '' : wc_format_decimal( $variable_length[ $i ] ) );
            if ( isset( $variable_width[ $i ] ) )
                update_post_meta( $variation_id, '_width', ( $variable_width[ $i ] === '' ) ? '' : wc_format_decimal( $variable_width[ $i ] ) );
            if ( isset( $variable_height[ $i ] ) )
                update_post_meta( $variation_id, '_height', ( $variable_height[ $i ] === '' ) ? '' : wc_format_decimal( $variable_height[ $i ] ) );


            // Price handling
            $regular_price  = wc_format_decimal( $variable_regular_price[ $i ] );
            $sale_price     = ( $variable_sale_price[ $i ] === '' ? '' : wc_format_decimal( $variable_sale_price[ $i ] ) );
            $date_from      = wc_clean( $variable_sale_price_dates_from[ $i ] );
            $date_to        = wc_clean( $variable_sale_price_dates_to[ $i ] );

            update_post_meta( $variation_id, '_regular_price', $regular_price );
            update_post_meta( $variation_id, '_sale_price', $sale_price );

            // Save Dates
            if ( $date_from )
                update_post_meta( $variation_id, '_sale_price_dates_from', strtotime( $date_from ) );
            else
                update_post_meta( $variation_id, '_sale_price_dates_from', '' );

            if ( $date_to )
                update_post_meta( $variation_id, '_sale_price_dates_to', strtotime( $date_to ) );
            else
                update_post_meta( $variation_id, '_sale_price_dates_to', '' );

            if ( $date_to && ! $date_from )
                update_post_meta( $variation_id, '_sale_price_dates_from', strtotime( 'NOW', current_time( 'timestamp' ) ) );

            // Update price if on sale
            if ( $sale_price != '' && $date_to == '' && $date_from == '' )
                update_post_meta( $variation_id, '_price', $sale_price );
            else
                update_post_meta( $variation_id, '_price', $regular_price );

            if ( $sale_price != '' && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) )
                update_post_meta( $variation_id, '_price', $sale_price );

            if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
                update_post_meta( $variation_id, '_price', $regular_price );
                update_post_meta( $variation_id, '_sale_price_dates_from', '' );
                update_post_meta( $variation_id, '_sale_price_dates_to', '' );
            }

            if ( isset( $variable_tax_class[ $i ] ) && $variable_tax_class[ $i ] !== 'parent' )
                update_post_meta( $variation_id, '_tax_class', wc_clean( $variable_tax_class[ $i ] ) );
            else
                delete_post_meta( $variation_id, '_tax_class' );

            if ( $is_downloadable == 'yes' ) {
                update_post_meta( $variation_id, '_download_limit', wc_clean( $variable_download_limit[ $i ] ) );
                update_post_meta( $variation_id, '_download_expiry', wc_clean( $variable_download_expiry[ $i ] ) );

                $files         = array();
                $file_names    = isset( $_POST['_wc_variation_file_names'][ $variation_id ] ) ? array_map( 'wc_clean', $_POST['_wc_variation_file_names'][ $variation_id ] ) : array();
                $file_urls     = isset( $_POST['_wc_variation_file_urls'][ $variation_id ] ) ? array_map( 'esc_url_raw', array_map( 'trim', $_POST['_wc_variation_file_urls'][ $variation_id ] ) ) : array();
                $file_url_size = sizeof( $file_urls );

                for ( $ii = 0; $ii < $file_url_size; $ii ++ ) {
                    if ( ! empty( $file_urls[ $ii ] ) )
                        $files[ md5( $file_urls[ $ii ] ) ] = array(
                            'name' => $file_names[ $ii ],
                            'file' => $file_urls[ $ii ]
                        );
                }

                // grant permission to any newly added files on any existing orders for this product prior to saving
                do_action( 'woocommerce_process_product_file_download_paths', $post_id, $variation_id, $files );

                update_post_meta( $variation_id, '_downloadable_files', $files );
            } else {
                update_post_meta( $variation_id, '_download_limit', '' );
                update_post_meta( $variation_id, '_download_expiry', '' );
                update_post_meta( $variation_id, '_downloadable_files', '' );
            }

            // Save shipping class
            $variable_shipping_class[ $i ] = ! empty( $variable_shipping_class[ $i ] ) ? (int) $variable_shipping_class[ $i ] : '';
            wp_set_object_terms( $variation_id, $variable_shipping_class[ $i ], 'product_shipping_class');

            // Update taxonomies - don't use wc_clean as it destroys sanitized characters
            $updated_attribute_keys = array();
            foreach ( $attributes as $attribute ) {

                if ( $attribute['is_variation'] ) {
                    $attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );
                    $value         = isset( $_POST[ $attribute_key ][ $i ] ) ? sanitize_title( stripslashes( $_POST[ $attribute_key ][ $i ] ) ) : '';
                    $updated_attribute_keys[] = $attribute_key;
                    update_post_meta( $variation_id, $attribute_key, $value );
                }
            }

            // Remove old taxonomies attributes so data is kept up to date - first get attribute key names
            $delete_attribute_keys = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM {$wpdb->postmeta} WHERE meta_key LIKE 'attribute_%%' AND meta_key NOT IN ( '" . implode( "','", $updated_attribute_keys ) . "' ) AND post_id = %d;", $variation_id ) );

            foreach ( $delete_attribute_keys as $key ) {
                delete_post_meta( $variation_id, $key );
            }

            do_action( 'woocommerce_save_product_variation', $variation_id, $i );
        }
    }

    // Update parent if variable so price sorting works and stays in sync with the cheapest child
    WC_Product_Variable::sync( $post_id );

    // Update default attribute options setting
    $default_attributes = array();

    foreach ( $attributes as $attribute ) {
        if ( $attribute['is_variation'] ) {

            // Don't use wc_clean as it destroys sanitized characters
            if ( isset( $_POST[ 'default_attribute_' . sanitize_title( $attribute['name'] ) ] ) )
                $value = sanitize_title( trim( stripslashes( $_POST[ 'default_attribute_' . sanitize_title( $attribute['name'] ) ] ) ) );
            else
                $value = '';

            if ( $value )
                $default_attributes[ sanitize_title( $attribute['name'] ) ] = $value;
        }
    }

    update_post_meta( $post_id, '_default_attributes', $default_attributes );
}


/**
 * Grant downloadable file access to any newly added files on any existing.
 * orders for this product that have previously been granted downloadable file access.
 *
 * @param int $product_id product identifier
 * @param int $variation_id optional product variation identifier
 * @param array $downloadable_files newly set files
 */
function dokan_process_product_file_download_paths( $product_id, $variation_id, $downloadable_files ) {
    global $wpdb;

    if ( $variation_id ) {
        $product_id = $variation_id;
    }

    $product               = wc_get_product( $product_id );
    $existing_download_ids = array_keys( (array) $product->get_files() );
    $updated_download_ids  = array_keys( (array) $downloadable_files );
    $new_download_ids      = array_filter( array_diff( $updated_download_ids, $existing_download_ids ) );
    $removed_download_ids  = array_filter( array_diff( $existing_download_ids, $updated_download_ids ) );

    if ( ! empty( $new_download_ids ) || ! empty( $removed_download_ids ) ) {
        // determine whether downloadable file access has been granted via the typical order completion, or via the admin ajax method
        $existing_permissions = $wpdb->get_results( $wpdb->prepare( "SELECT * from {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE product_id = %d GROUP BY order_id", $product_id ) );

        foreach ( $existing_permissions as $existing_permission ) {
            $order = wc_get_order( $existing_permission->order_id );

            if ( ! empty( $order->id ) ) {
                // Remove permissions
                if ( ! empty( $removed_download_ids ) ) {
                    foreach ( $removed_download_ids as $download_id ) {
                        if ( apply_filters( 'woocommerce_process_product_file_download_paths_remove_access_to_old_file', true, $download_id, $product_id, $order ) ) {
                            $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s", $order->id, $product_id, $download_id ) );
                        }
                    }
                }
                // Add permissions
                if ( ! empty( $new_download_ids ) ) {

                    foreach ( $new_download_ids as $download_id ) {

                        if ( apply_filters( 'woocommerce_process_product_file_download_paths_grant_access_to_new_file', true, $download_id, $product_id, $order ) ) {
                            // grant permission if it doesn't already exist
                            if ( ! $wpdb->get_var( $wpdb->prepare( "SELECT 1=1 FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s", $order->id, $product_id, $download_id ) ) ) {
                                wc_downloadable_file_permission( $download_id, $product_id, $order );
                            }
                        }
                    }
                }
            }
        }
    }
}



/**
 * Monitors a new order and attempts to create sub-orders
 *
 * If an order contains products from multiple vendor, we can't show the order
 * to each seller dashboard. That's why we need to divide the main order to
 * some sub-orders based on the number of sellers.
 *
 * @param int $parent_order_id
 * @return void
 */
function dokan_create_sub_order( $parent_order_id ) {

    if ( get_post_meta( $parent_order_id, 'has_sub_order' ) == true ) {
        $args = array(
            'post_parent' => $parent_order_id,
            'post_type'   => 'shop_order',
            'numberposts' => -1,
            'post_status' => 'any'
        );
        $child_orders = get_children( $args );

        foreach ( $child_orders as $child ) {
            wp_delete_post( $child->ID );
        }
    }

    $parent_order = new WC_Order( $parent_order_id );

    $sellers = dokan_get_sellers_by( $parent_order_id );

    // return if we've only ONE seller
    if ( count( $sellers ) == 1 ) {
        $temp = array_keys( $sellers );
        $seller_id = reset( $temp );
        wp_update_post( array( 'ID' => $parent_order_id, 'post_author' => $seller_id ) );
        return;
    }

    // flag it as it has a suborder
    update_post_meta( $parent_order_id, 'has_sub_order', true );

    // seems like we've got multiple sellers
    foreach ($sellers as $seller_id => $seller_products ) {
        dokan_create_seller_order( $parent_order, $seller_id, $seller_products );
    }
}

add_action( 'woocommerce_checkout_update_order_meta', 'dokan_create_sub_order' );



/**
 * Creates a sub order
 *
 * @param int $parent_order
 * @param int $seller_id
 * @param array $seller_products
 */
function dokan_create_seller_order( $parent_order, $seller_id, $seller_products ) {
    $order_data = apply_filters( 'woocommerce_new_order_data', array(
        'post_type'     => 'shop_order',
        'post_title'    => sprintf( __( 'Order &ndash; %s', 'dokan' ), strftime( _x( '%b %d, %Y @ %I:%M %p', 'Order date parsed by strftime', 'dokan' ) ) ),
        'post_status'   => 'wc-pending',
        'ping_status'   => 'closed',
        'post_excerpt'  => isset( $posted['order_comments'] ) ? $posted['order_comments'] : '',
        'post_author'   => $seller_id,
        'post_parent'   => $parent_order->id,
        'post_password' => uniqid( 'order_' )   // Protects the post just in case
    ) );

    $order_id = wp_insert_post( $order_data );

    if ( $order_id && !is_wp_error( $order_id ) ) {

        $order_total = $order_tax = 0;
        $product_ids = array();

        do_action( 'woocommerce_new_order', $order_id );

        // now insert line items
        foreach ($seller_products as $item) {
            $order_total += (float) $item['line_total'];
            $order_tax += (float) $item['line_tax'];
            $product_ids[] = $item['product_id'];

            $item_id = wc_add_order_item( $order_id, array(
                'order_item_name' => $item['name'],
                'order_item_type' => 'line_item'
            ) );

            if ( $item_id ) {
                foreach ($item['item_meta'] as $meta_key => $meta_value) {
                    wc_add_order_item_meta( $item_id, $meta_key, $meta_value[0] );
                }
            }
        } // foreach

        $bill_ship = array(
            '_billing_country', '_billing_first_name', '_billing_last_name', '_billing_company',
            '_billing_address_1', '_billing_address_2', '_billing_city', '_billing_state', '_billing_postcode',
            '_billing_email', '_billing_phone', '_shipping_country', '_shipping_first_name', '_shipping_last_name',
            '_shipping_company', '_shipping_address_1', '_shipping_address_2', '_shipping_city',
            '_shipping_state', '_shipping_postcode'
        );

        // save billing and shipping address
        foreach ($bill_ship as $val) {
            $order_key = ltrim( $val, '_' );
            update_post_meta( $order_id, $val, $parent_order->$order_key );
        }

        // do shipping
        $shipping_cost = dokan_create_sub_order_shipping( $parent_order, $order_id, $seller_products );

        // add coupons if any
        dokan_create_sub_order_coupon( $parent_order, $order_id, $product_ids );
        $discount = dokan_sub_order_get_total_coupon( $order_id );

        // calculate the total
        $order_in_total = $order_total + $shipping_cost + $order_tax;
        //$order_in_total = $order_total + $shipping_cost + $order_tax - $discount;

        // set order meta
        update_post_meta( $order_id, '_payment_method',         $parent_order->payment_method );
        update_post_meta( $order_id, '_payment_method_title',   $parent_order->payment_method_title );

        update_post_meta( $order_id, '_order_shipping',         woocommerce_format_decimal( $shipping_cost ) );
        update_post_meta( $order_id, '_order_discount',         woocommerce_format_decimal( $discount ) );
        update_post_meta( $order_id, '_cart_discount',          woocommerce_format_decimal( $discount ) );
        update_post_meta( $order_id, '_order_tax',              woocommerce_format_decimal( $order_tax ) );
        update_post_meta( $order_id, '_order_shipping_tax',     '0' );
        update_post_meta( $order_id, '_order_total',            woocommerce_format_decimal( $order_in_total ) );
        update_post_meta( $order_id, '_order_key',              apply_filters('woocommerce_generate_order_key', uniqid('order_') ) );
        update_post_meta( $order_id, '_customer_user',          $parent_order->customer_user );
        update_post_meta( $order_id, '_order_currency',         get_post_meta( $parent_order->id, '_order_currency', true ) );
        update_post_meta( $order_id, '_prices_include_tax',     $parent_order->prices_include_tax );
        update_post_meta( $order_id, '_customer_ip_address',    get_post_meta( $parent_order->id, '_customer_ip_address', true ) );
        update_post_meta( $order_id, '_customer_user_agent',    get_post_meta( $parent_order->id, '_customer_user_agent', true ) );

        do_action( 'dokan_checkout_update_order_meta', $order_id, $seller_id );
    } // if order
}



/**
 * Get discount coupon total from a order
 *
 * @global WPDB $wpdb
 * @param int $order_id
 * @return int
 */
function dokan_sub_order_get_total_coupon( $order_id ) {
    global $wpdb;

    $sql = $wpdb->prepare( "SELECT SUM(oim.meta_value) FROM {$wpdb->prefix}woocommerce_order_itemmeta oim
            LEFT JOIN {$wpdb->prefix}woocommerce_order_items oi ON oim.order_item_id = oi.order_item_id
            WHERE oi.order_id = %d AND oi.order_item_type = 'coupon'", $order_id );

    $result = $wpdb->get_var( $sql );
    if ( $result ) {
        return $result;
    }

    return 0;
}



/**
 * Create coupons for a sub-order if neccessary
 *
 * @param WC_Order $parent_order
 * @param int $order_id
 * @param array $product_ids
 * @return type
 */
function dokan_create_sub_order_coupon( $parent_order, $order_id, $product_ids ) {
    $used_coupons = $parent_order->get_used_coupons();

    if ( ! count( $used_coupons ) ) {
        return;
    }

    if ( $used_coupons ) {
        foreach ($used_coupons as $coupon_code) {
            $coupon = new WC_Coupon( $coupon_code );

            if ( $coupon && !is_wp_error( $coupon ) && array_intersect( $product_ids, $coupon->product_ids ) ) {

                // we found some match
                $item_id = wc_add_order_item( $order_id, array(
                    'order_item_name' => $coupon_code,
                    'order_item_type' => 'coupon'
                ) );

                // Add line item meta
                if ( $item_id ) {
                    wc_add_order_item_meta( $item_id, 'discount_amount', isset( WC()->cart->coupon_discount_amounts[ $coupon_code ] ) ? WC()->cart->coupon_discount_amounts[ $coupon_code ] : 0 );
                }
            }
        }
    }
}


/**
 * Create shipping for a sub-order if neccessary
 *
 * @param WC_Order $parent_order
 * @param int $order_id
 * @param array $product_ids
 * @return type
 */
function dokan_create_sub_order_shipping( $parent_order, $order_id, $seller_products ) {

    // take only the first shipping method
    $shipping_methods = $parent_order->get_shipping_methods();

    $shipping_method = is_array( $shipping_methods ) ? reset( $shipping_methods ) : array();

    $shipping_method = apply_filters( 'dokan_shipping_method', $shipping_method, $order_id, $parent_order );

    // bail out if no shipping methods found
    if ( !$shipping_method ) {
        return;
    }

    $shipping_products = array();
    $packages = array();

    // emulate shopping cart for calculating the shipping method
    foreach ($seller_products as $product_item) {
        $product = get_product( $product_item['product_id'] );

        if ( $product->needs_shipping() ) {
            $shipping_products[] = array(
                'product_id'        => $product_item['product_id'],
                'variation_id'      => $product_item['variation_id'],
                'variation'         => '',
                'quantity'          => $product_item['qty'],
                'data'              => $product,
                'line_total'        => $product_item['line_total'],
                'line_tax'          => $product_item['line_tax'],
                'line_subtotal'     => $product_item['line_subtotal'],
                'line_subtotal_tax' => $product_item['line_subtotal_tax'],
            );
        }
    }

    if ( $shipping_products ) {
        $package = array(
            'contents'        => $shipping_products,
            'contents_cost'   => array_sum( wp_list_pluck( $shipping_products, 'line_total' ) ),
            'applied_coupons' => array(),
            'destination'     => array(
                'country'   => $parent_order->shipping_country,
                'state'     => $parent_order->shipping_state,
                'postcode'  => $parent_order->shipping_postcode,
                'city'      => $parent_order->shipping_city,
                'address'   => $parent_order->shipping_address_1,
                'address_2' => $parent_order->shipping_address_2,
            )
        );

        $wc_shipping = WC_Shipping::instance();
        $pack = $wc_shipping->calculate_shipping_for_package( $package );

        if ( array_key_exists( $shipping_method['method_id'], $pack['rates'] ) ) {

            $method = $pack['rates'][$shipping_method['method_id']];
            $cost = wc_format_decimal( $method->cost );

            $item_id = wc_add_order_item( $order_id, array(
                'order_item_name'       => $method->label,
                'order_item_type'       => 'shipping'
            ) );

            if ( $item_id ) {
                wc_add_order_item_meta( $item_id, 'method_id', $method->id );
                wc_add_order_item_meta( $item_id, 'cost', $cost );
            }

            return $cost;
        };
    }

    return 0;
}



/**
 * Validates seller registration form from my-account page
 *
 * @param WP_Error $error
 * @return \WP_Error
 */
function dokan_seller_registration_errors( $error ) {
    $allowed_roles = apply_filters( 'dokan_register_user_role', array( 'customer', 'seller' ) );

    // is the role name allowed or user is trying to manipulate?
    if ( isset( $_POST['role'] ) && !in_array( $_POST['role'], $allowed_roles ) ) {
        return new WP_Error( 'role-error', __( 'Cheating, eh?', 'dokan' ) );
    }

    $role = $_POST['role'];

    if ( $role == 'seller' ) {

        $first_name = trim( $_POST['fname'] );
        if ( empty( $first_name ) ) {
            return new WP_Error( 'fname-error', __( 'Please enter your first name.', 'dokan' ) );
        }

        $last_name = trim( $_POST['lname'] );
        if ( empty( $last_name ) ) {
            return new WP_Error( 'lname-error', __( 'Please enter your last name.', 'dokan' ) );
        }
        $phone = trim( $_POST['phone'] );
        if ( empty( $phone ) ) {
            return new WP_Error( 'phone-error', __( 'Please enter your phone number.', 'dokan' ) );
        }
    }

    return $error;
}

add_filter( 'woocommerce_process_registration_errors', 'dokan_seller_registration_errors' );
add_filter( 'registration_errors', 'dokan_seller_registration_errors' );



/**
 * Inject first and last name to WooCommerce for new seller registraion
 *
 * @param array $data
 * @return array
 */
function dokan_new_customer_data( $data ) {
    $allowed_roles = array( 'customer', 'seller' );
    $role = ( isset( $_POST['role'] ) && in_array( $_POST['role'], $allowed_roles ) ) ? $_POST['role'] : 'customer';

    $data['role'] = $role;

    if ( $role == 'seller' ) {
        $data['first_name']    = strip_tags( $_POST['fname'] );
        $data['last_name']     = strip_tags( $_POST['lname'] );
        $data['user_nicename'] = sanitize_title( $_POST['shopurl'] );
    }

    return $data;
}

add_filter( 'woocommerce_new_customer_data', 'dokan_new_customer_data');



/**
 * Adds default dokan store settings when a new seller registers
 *
 * @param int $user_id
 * @param array $data
 * @return void
 */
function dokan_on_create_seller( $user_id, $data ) {
    if ( $data['role'] != 'seller' ) {
        return;
    }

    $dokan_settings = array(
        'store_name'     => strip_tags( $_POST['shopname'] ),
        'social'         => array(),
        'payment'        => array(),
        'phone'          => $_POST['phone'],
        'show_email'     => 'no',
        'location'       => '',
        'find_address'   => '',
        'dokan_category' => '',
        'banner'         => 0,
    );

    update_user_meta( $user_id, 'dokan_profile_settings', $dokan_settings );

    Dokan_Email::init()->new_seller_registered_mail( $user_id );
}

add_action( 'woocommerce_created_customer', 'dokan_on_create_seller', 10, 2);



/**
 * Get featured products
 *
 * Shown on homepage
 *
 * @param int $per_page
 * @return \WP_Query
 */
function dokan_get_featured_products( $per_page = 9) {
    $featured_query = new WP_Query( apply_filters( 'dokan_get_featured_products', array(
        'posts_per_page'      => $per_page,
        'post_type'           => 'product',
        'ignore_sticky_posts' => 1,
        'meta_query'          => array(
            array(
                'key'     => '_visibility',
                'value'   => array('catalog', 'visible'),
                'compare' => 'IN'
            ),
            array(
                'key'   => '_featured',
                'value' => 'yes'
            )
        )
    ) ) );

    return $featured_query;
}

/**
 * Get latest products
 *
 * Shown on homepage
 *
 * @param int $per_page
 * @return \WP_Query
 */
function dokan_get_latest_products( $per_page = 9 , $seller_id = '' ) {
    $args = array(
        'posts_per_page'      => $per_page,
        'post_type'           => 'product',
        'ignore_sticky_posts' => 1,
        'meta_query'          => array(
            array(
                'key'     => '_visibility',
                'value'   => array('catalog', 'visible'),
                'compare' => 'IN'
            )
        ),
    );

    if ( !empty( $seller_id ) ) {
        $args['author'] = (int) $seller_id;
    }

    $latest_query = new WP_Query( apply_filters( 'dokan_get_latest_products', $args ) );

    return $latest_query;
}

/**
 * Get best selling products
 *
 * Shown on homepage
 *
 * @param int $per_page
 * @return \WP_Query
 */
function dokan_get_best_selling_products( $per_page = 8, $seller_id = '' ) {

    $args = array(
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $per_page,
        'meta_key'            => 'total_sales',
        'orderby'             => 'meta_value_num',
        'meta_query'          => array(
            array(
                'key'     => '_visibility',
                'value'   => array( 'catalog', 'visible' ),
                'compare' => 'IN'
            ),
        )
    );

    if ( !empty( $seller_id ) ) {
        $args['author'] = (int) $seller_id;
    }

    $best_selling_query = new WP_Query( apply_filters( 'dokan_best_selling_query', $args ) );

    return $best_selling_query;
}



/**
 * Get top rated products
 *
 * Shown on homepage
 *
 * @param int $per_page
 * @return \WP_Query
 */
function dokan_get_top_rated_products( $per_page = 8 , $seller_id = '') {

    $args = array(
        'post_type'             => 'product',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => 1,
        'posts_per_page'        => $per_page,
        'meta_query'            => array(
            array(
                'key'           => '_visibility',
                'value'         => array('catalog', 'visible'),
                'compare'       => 'IN'
            )
        )
    );

    if ( !empty( $seller_id ) ) {
        $args['author'] = (int) $seller_id;
    }

    add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

    $top_rated_query = new WP_Query( apply_filters( 'dokan_top_rated_query', $args ) );

    remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );

    return $top_rated_query;
}

/**
 * Get products on-sale
 *
 * Shown on homepage
 *
 * @param type $per_page
 * @param type $paged
 * @return \WP_Query
 */
function dokan_get_on_sale_products( $per_page = 10, $paged = 1, $seller_id = '' ) {
    // Get products on sale
    $product_ids_on_sale = wc_get_product_ids_on_sale();

    $args = array(
        'posts_per_page'    => $per_page,
        'no_found_rows'     => 1,
        'paged'             => $paged,
        'post_status'       => 'publish',
        'post_type'         => 'product',
        'post__in'          => array_merge( array( 0 ), $product_ids_on_sale ),
        'meta_query'        => array(
            array(
                'key'       => '_visibility',
                'value'     => array('catalog', 'visible'),
                'compare'   => 'IN'
            ),
            array(
                'key'       => '_stock_status',
                'value'     => 'instock',
                'compare'   => '='
            )
        )
    );

    if ( !empty( $seller_id ) ) {
        $args['author'] = (int) $seller_id;
    }

    return new WP_Query( apply_filters( 'dokan_on_sale_products_query', $args ) );
}



/**
 * Get current balance of a seller
 *
 * Total = SUM(net_amount) - SUM(withdraw)
 *
 * @global WPDB $wpdb
 * @param type $seller_id
 * @param type $formatted
 *
 * @return mixed
 */
function dokan_get_seller_balance( $seller_id, $formatted = true ) {
    global $wpdb;

    $status        = dokan_withdraw_get_active_order_status_in_comma();
    $cache_key     = 'dokan_seller_balance_' . $seller_id;
    $earning       = wp_cache_get( $cache_key, 'dokan' );
    $threshold_day = dokan_get_option( 'withdraw_date_limit', 'dokan_withdraw', 0 );
    $date          = date( 'Y-m-d', strtotime( date('Y-m-d') . ' -'.$threshold_day.' days' ) );

    if ( false === $earning ) {
        $sql = "SELECT SUM(net_amount) as earnings,
            (SELECT SUM(amount) FROM {$wpdb->prefix}dokan_withdraw WHERE user_id = %d AND status = 1) as withdraw
            FROM {$wpdb->prefix}dokan_orders as do LEFT JOIN {$wpdb->prefix}posts as p ON do.order_id = p.ID
            WHERE seller_id = %d AND DATE(p.post_date) <= %s AND order_status IN({$status})";

        $result = $wpdb->get_row( $wpdb->prepare( $sql, $seller_id, $seller_id, $date ) );
        $earning = $result->earnings - $result->withdraw;

        wp_cache_set( $cache_key, $earning, 'dokan' );
    }

    if ( $formatted ) {
        return wc_price( $earning );
    }

    return $earning;
}

/**
 * Get seller rating
 *
 * @global WPDB $wpdb
 * @param type $seller_id
 * @return type
 */
function dokan_get_seller_rating( $seller_id ) {
    global $wpdb;

    $sql = "SELECT AVG(cm.meta_value) as average, COUNT(wc.comment_ID) as count FROM $wpdb->posts p
        INNER JOIN $wpdb->comments wc ON p.ID = wc.comment_post_ID
        LEFT JOIN $wpdb->commentmeta cm ON cm.comment_id = wc.comment_ID
        WHERE p.post_author = %d AND p.post_type = 'product' AND p.post_status = 'publish'
        AND ( cm.meta_key = 'rating' OR cm.meta_key IS NULL) AND wc.comment_approved = 1
        ORDER BY wc.comment_post_ID";

    $result = $wpdb->get_row( $wpdb->prepare( $sql, $seller_id ) );

    return array( 'rating' => number_format( $result->average, 2), 'count' => (int) $result->count );
}


/**
 * Get seller rating in a readable rating format
 *
 * @param int $seller_id
 * @return void
 */
function dokan_get_readable_seller_rating( $seller_id ) {
    $rating = dokan_get_seller_rating( $seller_id );

    if ( ! $rating['count'] ) {
        echo __( 'No ratings found yet!', 'dokan' );
        return;
    }

    $long_text = _n( __( '%s rating from %d review', 'dokan' ), __( '%s rating from %d reviews', 'dokan' ), $rating['count'], 'dokan' );
    $text = sprintf( __( 'Rated %s out of %d', 'dokan' ), $rating['rating'], number_format( 5 ) );
    $width = ( $rating['rating']/5 ) * 100;
    ?>
        <span class="seller-rating">
            <span title="<?php echo esc_attr( $text ); ?>" class="star-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
                <span class="width" style="width: <?php echo $width; ?>%"></span>
                <span style=""><strong itemprop="ratingValue"><?php echo $rating['rating']; ?></strong></span>
            </span>
        </span>

        <span class="text"><a href="<?php echo dokan_get_review_url( $seller_id ); ?>"><?php printf( $long_text, $rating['rating'], $rating['count'] ); ?></a></span>

    <?php
}

/**
 * Adds default dokan store settings when a new seller registers
 *
 * @param int $user_id
 * @param array $data
 * @return void
 */
function dokan_user_update_to_seller( $user, $data ) {
    if ( ! dokan_is_user_customer( $user->ID ) ) {
        return;
    }

    $user_id = $user->ID;

    // Remove role
    $user->remove_role( 'customer' );

    // Add role
    $user->add_role( 'seller' );

    $user_id = wp_update_user( array( 'ID' => $user_id, 'user_nicename' => $data['shopurl'] ) );
    update_user_meta( $user_id, 'first_name', $data['fname'] );
    update_user_meta( $user_id, 'last_name', $data['lname'] );

    if ( dokan_get_option( 'new_seller_enable_selling', 'dokan_selling', 'on' ) == 'off' ) {
        update_user_meta( $user_id, 'dokan_enable_selling', 'no' );
    } else {
        update_user_meta( $user_id, 'dokan_enable_selling', 'yes' );
    }

    $dokan_settings = array(
        'store_name'     => $data['shopname'],
        'social'         => array(),
        'payment'        => array(),
        'phone'          => $data['phone'],
        'show_email'     => 'no',
        'address'        => $data['address'],
        'location'       => '',
        'find_address'   => '',
        'dokan_category' => '',
        'banner'         => 0,
    );

    update_user_meta( $user_id, 'dokan_profile_settings', $dokan_settings );


    $publishing = dokan_get_option( 'product_status', 'dokan_selling' );
    $percentage = dokan_get_option( 'seller_percentage', 'dokan_selling' );

    update_user_meta( $user_id, 'dokan_publishing', $publishing );
    update_user_meta( $user_id, 'dokan_seller_percentage', $percentage );

    Dokan_Email::init()->new_seller_registered_mail( $user_id );
}

/**
 * Handles the become a seller form
 *
 * @return void
 */
function dokan_become_seller_handler () {
    if ( isset( $_POST['dokan_migration'] ) && wp_verify_nonce( $_POST['dokan_nonce'], 'account_migration' ) ) {
        $user   = get_userdata( get_current_user_id() );
        $errors = array();

        $checks = array(
            'fname'    => __( 'Enter your first name', 'dokan' ),
            'lname'    => __( 'Enter your last name', 'dokan' ),
            'shopname' => __( 'Enter your shop name', 'dokan' ),
            'address'  => __( 'Enter your shop address', 'dokan' ),
            'phone'    => __( 'Enter your phone number', 'dokan' ),
        );

        foreach ($checks as $field => $error) {
            if ( empty( $_POST[$field]) ) {
                $errors[] = $error;
            }
        }

        if ( ! $errors ) {
            dokan_user_update_to_seller( $user, $_POST );

            wp_redirect( dokan_get_page_url( 'myaccount', 'dokan' ) );
        }
    }
}

add_action( 'template_redirect', 'dokan_become_seller_handler' );

/**
 * Exclude child order emails for customers
 *
 * A hacky and dirty way to do this from this action. Because there is no easy
 * way to do this by removing action hooks from WooCommerce. It would be easier
 * if they were from functions. Because they are added from classes, we can't
 * remove those action hooks. Thats why we are doing this from the phpmailer_init action
 * by returning a fake phpmailer class.
 *
 * @param  array $attr
 * @return array
 */
function dokan_exclude_child_customer_receipt( &$phpmailer ) {
    $subject      = $phpmailer->Subject;

    // order receipt
    $sub_receipt  = __( 'Your {site_title} order receipt from {order_date}', 'dokan' );
    $sub_download = __( 'Your {site_title} order from {order_date} is complete', 'dokan' );

    $sub_receipt  = str_replace( array('{site_title}', '{order_date}'), array(wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ), ''), $sub_receipt);
    $sub_download = str_replace( array('{site_title}', '{order_date} is complete'), array(wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES ), ''), $sub_download);

    // not a customer receipt mail
    if ( ( stripos( $subject, $sub_receipt ) === false ) && ( stripos( $subject, $sub_download ) === false ) ) {
        return;
    }

    $message = $phpmailer->Body;
    $pattern = '/Order: #(\d+)/';
    preg_match( $pattern, $message, $matches );

    if ( isset( $matches[1] ) ) {
        $order_id = $matches[1];
        $order    = get_post( $order_id );

        // we found a child order
        if ( ! is_wp_error( $order ) && $order->post_parent != 0 ) {
            $phpmailer = new DokanFakeMailer();
        }
    }
}

add_action( 'phpmailer_init', 'dokan_exclude_child_customer_receipt' );

/**
 * A fake mailer class to replace phpmailer
 */
class DokanFakeMailer {
    public function Send() {}
}

add_filter( 'woocommerce_dashboard_status_widget_sales_query', 'dokan_filter_woocommerce_dashboard_status_widget_sales_query' );

/**
 * Woocommerce Admin dashboard Sales Report Synced with Dokan Dashboard report
 *
 * @since 2.4.3
 *
 * @global WPDB $wpdb
 * @param array $query
 *
 * @return $query
 */
function dokan_filter_woocommerce_dashboard_status_widget_sales_query( $query ) {
    global $wpdb;

    $query['where']  .= " AND posts.ID NOT IN ( SELECT post_parent FROM {$wpdb->posts} WHERE post_type IN ( '" . implode( "','", array_merge( wc_get_order_types( 'sales-reports' ), array( 'shop_order_refund' ) ) ) . "' ) )";

    return $query;
}

/**
 * Flat Rate Shipping made compatible for Orders with multiple seller
 *
 * @since 2.4.3
 *
 * @param array $rates
 * @param array $package
 *
 * @return $rates
 */
function dokan_multiply_flat_rate_price_by_seller( $rates, $package ) {

    if ( !isset( $rates['flat_rate'] ) && !isset( $rates['international_delivery'] ) ) {
        return $rates;
    }

    foreach ( $package['contents'] as $product ) {
        $sellers[] = get_post_field( 'post_author', $product['product_id'] );
    }

    $sellers = array_unique( $sellers );

    $selllers_count = count( $sellers );

    $rates['flat_rate']->cost = $rates['flat_rate']->cost * $selllers_count;

    return $rates;
}

add_filter( 'woocommerce_package_rates', 'dokan_multiply_flat_rate_price_by_seller', 1,2);


/**
 * Handle password edit and name update functions
 *
 * @since 2.4.10
 *
 * @return void
 */
function dokan_save_account_details(){

    if ( 'POST' !== strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) ) {
		return;
	}

	if ( empty( $_POST[ 'action' ] ) || 'dokan_save_account_details' !== $_POST[ 'action' ] || empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'dokan_save_account_details' ) ) {
		return;
	}

	$errors       = new WP_Error();
	$user         = new stdClass();

	$user->ID     = (int) get_current_user_id();
	$current_user = get_user_by( 'id', $user->ID );

	if ( $user->ID <= 0 ) {
		return;
	}

	$account_first_name = ! empty( $_POST[ 'account_first_name' ] ) ? wc_clean( $_POST[ 'account_first_name' ] ) : '';
	$account_last_name  = ! empty( $_POST[ 'account_last_name' ] ) ? wc_clean( $_POST[ 'account_last_name' ] ) : '';
	$account_email      = ! empty( $_POST[ 'account_email' ] ) ? sanitize_email( $_POST[ 'account_email' ] ) : '';
	$pass_cur           = ! empty( $_POST[ 'password_current' ] ) ? $_POST[ 'password_current' ] : '';
	$pass1              = ! empty( $_POST[ 'password_1' ] ) ? $_POST[ 'password_1' ] : '';
	$pass2              = ! empty( $_POST[ 'password_2' ] ) ? $_POST[ 'password_2' ] : '';
	$save_pass          = true;

	$user->first_name   = $account_first_name;
	$user->last_name    = $account_last_name;

	// Prevent emails being displayed, or leave alone.
	$user->display_name = is_email( $current_user->display_name ) ? $user->first_name : $current_user->display_name;

	// Handle required fields
	$required_fields = apply_filters( 'woocommerce_save_account_details_required_fields', array(
		'account_first_name' => __( 'First Name', 'dokan' ),
		'account_last_name'  => __( 'Last Name', 'dokan' ),
		'account_email'      => __( 'Email address', 'dokan' ),
	) );

	foreach ( $required_fields as $field_key => $field_name ) {
		if ( empty( $_POST[ $field_key ] ) ) {
			wc_add_notice( '<strong>' . esc_html( $field_name ) . '</strong> ' . __( 'is a required field.', 'dokan' ), 'error' );
		}
	}

	if ( $account_email ) {
		if ( ! is_email( $account_email ) ) {
			wc_add_notice( __( 'Please provide a valid email address.', 'dokan' ), 'error' );
		} elseif ( email_exists( $account_email ) && $account_email !== $current_user->user_email ) {
			wc_add_notice( __( 'This email address is already registered.', 'dokan' ), 'error' );
		}
		$user->user_email = $account_email;
	}

	if ( ! empty( $pass1 ) && ! wp_check_password( $pass_cur, $current_user->user_pass, $current_user->ID ) ) {
		wc_add_notice( __( 'Your current password is incorrect.', 'dokan' ), 'error' );
		$save_pass = false;
	}

	if ( ! empty( $pass_cur ) && empty( $pass1 ) && empty( $pass2 ) ) {
		wc_add_notice( __( 'Please fill out all password fields.', 'dokan' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && empty( $pass_cur ) ) {
		wc_add_notice( __( 'Please enter your current password.', 'dokan' ), 'error' );
		$save_pass = false;
	} elseif ( ! empty( $pass1 ) && empty( $pass2 ) ) {
		wc_add_notice( __( 'Please re-enter your password.', 'dokan' ), 'error' );
		$save_pass = false;
	} elseif ( ( ! empty( $pass1 ) || ! empty( $pass2 ) ) && $pass1 !== $pass2 ) {
		wc_add_notice( __( 'New passwords do not match.', 'dokan' ), 'error' );
		$save_pass = false;
	}

	if ( $pass1 && $save_pass ) {
		$user->user_pass = $pass1;
	}

	// Allow plugins to return their own errors.
	do_action_ref_array( 'woocommerce_save_account_details_errors', array( &$errors, &$user ) );

	if ( $errors->get_error_messages() ) {
		foreach ( $errors->get_error_messages() as $error ) {
			wc_add_notice( $error, 'error' );
		}
	}

	if ( wc_notice_count( 'error' ) === 0 ) {

		wp_update_user( $user ) ;

		wc_add_notice( __( 'Account details changed successfully.', 'dokan' ) );

		do_action( 'woocommerce_save_account_details', $user->ID );

		wp_safe_redirect( dokan_get_navigation_url( ' edit-account' ) );
		exit;
	}
}

add_action( 'template_redirect', 'dokan_save_account_details' );