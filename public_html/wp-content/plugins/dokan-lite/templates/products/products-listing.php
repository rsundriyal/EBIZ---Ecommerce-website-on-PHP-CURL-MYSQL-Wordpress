<?php global $post; ?>

<div class="dokan-dashboard-wrap">

    <?php

        /**
         *  dokan_dashboard_content_before hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
    ?>

    <div class="dokan-dashboard-content dokan-product-listing">

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_before' );
            do_action( 'dokan_before_listing_product' );
        ?>

        <article class="dokan-product-listing-area">

            <div class="product-listing-top dokan-clearfix">

                <?php dokan_product_listing_status_filter(); ?>

                <span class="dokan-add-product-link">
                    <a href="<?php echo dokan_get_navigation_url( 'new-product' ); ?>" class="dokan-btn dokan-btn-theme dokan-right"><i class="fa fa-briefcase">&nbsp;</i> <?php _e( 'Add new product', 'dokan' ); ?></a>
                </span>
            </div>

            <?php dokan_product_dashboard_errors(); ?>

            <div class="dokan-w12">
                <?php dokan_product_listing_filter(); ?>
            </div>

            <table class="dokan-table dokan-table-striped product-listing-table">
                <thead>
                    <tr>
                        <th><?php _e( 'Image', 'dokan' ); ?></th>
                        <th><?php _e( 'Name', 'dokan' ); ?></th>
                        <th><?php _e( 'Status', 'dokan' ); ?></th>
                        <th><?php _e( 'SKU', 'dokan' ); ?></th>
                        <th><?php _e( 'Stock', 'dokan' ); ?></th>
                        <th><?php _e( 'Price', 'dokan' ); ?></th>
                        <th><?php _e( 'Type', 'dokan' ); ?></th>
                        <th><?php _e( 'Views', 'dokan' ); ?></th>
                        <th><?php _e( 'Date', 'dokan' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;

                    $post_statuses = array('publish', 'draft', 'pending');
                    $args = array(
                        'post_type'      => 'product',
                        'post_status'    => $post_statuses,
                        'posts_per_page' => 10,
                        'author'         => get_current_user_id(),
                        'orderby'        => 'post_date',
                        'order'          => 'DESC',
                        'paged'          => $pagenum
                    );

                    if ( isset( $_GET['post_status']) && in_array( $_GET['post_status'], $post_statuses ) ) {
                        $args['post_status'] = $_GET['post_status'];
                    }

                    if( isset( $_GET['date'] ) && $_GET['date'] != 0 ) {
                        $args['m'] = $_GET['date'];
                    }

                    if( isset( $_GET['product_cat'] ) && $_GET['product_cat'] != -1 ) {
                        $args['tax_query']= array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'id',
                                'terms' => (int)  $_GET['product_cat'],
                                'include_children' => false,
                            )
                        );
                    }

                    if ( isset( $_GET['product_search_name']) && !empty( $_GET['product_search_name'] ) ) {
                        $args['s'] = $_GET['product_search_name'];
                    }


                    $original_post = $post;
                    $product_query = new WP_Query( apply_filters( 'dokan_product_listing_query', $args ) );

                    if ( $product_query->have_posts() ) {
                        while ($product_query->have_posts()) {
                            $product_query->the_post();

                            $tr_class = ($post->post_status == 'pending' ) ? ' class="danger"' : '';
                            $product = get_product( $post->ID );
                            ?>
                            <tr<?php echo $tr_class; ?>>
                                <td>
                                    <a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php echo $product->get_image(); ?></a>
                                </td>
                                <td>
                                    <p><a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php echo $product->get_title(); ?></a></p>

                                    <div class="row-actions">
                                        <span class="edit"><a href="<?php echo dokan_edit_product_url( $post->ID ); ?>"><?php _e( 'Edit', 'dokan' ); ?></a> | </span>
                                        <span class="delete"><a onclick="return confirm('Are you sure?');" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dokan-delete-product', 'product_id' => $post->ID ), dokan_get_navigation_url('products') ), 'dokan-delete-product' ); ?>"><?php _e( 'Delete Permanently', 'dokan' ); ?></a> | </span>
                                        <span class="view"><a href="<?php echo get_permalink( $product->ID ); ?>" rel="permalink"><?php _e( 'View', 'dokan' ); ?></a></span>
                                    </div>
                                </td>
                                <td class="post-status">
                                    <label class="dokan-label <?php echo $post->post_status; ?>"><?php echo dokan_get_post_status( $post->post_status ); ?></label>
                                </td>
                                <td>
                                    <?php
                                    if ( $product->get_sku() ) {
                                        echo $product->get_sku();
                                    } else {
                                        echo '<span class="na">&ndash;</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ( $product->is_in_stock() ) {
                                        echo '<mark class="instock">' . __( 'In stock', 'woocommerce' ) . '</mark>';
                                    } else {
                                        echo '<mark class="outofstock">' . __( 'Out of stock', 'woocommerce' ) . '</mark>';
                                    }

                                    if ( $product->managing_stock() ) :
                                        echo ' &times; ' . $product->get_total_stock();
                                    endif;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ( $product->get_price_html() ) {
                                        echo $product->get_price_html();
                                    } else {
                                        echo '<span class="na">&ndash;</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if( $product->product_type == 'grouped' ):
                                            echo '<span class="product-type tips grouped" title="' . __( 'Grouped', 'woocommerce' ) . '"></span>';
                                        elseif ( $product->product_type == 'external' ):
                                            echo '<span class="product-type tips external" title="' . __( 'External/Affiliate', 'woocommerce' ) . '"></span>';
                                        elseif ( $product->product_type == 'simple' ):

                                            if ( $product->is_virtual() ) {
                                                echo '<span class="product-type tips virtual" title="' . __( 'Virtual', 'woocommerce' ) . '"></span>';
                                            } elseif ( $product->is_downloadable() ) {
                                                echo '<span class="product-type tips downloadable" title="' . __( 'Downloadable', 'woocommerce' ) . '"></span>';
                                            } else {
                                                echo '<span class="product-type tips simple" title="' . __( 'Simple', 'woocommerce' ) . '"></span>';
                                            }

                                        elseif ( $product->product_type == 'variable' ):
                                            echo '<span class="product-type tips variable" title="' . __( 'Variable', 'woocommerce' ) . '"></span>';
                                        else:
                                            // Assuming that we have other types in future
                                            echo '<span class="product-type tips ' . $product->product_type . '" title="' . ucfirst( $product->product_type ) . '"></span>';
                                        endif;
                                    ?>
                                </td>
                                <td>
                                    <?php echo (int) get_post_meta( $post->ID, 'pageview', true ); ?>
                                </td>
                                <td class="post-date">
                                    <?php
                                    if ( '0000-00-00 00:00:00' == $post->post_date ) {
                                        $t_time = $h_time = __( 'Unpublished', 'dokan' );
                                        $time_diff = 0;
                                    } else {
                                        $t_time = get_the_time( __( 'Y/m/d g:i:s A', 'dokan' ) );
                                        $m_time = $post->post_date;
                                        $time = get_post_time( 'G', true, $post );

                                        $time_diff = time() - $time;

                                        if ( $time_diff > 0 && $time_diff < 24 * 60 * 60 ) {
                                            $h_time = sprintf( __( '%s ago', 'dokan' ), human_time_diff( $time ) );
                                        } else {
                                            $h_time = mysql2date( __( 'Y/m/d', 'dokan' ), $m_time );
                                        }
                                    }

                                    echo '<abbr title="' . $t_time . '">' . apply_filters( 'post_date_column_time', $h_time, $post, 'date', 'all' ) . '</abbr>';
                                    echo '<br />';
                                    if ( 'publish' == $post->post_status ) {
                                        _e( 'Published', 'dokan' );
                                    } elseif ( 'future' == $post->post_status ) {
                                        if ( $time_diff > 0 ) {
                                            echo '<strong class="attention">' . __( 'Missed schedule', 'dokan' ) . '</strong>';
                                        } else {
                                            _e( 'Scheduled', 'dokan' );
                                        }
                                    } else {
                                        _e( 'Last Modified', 'dokan' );
                                    }
                                    ?>
                                </td>
                            </tr>

                        <?php } ?>

                    <?php } else { ?>
                        <tr>
                            <td colspan="7"><?php _e( 'No product found', 'dokan' ); ?></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>

            <?php
            wp_reset_postdata();

            $pagenum      = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
            $base_url = dokan_get_navigation_url('products');

            if ( $product_query->max_num_pages > 1 ) {
                echo '<div class="pagination-wrap">';
                $page_links = paginate_links( array(
                    'current'   => $pagenum,
                    'total'     => $product_query->max_num_pages,
                    'base'      => $base_url. '%_%',
                    'format'    => '?pagenum=%#%',
                    'add_args'  => false,
                    'type'      => 'array',
                    'prev_text' => __( '&laquo; Previous', 'dokan' ),
                    'next_text' => __( 'Next &raquo;', 'dokan' )
                ) );

                echo '<ul class="pagination"><li>';
                echo join("</li>\n\t<li>", $page_links);
                echo "</li>\n</ul>\n";
                echo '</div>';
            }
            ?>
        </article>

        <?php

            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked get_dashboard_side_navigation
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_after' );
            do_action( 'dokan_after_listing_product' );
        ?>

    </div><!-- #primary .content-area -->

    <?php

        /**
         *  dokan_dashboard_content_after hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
    ?>

</div><!-- .dokan-dashboard-wrap -->
