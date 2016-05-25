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
        display: table-cell;
        vertical-align: middle;
        float: left;
        width: auto;
        margin-right: 15px;
    }
    .section .section-title h2,.section .section-title h3
    {
        display: table-cell;
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
        background: url(<?php echo YITH_WCAUTHNET_URL?>/assets/images/upgrade.png) #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YITH_WCAUTHNET_URL?>/assets/images/upgrade.png) #971d00 no-repeat 13px 13px;
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

    @media (max-width: 767px){
        .section{
            margin-left: 0;
            margin-right: 0;
        }
        .premium-cta a.button{
            float: none;
        }
        .premium-cta{
            text-align: center;
        }
        .premium-cta p{
            width: 100%;
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
                    of <span class="highlight">YITH WooCommerce Authorize.net Payment Gateway</span> to benefit from all features!
                </p>
                <a href="<?php echo YITH_WCAUTHNET_Admin()->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight">UPGRADE</span>
                    <span>to the premium version</span>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCAUTHNET_URL ?>/assets/images/01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1>Premium Features</h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/01.png" alt="Review Title" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/01-icon.png" alt="Review Title"/>
                    <h2>TRANSACTION MODE</h2>
                </div>
                <p>The customers that buy with Authorize.net could compete their payment in two ways: on the same page of the store (with the "API" mode), or on the payment page of Authorize.net (with the "Redirect" mode).</p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCAUTHNET_URL ?>/assets/images/02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/02-icon.png" alt="Attachment List" />
                    <h2>PAYMENT WITH CREDIT CARD</h2>
                </div>
                <p>The credit card becomes a new way of payment for whoever wants to but from your shop. Authorize.net will give to your clients the chance to pay the order with a new credit card, or selecting another one already used, storing its details.</p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/02.png" alt="Attachment List" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCAUTHNET_URL ?>/assets/images/03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/03.png" alt="Vote the review" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/03-icon.png" alt="Vote the review" />
                    <h2>ECHECK</h2>
                </div>
                <p>You can activate the eCheck payment method, which will be available for users during the checkout among the other options.</p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCAUTHNET_URL ?>/assets/images/04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/04-icon.png" alt="Attachment List" />
                    <h2>ITEMIZED ORDERS</h2>
                </div>
                <p>An option tailored to show the order details both in the checkout during the purchase, and later in the invoice. Your clients won't see just the amount of the order, but also how it is composed.</p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/04.png" alt="Attachment List" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCAUTHNET_URL ?>/assets/images/05-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/05.png" alt="Vote the review" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCAUTHNET_URL ?>/assets/images/05-icon.png" alt="Vote the review" />
                    <h2>REFUND</h2>
                </div>
                <p>The refund is now quick and easy. You will just have to go to the order page you are interested into, and with the related button, the amount that you will write will be refunded directly on the client's credit card.</p>
            </div>
        </div>
    </div>


    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    Upgrade to the <span class="highlight">premium version</span>
                    of <span class="highlight">YITH WooCommerce Authorize.net Payment Gateway</span> to benefit from all features!
                </p>
                <a href="<?php echo YITH_WCAUTHNET_Admin()->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight">UPGRADE</span>
                    <span>to the premium version</span>
                </a>
            </div>
        </div>
    </div>
</div>