<div id="upgrade-to-premium">
    <h1><?php _e( 'Upgrade to Premium Version', 'yith-plugin-fw' ) ?></h1>
    <h3><?php _e( "Have you purchased the premium version of a plugin? Don't you know how to activate the license after the purchase?", 'yith-plugin-fw' ) ?></h3>
    <p class="upgrade-how-to">
        <?php echo _e( "To upgrade from a FREE to a PREMIUM plugin is not suffice to insert the license key provided after the purchase.
        The reason is that they are two distinct products, with significant differences both for available options and for number of files included in the plugin package.
        To start to use the PREMIUM version of the plugin, you simply need to download the PREMIUM packet and install it on your site.", 'yith-plugin-fw' ); ?>
    </p>
    <p class="highlighted"><?php echo sprintf( __( '%1$sDo you need to know how to do it?%2$s Easy! %1$sFollow this list of steps%2$s and in a few minutes the plugin you purchased will be installed on your site', 'yith-plugin-fw' ),'<b>','</b>' ); ?></p>
    <ol class="upgrade-steps">
        <li class="step">
             <?php _e( 'Go to yithemes.com and login to "My Account" page', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/01.jpg" title="YIThemes - Login">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/01.jpg" alt="YIThemes - Login">
            </a>
        </li>
        <li class="step">
             <?php _e( 'From the menu on the left, click on "My Downloads", look for the plugin you want to install among the available downloads and click on "Download" button' , 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/02.jpg" title="My Account -> My Downloads">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/02.jpg" alt="My Account -> My Downloads">
            </a>
        </li>
        <li class="step">
             <?php _e( "After downloading the packet, go to your website and login to WordPress administration area.", 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/03.jpg" title="Login to WordPress">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/03.jpg" alt="Login to WordPress">
            </a>
        </li>
        <li class="step">
             <?php _e( 'From the menu on the left, click on "Plugins". You will be redirected to the page where you will find the complete list of all the plugins available on your site. Click on "Add New" button that you find above on the left to add a new plugin', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/04.jpg" title="Add new plugin">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/04.jpg" alt="Add new plugin">
            </a>
        </li>
        <li class="step">
             <?php _e( 'You will be redirected to a new page where you will find, above on the left next to the page title, the "Upload Plugin" button.', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/05.jpg" title="Upload plugin">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/05.jpg" alt="Upload plugin">
            </a>
        </li>
        <li class="step">
             <?php _e( 'Click on "Upload Plugins" button to start the upload of the PREMIUM version of the plugin previously downloaded. Click on "Select File", search for the download folder related to the plugin and upload the package. Now you only need to wait a few minutes for the upload and the installation on your site. (We used YITH Live Chat plugin by way of example)', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/06.jpg" title="Select plugin package">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/06.jpg" alt="Select plugin package">
            </a>
        </li>
        <li class="step">
             <?php _e( 'After completing the installation, click on "Activate plugin"', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/07.jpg" title="Activate plugin">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/07.jpg" alt="Activate plugin">
            </a>
            <?php _e( 'If everything worked allright, your plugin is now correctly installed on your website. Enjoy it :-)', 'yith-plugin-fw' ); ?>
        </li>
        <li class="step">
             <?php _e( 'The last step is the activation of the plugin through its license key you received after the purchase. Click on "License Activation" that you find in "YITH Plugins" and insert the license key and the email address you used during the purchase.', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/08.jpg" title="Activate license">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/08.jpg" alt="Activate license">
            </a>
        </li>
        <li class="step">
            <?php _e( 'In case you had difficulty to recover the license key we sent you by email, you can easily find it in "My Licenses" section of your account on yithemes.com', 'yith-plugin-fw' ); ?>
            <a class="image-lightbox" href="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/09.jpg" title="Section My License">
                <img class="img-responsive" src="<?php echo $core_plugin_url; ?>/assets/images/upgrade-page/09.jpg" alt="Section My License">
            </a>
        </li>
    </ol>
</div>

<script>
    // Lightbox image
    jQuery('document').ready(function($){
        $(".image-lightbox").colorbox({rel:'image-lightbox'});
    });

</script>