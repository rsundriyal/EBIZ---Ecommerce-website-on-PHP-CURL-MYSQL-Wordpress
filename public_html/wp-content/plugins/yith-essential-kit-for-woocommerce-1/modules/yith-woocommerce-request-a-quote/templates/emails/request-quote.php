<?php
/**
 * HTML Template Email
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @author  Yithemes
 */
?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>

<p><?php printf( __( 'You received a quote request from %s. The request is the following:', 'yith-woocommerce-request-a-quote' ), $raq_data['user_name'] ); ?></p>

<?php do_action( 'yith_ywraq_email_before_raq_table', $raq_data ); ?>

<h2><?php _e('Request Quote', 'yith-woocommerce-request-a-quote') ?></h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
    <thead>
    <tr>
        <th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'yith-woocommerce-request-a-quote' ); ?></th>
        <th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'yith-woocommerce-request-a-quote' ); ?></th>
        <th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Subtotal', 'yith-woocommerce-request-a-quote' ); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if( ! empty( $raq_data['raq_content'] ) ):
        foreach( $raq_data['raq_content'] as $item ):
            if( isset( $item['variation_id']) ){
                $_product = wc_get_product( $item['variation_id'] );
            }else{
                $_product = wc_get_product( $item['product_id'] );
            }
            ?>
            <tr>
                <td scope="col" style="text-align:left;"><a href="<?php echo get_edit_post_link( $_product->id )?>"><?php echo $_product->post->post_title ?></a>
                 <?php  if( isset($item['variations'])): ?><small><?php echo yith_ywraq_get_product_meta($item); ?></small><?php endif ?></td>
                <td scope="col" style="text-align:left;"><?php echo $item['quantity'] ?></td>
                <td scope="col" style="text-align:left;"><?php  echo WC()->cart->get_product_subtotal( $_product, $item['quantity'] ); ?></td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>

<?php do_action( 'yith_ywraq_email_after_raq_table', $raq_data ); ?>
<?php if( ! empty( $raq_data['user_message']) ): ?>
<h2><?php _e( 'Customer message', 'yith-woocommerce-request-a-quote' ); ?></h2>
    <p><?php echo $raq_data['user_message'] ?></p>
<?php endif ?>
<h2><?php _e( 'Customer details', 'yith-woocommerce-request-a-quote' ); ?></h2>

<p><strong><?php _e( 'Name:', 'yith-woocommerce-request-a-quote' ); ?></strong> <?php echo $raq_data['user_name'] ?></p>
<p><strong><?php _e( 'Email:', 'yith-woocommerce-request-a-quote' ); ?></strong> <a href="mailto:<?php echo $raq_data['user_email']; ?>"><?php echo $raq_data['user_email']; ?></a></p>

<?php do_action( 'woocommerce_email_footer' ); ?>