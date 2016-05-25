<?php
/*
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if (!defined('ABSPATH')) {
    exit('Direct access forbidden.');
}

global $YWAR_AdvancedReview;

if (!class_exists('YITH_Advanced_Reviews_List_Table')) {
    /**
     *
     *
     * @class class.yith-advanced-reviews-list-table.php
     * @package    Yithemes
     * @since      Version 1.0.0
     * @author     Your Inspiration Themes
     *
     */
    class YITH_Advanced_Reviews_List_Table extends WP_List_Table
    {
        /**
         * @var object store the Advanced reviews class object, used as shortcut to full singleton name
         */
        private $ywar;


        /**
         * Construct
         */
        public function __construct()
        {
            global $YWAR_AdvancedReview;

            $this->ywar = $YWAR_AdvancedReview;
            //Set parent defaults
            parent::__construct(array(
                    'singular' => 'review', //singular name of the listed records
                    'plural' => 'reviews', //plural name of the listed records
                    'ajax' => false //does this table support ajax?
                )
            );
        }

        /**
         * Returns columns available in table
         *
         * @return array Array of columns of the table
         * @since 1.0.0
         */
        public function get_columns()
        {
            $columns = array(
                'cb' => '<input type="checkbox" />',
                $this->ywar->custom_column_review => __('Review', 'yith-woocommerce-advanced-reviews'),
                $this->ywar->custom_column_author => __('Author', 'yith-woocommerce-advanced-reviews'),
                $this->ywar->custom_column_date => __('Date', 'yith-woocommerce-advanced-reviews'),
                $this->ywar->custom_column_rating => __('Rate', 'yith-woocommerce-advanced-reviews'),
                $this->ywar->custom_column_product => __('Product', 'yith-woocommerce-advanced-reviews')
            );

            return apply_filters('yith_advanced_reviews_custom_column', $columns);
        }


        /**
         * Generate row actions div
         *
         * @since 3.1.0
         * @access protected
         *
         * @param array $actions The list of actions
         * @param bool $always_visible Whether the actions should be always visible
         *
         * @return string
         */
        protected function row_actions($actions, $always_visible = false)
        {
            $action_count = count($actions);
            $i = 0;

            if (!$action_count) {
                return '';
            }

            $out = '<div class="' . ($always_visible ? 'row-actions visible' : 'row-actions') . '">';
            foreach ($actions as $action => $link) {
                ++$i;
                ($i == $action_count) ? $sep = '' : $sep = ' | ';
                $out .= "<span class='$action'>$link$sep</span>";
            }
            $out .= '</div>';

            return $out;
        }

        /**
         * Get a parameter array to be passed to get_posts
         *
         * @param $args parameters for filtering the review list
         * 'page' => 0 = show all, any positive value ask for paginated results
         * 'post_status' => 'all', //value are all, publish,future...
         * 'post_parent' => -1, //-1 stands for all post parent, any non negative value is intended as a specifici parent
         * 'review_status' => 'all',
         * 'items_for_page => 0 = show all on 1 page, any positive value is the number of items to show
         */
        private function get_params_for_current_view($args)
        {
            //  Start the filters array, selecting the review post type
            $params = array(
                'post_type' => 'ywar_reviews',
                'suppress_filters' => false
            );

            //  Show a single page or all items
            $params['numberposts'] = -1;
            if (isset($args['page']) && ($args['page'] > 0) && isset($args['items_for_page']) && ($args['items_for_page'] > 0)) {

                //  set number of posts and offset
                $current_page = $args['page'];
                $items_for_page = $args['items_for_page'];
                $offset = ($current_page * $items_for_page) - $items_for_page;
                $params['offset'] = $offset;
                $params['numberposts'] = $items_for_page;


            } else {
                $params['offset'] = 0;
            }

            //  Choose post status
            if (isset($args['post_status']) && ("all" != $args['post_status'])) {
                $params['post_status'] = $args['post_status'];
            }

            if (isset($args['post_parent']) && ($args['post_parent'] >= 0)) {
                $params['post_parent'] = $args['post_parent'];
            }

            $order = isset($args['order']) ? $args['order'] : 'DESC';
            $params['order'] = $order;

            if (isset($args['orderby'])) {
                switch ($order_by = $args['orderby']) {
                    case $this->ywar->custom_column_rating :
                        $params['meta_key'] = $this->ywar->meta_key_rating;
                        $params['orderby'] = 'meta_value_num';
                        break;

                    case $this->ywar->custom_column_date :
                        $params['orderby'] = 'post_date';
                        break;

                    default :
                        $params = apply_filters("yith_advanced_reviews_column_sort", $params, $order_by);
                }
            }

            if (isset($args['review_status'])) {

                switch ($args['review_status']) {
                    case 'all' :
                        break;

                    case 'trash' :
                        $params['post_status'] = 'trash';

                        break;

                    case 'not_approved' :
                        $params['meta_query'][] = array(
                            'key' => $this->ywar->meta_key_approved,
                            'value' => 1,
                            'compare' => '!=',
                            'type' => 'numeric'
                        );
                        break;

                    default :
                        $params = apply_filters('yith_advanced_reviews_filter_view', $params, $args['review_status']);
                }
            }

            return $params;
        }

        public function filter_reviews_by_search_term($where)
        {
            $filter_content = isset($_GET["s"]) ? $_GET["s"] : '';
            $terms = explode("+", $filter_content);
            global $wpdb;
            $where_clause = '';
            foreach ($terms as $term) {
                if (!empty($where_clause)) {
                    $where_clause .= " OR ";
                }
                $where_clause .= "( {$wpdb->prefix}posts.post_content LIKE '%$term%' ) or ({$wpdb->prefix}posts.post_title like '%$term%') ";
            }

            $where = "$where AND ($where_clause)";

            return $where;
        }

        /**
         * Perform custom bulk actions, if there are some
         */
        public function process_bulk_action()
        {
            switch ($this->current_action()) {

                case 'untrash' :
                    foreach ($_GET['reviews'] as $review_id) {
                        $my_post = array(
                            'ID' => $review_id,
                            'post_status' => 'publish'
                        );

                        // Update the post into the database
                        wp_update_post($my_post);
                    }

                    break;

                case 'trash' :
                    foreach ($_GET['reviews'] as $review_id) {
                        $my_post = array(
                            'ID' => $review_id,
                            'post_status' => 'trash'
                        );

                        // Update the post into the database
                        wp_update_post($my_post);
                    }

                    break;

                case 'delete' :
                    foreach ($_GET['reviews'] as $review_id) {
                        wp_delete_post($review_id);
                    }

                    break;

                case 'approve' :
                    foreach ($_GET['reviews'] as $review_id) {
                        update_post_meta($review_id, $this->ywar->meta_key_approved, 1);
                    }

                    break;

                case 'unapprove' :
                    foreach ($_GET['reviews'] as $review_id) {
                        update_post_meta($review_id, $this->ywar->meta_key_approved, 0);
                    }

                    break;

                default :
                    if (isset($_GET['reviews'])) {
                        do_action('yith_advanced_reviews_process_bulk_actions', $this->current_action(), $_GET['reviews']);
                    }
            }
        }

        /**
         * Prepare items for table
         *
         * @return void
         * @since 1.0.0
         */
        public function prepare_items()
        {
            $this->process_bulk_action();

            // sets pagination arguments
            $current_page = absint($this->get_pagenum());

            // sets columns headers
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();
            $this->_column_headers = array($columns, $hidden, $sortable);

            $review_status = isset($_GET["status"]) ? $_GET["status"] : 'all';
            $orderby = isset($_GET["orderby"]) ? $_GET["orderby"] : '';
            $order = isset($_GET["order"]) ? $_GET["order"] : 'desc';

            //  Start the filters array, selecting the review post type
            $params = array(
                'post_type' => 'ywar_reviews',
                'items_for_page' => $this->ywar->items_for_page,
                'review_status' => $review_status,
                'orderby' => $orderby,
                'order' => $order
            );

            //  retrieve the number of items for the current filters
            $args = $this->get_params_for_current_view($params);
            $args['fields'] = 'ids';
            $total_items = count(get_posts($args));

            //  retrieve only a page for the current filter
            $params['page'] = $current_page;
            $args = $this->get_params_for_current_view($params);

            $filter_content = isset($_GET["s"]) ? $_GET["s"] : '';
            if (!empty($filter_content)) {
                //  Add a filter to alter WHERE clause on following get_posts call
                add_filter('posts_where', array($this, 'filter_reviews_by_search_term'));
            }

            $this->items = get_posts($args);

            //remove the previous filter, not needed anymore
            remove_filter('posts_where', array($this, 'filter_reviews_by_search_term'));

            $total_pages = ceil($total_items / $this->ywar->items_for_page);

            // Set the pagination
            $this->set_pagination_args(array(
                'total_items' => $total_items,
                'per_page' => $this->ywar->items_for_page,
                'total_pages' => $total_pages
            ));
        }


        /**
         * Decide which columns to activate the sorting functionality on
         * @return array $sortable, the array of columns that can be sorted by the user
         */
        public function get_sortable_columns()
        {

            $columns = array(

                $this->ywar->custom_column_rating => array($this->ywar->custom_column_rating, false),
                $this->ywar->custom_column_date => array($this->ywar->custom_column_date, false),
            );

            return apply_filters('yith_advanced_reviews_sortable_custom_columns', $columns);
        }

        /**
         * Sets bulk actions for table
         *
         * @return array Array of available actions
         * @since 1.0.0
         */
        public function get_bulk_actions()
        {
            $actions = array();

            $actions['untrash'] = __('Restore', 'yith-woocommerce-advanced-reviews');
            $actions['trash'] = __('Move to bin', 'yith-woocommerce-advanced-reviews');

            $actions['delete'] = __('Delete permanently', 'yith-woocommerce-advanced-reviews');
            $actions['approve'] = __('Approve reviews', 'yith-woocommerce-advanced-reviews');
            $actions['unapprove'] = __('Unapprove reviews', 'yith-woocommerce-advanced-reviews');

            return apply_filters('yith_advanced_reviews_bulk_actions', $actions);
        }

        /**
         * Extra controls to be displayed between bulk actions and pagination
         *
         * @since 3.1.0
         * @access protected
         */
        protected function get_views()
        {
            $views = array(
                'all' => __('All', 'yith-woocommerce-advanced-reviews'),
                'trash' => __('Bin', 'yith-woocommerce-advanced-reviews'),
                'not_approved' => __('Not approved', 'yith-woocommerce-advanced-reviews')
            );

            $views = apply_filters('yith_advanced_reviews_table_views', $views);

            $current_view = $this->get_current_view();
            $args = array('status' => 0);

            $args['user_id'] = get_current_user_id();

            // merge Unpaid with Processing
            //$views['unpaid'] .= '/' . $views['processing'];
            unset($views['processing']);

            foreach ($views as $id => $view) {
                //  number of items for the view

                $args = $this->get_params_for_current_view(array(
                    'review_status' => $id
                ));
                $args['fields'] = 'ids';

                //  retrieve the number of items for the current filters
                $total_items = count(get_posts($args));

                $href = esc_url(add_query_arg('status', $id));
                $class = $id == $current_view ? 'current' : '';
                $args['status'] = 'unpaid' == $id ? array($id, 'processing') : $id;
                $views[$id] = sprintf("<a href='%s' class='%s'>%s <span class='count'>(%d)</span></a>", $href, $class, $view, $total_items);
            }

            return $views;
        }

        /**
         * Print the columns information
         *
         * @param $review
         * @param $column_name
         *
         * @return string
         */
        public function column_default($review, $column_name)
        {

            switch ($column_name) {

                case $this->ywar->custom_column_review:

                    $post = get_post($review->ID);
                    if (empty($post->post_title) && empty($post->post_content)) {
                        return;
                    }

                    $edit_link = get_edit_post_link($review->ID);
                    echo '<a class="row-title" href="' . $edit_link . '">';

                    if (!empty($post->post_title)) {

                        echo '<span class="review-title">' . wc_trim_string($post->post_title, 80) . '</span>';
                        echo "<br>";
                    }

                    if (!empty($post->post_content)) {

                        echo '<span class="review-content">' . wc_trim_string($post->post_content, 80) . '</span>';
                    }

                    echo '</a>';

                    $post_type_object = get_post_type_object($this->ywar->post_type_name);

                    if ('trash' == $post->post_status) {
                        $actions['untrash'] = "<a title='" . esc_attr__('Restore this item from the bin') . "' href='" . $this->ywar->untrash_review_url($post) . "'>" . __('Restore') . "</a>";
                    } elseif (EMPTY_TRASH_DAYS) {
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr__('Move this item to the bin') . "' href='" . get_delete_post_link($post->ID) . "'>" . __('Bin') . "</a>";
                    }
                    if ('trash' == $post->post_status || !EMPTY_TRASH_DAYS) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr__('Delete this item permanently') . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . __('Delete permanently') . "</a>";
                    }

                    $actions = apply_filters('yith_advanced_reviews_row_actions', $actions, $post);

                    echo $this->row_actions($actions);


                    break;

                case $this->ywar->custom_column_rating:
                    if (0 == $review->post_parent) {
                        $rating = get_post_meta($review->ID, $this->ywar->meta_key_rating, true);

                        echo '<div class="woocommerce">
<div class="star-rating" title="' . sprintf(__("Rated %d out of 5", 'yith-woocommerce-advanced-reviews'), $rating) . '">
<span style="width:' . (($rating / 5) * 100) . '%"><strong>' . $rating . '</strong>' . __("out of 5", 'yith-woocommerce-advanced-reviews') . ' </span>
</div>
</div>';
                    }

                    break;

                case $this->ywar->custom_column_product:

                    $product_id = get_post_meta($review->ID, $this->ywar->meta_key_product_id, true);

                    echo get_the_title($product_id) . "<br>";

                    if (current_user_can('edit_post', $product_id)) {
                        echo "<a class='edit-product-review' href='" . get_edit_post_link($product_id) . "'>" . __("Edit", 'yith-woocommerce-advanced-reviews') . '</a>';
                    }

                    echo "<a class='view-product-review' href='" . get_permalink($product_id) . "' target='_blank'>" . __("View", 'yith-woocommerce-advanced-reviews') . '</a>';

                    break;

                case $this->ywar->custom_column_author:
                    if ($review->post_author) {
                        $user = get_userdata($review->post_author);
                        $author_name = $user ? $user->display_name : __('Anonymous', 'yith-woocommerce-advanced-reviews');
                    } else {
                        $user = yit_get_post_meta($review->ID, $this->ywar->meta_key_review_author);

                        if ($user) {
                            $author_name = $user ? $user : __('Anonymous', 'yith-woocommerce-advanced-reviews');
                        }
                    }

                    echo $author_name;

                    break;

                case $this->ywar->custom_column_date:
                    $t_time = get_the_time(__('Y/m/d g:i:s a'));
                    $m_time = $review->post_date;
                    $time = get_post_time('G', true, $review);

                    $time_diff = time() - $time;

                    if ($time_diff > 0 && $time_diff < DAY_IN_SECONDS) {
                        $h_time = sprintf(__('%s ago'), human_time_diff($time));
                    } else {
                        $h_time = mysql2date(__('Y/m/d'), $m_time);
                    }

                    echo '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
                    break;

                default :
                    do_action('yith_advanced_reviews_show_advanced_reviews_columns', $column_name, $review->ID);
            }

            return null;
        }

        /**
         * Prints column cb
         *
         * @param $rec Object Item to use to print CB record
         *
         * @return string
         * @since 1.0.0
         */
        public function column_cb($rec)
        {

            return sprintf(
                '<input type="checkbox" name="%1$s[]" value="%2$s" />',
                $this->_args['plural'], //Let's simply repurpose the table's plural label
                $rec->ID //The value of the checkbox should be the record's id
            );
        }

        /**
         * Message to be displayed when there are no items
         *
         * @since 3.1.0
         * @access public
         */
        public function no_items()
        {
            _e('No reviews found.', 'yith-woocommerce-advanced-reviews');
        }


        /**
         * Extra controls to be displayed between bulk actions and pagination
         *
         * @since  1.0.0
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         *
         * @return string The view name
         */
        public function get_current_view()
        {
            return empty($_GET['status']) ? 'all' : $_GET['status'];
        }

        /**
         * Generate the table navigation above or below the table
         *
         * @since 3.1.0
         * @access protected
         *
         * @param string $which
         */
        protected function display_tablenav($which)
        {
            if ('top' == $which) {
                wp_nonce_field('bulk-' . $this->_args['plural']);
            }
            ?>
            <div class="tablenav <?php echo esc_attr($which); ?>">

                <div class="alignleft actions bulkactions">
                    <?php $this->bulk_actions($which); ?>
                </div>
                <?php
                $this->extra_tablenav($which);
                $this->pagination($which);
                ?>

                <br class="clear"/>
            </div>
            <?php
        }

        /**
         * Generates content for a single row of the table
         *
         * @since 3.1.0
         * @access public
         *
         * @param object $item The current item
         */
        public function single_row($item)
        {
            $approved = 1 == get_post_meta($item->ID, $this->ywar->meta_key_approved, true);
            if (!$approved) {
                echo '<tr class="review-unapproved">';
            } else {
                echo '<tr>';
            }

            $this->single_row_columns($item);
            echo '</tr>';
        }
    }
}

