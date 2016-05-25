<?php

/********************************
** adamrob.co.uk - 2FEB2015
** Parallax Scroll Wordpress Plugin
**
** For Help and Support please visit www.adamrob.co.uk
**
** Help
**
** 22MAR2016 - V2.0 - Extended Help for new version
********************************/


function parallaxscroll_help_get_whatsnew(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>What's New?</H3>";
    $text.="<p>";
    $text.="<ul>";
    $text.="<li>New help menus! To help improve the look and feel of the plugin-in, help text has now been moved to the help menus</li>";
    $text.="<li>New image size property for users who want more control on the size of their parallax image</li>";
    $text.="<li>Fixed - When a user visits on a mobile device, the image will no longer appear too large.</li>";
    $text.="<li>New image size property for mobile devices. Specify a size when a user visits on a mobile device</li>";
    $text.="<li>More DIVS have been given IDs; so you can customise the CSS better.</li>";
    $text.="</ul>";
    $text.="Please visit <a href='http://www.adamrob.co.uk/parallax-scroll' target='blank'> adamrob.co.uk</a> for more information and support.";
    $text.="</p>";

    return $text;
}

function parallaxscroll_help_get_creating(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>Creating a new Parallax</H3>";
    $text.="<p>";
    $text.="<ul>";
    $text.="<li>Click create new parallax from the parallax scroll menu.</li>";
    $text.="<li><i>Optional</i> Enter a title for the parallax</li>";
    $text.="<li><i>Optional</i> Enter some content into the post box. Include anything you like, from text and images to shortcodes.</li>";
    $text.="<li>Set your parallax background image by selecting a featured image. This is usually positioned in the bottom right of the screen (some wordpress installations may be different)</li>";
    $text.="<li><i>Optional</i> Fill out any additional parallax options that you may require. Check the options tab in the help system for details.</li>";
    $text.="<li>Click publish</li>";
    $text.="<li>Copy the parallax shortcode and paste into any page/post where you would like the parallax to display. The shortcode is found by clicking parallax scroll in the wordpress menu. The code is displayed in the table.</li>";
    $text.="<li>Thats it. Publish your page/post and the parallax will be live.</li>";
    $text.="</ul>";
    $text.="</p>";

    return $text;
}

function parallaxscroll_help_get_options(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>Options</H3>";
    $text.="<p>";

    $text.="<p><h3>Style</h3>";
    $text.="<ul>";
    $text.="<li><b>Enter a post title</b><br/>This will be the main title which is displayed over the parallax background. The title can also be hidden. See header style point below.</li>";
    $text.="<li><b>Enter some content</b> <i>optional</i><br/>Add some content if required, just like any other post/page.</li>";
    $text.="<li><b>Add Feature Image</b><br/>The feature image is your parallax background</li>";
    $text.="<li><b>Parallax Height</b> <i>optional</i><br/>Enter a height in pixels you would like the parallax to be. Setting this option will aut-size the parallax based on the content entered. Minimum height is always 100px</li>";
    $text.="<li><b>Parallax Image Size</b> <i>optional</i><br/>The parallax image will be scaled based on this value. Specify the width in pixels. Set to 0 to auto set the size of the image (recommended)</li>";
    $text.="<li><b>Horizontal Position</b><br/>The horizontal position of the header on the parallax background.</li>";
    $text.="<li><b>Vertical Position</b><br/>The vertical position of the header on the parallax background. This setting is ignored if post content is specified.</li>";
    $text.="<li><b>Header Style</b> <i>optional</i><br/>Enter the inline CSS style required for the header eg. font-weight: bold; font-size: large;<br>If you would like to hide the header, type: display: none; </li>";
    $text.="<li><b>Full Width</b> <i>optional</i><br/>
            Display the parallax across the full width of the page. This is a work around to get a full width parallax if its not already. This may not work on some themes. Please see the full width help menu for more information.</li>";
    $text.="</ul></p>";

    $text.="<p><h3>Parallax Settings</h3>";
    $text.="<ul>";
    $text.="<li>Parallax Speed <i>optional</i><br/>
            Enter the scrolling speed of the parallax background image. Values between 1 and 10 are valid, 1 being the slowest speed and 10 the quickest. Setting a value of 0 will disable the scrolling of the parallax image, instead leaving the image static.</li>";
    $text.='<li>Use Parallax.js<br/>
            Parallax.js uses java script to render the parallax effect. The plugin below version 1.0 used to be built around this. It may provide improved performance, responsive images and improved mobile options; however it may also introduce cross platform issues. If the parallax effect does not work as required without this being enabled, try enabling it. It is down to user preference to enable or not. (Please note parallax.js was written by picelcog <a href="https://github.com/pixelcog/parallax.js/">Link</a></li>';
    $text.="</ul></p>";

    
    $text.="<p><h3>Mobile Settings</h3>";
    $text.="<ul>";
    $text.="<li><b>Mobile: Disable Image</b> <i>optional</i><br/>Parallax Scroll can only render the background image on mobile devices with no animation. Select this option if you would rather the background image not display at all on mobile devices.</li>";
    $text.="<li><b>Mobile: Disable Parallax</b> <i>optional</i><br/>Parallax Scroll can only render the background image on mobile devices with no animation. Select this option if you would rather not show the entire parallax (including content) when on a mobile device.</li>";
    $text.="<li><b>Mobile: Image Size</b> <i>optional</i><br/>Set a size here to scale the image size when on a mobile device. Specify the width in pixels. Set to 0 to auto set the size of the image.</li>";
    $text.="</ul></p>";

    return $text;
}

function parallaxscroll_help_get_styles(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>Extending with CSS styles</H3>";
    $text.="<p>";
    $text.="If you define a title and/or content, the following can be used to change the styles:";
    $text.="<ul>";
    $text.='<li><b>"adamrob_parallax_posttitle"</b> <i>CSS Class</i><br/>
            Use this class to alter the div the header is contained in. The class can be entered into your theme CSS or can be altered in the plugin css. Altering the plugin CSS will mean any future updates will overrite your code.</li>';
    $text.='<li><b>"adamrob_parallax_postcontent"</b> <i>CSS Class</i><br/>
            Use this class to alter the div the content is contained in. The class can be entered into your theme CSS or can be altered in the plugin css. Altering the plugin CSS will mean any future updates will overrite your code.</li>';
    $text.="</ul>";
    $text.="<br/>In addition, parallax' can be targeted directly using the ID of the parallax. This is usefull when you want to change the style of only 1 or a selection of parallax'";
    $text.="<ul>";
    $text.='<li><b>"parallax_<"ID">_posttitle"</b> <i>ID</i><br/>
            Replace <"ID"> with the ID number of your parallax you want to target (ie, the same ID number as used in the shortcode). Use this ID to alter the div the header is contained in for the specific parallax. The CSS can be entered into your theme CSS or can be altered in the plugin css. Altering the plugin CSS will mean any future updates will overrite your code.</li>';
    $text.='<li><b>"parallax_<"ID">_postcontent"</b> <i>ID</i><br/>
            Replace <"ID"> with the ID number of your parallax you want to target (ie, the same ID number as used in the shortcode). Use this ID to alter the div the content is contained in for the specific parallax. The CSS can be entered into your theme CSS or can be altered in the plugin css. Altering the plugin CSS will mean any future updates will overrite your code.</li>';
    $text.="</ul>";
    $text.="</p>";

    return $text;
}

function parallaxscroll_help_get_fullwidth(){
    //Returns whats new help text
    $text='';
    $text.="<H1>Parallax Scroll by adamrob.co.uk</H1>";
    $text.="<H3>Full Width Issues</H3>";
    $text.="<p>";
    $text.="Parallax scroll has been written to work across as many different themes as possible, however as everyones wordpress setup is different, and every theme is different it is very difficult if not near impossible to guarente that the plugin will work on every site. Parallax scroll is built and tested using the standard wordpress themes; this is the only base line that is availble to work against; therfore if you are having issues, please test it against the standard theme to check if its a fault with the plugin or the theme.";
    $text.="</p>";
    $text.="<p>";
    $text.="The full width issue is a common one, where the parallax does not span the full width of the page. Parallax scroll is designed to be full width out of the box. As standard it will size to the full width of the post. If this doesn't work as required, a full width option is availble. This is a bit of a hack to resize the parallax to the full width of the content area of the page/post. Because this is a bit of a hack, it may not appear correctly for everyone.";
    $text.="</p>";
        $text.="<p>";
    $text.="Why is this an issue on some themes? Well some themes, even though they claim are full width themes, are not actually full width at all. A lot of themes will actually be setup using divs with margins either side. They trick you into thinking its full width by setting the colors and borders to the same color. Unfortunatly, on themes like this its impossible for me to cater for, however you can modify the fullwidth.js script to target the specific width required yourself.";
    $text.="</p>";

    return $text;
}


/***
** Help Tabs
***/
function parallaxscroll_help_add_tabs() {

  $screen = get_current_screen();

  // Return early if we're not on the book post type.
  if ( PARALLAX_POSTTYPE != $screen->post_type )
    return;

    // Setup help tab args.
    $maintab = array(
        'id'      => 'parallaxscroll_help_main', //unique id for the tab
        'title'   => "What's New", //unique visible title for the tab
        'content' => parallaxscroll_help_get_whatsnew(),  //actual help text
    );
    $createtab = array(
        'id'      => 'parallaxscroll_help_create', //unique id for the tab
        'title'   => "Create New Parallax", //unique visible title for the tab
        'content' => parallaxscroll_help_get_creating(),  //actual help text
    );
    $optionstab = array(
        'id'      => 'parallaxscroll_help_options', //unique id for the tab
        'title'   => "Parallax Options", //unique visible title for the tab
        'content' => parallaxscroll_help_get_options(),  //actual help text
    );
    $stylestab = array(
        'id'      => 'parallaxscroll_help_style', //unique id for the tab
        'title'   => "Extending Styles", //unique visible title for the tab
        'content' => parallaxscroll_help_get_styles(),  //actual help text
    );
    $fullwidthtab = array(
        'id'      => 'parallaxscroll_help_fullwidth', //unique id for the tab
        'title'   => "Full Width Issues", //unique visible title for the tab
        'content' => parallaxscroll_help_get_fullwidth(),  //actual help text
    );
  
  // Add the help tab.
  $screen->add_help_tab( $maintab );
  $screen->add_help_tab( $createtab );
  $screen->add_help_tab( $optionstab );
  $screen->add_help_tab( $stylestab );
  $screen->add_help_tab( $fullwidthtab );

}
add_action('admin_head', 'parallaxscroll_help_add_tabs');



// Add fake metabox above editing pane for help guidence
function parallaxscroll_help_ater_title( $post_type ) {
    $screen = get_current_screen();

    // Return early if we're not on the book post type.
    if ( PARALLAX_POSTTYPE != $screen->post_type )
        return;

    ?>
    <div class="after-title-help postbox">
        <h3>Parallax Scroll by adamrob.co.uk</h3>
        <div class="inside">
            <p>Use this screen to setup your parallax. Once published, use the shortcode to display on a page or post. Remember
                to select your background image in the featured image section. For further help, use the help menu in the top right.</p>
        </div><!-- .inside -->
    </div><!-- .postbox -->
    <?php }
add_action( 'edit_form_after_title', 'parallaxscroll_help_ater_title' );


?>