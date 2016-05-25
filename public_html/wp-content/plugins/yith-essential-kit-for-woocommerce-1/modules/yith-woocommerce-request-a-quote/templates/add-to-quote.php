<?php
/**
 * Add to Quote button template
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @author  Yithemes
 */
?>

<div class="yith-ywraq-add-to-quote add-to-quote-<?php echo $product_id ?>">
    <div class="yith-ywraq-add-button <?php echo ( $exists ) ? 'hide': 'show' ?>" style="display:<?php echo ( $exists ) ? 'none': 'block' ?>">
        <?php wc_get_template( 'add-to-quote-' . $template_part . '.php', $args, YITH_YWRAQ_DIR, YITH_YWRAQ_DIR );  ?>
    </div>
    <?php if( $exists ): ?>
        <div class="yith_ywraq_add_item_response-<?php echo $product_id ?> yith_ywraq_add_item_response_message"><?php echo apply_filters( 'ywraq_product_in_list', __('The product is already in quote request list!', 'yith-woocommerce-request-a-quote') )?></div>
        <div class="yith_ywraq_add_item_browse-list-<?php echo $product_id ?> yith_ywraq_add_item_browse_message"><a href="<?php echo  $rqa_url ?>"><?php echo $label_browse ?></a></div>
    <?php endif ?>
</div>

<div class="clear"></div>
