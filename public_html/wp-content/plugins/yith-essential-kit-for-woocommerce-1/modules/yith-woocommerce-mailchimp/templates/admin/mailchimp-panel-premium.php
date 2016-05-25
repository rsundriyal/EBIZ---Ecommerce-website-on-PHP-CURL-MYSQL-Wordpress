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
        font-size: 15px;
        font-weight: 500;
        display: inline-block;
        width: 60%;
    }
    .premium-cta a.button{
        border-radius: 6px;
        height: 60px;
        float: right;
        background: url(<?php echo YITH_WCMC_URL?>assets/images/upgrade.png) #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YITH_WCMC_URL?>assets/images/upgrade.png) #971d00 no-repeat 13px 13px;
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
                    Upgrade to the <span class="highlight">premium version</span>
                    of <span class="highlight">YITH WooCommerce Mailchimp</span> to benefit from all features!
                </p>
                <a href="<?php echo YITH_WCMC_Admin()->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight">UPGRADE</span>
                    <span>to the premium version</span>
                </a>
            </div>

        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1>Premium Features</h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/01.png" alt="Review Title" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/01-icon.png" alt="Review Title"/>
                    <h2>Ecommerce 360</h2>
                </div>
                <p>
                    Which users come from a <b>MailChimp campaign</b>? Discover it with Ecommerce 360, the system that uses two
                    identifying values in the email they receive to store them in a cookie of your store for period of
                    time you can set freely.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/02-icon.png" alt="Attachment List" />
                    <h2>Replace interests</h2>
                </div>
                <p>
                    Don't get caught unprepared if your users subscribe again to your list and the related interest
                    groups. "Replace interests" gives you the chance to substitute the <b>interest groups</b> of the users, or
                    add new ones when they subscribe again.
                </p>

            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/02.png" alt="Attachment List" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/03.png" alt="Vote the review" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/03-icon.png" alt="Vote the review" />
                    <h2>Interest Groups</h2>
                </div>
                <p>
                    You can create one or more interest groups inside a list of your MailChimp account. <b>Just one click</b>
                    and these will be at your disposal from the plugin. You will just have to select the interest groups
                    in which you want to include the users that <b>subscribe</b> to your list.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/04-icon.png" alt="Number" />
                    <h2>Integration Mode</h2>
                </div>
                <p>
                    You have two different ways to integrate in your MailChimp lists the users that buy from your store.
                    The <b>basic</b> one lets you choose a single list and possible interest groups for all the users; on the
                    contrary, with the <b>advanced</b> one you can filter the users. Following the settings you can choose (as
                    purchased products or total purchase amount), you may decide in which list users can be subscribed.
                </p>

            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/04.png" alt="Number" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/05-bg.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/05.png" alt="Review Title" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/05-icon.png" alt="Review Title"/>
                    <h2>Shortcode</h2>
                </div>
                <p>
                    Thanks to the shortcode, you can add a <b>subscription form</b> for your newsletter in every page of your
                    site. In the settings panel of your plugin, you can find the rich "<b>Shortcode"</b> section, tailored to
                    let you set the perfect shortcode for your needs.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/06-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/06-icon.png" alt="Attachment List" />
                    <h2>Widget</h2>
                </div>
                <p>
                    Every tool can be an added value for your site and this is why the premium version of the plugin
                    offers you the <b>"MailChimp Subscription Form"</b> widget, to invite your users to subscribe to your
                    newsletter directly from the sidebar of your store.
                </p>

            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/06.png" alt="Attachment List" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/07-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/07.png" alt="Vote the review" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/07-icon.png" alt="Vote the review" />
                    <h2>Custom Style</h2>
                </div>
                <p>
                    Shortcodes and widgets style can be set easily from the plugin itself, without messing with the
                    theme or plugin' files. You will find many options and a textarea where you can write the CSS code
                    you prefer.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCMC_URL ?>assets/images/08-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCMC_URL ?>assets/images/08-icon.png" alt="Number" />
                    <h2>Export</h2>
                </div>
                <p>
                    Export the users of your store in the MailChimp list you want. Choose the <b>set of users</b> you want to
                    include (all or just a part of them) and with just one click, you will add them to the list you have
                    chosen; and if you don't like automatic processes, you can always download the <b>CSV</b> file with all
                    their details, so that you can manage it as you prefer.
                </p>

            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCMC_URL ?>assets/images/08.png" alt="Number" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    Upgrade to the <span class="highlight">premium version</span>
                    of <span class="highlight">YITH WooCommerce Mailchimp</span> to benefit from all features!
                </p>
                <a href="<?php echo YITH_WCMC_Admin()->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight">UPGRADE</span>
                    <span>to the premium version</span>
                </a>
            </div>
        </div>
    </div>
</div>