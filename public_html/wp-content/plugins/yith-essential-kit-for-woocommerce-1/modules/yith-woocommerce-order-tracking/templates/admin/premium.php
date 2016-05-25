<?php global $YWOT_Instance; ?>
<style>
    .section{
        margin-left: -20px;
        margin-right: -20px;
        font-family: "Raleway";
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
    .section:nth-child(even){
        background-color: #fff;
    }
    .section:nth-child(odd){
        background-color: #f1f1f1;
    }
    .section .section-title img{
        display: inline-block;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }
    .section .section-title h2,
    .section .section-title h3 {
        display: inline-block;
        vertical-align: middle;
        padding: 0;
        font-size: 24px;
        font-weight: 700;
        color: #808a97;
        text-transform: uppercase;
    }

    .section .section-title h3 {
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
        background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL?>upgrade.png) #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL?>upgrade.png) #971d00 no-repeat 13px 13px;
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
                    <?php echo sprintf( __('Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Order Tracking%2$s to benefit from all features!','yith-woocommerce-order-tracking'),'<span class="highlight">','</span>');?>
                </p>
                <a href="<?php echo $YWOT_Instance->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-order-tracking');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-order-tracking');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1><?php _e('Premium Features','yith-woocommerce-order-tracking');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>01.png" alt=<?php _e('Carrier list','yith-woocommerce-order-tracking');?> />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>01-icon.png" alt="icon-01"/>
                    <h2><?php _e('Carrier list','yith-woocommerce-order-tracking');?></h2>

                </div>
                <p>
                    <?php echo sprintf( __('You can choose among many logistics companies from a list that is always %1$supdated and expanded.%2$s From the %1$splugin options,%2$s activate only the carriers you support, and the others will be ignored. You can always %1$sadd or remove%2$s some of them when you want.','yith-woocommerce-order-tracking'),'<b>','</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>02-icon.png" alt="icon-02" />
                    <h2><?php _e('Default carrier','yith-woocommerce-order-tracking');?></h2>

                </div>
                <p><?php echo sprintf( __('Do you use a specific carrier frequently? Set it as %1$sdefault carrier:%2$s during the creation of a new order, the carrier will be set automatically without choosing from the list.','yith-woocommerce-order-tracking'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>02.png" alt=<?php _e('Set a default carrier','yith-woocommerce-order-tracking');?> />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>03.png" alt=<?php _e('TRACK THE ORDER DIRECTLY','yith-woocommerce-order-tracking');?> />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>03-icon.png" alt="icon-03" />
                    <h2><?php _e('Tracking','yith-woocommerce-order-tracking');?></h2>

                </div>
                <p><?php echo sprintf( __('Do you have a tracking code and you want to follow the delivery process? %1$sThe plugin generates dynamically an address to track your order from the site of the carrier.%2$s You can find the link everywhere: %1$sin the mail, in the order detail and in orders page.%2$s','yith-woocommerce-order-tracking'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>04-icon.png" alt="icon-05" />
                    <h2><?php _e('EMAIL TEXT','yith-woocommerce-order-tracking');?></h2>

                </div>
                <p>
                    <?php echo sprintf( __('Customize the email that users %1$sreceive when orders are complete%2$s adding the picking up information.','yith-woocommerce-order-tracking'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>04.png" alt=<?php _e('Email text','yith-woocommerce-order-tracking');?> />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>05-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>05.png" alt=<?php _e('Csv Import','yith-woocommerce-order-tracking');?> />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>05-icon.png" alt="icon-05" />
                    <h2><?php _e('Csv Import','yith-woocommerce-order-tracking');?></h2>

                </div>
                <p>
                    <?php echo sprintf( __('You would like to switch to %1$sYITH Woocommerce Order Tracking%2$s, but you are afraid you might lose tracking data generated so far by a similar plugin? No problem, this will not happen.','yith-woocommerce-order-tracking'),'<b>','</b>');?>
                </p>
                <p>
                    <?php echo sprintf( __('Collect existing data in a CSV file and a simple upload will be enough to bring them back. Thanks to the %1$sadvanced import tool%2$s included in the plugin, none of your data will be lost and you’ll be able to enjoy YITH WooCommerce Order Tracking without any inconveniences.  ','yith-woocommerce-order-tracking'),'<b>','</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>06-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>06-icon.png" alt="icon-06" />
                    <h2><?php _e('Completed order','yith-woocommerce-order-tracking');?></h2>

                </div>
                <p>
                    <?php echo sprintf( __('You inserted tracking data: do you consider the order as completed? Well, maybe the system could consider it in a different way, since it sees your order as still processing. %3$s No need to worry though. The plugin allows to automatize this action, by applying the %1$s"Completed" status soon after inserting tracking data%2$s.','yith-woocommerce-order-tracking'),'<b>','</b>','<br>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWOT_ASSETS_IMAGES_URL ?>06.png" alt=<?php _e('Email text','yith-woocommerce-order-tracking');?> />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Order Tracking%2$s to benefit from all features!','yith-woocommerce-order-tracking'),'<span class="highlight">','</span>');?>
                </p>
                <a href="<?php echo $YWOT_Instance->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-order-tracking');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-order-tracking');?></span>
                </a>
            </div>
        </div>
    </div>
</div>