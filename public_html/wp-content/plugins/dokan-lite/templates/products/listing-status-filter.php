<?php
/**
 * Dokan Dahsboard Product Listing status filter
 * Template
 *
 * @since 2.4
 *
 * @package dokan
 */
?>
<ul class="dokan-listing-filter dokan-left subsubsub">
    <li<?php echo $status_class == 'all' ? ' class="active"' : ''; ?>>
        <a href="<?php echo $permalink; ?>"><?php printf( __( 'All (%d)', 'dokan' ), $post_counts->total ); ?></a>
    </li>
    <li<?php echo $status_class == 'publish' ? ' class="active"' : ''; ?>>
        <a href="<?php echo add_query_arg( array( 'post_status' => 'publish' ), $permalink ); ?>"><?php printf( __( 'Online (%d)', 'dokan' ), $post_counts->publish ); ?></a>
    </li>
    <li<?php echo $status_class == 'pending' ? ' class="active"' : ''; ?>>
        <a href="<?php echo add_query_arg( array( 'post_status' => 'pending' ), $permalink ); ?>"><?php printf( __( 'Pending Review (%d)', 'dokan' ), $post_counts->pending ); ?></a>
    </li>
    <li<?php echo $status_class == 'draft' ? ' class="active"' : ''; ?>>
        <a href="<?php echo add_query_arg( array( 'post_status' => 'draft' ), $permalink ); ?>"><?php printf( __( 'Draft (%d)', 'dokan' ), $post_counts->draft ); ?></a>
    </li>
</ul> <!-- .post-statuses-filter -->
