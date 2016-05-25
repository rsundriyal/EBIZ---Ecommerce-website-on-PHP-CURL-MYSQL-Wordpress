<?php
/**
 * Variable product add to cart
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Colors and Labels Variations
 * @version 1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $woocommerce, $product, $post;

$wc_attribute_label = function_exists('wc_attribute_label') ? 'wc_attribute_label' : 'attribute_label';

$name = isset( $name ) ? $name : '';
?>

<?php

do_action('woocommerce_before_add_to_cart_form');

if ( function_exists('wc_attribute_label') ) {
    $attribute_label = wc_attribute_label( $name );
} else {
    $attribute_label = $woocommerce->attribute_label( $name );
}

$attribute_keys = array_keys( $attributes );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>" data-wccl="true">
    <?php do_action( 'woocommerce_before_variations_form' ); ?>

    <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

        <p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

    <?php else : ?>

    <table class="variations" cellspacing="0">
        <tbody>
        <?php foreach ( $attributes as $name => $options ) : ?>

            <?php if ( version_compare( preg_replace( '/-beta-([0-9]+)/', '', $woocommerce->version ), '2.1', '<' ) ) : ?>
                <?php $wc_attribute_label_name = $woocommerce->$wc_attribute_label( $name ); ?>
            <?php else : ?>
                <?php $wc_attribute_label_name = $wc_attribute_label( $name ); ?>
            <?php endif; ?>

            <tr>
                <td class="label"><label for="<?php echo sanitize_title( $name ); ?>"><?php echo $wc_attribute_label_name; ?></label></td>
                <td class="value">
                    <select id="<?php echo esc_attr( sanitize_title($name) ); ?>" name="<?php echo 'attribute_' . esc_attr( sanitize_title( $name ) ) ?>" data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $name ) ) ?>" data-type="<?php echo $attributes_types[$name] ?>">
                        <option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
                        <?php
                        if (  ! empty( $options ) ) {

                            if ( version_compare( preg_replace( '/-beta-([0-9]+)/', '', $woocommerce->version ), '2.4', '<' ) ) {
                                if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
                                    $selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
                                } elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
                                    $selected_value = $selected_attributes[ sanitize_title( $name ) ];
                                } else {
                                    $selected_value = '';
                                }
                            } else {
                                $selected_value = isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) : $product->get_variation_default_attribute( $name );
                            }

                            // Get terms if this is a taxonomy - ordered
                            if ( $product && taxonomy_exists( $name ) ) {

                                if ( function_exists( 'wc_get_product_terms' ) ) {
                                    $terms = wc_get_product_terms( $post->ID, $name, array( 'fields' => 'all' ) );
                                } else {
                                    $terms = get_terms( $name, $args );
                                }

                                foreach ( $terms as $term ) {
                                    if ( ! in_array( $term->slug, $options ) ) {
                                        continue;
                                    }
                                    $value = get_woocommerce_term_meta( $term->term_id, $name . '_yith_wccl_value' );
                                    echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . ' data-value="'. $value .'">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                }

                            } else {

                                foreach ( $options as $option ) {
                                    // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
                                    $selected = sanitize_title( $selected_value ) === $selected_value ? selected( $selected_value, sanitize_title( $option ), false ) : selected( $selected_value, $option, false );
                                    echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
                                }

                            }
                        }
                        ?>
                    </select>

                    <?php echo end( $attribute_keys ) === $name ? '<a class="reset_variations" href="#">' . __( 'Clear selection', 'woocommerce' ) . '</a>' : ''; ?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

    <div class="single_variation_wrap" style="display:none;">
        <?php
        /**
         * woocommerce_before_single_variation Hook.
         */
        do_action( 'woocommerce_before_single_variation' );

        /**
         * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
         * @since 2.4.0
         * @hooked woocommerce_single_variation - 10 Empty div for variation data.
         * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
         */
        do_action( 'woocommerce_single_variation' );

        /**
         * woocommerce_after_single_variation Hook.
         */
        do_action( 'woocommerce_after_single_variation' );
        ?>
    </div>

    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
