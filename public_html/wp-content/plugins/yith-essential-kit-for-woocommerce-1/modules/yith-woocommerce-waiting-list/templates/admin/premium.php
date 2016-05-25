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
        background: url('<?php echo YITH_WCWTL_URL?>assets/images/upgrade.png') #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YITH_WCWTL_URL?>assets/images/upgrade.png) #971d00 no-repeat 13px 13px;
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
                    of <span class="highlight">YITH WooCommerce Waiting List</span> to benefit from all features!
                </p>
                <a href="<?php echo YITH_WCWTL_Admin()->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight">UPGRADE</span>
                    <span>to the premium version</span>
                </a>
            </div>

        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/01-bg.png) no-repeat #fff; background-position: 85% 75%">
        <h1>Premium Features</h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/01.png" alt="Review Title" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/01-icon.png" alt="Custom messages"/>
                    <h2>Custom messages</h2>
                </div>
                <p>
                    Notifications shown to your users during their subscription to the list are entirely customizable.
                    Write the message text you want to show both for <b>successful subscription</b> and for <b>unsuccessful
                    subscription</b>.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/02-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/02-icon.png" alt="Attachment List" />
                    <h2>Send emails automatically</h2>
                </div>
                <p>
                    An option explicitly conceived to relieve you of the task to manually generate the email as soon as
                    the product status is set as “Available”. In fact, with the premium version, <b>email sending is
                    automatic</b> and allows you to automatically manage them and keep your users up to date.
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/02.png" alt="Attachment List" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/03-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/03.png" alt="Vote the review" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/03-icon.png" alt="Vote the review" />
                    <h2>Keep the list after sending the email</h2>
                </div>
                <p>
                    If you do not want your list is emptied after the product comes back as “available”, enable the
                    option <b>“Keep the list after email”</b> and you will be able to generate a new email for users in that
                    list whenever you want.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/04-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/04-icon.png" alt="Number" />
                    <h2>Customize the style</h2>
                </div>
                <p>
                    A rich panel option from which you can shape buttons for subscription and deletion from the list and
                    suit them to the layout of your shop. <b>Details are what make the difference</b> and you must have the
                    best tools to get the best results.
                </p>

            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/04.png" alt="Number" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/05-bg.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/05.png" alt="Review Title" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/05-icon.png" alt="Review Title"/>
                    <h2>Notification email</h2>
                </div>
                <p>
                    Any time users sends a subscription request, they will be instantly sent a notification email that confirms they have been successfully added to the list.
                    Moreover, from the same email <b>they will be able to unsubscribe</b> from the list whenever they wanted.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/06-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/06-icon.png" alt="Attachment List" />
                    <h2>Custom email content</h2>
                </div>
                <p>
                    The plugin generates two types of email, one that confirms a successful subscription and abother one
                    to inform users that the product is back in store. For both of them, <b>you can customize contents and
                    template file as you like</b>. Product data can be recovered dynamically using specific placeholders.
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/06.png" alt="Attachment List" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/07-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/07.png" alt="Vote the review" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/07-icon.png" alt="Vote the review" />
                    <h2>Exclusion List</h2>
                </div>
                <p>
                    Do you want that the plugin works only for some and not all “out of stock” products? <b>Exclusion list
                    table</b> has been developed to meet your need and to allow you to exclude some specific products for
                    which no email has to be sent as they come back in stock.
                </p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_WCWTL_URL ?>assets/images/08-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCWTL_URL ?>assets/images/08-icon.png" alt="Number" />
                    <h2>Waiting list Checklist</h2>
                </div>
                <p>
                    “Waiting List Checklist” tab allows you to check any moment the status of waiting lists for
                    out-of-stock products. For each of them, you have the following options available: <b>delete list</b>, <b>send
                    email</b> and a <b>button through which you can access to the list with users</b>.
                    Nothing prevents you from adding a new user to the list whenever you want.
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCWTL_URL ?>assets/images/08.png" alt="Number" />
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    Upgrade to the <span class="highlight">premium version</span>
                    of <span class="highlight">YITH WooCommerce Waiting List</span> to benefit from all features!
                </p>
                <a href="<?php echo YITH_WCWTL_Admin()->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight">UPGRADE</span>
                    <span>to the premium version</span>
                </a>
            </div>
        </div>
    </div>
</div>