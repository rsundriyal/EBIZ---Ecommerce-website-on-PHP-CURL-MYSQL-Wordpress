<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
?>

<style>
    .section {
        margin-left: -20px;
        margin-right: -20px;
        font-family: "Raleway", san-serif;
    }

    .section h1 {
        text-align: center;
        text-transform: uppercase;
        color: #808a97;
        font-size: 35px;
        font-weight: 700;
        line-height: normal;
        display: inline-block;
        width: 100%;
        margin: 50px 0 0;
    }

    .section:nth-child(even) {
        background-color: #fff;
    }

    .section:nth-child(odd) {
        background-color: #f1f1f1;
    }

    .section .section-title img {
        display: table-cell;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }

    .section h2,
    .section h3 {
        display: inline-block;
        vertical-align: middle;
        padding: 0;
        font-size: 24px;
        font-weight: 700;
        color: #808a97;
        text-transform: uppercase;
    }

    .section .section-title h2 {
        display: table-cell;
        vertical-align: middle;
        line-height: 24px;
    }

    .section-title {
        display: table;
    }

    .section h3 {
        font-size: 14px;
        line-height: 28px;
        margin-bottom: 0;
        display: block;
    }

    .section p {
        font-size: 13px;
        margin: 25px 0;
    }

    .section ul li {
        margin-bottom: 4px;
    }

    .landing-container {
        max-width: 750px;
        margin-left: auto;
        margin-right: auto;
        padding: 50px 0 30px;
    }

    .landing-container:after {
        display: block;
        clear: both;
        content: '';
    }

    .landing-container .col-1,
    .landing-container .col-2 {
        float: left;
        box-sizing: border-box;
        padding: 0 15px;
    }

    .landing-container .col-1 img {
        width: 100%;
    }

    .landing-container .col-1 {
        width: 55%;
    }

    .landing-container .col-2 {
        width: 45%;
    }

    .premium-cta {
        background-color: #808a97;
        color: #fff;
        border-radius: 6px;
        padding: 20px 15px;
    }

    .premium-cta:after {
        content: '';
        display: block;
        clear: both;
    }

    .premium-cta p {
        margin: 7px 0;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        width: 60%;
    }

    .premium-cta a.button {
        border-radius: 6px;
        height: 60px;
        float: right;
        background: url('<?php echo YITH_WPV_URL?>assets/images/upgrade.png') #ff643f no-repeat 13px 13px;
        border-color: #ff643f;
        box-shadow: none;
        outline: none;
        color: #fff;
        position: relative;
        padding: 9px 50px 9px 70px;
    }

    .premium-cta a.button:hover,
    .premium-cta a.button:active,
    .premium-cta a.button:focus {
        color: #fff;
        background: url(<?php echo YITH_WPV_URL?>assets/images/upgrade.png) #971d00 no-repeat 13px 13px;
        border-color: #971d00;
        box-shadow: none;
        outline: none;
    }

    .premium-cta a.button:focus {
        top: 1px;
    }

    .premium-cta a.button span {
        line-height: 13px;
    }

    .premium-cta a.button .highlight {
        display: block;
        font-size: 20px;
        font-weight: 700;
        line-height: 20px;
    }

    .premium-cta .highlight {
        text-transform: uppercase;
        background: none;
        font-weight: 800;
        color: #fff;
    }

    @media (max-width: 768px) {
        .section {
            margin: 0
        }

        .premium-cta p {
            width: 100%;
        }

        .premium-cta {
            text-align: center;
        }

        .premium-cta a.button {
            float: none;
        }
    }

    @media (max-width: 480px) {
        .wrap {
            margin-right: 0;
        }

        .section {
            margin: 0;
        }

        .landing-container .col-1,
        .landing-container .col-2 {
            width: 100%;
            padding: 0 15px;
        }

        .section-odd .col-1 {
            float: left;
            margin-right: -100%;
        }

        .section-odd .col-2 {
            float: right;
            margin-top: 65%;
        }
    }

    @media (max-width: 320px) {
        .premium-cta a.button {
            padding: 9px 20px 9px 70px;
        }

        .section .section-title img {
            display: none;
        }
    }
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __( 'Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Multi Vendor%2$s to benefit from all features!', 'yith_wc_product_vendors' ), '<span class="highlight">', '</span>' ); ?>
                </p>
                <a href="<?php echo YITH_Vendors()->admin->get_premium_landing_uri(); ?>" target="_blank"
                   class="premium-cta-button button btn">
                    <?php echo sprintf( __( '%1$s UPGRADE %2$s %3$s to the premium version %2$s', 'yith_wc_product_vendors' ),'<span class="highlight">', '</span>', '<span>' ); ?>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1><?php echo _e('Premium Features','yith_wc_product_vendors');?></h1>

        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/01.png" alt="Socials icon"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/01-icon.png" alt="Vendor shop page"/>
                    <h2><?php echo _e('A richer vendor shop page','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('The vendor page gets more details!Vendors will be able to add their %s contact details %s (email, address, phone number) and the most common social network profiles (Facebook, Twitter, Google+, LinkedIn and YouTube)','yith_wc_product_vendors'),'<b>','</b>')  ?>
                </p>
                <p>
                    <?php  echo sprintf(__('These pieces of information are gathered in the page of every vendor shop with a %sheader%s where style and images can be customized.','yith_wc_product_vendors'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/02-icon.png" alt="admin shop"/>
                    <h2><?php echo _e('One or more administrators for every vendor shop','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('The administrators of the vendor shop are one of the most important new features.%s They are simple registered users of the shop that have been admitted to %smanage the products%s and all the information about a vendor shop by the administrator of the store or the owner of the vendor shop.','yith_wc_product_vendors'),'<br>','<b>','</b>');?>
                </p>
                <p>
                    <?php echo sprintf( __('The only element they can\'t change is the %stype of payment%s that only administrator of the store or the owner of the vendor shop can set.','yith_wc_product_vendors'),'<b>','</b>'); ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/02.png" alt="icon"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/03.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/03-icon.png" alt="product sale"/>
                    <h2><?php _e('Direct product sale','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Thanks to the %s"Skip Admin review"%s option, vendors can publish new products without the store administrator approval. This option can be applied to all the vendor shops, or just to the selected ones.', 'yith_wc_product_vendors' ), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/04-icon.png" alt="Actions"/>
                    <h2><?php _e('Actions for commissions','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e('A commissions table with more details to be always up-to-date. Every commission offers a set of buttons to quickly proceed to the PayPal payments (if set as manual), or to change the state of the commission.','yith_wc_product_vendors'); ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/04.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/05-bg.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/05.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/05-icon.png" alt="Commission rate"/>
                    <h2><?php _e('Variable commission rates','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('%sNo more single commission rate for all the vendor shops:%s in the premium version of the plugin, this rate can be modified for every single vendor shop and for every product associated.','yith_wc_product_vendors'),'<b>','</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/06-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/06-icon.png" alt="Coupon"/>
                    <h2><?php _e('Coupon handling','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('If users use a coupon during a purchase, how will vendor commissions be calculated? It\'s up to you: with the %s"Coupon handling"%s option, you can decide whether you want to calculate the commission for the discounted total or not.','yith_wc_product_vendors'),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/06.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/05-bg.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/05.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/05-icon.png" alt="Commission rate"/>
                    <h2><?php _e('Variable commission rates','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('%sNo more single commission rate for all the vendor shops:%s in the premium version of the plugin, this rate can be modified for every single vendor shop and for every product associated.','yith_wc_product_vendors'),'<b>','</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/13-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/13-icon.png" alt="Coupon"/>
                    <h2><?php _e('COUPON CREATION','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('With the option %s "Enable coupon management" %s, the vendors of your shop can create coupons regarding the products they own. A nice innovation to offer to your vendor-users.','yith_wc_product_vendors'),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/13.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/14-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/14.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/14-icon.png" alt="payments method"/>
                    <h2><?php _e('REVIEWS','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __(' Just like coupons, this option is tailored on the need to manage reviews and it has been added to the premium version of the plugin. Activating the %s"Enable review management"%s option from the option panel of the plugin, vendors will be free to manage the reviews of the products they own, and act with the same privileges of the administrator of the store.','yith_wc_product_vendors'),'<b>','</b>' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/08-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/08-icon.png" alt="Icon"/>
                    <h2><?php _e('Advanced reports','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Statistics have a central relevance in the e-commerce field and WooCommerce Multi Vendor offers you different reports to %sanalyze your data%s: from the most lucrative vendors, to the best sellers, including convenient commission diagrams for each of them.','yith_wc_product_vendors'),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/08.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/09-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/09.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/09-icon.png" alt="payments method"/>
                    <h2><?php _e('CSV exportation of the reports','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('For each report, %syou can export its data in the CSV format%s: in this way, you will be free to use all the report details in every fields not expressively related to WordPress.','yith_wc_product_vendors'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/10-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/10-icon.png" alt="Icon"/>
                    <h2><?php _e('Vendor\'s product exclusion from the shop (Product listing)','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('The %s"Product listing"%s option has been conceived to exclude from the shop the products of a particular vendor. In this way, these would be consultable only from the relative vendor\'s page.','yith_wc_product_vendors'), '<b>' , '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/10.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/11-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/11.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/11-icon.png" alt="payments method"/>
                    <h2><?php _e('Three widgets for your sidebars','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('%1$sYITH Vendor List, YITH Vendor Quick Info%2$s and %1$sYITH Vendor Store Location%2$s: these are the three widgets that the plugin offers you. Thanks to these widgets, you will be able to show the list of the registered vendors of your shop, and enrich the detail page of the vendor shops with information about their locations, or a contact form users can use to send emails to the shop administrators.','yith_wc_product_vendors'), '<b>', '</b>' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/24-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/24-icon.png" alt="Icon"/>
                    <h2><?php _e('Shortcode','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e('Take advantage of the YITH WooCommerce Multi Vendor List shortcode to show the complete list of your shop vendors in any page.','yith_wc_product_vendors','yith_wc_product_vendors');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/24.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/15-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/15.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/15-icon.png" alt="vendor name"/>
                    <h2><?php _e('VISUALIZATION OF THE VENDOR\'S NAME','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'The default setting of the plugin shows the name of each vendor in three pages of your site: the shop page, the product detail page and product category page. Now you can decide whether you want to show their name and hide them whenever you want with three different options.','yith_wc_product_vendors' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/16-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/16-icon.png" alt="Icon"/>
                    <h2><?php _e( 'VENDOR REGISTRATION','yith_wc_product_vendors' );?> </h2>
                </div>
                <p>
                    <?php _e( 'A more dynamic management for whoever wants to become a vendor in your store. It doesn\'t matter whether you are a registered user or a new one: everyone will be free to register as a vendor with the related %1$sregistration form.%2$s Following your settings, the registration request can be accepted automatically or manually by administrators','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/16.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"
         style="background: url(<?php echo YITH_WPV_URL ?>assets/images/17-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/17.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/17-icon.png" alt="icon"/>
                    <h2><?php _e('RESTRICTED NUMBER OF PRODUCTS','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'The option "Enable product amount limit" has been conceived to whoever would like to limit the creation of products of the shop vendors, with the freedom to indicate a specific maximum number of products that each vendor can create.','yith_wc_product_vendors' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/18-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/18-icon.png" alt="Icon"/>
                    <h2><?php _e('BULK ACTIONS ON VENDORS','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'How many times did you find yourself annoyed by the repetition of the same passages with a huge waste of time? Well, now vendors management is completely renewed! You will be able to apply bulk actions on all the registered vendors, approving or deleting them all together with just one click.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/18.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/12-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/12.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/12-icon.png" alt="icon"/>
                    <h2><?php _e('Advanced administration area for each vendor','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'A breath of fresh air for the "vendor users" that can take advantage of a big and advanced administrative area. From this place, they will be free to consult the reports about their products,change their profile information and choose the payment method they prefer. Each vendor can also check the commissions table, with the whole sum of the relative commissions up to that moment.','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/19-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/19-icon.png" alt="Icon"/>
                    <h2><?php _e('ABUSE REPORT','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'With this feature, your users will be able to send you a message about one of the products of your shop with a dedicated form that will open in a popup within the related product detail page.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/19.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/20-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/20.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/20-icon.png" alt="icon"/>
                    <h2><?php _e('Second email','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'Each time that a new order is registered or cancelled, a notification email is sent to the corresponding vendor. This sending can sometimes be affected by some problems, and this is why you should be able to send again the lost email. With the premium version of the plugin, you will just have to go to the detail page of the order and with a single click everything will be solved.','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/21-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/21-icon.png" alt="Icon"/>
                    <h2><?php _e('Minimum amount of commissions','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'If each vendor can decide a commission threshold for which asking the payment, administrators must be free to control how this works.Setting a minimum amount of commissions, you will be free to pay commissions starting from the amount you have set.','yith_wc_product_vendors' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/21.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/22-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/22.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/22-icon.png" alt="icon"/>
                    <h2><?php _e('Highlighted products','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'Setting a WooCommerce product as "Featured" means standing it out among the others, maybe putting it in the main part of the homepage, or in one of the widgets of the siderbars of your shop. With the related option, you will be free to allow or block vendors to set their products as "featured".','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/23-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/23-icon.png" alt="Icon"/>
                    <h2><?php _e('Sales amount','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'Enrich your shop with more information. Show the amount of sales made by each vendor, placing it in the detail page of the related product, and for each single product assigned to a vendor.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/23.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/25-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/25.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/25-icon.png" alt="icon"/>
                    <h2><?php _e('Shop closed','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'Even the owners of online shops need a break, maybe for deserved vacations or for other reasons. Therefore, when administrators offers this freedom to their vendors, they will be free to close their stores, showing a customized message to users. Vendors will also be free to decide whether they want to keep their products purchasable, or showing them in catalogue mode with no opportunity to add them to the cart. ','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/26-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/26-icon.png" alt="Icon"/>
                    <h2><?php _e('Vendor Chat','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'Thanks to the integration with %1$sYITH Live Chat%2$s, vendors of your site will be free to answer immediately to their customers\' questions. In this way, vendors and purchasers will be even nearer, for a complete success of your e-commerce.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/26.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/yith-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/27.jpg" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/yith-icon.png" alt="icon"/>
                    <h2><?php _e('VAT numbers','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'If you need the VAT number of your vendors, make it mandatory during the registration. In this way, no request to become vendor could be completed without adding the VAT number, as this can also be showed in the related detailed vendor\'s page.','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/yith-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/yith-icon.png" alt="Icon"/>
                    <h2><?php _e('Refund management','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'Now refund management can be designated to the vendors of your shop. In fact, they will be able to refund partially or totally users about the products they own, with a related recalculation of the commissions received. Another way to empower your vendors about the management of their shops.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/28.jpg" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/29-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/29.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/29-icon.png" alt="icon"/>
                    <h2><?php _e('VENDOR TAXONOMY','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'With a specific option, %1$svendor taxonomy slug%2$s becomes customizable according to your needs.','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/30-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/30-icon.png" alt="Icon"/>
                    <h2><?php _e('VENDOR LOGO','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'Vendors might wish to show their own logo, but not all vendors have one. This is the reason why you can give them the chance to add it or not in their shop pages. If you prefer to have an uniform style in your site, you can also choose to hide all your vendors’ logos.','yith_wc_product_vendors' )?>
                </p>
                <p>
                    <?php _e( ' If you prefer to have an suniform style in your site, you can also choose to hide all your vendors’ logos.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/30.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/31-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/31.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/31-icon.png" alt="icon"/>
                    <h2><?php _e('USERS PRIVACY','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'Protect your customers\' privacy! With a specific option of the plugin, you can hide "Customer" search section in order detail page, so that other vendors won’t have access to your customers email addresses.','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/32-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/32-icon.png" alt="Icon"/>
                    <h2><?php _e('Advanced editor','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'All vendors can have WordPress advanced editor so that they can add a richer description of their shop by inserting HTML tags and images.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/32.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/33-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/33-icon.png" alt="Icon"/>
                    <h2><?php _e('LEGAL NOTES','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'Each vendor of your shop can insert important legal notes in their reserved area, which will be shown with the other profile information in vendor detail page.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/33.png" alt="Screenshot"/>
            </div>
        </div>
    </div>
    <div class="section section-even clear"style="background: url(<?php echo YITH_WPV_URL ?>assets/images/34-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/34.png" alt="Screenshot"/>
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/34-icon.png" alt="icon"/>
                    <h2><?php _e('IBAN/BIC','yith_wc_product_vendors'); ?></h2>
                </div>
                <p>
                    <?php _e( 'By giving your users the possibility to add their IBAN/BIC code, it will be much easier to pay their commissions by bank transfer when requested.  ','yith_wc_product_vendors' )?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WPV_URL ?>assets/images/35-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WPV_URL ?>assets/images/35-icon.png" alt="Icon"/>
                    <h2><?php _e('TERMS AND CONDITIONS','yith_wc_product_vendors');?></h2>
                </div>
                <p>
                    <?php _e( 'Ask to users who wish to become vendors in your shop, to accept "terms and conditions" during their registration, which, in case of non-acceptance, could not be completed.','yith_wc_product_vendors' )?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WPV_URL ?>assets/images/35.png" alt="Screenshot"/>
            </div>
        </div>
    </div>

    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __( 'Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Multi Vendor%2$s to benefit from all features!', 'yith_wc_product_vendors' ),'<span class="highlight">', '</span>' ); ?>
                </p>
                <a href="<?php echo YITH_Vendors()->admin->get_premium_landing_uri(); ?>" target="_blank"
                   class="premium-cta-button button btn">
                    <?php echo sprintf( __( '%1$s UPGRADE %2$s %3$s to the premium version %2$s', 'yith_wc_product_vendors' ),'<span class="highlight">', '</span>', '<span>' ); ?>
                </a>
            </div>
        </div>
    </div>
</div>
