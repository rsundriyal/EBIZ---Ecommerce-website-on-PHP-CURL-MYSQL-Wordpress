<?php 
global $wp_query;
$options = get_option('br_lgv_liststyle_option'); 
?>
<div class="berocket_lgv_additional_data">
    <?php
    do_action( 'lgv_simple_before' );
    ?>
    <a class="<?php echo ( ( @ $options['button']['lgv_link_simple']['custom_class'] ) ? $options['button']['lgv_link_simple']['custom_class'] : 'lgv_link lgv_link_simple' ) ?>" href="<?php the_permalink(); ?>">
        <h3><?php the_title(); ?></h3>
    </a>
    <?php
    do_action( 'lgv_simple_after_product_name' );
    ?>
    <div class="<?php echo ( ( @ $options['button']['lgv_description_simple']['custom_class'] ) ? $options['button']['lgv_description_simple']['custom_class'] : 'lgv_description lgv_description_simple' ) ?>">
        <?php
        woocommerce_template_single_excerpt();
        ?>
    </div>
    <?php
    do_action( 'lgv_simple_after_description' );
    ?>
    <div class="<?php echo ( ( @ $options['button']['lgv_meta_simple']['custom_class'] ) ? $options['button']['lgv_meta_simple']['custom_class'] : 'lgv_meta lgv_meta_simple' ) ?>">
        <?php
        woocommerce_template_single_meta();
        ?>
    </div>
    <?php
    do_action( 'lgv_simple_after_meta' );
    ?>
    <div class="<?php echo ( ( @ $options['button']['lgv_price_simple']['custom_class'] ) ? $options['button']['lgv_price_simple']['custom_class'] : 'lgv_price lgv_price_simple' ) ?>">
        <?php
        woocommerce_template_loop_price();
        ?>
    </div>
    <?php
    do_action( 'lgv_simple_after' );
    ?>
    <script>
        jQuery(document).ready( function () {
            br_lgv_style_set();
        });
    </script>
</div>