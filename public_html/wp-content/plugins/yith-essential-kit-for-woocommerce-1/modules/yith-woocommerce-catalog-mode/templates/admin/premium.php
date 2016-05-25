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
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/upgrade.png) #ff643f no-repeat 13px 13px;
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
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/upgrade.png) #971d00 no-repeat 13px 13px;
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
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/01-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.two{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/02-bg.png) no-repeat #fff; background-position: 15% 100%
}
.section.three{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/03-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.four{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/04-bg.png) no-repeat #fff; background-position: 15% 100%
}
.section.five{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/05-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.six{
     background: url(<?php echo YWCTM_ASSETS_URL?>/images/06-bg.png) no-repeat #fff; background-position: 15% 100%
 }

.section.seven{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/07-bg.png) no-repeat #fff; background-position: 85% 75%
}
.section.eight{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/08-bg.png) no-repeat #fff; background-position: 15% 100%
}

.section.nine{
    background: url(<?php echo YWCTM_ASSETS_URL?>/images/09-bg.png) no-repeat #fff; background-position: 85% 75%
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
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Catalog Mode%2$s to benefit from all features!','yith-woocommerce-catalog-mode'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-catalog-mode');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-catalog-mode');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-woocommerce-catalog-mode');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/01.png" alt="Hide price" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Hide price','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Hide the price of products in your shop and replace it with a text. Decide if some of the products have to be excluded and if %1$shiding price%2$s has to be applied to all or restricted only to unlogged users.', 'yith-woocommerce-catalog-mode'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Inquiry form','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Improve single product page by adding a tab with an %1$sinquiry form%2$s explicitly thought to let them send messages to site administrator.', 'yith-woocommerce-catalog-mode'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/02.png" alt="Inquiry form" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/03.png" alt="Custom button" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Custom button','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Add a button in single product page to call users to a specific %1$saction%2$s, depending on the specified %1$slink%2$s (email sending, skype call, telephone call).', 'yith-woocommerce-catalog-mode'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('Product reviews','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('You can disable product %1$sreviewing system%2$s of your shop and decide if applying it to all users or just to unlogged ones.', 'yith-woocommerce-catalog-mode'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/04.png" alt="Product reviews" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/05.png" alt="Exclusion list" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/05-icon.png" alt="icon 05" />
                    <h2><?php _e('Exclusion list','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Set plugin options, but if you want that options concerning price visibility and ‘Add to cart’ do not apply to specific products, add them to %1$sexclusion list%2$s and, voilà, problem solved.','yith-woocommerce-catalog-mode'),'<b>','</b>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="six section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('REVERSE EXCLUSION LIST','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'Apply Catalog Mode to some items only: add them to the "Exclusion List" and %1$smake it work in the opposite way as usual%2$s. All items in the shop show price and “Add to Cart” button, while items in the list don’t.','yith-woocommerce-catalog-mode' ),'<b>','</b>' ) ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/06.png" alt="REVERSE EXCLUSION LIST" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/07.png" alt="Source page of the request" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/07-icon.png" alt="icon 05" />
                    <h2><?php _e('Source page of the request','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Thanks to the %1$s"Product Permalink"%2$s option you will be able to know from which page your users have generated the request.%3$sThe email generated from the request form will include the address of the page: another important information that can be really useful for you.','yith-woocommerce-catalog-mode'),'<b>','</b>','<br>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="eight section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/08-icon.png" alt="icon 08" />
                    <h2><?php _e('Users','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __( 'By default, the plugin requires for configured rules to be valid for all users of the shop, registered or not. However, this can be changed by limiting the functioning of options only to %1$sunregistered users%2$s or to those who are logged from one of the specified nations.','yith-woocommerce-catalog-mode' ),'<b>','</b>' ) ?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/08.png" alt="Users" />
            </div>
        </div>
    </div>
    <div class="nine section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YWCTM_ASSETS_URL?>/images/09.png" alt="YITH WOOCOMMERCE MULTI VENDOR" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YWCTM_ASSETS_URL?>/images/09-icon.png" alt="icon 09" />
                    <h2><?php _e('YITH WOOCOMMERCE MULTI VENDOR','yith-woocommerce-catalog-mode');?></h2>
                </div>
                <p>
                    <?php echo sprintf( __('Integration with %1$sMulti Vendor%2$s will allow vendors to configure catalog options specifically for their own products.%3$sSite administrator can decide to %1$soverwrite the product settings%2$s configured by vendors and have the last word '),'<b>','</b>','<br>'); ?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Catalog Mode%2$s to benefit from all features!','yith-woocommerce-catalog-mode'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-woocommerce-catalog-mode');?></span>
                    <span><?php _e('to the premium version','yith-woocommerce-catalog-mode');?></span>
                </a>
            </div>
        </div>
    </div>
</div>