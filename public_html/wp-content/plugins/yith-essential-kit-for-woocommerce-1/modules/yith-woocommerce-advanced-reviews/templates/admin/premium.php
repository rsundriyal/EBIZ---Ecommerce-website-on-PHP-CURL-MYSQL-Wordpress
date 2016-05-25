<?php
global $YWAR_AdvancedReview;
?>

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
    .section-title{
        display: table;
    }
    .section .section-title img{
        display: table-cell;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }

    .section .section-title h2{
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
        padding: 0;
        font-size: 24px;
        font-weight: 700;
        color: #808a97;
        text-transform: uppercase;
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
        background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>upgrade.png) #ff643f no-repeat 13px 13px;
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
        background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>upgrade.png) #971d00 no-repeat 13px 13px;
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
                    <?php echo sprintf (__('Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Advanced Reviews%2$s to benefit from all features!','yith-woocommerce-advanced-reviews'),'<span class="highlight">','</span>');?>
                </p>
                <a href="<?php echo $YWAR_AdvancedReview->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <?php echo sprintf (__('%1$sUPGRADE%2$s %3$sto the premium version%2$s','yith-woocommerce-advanced-reviews'),'<span class="highlight">','</span>','<span>');?>
                </a>
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background1.png) no-repeat #fff; background-position: 85% 75%">
        <h1><?php _e('Premium Features');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>001.png" alt="<?php _e('SUMMARIZE');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>icon1.png" alt="icon1" />
                    <h2><?php _e('Review title');?></h2>
                </div>
                <p><?php echo sprintf (__('Giving a title to a review is a smart way to make a %1$ssummary of the content%2$s in few words. With it, it will be easier to find a particular review, for a better visual effect.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background2.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>icon2.png" alt="icon2"/>
                    <h2><?php _e('REVIEW ATTACHMENT');?></h2>
                </div>
                <p><?php echo sprintf (__('Attach one or more files to reviews is today a need for many users that surf web shops. Be always up-to-date and purchase the premium version of the plugin to offer your users the freedom to %1$sattach files%2$s for a complete service.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>002.png" alt="<?php _e('ADD AN ATTACHMENT');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>11-g.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>003.png" alt="<?php _e('CUSTOMIZE COLOURS');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>11-icon.png" alt="icon11" />
                    <h2><?php _e('COLOR CUSTOMIZATION');?></h2>
                </div>
                <p><?php echo sprintf (__('Appearance is important, and this is why it will be simple for you to customize some of the %1$Scolors%2$S of the plugin to blend it with the %1$Sstyle%2$S of your theme. Nice and easy.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>12-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>12-icon.png" alt="icon12"/>
                    <h2><?php _e('VOTER PERCENTAGE BY RATING');?></h2>
                </div>
                <p><?php echo sprintf (__('Each product of your shop will display a box with %1$sreviews%2$s and %1$svotes%2$s, in addition to percentages that represent each star rate. ','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>004.png" alt="<?php _e('REPRESENT GRAPHICALLY');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background1.png) no-repeat #fff; background-position: 85% 75%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>02.png" alt="<?php _e('MODAL WINDOW');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>icon1.png" alt="icon1" />
                    <h2><?php _e('MODAL WINDOW');?></h2>
                </div>
                <p><?php echo sprintf (__('Enabling this option, the result of the review filter will be slightly different: %1$sthe filtered review will be showed%2$s in a modal window.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background2.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>icon2.png" alt="icon2"/>
                    <h2><?php _e('LOAD MORE');?></h2>
                </div>
                <p><?php echo sprintf (__('%1$sDo you want to hide some of your reviews?%2$s Set how many to show with the relative option, and if you want to let users read the rest of them, choose the load more option.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>01.png" alt="<?php _e('LOAD MORE');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background3.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>03.png" alt="<?php _e('VOTE THE REVIEW');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>icon3.png" alt="icon3" />
                    <h2><?php _e('VOTE THE REVIEW');?></h2>
                </div>
                <p><?php echo sprintf (__('Have you found a review that was particularly good and explicative and that helped you a lot choose a product? Give prominence to it and express your satisfaction or disappointment through the dedicated %1$supvote%2$s or %1$sdownvote%2$s buttons.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background4.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>icon4.png" alt="icon4" />
                    <h2><?php _e('NUMBER');?></h2>
                </div>
                <p><?php echo sprintf (__('This feature allows you to provide users with another piece of information concerning each individual review: it displays %1$sthe number of users%2$s that have appreciated it by expressing their preference for it.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>04.png" alt="<?php _e('NUMBER');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background5.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>05.png" alt="<?php _e('FILTER BY RATING');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>icon5.png" alt="icon5" />
                    <h2><?php _e('FILTER BY RATING');?></h2>
                </div>
                <p><?php echo sprintf (__('%1$sThe product you are watching has too many reviews?%2$sDo not worry, it is possible to filter reviews according to the vote users have given to the product. Thanks to this feature, you will be able to filter and analyse results simply and quickly, without having to scroll the entire list to find what you need.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>background4.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>icon6.png" alt="icon6" />
                    <h2><?php _e('REPLY TO REVIEW');?></h2>
                </div>
                <p><?php echo sprintf (__('You can control the answers of the reviews with the options %1$sreply to all%2$s, %1$snone%2$s or %1$sonly to the administrator of the site%2$s.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>06.png" alt="<?php _e('REPLY TO REVIEW');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>07-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>07.png" alt="<?php _e('MANUAL REVIEW APPROVAL');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>07-icon.png" alt="icon7" />
                    <h2><?php _e('MANUAL REVIEW APPROVAL');?></h2>
                </div>
                <p><?php echo sprintf (__('Sometimes you might feel the need to approve manually reviews that your users write for your products. This option allows you to filter all reviews, and it will be always up to you to approve them %1$sbefore they can be shown%2$s to everyone.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>08-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>08-icon.png" alt="icon-08" />
                    <h2><?php _e('ENABLE VOTE FOR ALL');?></h2>
                </div>
                <p><?php echo sprintf (__('Do you want to prevent users to %1$svote reviews?%2$s Set the options following your needs, choosing whether only registered users can vote or anyone can.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>08.png" alt="<?php _e('ENABLE VOTE FOR ALL');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>09-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>09.png" alt="<?php _e('INAPPROPRIATE REVIEWS');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>09-icon.png" alt="icon-09" />
                    <h2><?php _e('INAPPROPRIATE REVIEWS');?></h2>
                </div>
                <p><?php echo sprintf (__('Among the different reviews your products receive, some of them might be way out of line, or contain gross words. %1$sGive your users the freedom to report them as "inappropriate":%2$s in this way, after a certain number of markings (that you can choose), the review will be automatically removed from the system. Clear your shop from impolite users.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>10-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>10-icon.png" alt="icon-10" />
                    <h2><?php _e('FEATURED REVIEWS');?></h2>
                </div>
                <p><?php echo sprintf (__('%1$sDid you like a review so much and you want to highlight it? That\'s easy to do!%2$s Go in the review list and click on the icon of that specific review: this will appear ahead of the other reviews of the product with a slightly different style. Your users will read it for sure!','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>10.png" alt="<?php _e('FEATURED REVIEWS');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>11-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>11.png" alt="<?php _e('MORE DETAILS');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>11-icon.png" alt="icon-11" />
                    <h2><?php _e('MORE DETAILS');?></h2>
                </div>
                <p><?php echo sprintf (__('The Reviews custom post type gets %1$sricher%2$s and %1$sgrants%2$s you many new details about the reviews in a single screen.%3$sAt a glance, you could see how many people consider the review useful, if this has been reported as inappropriate, if a review is featured, or if the replies are blocked.','yith-woocommerce-advanced-reviews'),'<b>','</b>','<br/>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>12-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>12-icon.png" alt="icon-12" />
                    <h2><?php _e('REPORT');?></h2>
                </div>
                <p><?php echo sprintf (__('A detailed report that lets you control the %1$sinformation%2$s of the reviews for each product. You can easily discover which are the most reviewed products, and which are the best and worst voted.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>12.png" alt="<?php _e('REPORT');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>13-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>13.png" alt="<?php _e('STOP REPLY');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>13-icon.png" alt="icon-13" />
                    <h2><?php _e('STOP REPLY');?></h2>
                </div>
                <p><?php echo sprintf (__('If you want to prevent the replies for specific reviews, you don\'t have to block the entire reply system. Go to the Review custom post type and %1$sblock the replies only for the reviews you want%2$s.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-odd clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>15-bg.png) no-repeat #f1f1f1; background-position: 15% 100%">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>15-icon.png" alt="icon-15" />
                    <h2><?php _e('SINGLE REVIEW');?></h2>
                </div>
                <p><?php echo sprintf (__('Allow your users to write one %1$ssingle review for the product they bought%2$s. In this way, you will block any unhappy user to flood your site with negative comments.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>15.png" alt="<?php _e('Single review');?>" />
            </div>
        </div>
    </div>
    <div class="section section-even clear" style="background: url(<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>16-bg.png) no-repeat #fff; background-position: 85% 100%">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL ?>16.png" alt="<?php _e('EDIT REVIEWS');?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_YWAR_ASSETS_IMAGES_URL?>16-icon.png" alt="icon-16" />
                    <h2><?php _e('EDIT REVIEWS');?></h2>
                </div>
                <p><?php echo sprintf (__('Let users edit their reviews. Who purchased something from your shop will be free to %1$schange a negative comment in a positive one%2$s after resolving any problem or misunderstanding.','yith-woocommerce-advanced-reviews'),'<b>','</b>');?></p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf (__('Upgrade to the %1$spremium version%2$s of %1$sYITH WooCommerce Advanced Reviews%2$s to benefit from all features!','yith-woocommerce-advanced-reviews'),'<span class="highlight">','</span>');?>
                </p>
                <a href="<?php echo $YWAR_AdvancedReview->get_premium_landing_uri(); ?>" target="_blank" class="premium-cta-button button btn">
                    <?php echo sprintf (__('%1$sUPGRADE%2$s %3$sto the premium version%2$s','yith-woocommerce-advanced-reviews'),'<span class="highlight">','</span>','<span>');?>
                </a>
            </div>
        </div>
    </div>
</div>