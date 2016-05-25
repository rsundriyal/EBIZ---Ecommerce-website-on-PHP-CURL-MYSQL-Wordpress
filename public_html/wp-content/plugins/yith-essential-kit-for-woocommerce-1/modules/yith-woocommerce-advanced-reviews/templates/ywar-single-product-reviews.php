<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly


global $review_stats;
global $product;
?>

<div id="reviews_summary">
    <h3><?php _e('Customers\' review', 'yith-woocommerce-advanced-reviews') ?></h3>

    <?php do_action('ywar_summary_prepend', $product) ?>

    <div class="reviews_bar">

        <?php for ($i = 5; $i >= 1; $i--) :
            $perc = ($review_stats['total'] == '0') ? 0 : floor($review_stats[$i] / $review_stats['total'] * 100);
            ?>

            <div class="ywar_review_row">
                <?php do_action('ywar_summary_row_prepend', $i, $product->id) ?>

                <span
                    class="ywar_stars_value"><?php printf(_n('%s star', '%s stars', $i, 'yith-woocommerce-advanced-reviews'), $i); ?></span>
                <span class="ywar_num_reviews"><?php echo $review_stats[$i]; ?></span>
				<span class="ywar_rating_bar">
					<span style="background-color:<?php echo get_option('ywar_summary_bar_color'); ?>"
                          class="ywar_scala_rating">
						<span class="ywar_perc_rating"
                              style="width: <?php echo $perc; ?>%; background-color:<?php echo get_option('ywar_summary_percentage_bar_color'); ?>">
							<?php if ('yes' == get_option('ywar_summary_percentage_value')) : ?>
                                <span style="color:<?php echo get_option('ywar_summary_percentage_value_color'); ?>"
                                      class="ywar_perc_value"><?php printf('%s %%', $perc); ?></span>
                            <?php endif; ?>
						</span>
					</span>
				</span>

                <?php do_action('ywar_summary_row_append', $i, $product->id) ?>
            </div>
        <?php endfor; ?>
    </div>

    <?php do_action('ywar_summary_append') ?>

    <div id="reviews_header">
        <?php do_action('ywar_reviews_header', $review_stats) ?>
    </div>
</div>



