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
        line-height: 25px;
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
        background: url(<?php echo YWRR_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YWRR_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
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
                    <?php echo sprintf(__('Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Review Reminder%2$s to benefit from all features!','yith-woocommerce-review-reminder'),'<span class="highlight">','</span>');?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <?php echo sprintf(__('%1$sUPGRADE%2$s %3$sto the premium%2$s','yith-woocommerce-review-reminder'),'<span class="highlight">','</span>','<span>');?>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1><?php _e('Premium Features','yith-woocommerce-review-reminder');?></h1>

        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/01.png" alt="<?php _e('SELECTION TO REVIEW','yith-woocommerce-review-reminder');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/01-icon.png" alt=icon-01 />

                    <h2><?php _e('SELECTION OF THE PRODUCTS TO REVIEW','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('%1$sChoose to ask users%2$s the review of every purchased product, or only a part of them.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/02-icon.png" alt="icon-02" />

                    <h2><?php _e('DEADLINE FOR EMAIL DISPATCHING','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('Set %1$show many days have to pass%2$s before sending the email to request a review, after the order has been marked as "Completed".','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/02.png" alt="<?php _e('DEADLINE','yith-woocommerce-review-reminder');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/03.png" alt="<?php _e('BLOCKLIST','yith-woocommerce-review-reminder');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/03-icon.png" alt="icon-03" />

                    <h2><?php _e('BLOCKLIST','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('%1$sAdd to the blocklist%2$s all the users emails that don\'t want to review any product of your e-commerce.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/04-icon.png" alt="icon-04" />

                    <h2><?php _e('EMAIL TEMPLATE','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('Select the %1$slayout you want%2$s for your email choosing among the four possibilities we offer you.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/04.png" alt="<?php _e('EMAIL TEMPLATE','yith-woocommerce-review-reminder');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/05-bg.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/05.png" alt="<?php _e('MANDRILL','yith-woocommerce-review-reminder');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/05-icon.png" alt=icon-05 />

                    <h2><?php _e('USE MANDRILL TO MANAGE YOUR EMAILS','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('%1$sMake creation of custom%2$s reminders automatic in a few clicks.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/06-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/06-icon.png" alt="icon-06" />

                    <h2><?php _e('SCHEDULE LIST','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('See all reminders you have scheduled %1$s(past and present)%2$s in one tab only and delete them from this page without having to move anywhere else.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/06.png" alt="<?php _e('SCHEDULE LIST','yith-woocommerce-review-reminder');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/07-bg.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/07.png" alt="<?php _e('Google Analytics','yith-woocommerce-review-reminder');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/07-icon.png" alt="icon-07" />

                    <h2><?php _e('GOOGLE ANALYTICS','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('Configure the requested parameters to track, through %1$sGoogle Analytics%2$s, all emails sent from the plugin. This allows you to develop interesting market statistics for your shop.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YWRR_ASSETS_URL ?>/images/08-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWRR_ASSETS_URL ?>/images/08-icon.png" alt="icon-08" />

                    <h2><?php _e('YITH WOOCOMMERCE EMAIL TEMPLATES','yith-woocommerce-review-reminder');?></h2>
                </div>
                <p><?php echo sprintf (__('Thanks to full compatibility between the two plugins, you could configure customized email layouts, with %1$sYITH WooCommerce Email Templates%2$s, for all emails sent from YITH WooCommerce Review Reminder.','yith-woocommerce-review-reminder'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWRR_ASSETS_URL ?>/images/08.png" alt="<?php _e('YITH WooCommerce Email Templates','yith-woocommerce-review-reminder');?>" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf (__('Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Review Reminder%2$s to benefit from all features!','yith-woocommerce-review-reminder'),'<span class="highlight">','</span>');?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <?php echo sprintf (__('%1$sUPGRADE%2$s %3$sto the premium version%2$s','yith-woocommerce-review-reminder'),'<span class="highlight">','</span>','<span>');?>
                </a>
            </div>
        </div>
    </div>

</div>