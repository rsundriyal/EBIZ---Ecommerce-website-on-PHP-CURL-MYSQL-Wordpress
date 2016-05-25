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
        line-height: 26px;
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
        background: url(<?php echo YITH_YWRAQ_URL?>assets/images/upgrade.png) #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YITH_YWRAQ_URL?>assets/images/upgrade.png) #971d00 no-repeat 13px 13px;
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
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Request a Quote%2$s to benefit from all features!','yith-woocommerce-request-a-quote'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo YITH_YWRAQ_Admin()->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-request-a-quote');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-request-a-quote');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1><?PHP _e('Premium Features','yith-woocommerce-request-a-quote');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/01.png" alt="CUSTOMISED BUTTON" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/01-icon.png" alt="icon CUSTOMISED BUTTON"/>
                    <h2><?PHP _e('CUSTOMISED BUTTON','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Choose the style you prefer for your %s"Add to Quote"%s button! In the plugin option panel users will be able to find a section to set colours and text for the button','yith-woocommerce-request-a-quote'),'<b>','</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('NOT JUST IN PRODUCT PAGE','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Give users the opportunity to add one or more products to their list for a quote request from many different pages in your shop, and %snot just from product detail page%s. Enable this option and the button will be shown also in other pages of your store.','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/02.png" alt="show button in different pages" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/03.png" alt="HIDE PRODUCT PRICE" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'HIDE PRODUCT PRICE','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p><?php _e('Suppose that you do not want to show price for products in your shop. Just a click and your wish comes true. Enable the option "Hide Price" and it\'s done!','yith-woocommerce-request-a-quote');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('EXCLUSION TABLE','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'A dedicated list where you can add those products that have to be excluded from quote requests. Enable the specific option and "Add to Quote" button will %snot be displayed%s for products in this table. ','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/04.png" alt="exclusion table" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/05-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/05.png" alt="User filters" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('USER FILTERS','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('A specific option allows you to filter users to which applying plugin features. You can choose among %1$sregistered%2$s users, %1$sunregistered%2$s ones or let the plugin work for all of them without making any distinction. ','yith-woocommerce-request-a-quote'),'<b>','</b>' );?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/06-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('REQUEST FORM','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('The plugin includes a default form for %ssending emails%s, but if you feel you\'re not satisfied by the form you find there, you can enjoy creating your contact form using "Contact Form 7" and "YITH Contact Form". Two external plugins that, once correctly set, work perfectly to improve your plugin features.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/06.png" alt="request form" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/07-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/07.png" alt="request management" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/07-icon.png" alt="Icon 07" />
                    <h2><?php _e('REQUEST MANAGEMENT','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Every request you get is treated like an order! Yes, that\'s it. As soon as a user sends a quote request, you will see it in WooCommerce "Orders" section. %sMany details for each request%s, from current status to the username that generated it. A rich page specifically created to have everything there and at a hand\'s grasp.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/08-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/08-icon.png" alt="icon 08" />
                    <h2><?php _e('SEND THE QUOTE','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'The best of interaction with your users. They send their request and you can answer so simply, just need to access your admin panel. A few steps to send the right proposal that %spersuades%s your customer to purchase.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/08.png" alt="send the quote" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/09-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/09.png" alt="accept" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/09-icon.png" alt="icon 09" />
                    <h2><?php _e('ACCEPT OR REJECT?','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Users can decide whether to %1$saccept%2$s or %1$sreject%2$s your quote proposal directly from the email they\'ve got. Two simple choice options, that show professionalism and that your users will certainly appreciate. In case they accept, they will be redirected to the order checkout.','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>

    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/10-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/10-icon.png" alt="icon 10" />
                    <h2><?php _e('A QUOTE WITH EXPIRATION','yith-woocommerce-request-a-quote');?> </h2>
                </div>
                <p>
                    <?php echo sprintf( __('You made a good offer, one that cannot be rejected, and you want to urge your customer to purchase by %ssetting an expiration date for the proposal you are offering?%s Add the expiration date directly from the request page while you are writing your undeniable proposal.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/10.png" alt="quote expiration" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/13-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/13.png" alt="PDF Attachment" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/13-icon.png" alt="icon 13" />
                    <h2><?php _e('Send PDF attachment','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php _e('Choose the best form to send your quote offer: send the quote and the list of selected products either in the email body, or as PDF attachment or both of them. Everyone with their own style and needs.','yith-woocommerce-request-a-quote');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/12-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/12-icon.png" alt="icon 14" />
                    <h2><?php _e('Widget','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p><?php echo sprintf( __( 'Add a wigdet in the sidebar of your shop and put it at your customers\' disposal. There they will see a %slist%s with all products they have selected and added to the quote request so far.','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/12.png" alt="Widget" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/11-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/11.png" alt="recent request" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/11-icon.png" alt="icon 13" />
                    <h2><?php _e('Recent requests in "My Account"','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('All users registered in your store can see all quote requests they have sent from %s"My Account"%s page and check details, included the current status for them.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/13b-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/13b-icon.png" alt="icon 13" />
                    <h2><?php _e('PDF FOOTER','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p><?php echo sprintf( __( 'To add a %1$scustom text%2$s with the most appropriate and useful information.','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/13b.png" alt="Pdf footer" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/14-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/14.png" alt="PDF Paging" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/14-icon.png" alt="icon 14" />
                    <h2><?php _e('PDF PAGING','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('By activating %1$sPDF Paging%2$s, customers do not have to scroll the page repeatedly. Thanks to PDF wide contents they can carefully read your offer.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/15-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/15-icon.png" alt="icon 15" />
                    <h2><?php _e('ADDITIONAL COSTS','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p><?php echo sprintf( __( 'It’s easy to add %1$sadditional and shipping costs%2$s and create a quote as accurate as possible.','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/15.png" alt="ADDITIONAL COSTS" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/16-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/16.png" alt="PRICE CHANGE" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/16-icon.png" alt="icon 16" />
                    <h2><?php _e('PRICE CHANGE','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Special customers deserve special prices! This plugin allows to %1$schange prices in the quote%2$s without altering prices in the shop.','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/17-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/17-icon.png" alt="icon 17" />
                    <h2><?php _e('PDF DOWNLOAD','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p><?php echo sprintf( __( 'PDF can be downloaded at any time in %1$s"My Account"%2$s page. Certainly useful for those customers who lost the quote attached to your email.','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/17.png" alt="PDF DOWNLOAD" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/18-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/18.png" alt="EMAIL ATTACHMENT" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/18-icon.png" alt="icon 18" />
                    <h2><?php _e('EMAIL ATTACHMENT','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('With this Premium Version plugin, any file can be attached to emails. %1$sQuotes will be richer!%2$s','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/19-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/19-icon.png" alt="icon 19" />
                    <h2><?php _e('OUT OF STOCK PRODUCTS','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p><?php echo sprintf( __( 'A chance to insert a list of %1$s"Out of stock"%2$s products in the quote by simply clicking  "Add to quote" button','yith-woocommerce-request-a-quote' ),'<b>','</b>' );?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/19.png" alt="OUT OF STOCK PRODUCTS" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWRAQ_URL ?>assets/images/18-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWRAQ_URL ?>assets/images/20.png" alt="ACCOUNT REGISTRATION" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWRAQ_URL?>assets/images/20-icon.png" alt="icon 20" />
                    <h2><?php _e('ACCOUNT REGISTRATION','yith-woocommerce-request-a-quote');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('A new feature for your e-commerce. New users requesting a quote have the possibility to %1$sregister an account%2$s in the shop','yith-woocommerce-request-a-quote'),'<b>','</b>' );?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Request a Quote%2$s to benefit from all features!','yith-woocommerce-request-a-quote'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo YITH_YWRAQ_Admin()->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-request-a-quote');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-request-a-quote');?></span>
                </a>
            </div>
        </div>
    </div>
</div>