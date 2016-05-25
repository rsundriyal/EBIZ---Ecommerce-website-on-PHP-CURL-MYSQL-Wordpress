<?php
/**
 * Table view to Request A Quote
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @author  Yithemes
 */


if( count($raq_content) == 0):
?>
	<p><?php  _e('No products in list', 'yith-woocommerce-request-a-quote') ?></p>
<?php else: ?>
    <form id="yith-ywraq-form" name="yith-ywraq-form" action="<?php echo esc_url( YITH_Request_Quote()->get_raq_page_url( 'update' ) ) ?>" method="post">
	<table class="shop_table cart" id="yith-ywrq-table-list" cellspacing="0">
        <thead>
            <tr>
                <th class="product-remove">&nbsp;</th>
                <th class="product-thumbnail">&nbsp;</th>
                <th class="product-name"><?php _e( 'Product', 'yith-woocommerce-request-a-quote' ) ?></th>
                <th class="product-quantity"><?php _e( 'Quantity', 'yith-woocommerce-request-a-quote' ) ?></th>
                <th class="product-subtotal"><?php _e( 'Total', 'yith-woocommerce-request-a-quote' ); ?></th>
            </tr>
        </thead>
		<tbody>
	<?php foreach ( $raq_content as $key => $raq ):

		$_product = wc_get_product(  isset( $raq['variation_id'] ) ? $raq['variation_id'] : $raq['product_id'] );
        if( !isset( $_product ) || !is_object($_product) ) continue;
    ?>
			<tr class="cart_item">

				<td class="product-remove">
					<?php
						echo apply_filters( 'yith_ywraq_item_remove_link', sprintf( '<a href="#"  data-remove-item="%s" data-wp_nonce="%s"  data-product_id="%d" class="yith-ywraq-item-remove remove" title="%s">&times;</a>', $key, wp_create_nonce( 'remove-request-quote-' . $_product->id ), $_product->id,  __( 'Remove this item', 'yith-woocommerce-request-a-quote' ) ), $key );
					?>
                    <img src="<?php echo esc_url( admin_url( 'images/wpspin_light.gif' ) ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />
				</td>

				<td class="product-thumbnail">
					<?php $thumbnail =  $_product->get_image();

					if ( ! $_product->is_visible() )
						echo $thumbnail;
					else
						printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
					?>
				</td>

				<td class="product-name">
					<a href="<?php echo $_product->get_permalink() ?>"><?php echo $_product->get_title() ?></a>
					<?php

					sprintf( '<a href="%s">%s</a>', $_product->get_permalink( ), $_product->get_title() );
					// Meta data

					$item_data = array();

					// Variation data
					if ( ! empty( $raq['variation_id'] ) && is_array( $raq['variations'] ) ) {

						foreach ( $raq['variations'] as $name => $value ) {
                            $label = '';
							if ( '' === $value )
								continue;

							$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

							// If this is a term slug, get the term's nice name
							if ( taxonomy_exists( $taxonomy ) ) {
								$term = get_term_by( 'slug', $value, $taxonomy );
								if ( ! is_wp_error( $term ) && $term && $term->name ) {
									$value = $term->name;
								}
								$label = wc_attribute_label( $taxonomy );

							// If this is a custom option slug, get the options name
                            } else {
                                $value              = apply_filters( 'woocommerce_variation_option_name', $value );
                                $custom_att = str_replace( 'attribute_', '', $name);

                                if ( $custom_att != '' ) {
                                    $label = wc_attribute_label( $custom_att );
                                } else {
                                    $label = $name;
                                }
                            }


                        $item_data[] = array(
								'key'   => $label,
								'value' => $value
							);
						}
					}

					// Output flat or in list format
					if ( sizeof( $item_data ) > 0 ) {
							foreach ( $item_data as $data ) {
								echo esc_html( $data['key'] ) . ': ' . wp_kses_post( $data['value'] ) . "\n";
							}
						}

					?>
				</td>


				<td class="product-quantity">
					<?php
						$product_quantity = woocommerce_quantity_input( array(
                            'input_name'  => "raq[{$key}][qty]",
							'input_value' => $raq['quantity'],
							'max_value'   => apply_filters('ywraq_quantity_max_value', $_product->backorders_allowed() ? '' : $_product->get_stock_quantity() ),
							'min_value'   => '0'
						), $_product, false );

					    echo $product_quantity;
					?>
				</td>

                <td class="product-subtotal">
                    <?php
                        echo apply_filters( 'yith_ywraq_hide_price_template' , WC()->cart->get_product_subtotal( $_product, $raq['quantity'] ));
                    ?>
                </td>
			</tr>

	<?php endforeach ?>

            <tr>
                <td colspan="5" class="actions">
                    <input type="submit" class="button" name="update_raq" value="<?php _e('Update List', 'yith-woocommerce-request-a-quote') ?>">
                    <input type="hidden" id="update_raq_wpnonce" name="update_raq_wpnonce" value="<?php echo wp_create_nonce( 'update-request-quote-quantity' ) ?>">
                </td>
            </tr>

			</tbody>
	</table>
    </form>
	<?php endif ?>

