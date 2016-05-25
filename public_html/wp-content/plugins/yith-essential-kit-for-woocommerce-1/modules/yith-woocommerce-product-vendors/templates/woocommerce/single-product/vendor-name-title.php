<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$label_color = 'color: ' . get_option( 'yith_vendors_color_name' );
?>

<span style="<?php echo $label_color ?>" class="by-vendor-name">
    <small>
        <?php echo __( 'by', 'yith_wc_product_vendors' ) . ' ' . $vendor->name ?>
    </small>
</span>