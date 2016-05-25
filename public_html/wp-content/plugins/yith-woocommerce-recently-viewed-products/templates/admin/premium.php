<style>
.section{
    margin-left: -20px;
    margin-right: -20px;
    font-family: "Raleway",san-serif;
}
.section h1{
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
.section ul{
    list-style-type: disc;
    padding-left: 15px;
}
.section:nth-child(even){
    background-color: #fff;
}
.section:nth-child(odd){
    background-color: #f1f1f1;
}
.section .section-title img{
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

.section .section-title h2{
    display: table-cell;
    vertical-align: middle;
    line-height: 25px;
}

.section-title{
    display: table;
}

.section h3 {
    font-size: 14px;
    line-height: 28px;
    margin-bottom: 0;
    display: block;
}

.section p{
    font-size: 13px;
    margin: 25px 0;
}
.section ul li{
    margin-bottom: 4px;
}
.landing-container{
    max-width: 750px;
    margin-left: auto;
    margin-right: auto;
    padding: 50px 0 30px;
}
.landing-container:after{
    display: block;
    clear: both;
    content: '';
}
.landing-container .col-1,
.landing-container .col-2{
    float: left;
    box-sizing: border-box;
    padding: 0 15px;
}
.landing-container .col-1 img{
    width: 100%;
}
.landing-container .col-1{
    width: 55%;
}
.landing-container .col-2{
    width: 45%;
}
.premium-cta{
    background-color: #808a97;
    color: #fff;
    border-radius: 6px;
    padding: 20px 15px;
}
.premium-cta:after{
    content: '';
    display: block;
    clear: both;
}
.premium-cta p{
    margin: 7px 0;
    font-size: 14px;
    font-weight: 500;
    display: inline-block;
    width: 60%;
}
.premium-cta a.button{
    border-radius: 6px;
    height: 60px;
    float: right;
    background: url(<?php echo YITH_WRVP_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
    border-color: #ff643f;
    box-shadow: none;
    outline: none;
    color: #fff;
    position: relative;
    padding: 9px 50px 9px 70px;
}
.premium-cta a.button:hover,
.premium-cta a.button:active,
.premium-cta a.button:focus{
    color: #fff;
    background: url(<?php echo YITH_WRVP_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
    border-color: #971d00;
    box-shadow: none;
    outline: none;
}
.premium-cta a.button:focus{
    top: 1px;
}
.premium-cta a.button span{
    line-height: 13px;
}
.premium-cta a.button .highlight{
    display: block;
    font-size: 20px;
    font-weight: 700;
    line-height: 20px;
}
.premium-cta .highlight{
    text-transform: uppercase;
    background: none;
    font-weight: 800;
    color: #fff;
}

.section.one{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/01-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.two{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/02-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.three{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/03-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.four{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/04-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.five{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/05-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.six{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/06-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.seven{
    background: url(<?php echo YITH_WRVP_ASSETS_URL ?>/images/07-bg.png) no-repeat #fff; background-position: 85% 75%
}


@media (max-width: 768px) {
    .section{margin: 0}
    .premium-cta p{
        width: 100%;
    }
    .premium-cta{
        text-align: center;
    }
    .premium-cta a.button{
        float: none;
    }
}

@media (max-width: 480px){
    .wrap{
        margin-right: 0;
    }
    .section{
        margin: 0;
    }
    .landing-container .col-1,
    .landing-container .col-2{
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

@media (max-width: 320px){
    .premium-cta a.button{
        padding: 9px 20px 9px 70px;
    }

    .section .section-title img{
        display: none;
    }
}
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Recently Viewed Products%2$s to benefit from all features!','yith-woocommerce-recently-viewed-products'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-recently-viewed-products');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-recently-viewed-products');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-woocommerce-recently-viewed-products');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/01.png" alt="Feature 01" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Recently viewed products','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('The page %1$s"Recently viewed"%2$s aims at improving the experience of users who browse the pages of your shop and shows all products that have been recently viewed in one page only. With one move, so, users will be able to get an overview on viewed products and to go back to the one that has drawn their attention.', 'yith-woocommerce-recently-viewed-products'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Rules for product display','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('The aim of the plugin is to highlight some of the products in the shop in product detail page and in the page "Recently Viewed", according to specific selection criteria. In plugin option panel you can choose if you want to display only products %1$srecently viewed%2$s by users or add also products that belong to the same %1$scategories%2$s or have the same %1$stags%2$s as the recently viewed ones.', 'yith-woocommerce-recently-viewed-products'), '<b>', '</b>');?>
                </p>
                <p>
                    <?php echo sprintf(__('For an even more accurate selection, you can %1$shide products that have already been purchased%2$s and show also, among recently viewed products, all those items belonging to most visited categories.', 'yith-woocommerce-recently-viewed-products'), '<b>', '</b>','<br>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/02.png" alt="feature 02" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/03.png" alt="Feature 03" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Display in slider','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('A slider allows you to make your pages more dynamic and to show contents in a better way, especially when elements shown are not just a few. Moreover, it is %1$stouch-frienldy%2$s: an extra touch for displaying of products you want to suggest to your users.', 'yith-woocommerce-recently-viewed-products'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('Email sending','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Do not lose grasp of those who were interested in your products: write a %1$scustom email%2$s that will be sent after a specific number of days since their last access in your shop and choose the products you want to suggest them. Statistics prove, in fact, that a well-structured email can bring new sales to your store.', 'yith-woocommerce-recently-viewed-products'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/04.png" alt="Feature 04" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/05.png" alt="Feature 05" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL?>/images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('Coupons','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Who wouldn’t be happy to %1$sreceive a discount coupon%2$s for a future purchase? The plugin gives you the possibility to offer a coupon to your customers and attach it to the email you send to them: the coupon will be applied to the first item listed among products suggested in the email message.','yith-woocommerce-recently-viewed-products' ),'<b>','</b>') ?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('Dynamic custom shortcodes','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('One of the biggest news in the premium version of the plugin is the possibility to create dynamically %1$sunlimited shortcodes for recently viewed and suggested products%2$s of your shop from plugin option panel.%3$sConfigure custom attributes for your shortcodes and then paste the shortcode into your pages. Easy, isn’t it?','yith-woocommerce-recently-viewed-products'),'<b>','</b>','<br>'); ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/06.png" alt="Feature 06" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/07.png" alt="Feature 07" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL?>/images/07-icon.png" alt="icon 07" />
                    <h2><?php _e('Widget','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Enrich your shop sidebars with the widget %1$s"YITH WooCommerce Recently Viewed Products"%2$s, so that you can show suggested products also in that part of the page that most catches users’ eye. ','yith-woocommerce-recently-viewed-products'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="eight section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/08-icon.png" alt="icon 08" />
                    <h2><?php _e( 'Product list ','yith-woocommerce-recently-viewed-products');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Manage information in a slightly different way with the premium version of the plugin: data are no longer saved only in cookies, but, if users log in, information about their previous searches will be stored in your %1$ssite database%2$s. %3$sThis means that the list of recently viewed products shown to users will be updated in a more realistic way, even if they access from a different browser!','yith-woocommerce-recently-viewed-products'),'<b>','</b>','<br>'); ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WRVP_ASSETS_URL ?>/images/08.png" alt="Feature 08" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Recently Viewed Products%2$s to benefit from all features!','yith-woocommerce-recently-viewed-products'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-recently-viewed-products');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-recently-viewed-products');?></span>
                </a>
            </div>
        </div>
    </div>
</div>