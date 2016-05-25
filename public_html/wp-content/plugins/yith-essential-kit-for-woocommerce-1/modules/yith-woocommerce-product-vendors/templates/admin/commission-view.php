<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * @var YITH_Commission $commission
 */

$order   = $commission->get_order();
$user    = $commission->get_user();
$vendor  = $commission->get_vendor();
$product = $commission->get_product();
$item    = $commission->get_item();
$item_id = $commission->line_item_id;
?>

<div class="wrap">
	<h2>
		<?php _e( 'View Commission', 'yith_wc_product_vendors' ) ?>
		<a href="<?php echo esc_url( remove_query_arg( 'view' ) ) ?>" class="add-new-h2"><?php _e( 'Back', 'yith_wc_product_vendors' ) ?></a>
	</h2>

	<?php YITH_Commissions()->admin_notice(); ?>

	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">

			<div id="postbox-container-1" class="postbox-container">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">

					<?php if ( $vendor->is_super_user() ) : ?>
					<form id="woocommerce-order-actions" class="postbox" method="GET">
						<h3 class="hndle ui-sortable-handle"><span><?php _e( 'Commission Actions', 'yith_wc_product_vendors' ) ?></span></h3>
						<div class="inside">
							<ul class="order_actions submitbox">

								<li class="wide" id="actions">
									<select name="new_status">
										<option value=""><?php _e( 'Actions', 'yith_wc_product_vendors' ) ?></option>
										<?php foreach ( YITH_Commissions()->get_status() as $status => $display ) : if ( ! YITH_Commissions()->is_status_changing_permitted( $status, $commission->status ) ) continue; ?>
											<option value="<?php echo $status ?>"><?php printf( __( 'Change to %s', 'yith_wc_product_vendors' ), $display ) ?></option>
										<?php endforeach; ?>
									</select>

									<input type="hidden" name="action" value="yith_commission_table_actions" />
									<input type="hidden" name="view" value="<?php echo $commission->id ?>" />
									<button type="submit" class="button wc-reload" title="<?php _e( 'Apply', 'yith_wc_product_vendors' ) ?>"><span><?php _e( 'Apply', 'yith_wc_product_vendors' ) ?></span></button>
								</li>

							</ul>
						</div>
					</form>
					<?php endif; ?>

					<div id="woocommerce-order-notes" class="postbox">
						<h3 class="hndle ui-sortable-handle"><span><?php _e( 'Commission notes', 'yith_wc_product_vendors' ) ?></span></h3>
						<div class="inside">
							<ul class="order_notes">

								<?php if ( $notes = $commission->get_notes() ) : ?>
									<?php foreach ( $notes as $note ) : ?>
										<li rel="<?php echo $note->ID ?>" class="note">
											<div class="note_content">
												<p><?php echo $note->description ?></p>
											</div>
											<p class="meta">
												<abbr class="exact-date" title="<?php echo $note->note_date; ?>"><?php printf( __( 'added on %1$s at %2$s', 'woocommerce' ), date_i18n( wc_date_format(), strtotime( $note->note_date ) ), date_i18n( wc_time_format(), strtotime( $note->note_date ) ) ); ?></abbr>
											</p>
										</li>
									<?php endforeach; ?>
								<?php else : ?>
									<li><?php _e( 'There are no notes yet.', 'woocommerce' ) ?></li>
								<?php endif; ?>

							</ul>
						</div>
					</div>

				</div>
			</div>

			<div id="postbox-container-2" class="postbox-container">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<div id="woocommerce-order-data" class="postbox">
						<div class="inside">

							<style type="text/css">
								#post-body-content, #titlediv, #major-publishing-actions, #minor-publishing-actions, #visibility, #submitdiv { display:none }
							</style>

							<div class="panel-wrap woocommerce">
								<div id="order_data" class="yith-commission panel">
									<h2><?php printf( __( 'Commission %s Details', 'yith_wc_product_vendors' ), '#' . $commission->id ) ?></h2>
									<p class="order_number">
										<?php
										$user_info = $commission->get_user();

										if ( ! empty( $user_info ) ) {

											$current_user_can = current_user_can( 'edit_users' ) || get_current_user_id() == $user_info->ID;

                                            $username = $current_user_can ? '<a href="user-edit.php?user_id=' . absint( $user_info->ID ) . '">' : '';

                                            if ( $user_info->first_name || $user_info->last_name ) {
                                                $username .= esc_html( ucfirst( $user_info->first_name ) . ' ' . ucfirst( $user_info->last_name ) );
                                            }
                                            else {
                                                $username .= esc_html( ucfirst( $user_info->display_name ) );
                                            }

                                            if ( $current_user_can ) {
                                                $username .= '</a>';
                                            }
                                        }
										else {
											if ( $order->billing_first_name || $order->billing_last_name ) {
												$username = trim( $order->billing_first_name . ' ' . $order->billing_last_name );
											}
				 							else {
												$username = __( 'Guest', 'woocommerce' );
											}
										}

                                        $order_number    = '<strong>#' . esc_attr( $order->get_order_number() ) . '</strong>';
                                        $order_uri       = sprintf( '<a href="%s">#%d</a>', 'post.php?post=' . absint( $order->id ) . '&action=edit', $order->get_order_number() );
                                        $order_info      = $vendor->is_super_user() ? $order_uri : $order_number;

                                        if( $vendor->is_super_user() ){
                                            $order_info = $order_uri;
                                        }

                                        else if( defined( 'YITH_WPV_PREMIUM' ) && YITH_WPV_PREMIUM && $vendor->has_limited_access() && wp_get_post_parent_id( $order->id )&& in_array($order->id, $vendor->get_orders() ) ){
                                            $order_info = $order_uri;
                                        }

                                        else {
                                            $order_info = $order_number;
                                        }

                                        $wc_order_status = wc_get_order_statuses();

										printf( _x( 'credited to %s &#8212; from order %s &#8212; order status: %s', 'Commission credited to [user]', 'yith_wc_product_vendors' ), $username, $order_info, $wc_order_status[ $order->post_status ] );
										?>
									</p>

									<div class="order_data_column_container">
										<div class="order_data_column">

											<h4><?php _e( 'General details', 'yith_wc_product_vendors' ) ?></h4>
											<div class="address">
												<p>
													<strong><?php _e( 'Status', 'yith_wc_product_vendors' ) ?>:</strong>
													<?php echo $commission->get_status('display') ?>
												</p>
												<p>
													<strong><?php _e( 'Commission date', 'yith_wc_product_vendors' ) ?>:</strong>
													<?php echo $commission->get_date('display') ?>
												</p>
												<p>
													<strong><?php _e( 'Last update', 'yith_wc_product_vendors' ) ?>:</strong>
													<?php
													$date = ! empty( $commission->last_edit ) && strpos( $commission->last_edit, '0000-00-00' ) ? $commission->last_edit : $commission->get_date();
													$t_time = date_i18n( __( 'Y/m/d g:i:s A', 'yith_wc_product_vendors' ), mysql2date( 'U', $date ) );
													$h_time = sprintf( __( '%s ago', 'yith_wc_product_vendors' ), human_time_diff( mysql2date( 'U', $date ) ) );

													echo '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
													?>
												</p>
											</div>

										</div>
										<div class="order_data_column">

											<h4><?php _e( 'User details', 'yith_wc_product_vendors' ) ?></h4>
											<div class="address">
												<p>
                                                    <?php
                                                    if( ! empty( $user ) ) {
                                                        printf( '<strong>%1$s:</strong>',  __( 'Email', 'yith_wc_product_vendors' ) );
                                                        printf( '<a href="mailto:%1$s">%1$s</a>', $user->user_email );
                                                    } else {
                                                        echo '<em>' . __( 'User deleted', 'yith_wc_product_vendors' ) . '</em>';
                                                    }
                                                    ?>
												</p>
												<p>
													<strong><?php _e( 'Vendor', 'yith_wc_product_vendors' ) ?>:</strong>
													<?php
                                                    if( $vendor->is_valid() ) {
                                                        $vendor_url  = get_edit_term_link( $vendor->id, $vendor->taxonomy );
													    echo ! empty( $vendor_url ) ? "<a href='{$vendor_url}' target='_blank'>{$vendor->name}</a>" : $vendor->name;
                                                    } else {
                                                        echo '<em>' . __( 'Vendor deleted', 'yith_wc_product_vendors' ) . '</em>';
                                                    }
													?>
												</p>
												<p>
													<strong><?php _e( 'PayPal', 'yith_wc_product_vendors' ) ?>:</strong>
													<a href="mailto:<?php echo $vendor->paypal_email ?>"><?php echo $vendor->paypal_email ?></a>
												</p>
											</div>

										</div>
                                        <?php if( ! empty( $user ) ) : ?>
                                            <div class="order_data_column">
                                                <h4><?php _e( 'Billing information', 'yith_wc_product_vendors' ) ?></h4>
                                                <div class="address">
                                                    <p>
                                                        <?php

                                                        // Formatted Addresses
                                                        $formatted = WC()->countries->get_formatted_address( array(
                                                            'first_name'    => $user->first_name,
                                                            'last_name'     => $user->last_name,
                                                            'company'       => $user->billing_company,
                                                            'address_1'     => get_user_meta( $user->ID, 'billing_address_1', true ),
                                                            'address_2'     => get_user_meta( $user->ID, 'billing_address_2', true ),
                                                            'city'          => get_user_meta( $user->ID, 'billing_city', true ),
                                                            'state'         => get_user_meta( $user->ID, 'billing_state', true ),
                                                            'postcode'      => get_user_meta( $user->ID, 'billing_postcode', true ),
                                                            'country'       => get_user_meta( $user->ID, 'billing_country', true ),
                                                        ) );

                                                        echo wp_kses( $formatted, array( 'br' => array() ) )
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="order_data_column">
                                                <h4><?php _e( 'Shipping information', 'yith_wc_product_vendors' ) ?></h4>
                                                <div class="address">
                                                    <p>
                                                        <?php

                                                        // Formatted Addresses
                                                        $formatted = WC()->countries->get_formatted_address( array(
                                                            'first_name'    => get_user_meta( $user->ID, 'shipping_first_name', true ),
                                                            'last_name'     => get_user_meta( $user->ID, 'shipping_last_name', true ),
                                                            'company'       => get_user_meta( $user->ID, 'shipping_company', true ),
                                                            'address_1'     => get_user_meta( $user->ID, 'shipping_address_1', true ),
                                                            'address_2'     => get_user_meta( $user->ID, 'shipping_address_2', true ),
                                                            'city'          => get_user_meta( $user->ID, 'shipping_city', true ),
                                                            'state'         => get_user_meta( $user->ID, 'shipping_state', true ),
                                                            'postcode'      => get_user_meta( $user->ID, 'shipping_postcode', true ),
                                                            'country'       => get_user_meta( $user->ID, 'shipping_country', true ),
                                                        ) );

                                                        echo wp_kses( $formatted, array( 'br' => array() ) )
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
									</div>

									<div class="clear"></div>

								</div>
							</div>

						</div>
					</div>

					<div id="woocommerce-order-items" class="postbox">
						<h3 class="hndle ui-sortable-handle"><span><?php _e( 'Item data', 'yith_wc_product_vendors' ) ?></span></h3>
						<div class="inside">

							<div class="woocommerce_order_items_wrapper wc-order-items-editable">
								<table cellpadding="0" cellspacing="0" class="woocommerce_order_items">
									<thead>
										<tr>
											<th class="item sortable" colspan="2"><?php _e( 'Item', 'woocommerce' ) ?></th>
											<th class="quantity sortable"><?php _e( 'Qty', 'woocommerce' ) ?></th>
											<th class="item_cost sortable"><?php _e( 'Cost', 'woocommerce' ) ?></th>
											<th class="wc-order-edit-line-item" width="1%">&nbsp;</th>
										</tr>
									</thead>

									<tbody id="order_line_items">
										<tr class="item Zero Rate" data-order_item_id="<?php echo $item_id ?>">

											<td class="thumb">
												<?php if ( $product ) : ?>
													<a href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( $product->id ) . '&action=edit' ) ); ?>" class="tips" data-tip="<?php

													echo '<strong>' . __( 'Product ID:', 'woocommerce' ) . '</strong> ' . absint( $item['product_id'] );

													if ( $item['variation_id'] && 'product_variation' === get_post_type( $item['variation_id'] ) ) {
														echo '<br/><strong>' . __( 'Variation ID:', 'woocommerce' ) . '</strong> ' . absint( $item['variation_id'] );
													} elseif ( $item['variation_id'] ) {
														echo '<br/><strong>' . __( 'Variation ID:', 'woocommerce' ) . '</strong> ' . absint( $item['variation_id'] ) . ' (' . __( 'No longer exists', 'woocommerce' ) . ')';
													}

													if ( $product && $product->get_sku() ) {
														echo '<br/><strong>' . __( 'Product SKU:', 'woocommerce' ).'</strong> ' . esc_html( $product->get_sku() );
													}

													if ( $product && isset( $product->variation_data ) ) {
														echo '<br/>' . wc_get_formatted_variation( $product->variation_data, true );
													}

													?>"><?php echo $product->get_image( 'shop_thumbnail', array( 'title' => '' ) ); ?></a>
												<?php else : ?>
													<?php echo wc_placeholder_img( 'shop_thumbnail' ); ?>
												<?php endif; ?>
											</td>

											<td class="name">

												<?php echo ( $product && $product->get_sku() ) ? esc_html( $product->get_sku() ) . ' &ndash; ' : ''; ?>

												<?php if ( $product ) : ?>
													<a target="_blank" href="<?php echo esc_url( admin_url( 'post.php?post=' . absint( $product->id ) . '&action=edit' ) ); ?>">
														<?php echo esc_html( $item['name'] ); ?>
													</a>
												<?php else : ?>
													<?php echo esc_html( $item['name'] ); ?>
												<?php endif; ?>
                                                <div class="view">
                                                    <?php
                                                    global $wpdb;

                                                    if ( $metadata = $order->has_meta( $item_id ) ) {
                                                        echo '<table cellspacing="0" class="display_meta">';
                                                        foreach ( $metadata as $meta ) {

                                                            // Skip hidden core fields
                                                            if ( in_array( $meta['meta_key'], apply_filters( 'woocommerce_hidden_order_itemmeta', array(
                                                                '_qty',
                                                                '_tax_class',
                                                                '_product_id',
                                                                '_variation_id',
                                                                '_line_subtotal',
                                                                '_line_subtotal_tax',
                                                                '_line_total',
                                                                '_line_tax',
                                                                '_commission_id'
                                                            ) ) )
                                                            ) {
                                                                continue;
                                                            }

                                                            // Skip serialised meta
                                                            if ( is_serialized( $meta['meta_value'] ) ) {
                                                                continue;
                                                            }

                                                            // Get attribute data
                                                            if ( taxonomy_exists( wc_sanitize_taxonomy_name( $meta['meta_key'] ) ) ) {
                                                                $term               = get_term_by( 'slug', $meta['meta_value'], wc_sanitize_taxonomy_name( $meta['meta_key'] ) );
                                                                $meta['meta_key']   = wc_attribute_label( wc_sanitize_taxonomy_name( $meta['meta_key'] ) );
                                                                $meta['meta_value'] = isset( $term->name ) ? $term->name : $meta['meta_value'];
                                                            }
                                                            else {
                                                                $meta['meta_key'] = apply_filters( 'woocommerce_attribute_label', wc_attribute_label( $meta['meta_key'], $product ), $meta['meta_key'] );
                                                            }

                                                            echo '<tr><th>' . wp_kses_post( rawurldecode( $meta['meta_key'] ) ) . ':</th><td>' . wp_kses_post( wpautop( make_clickable( rawurldecode( $meta['meta_value'] ) ) ) ) . '</td></tr>';
                                                        }
                                                        echo '</table>';
                                                    }
                                                    ?>
                                                </div>
											</td>

											<td class="quantity" width="1%">
												<div class="view">
													<?php
													echo ( isset( $item['qty'] ) ) ? esc_html( $item['qty'] ) : '';

													if ( $refunded_qty = $order->get_qty_refunded_for_item( $item_id ) ) {
														echo '<small class="refunded">-' . $refunded_qty . '</small>';
													}
													?>
												</div>
											</td>

											<td class="item_cost" width="1%">
												<div class="view">
													<?php
													if ( isset( $item['line_total'] ) ) {
														if ( isset( $item['line_subtotal'] ) && $item['line_subtotal'] != $item['line_total'] ) {
															echo '<del>' . wc_price( $order->get_item_subtotal( $item, false, true ), array( 'currency' => $order->get_order_currency() ) ) . '</del> ';
														}
														echo wc_price( $order->get_item_total( $item, false, true ), array( 'currency' => $order->get_order_currency() ) );
													}
													?>
												</div>
											</td>

											<td class="line_tax" width="1%"></td>
										</tr>
									</tbody>

									<tbody id="order_refunds">
										<?php foreach ( $commission->get_refunds() as $refund_id => $amount ) : $refund = new WC_Order_Refund( $refund_id ) ?>
										<tr class="refund Zero Rate">
											<td class="thumb"><div></div></td>

											<td class="name">
												<?php echo esc_attr__( 'Refund', 'woocommerce' ) . ' #' . absint( $refund->id ) . ' - ' . esc_attr( date_i18n( get_option( 'date_format' ) . ', ' . get_option( 'time_format' ), strtotime( $refund->post->post_date ) ) ); ?>
												<?php if ( $refund->get_refund_reason() ) : ?>
													<p class="description"><?php echo esc_html( $refund->get_refund_reason() ); ?></p>
												<?php endif; ?>
											</td>

											<td class="quantity" width="1%">&nbsp;</td>

											<td class="line_cost" width="1%">
												<div class="view">
													<?php echo wc_price( $amount ) ?>
												</div>
											</td>

											<td class="line_tax" width="1%"></td>
										</tr>
										<?php endforeach; ?>
									</tbody>

								</table>
							</div>

							<div class="wc-order-data-row wc-order-totals-items wc-order-items-editable">

								<?php
								$coupons = $order->get_items( array( 'coupon' ) );
								if ( $coupons ) {
									?>
									<div class="wc-used-coupons">
										<ul class="wc_coupon_list"><?php
											echo '<li><strong>' . __( 'Coupon(s) Used', 'woocommerce' ) . '</strong></li>';
											foreach ( $coupons as $item_id => $item ) {
												global $wpdb;
												$post_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_title = %s AND post_type = 'shop_coupon' AND post_status = 'publish' LIMIT 1;", $item['name'] ) );

                                                $link_before = $link_after = '';
                                                if ( current_user_can( 'manage_woocommerce' ) ) {
                                                    $link = $post_id ? esc_url( add_query_arg( array( 'post' => $post_id, 'action' => 'edit' ), admin_url( 'post.php' ) ) ) : add_query_arg( array( 's' => $item['name'], 'post_status' => 'all', 'post_type' => 'shop_coupon' ), admin_url( 'edit.php' ) );
                                                    $link_before = '<a href="' . esc_url( $link ) . '" class="tips" data-tip="' . esc_attr( wc_price( $item['discount_amount'], array( 'currency' => $order->get_order_currency() ) ) ) . '">';
                                                    $link_after = '</a>';
                                                }

												printf( '<li class="code">%s<span>' . esc_html( $item['name'] ). '</span>%s</li>', $link_before, $link_after );
											}
											?></ul>
									</div>
								<?php
								}
								?>

								<table class="wc-order-totals">
									<tbody>

										<tr>
											<td class="label"><?php _e( 'Rate', 'yith_wc_product_vendors' ) ?>:</td>
											<td class="total"><?php echo $commission->get_rate( 'display' ) ?></td>
											<td width="1%"></td>
										</tr>

										<tr>
											<td class="label"><?php _e( 'Commission', 'yith_wc_product_vendors' ) ?>:</td>
											<td class="total">
												<?php echo str_replace( array( '<span class="amount">', '</span>' ), '', wc_price( $commission->get_amount() + abs( $commission->get_refund_amount() ) ) ) ?>
											</td>
											<td width="1%"></td>
										</tr>

                                        <?php if ( $commission->get_refunds() ) : ?>
										<tr>
											<td class="label refunded-total">Refunded:</td>
											<td class="total refunded-total"><?php echo $commission->get_refund_amount( 'display' ) ?></td>
											<td width="1%"></td>
										</tr>
                                        <?php endif; ?>

										<tr>
											<td class="label">Total:</td>
											<td class="total"><?php echo $commission->get_amount( 'display' ) ?></td>
											<td width="1%"></td>
										</tr>

									</tbody>
								</table>
								<div class="clear"></div>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>

		<br class="clear">
	</div>

</div>