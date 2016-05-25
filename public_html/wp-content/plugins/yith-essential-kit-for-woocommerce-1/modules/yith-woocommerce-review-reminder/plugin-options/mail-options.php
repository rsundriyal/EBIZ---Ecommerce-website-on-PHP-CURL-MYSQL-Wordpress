<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

$query_args              = array(
    'page' => isset( $_GET['page'] ) ? $_GET['page'] : '',
    'tab'  => 'howto',
);
$howto_url               = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );
$placeholders_text       = __( 'Allowed placeholders:', 'yith-woocommerce-review-reminder' );
$ph_reference_link       = ' - <a href="' . $howto_url . '" target="_blank">' . __( 'More info', 'yith-woocommerce-review-reminder' ) . '</a>';
$ph_site_title           = ' <b>{site_title}</b>';
$ph_customer_name        = ' <b>{customer_name}</b>';
$ph_customer_email       = ' <b>{customer_email}</b>';
$ph_order_id             = ' <b>{order_id}</b>';
$ph_order_date           = ' <b>{order_date}</b>';
$ph_order_date_completed = ' <b>{order_date_completed}</b>';
$ph_order_list           = ' <b>{order_list}</b>';
$ph_days_ago             = ' <b>{days_ago}</b>';
$ph_unsubscribe_link     = ' <b>{unsubscribe_link}</b>';

return array(
    'mail' => array(
        'section_general_settings_videobox' => array(
            'name'    => __( 'Upgrade to the PREMIUM VERSION', 'yith-woocommerce-review-reminder' ),
            'type'    => 'videobox',
            'default' => array(
                'plugin_name'               => __( 'YITH WooCommerce Review Reminder', 'yith-woocommerce-review-reminder' ),
                'title_first_column'        => __( 'Discover the Advanced Features', 'yith-woocommerce-review-reminder' ),
                'description_first_column'  => __( 'Upgrade to the PREMIUM VERSION of YITH WooCommerce Review Reminder to benefit from all features!', 'yith-woocommerce-review-reminder' ),
                'video'                     => array(
                    'video_id'          => '118824650',
                    'video_image_url'   => YWRR_ASSETS_URL . '/images/yith-woocommerce-review-reminder.jpg',
                    'video_description' => __( 'YITH WooCommerce Review Reminder', 'yith-woocommerce-review-reminder' ),
                ),
                'title_second_column'       => __( 'Get Support and Pro Features', 'yith-woocommerce-review-reminder' ),
                'description_second_column' => __( 'By purchasing the premium version of the plugin, you will take advantage of the advanced features of the product and you will get one year of free updates and support through our platform available 24h/24.', 'yith-woocommerce-review-reminder' ),
                'button'                    => array(
                    'href'  => YITH_WRR()->get_premium_landing_uri(),
                    'title' => 'Get Support and Pro Features'
                )
            ),
            'id'      => 'ywrr_general_videobox'
        ),

        'review_reminder_general_title'         => array(
            'name' => __( 'General Settings', 'yith-woocommerce-review-reminder' ),
            'type' => 'title',
            'desc' => '',
        ),
        'review_reminder_general_enable_plugin' => array(
            'name'    => __( 'Enable YITH WooCommerce Review Reminder', 'yith-woocommerce-review-reminder' ),
            'type'    => 'checkbox',
            'desc'    => '',
            'id'      => 'ywrr_enable_plugin',
            'default' => 'yes',
        ),
        'review_reminder_general_end'           => array(
            'type' => 'sectionend',
        ),

        'review_reminder_mail_section_title'    => array(
            'name' => __( 'Mail Settings', 'yith-woocommerce-review-reminder' ),
            'type' => 'title',
            'desc' => '',
        ),
        'review_reminder_mail_type'             => array(
            'name'    => __( 'Email type', 'yith-woocommerce-review-reminder' ),
            'type'    => 'select',
            'desc'    => __( 'Choose which format of email to send.', 'yith-woocommerce-review-reminder' ),
            'options' => array(
                'html'  => __( 'HTML', 'yith-woocommerce-review-reminder' ),
                'plain' => __( 'Plain text', 'yith-woocommerce-review-reminder' )
            ),
            'default' => 'html',
            'id'      => 'ywrr_mail_type'
        ),
        'review_reminder_mail_subject'          => array(
            'name'              => __( 'Email subject', 'yith-woocommerce-review-reminder' ),
            'type'              => 'text',
            'desc'              => $placeholders_text . $ph_site_title . $ph_reference_link,
            'id'                => 'ywrr_mail_subject',
            'default'           => __( '[{site_title}] Review recently purchased products', 'yith-woocommerce-review-reminder' ),
            'css'               => 'width: 400px;',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'review_reminder_mail_body'             => array(
            'name'              => __( 'Email content', 'yith-woocommerce-review-reminder' ),
            'type'              => 'yith-wc-textarea',
            'desc'              => $placeholders_text . $ph_site_title . $ph_customer_name . $ph_customer_email . $ph_order_id . $ph_order_date . $ph_order_date_completed . $ph_order_list . $ph_days_ago . $ph_unsubscribe_link . $ph_reference_link,
            'id'                => 'ywrr_mail_body',
            'default'           => __( 'Hello {customer_name},
Thank you for purchasing items from the {site_title} shop!
We would love if you could help us and other customers by reviewing the products you recently purchased.
It only takes a minute and it would really help others by giving them an idea of your experience.
Click the link below for each product and review the product under the \'Reviews\' tab.

{order_list}

Much appreciated,

{site_title}.


{unsubscribe_link}', 'yith-woocommerce-review-reminder' ),
            'class'             => 'ywrr-textarea',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'review_reminder_mail_unsubscribe_text' => array(
            'name'              => __( 'Review unsubscription text', 'yith-woocommerce-review-reminder' ),
            'type'              => 'text',
            'desc'              => '',
            'id'                => 'ywrr_mail_unsubscribe_text',
            'default'           => __( 'Unsubscribe from review emails', 'yith-woocommerce-review-reminder' ),
            'css'               => 'width: 400px;',
            'custom_attributes' => array(
                'required' => 'required'
            )
        ),
        'review_reminder_mail_test'             => array(
            'name'     => __( 'Test email', 'yith-woocommerce-review-reminder' ),
            'type'     => 'ywrr-send',
            'field_id' => 'ywrr_email_test',
        ),
        'review_reminder_mail_section_end'      => array(
            'type' => 'sectionend',
        )
    )

);