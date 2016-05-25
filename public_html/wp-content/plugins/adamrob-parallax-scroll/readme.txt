=== Parallax Scroll ===
Contributors: adamrob
Tags: parallax, scroll, image, header, adamrob, animation
Requires at least: 4.0
Tested up to: 4.4.2
Stable tag: 2.0
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create a header, or even a custom post/page with a scrolling parallax background. All with a simple shortcode.

== Description ==

Parallax Scroll; the easiest way to get a parallax scrolling background image for an element on your page/posts.

**Examples include:**

* Create a header text with a parallax scrolling background.
* Create a full section containing any content with a parallax scrolling background.
* Give single elements of your pages a parallax scrolling background.
* Ideal for sites with sections.

**How?**

* Simply create the content required in the custom Parallax Scroll post type.
* The Parallax Scroll admin page will display the shortcode required for all Parallax Scroll post types defined. Copy this shortcode, and paste it into any page or post.
* Alternatively you can use the plugin directly in your php code. Implement it straight into your theme!
* Thats it!


== Installation ==

No special steps required for installation.

Auto Install:

1. Navigate to plugins page in your WordPress admin section.
1. Search for Parallax Scroll by adamrob.co.uk.
1. Download and activate.
1. You will now have the Parallax Scroll menu item in your WordPress admin

Manual Install:

1. Download the plugin files.
1. Copy/upload the plugin folder to your WordPress Content/plugins directory.
1. Navigate to WordPress plugin page in your WordPress admin page. The plugin will be displayed.
1. Click activate. You will now have the Parallax Scroll menu item in your WordPress admin.

== Frequently Asked Questions ==

= How can I use Parallax Scroll in my theme and/or PHP? =

You can now use parallax scroll in your themes, using PHP. Using this method, there is no need to add a shortcode to a page or post; just simply paste the following PHP code into your PHP page where you would like your parallax to display. This method is especially usefull if you are having trouble with full width, or you would like to build it into your theme.

	echo do_shortcode('[parallax-scroll id="#"]')

*Where # = parallax ID number*

= I have no background image? =

Make sure you set a featured image in the Parallax setup screen. This is usualy in the bottom right of the edit page. This image will be the background.

= Full width does not work =

Parallax scroll has been written to work across as many different themes as possible, however as everyones wordpress setup is different, and every theme is different it is very difficult if not near impossible to guarente that the plugin will work on every site. Parallax scroll is built and tested using the standard wordpress themes; this is the only base line that is availble to work against; therfore if you are having issues, please test it against the standard theme to check if its a fault with the plugin or the theme.

The full width issue is a common one, where the parallax does not span the full width of the page. Parallax scroll is designed to be full width out of the box. As standard it will size to the full width of the post. If this doesn't work as required, a full width option is availble. This is a bit of a hack to resize the parallax to the full width of the content area of the page/post. Because this is a bit of a hack, it may not appear correctly for everyone.

Why is this an issue on some themes? Well some themes, even though they claim are full width themes, are not actually full width at all. A lot of themes will actually be setup using divs with margins either side. They trick you into thinking its full width by setting the colors and borders to the same color. Unfortunatly, on themes like this its impossible for me to cater for, however you can modify the fullwidth.js script to target the specific width required yourself.

= Where can i get support? =

Please visit the support forums to check if the subject is already covered.
Alternatively visit [adamrob.co.uk](http://adamrob.co.uk/parallax-scroll "my website") for support and/or suggestions.






== Screenshots ==

1. The options availble on the Parallax Scroll post page.
2. An example of parallax scroll being used for header text.
3. An example of parallax scroll being used as part of the page, in this instance it contains text and a google maps element.


== Changelog ==

= 0.1 =
* Initial release.

= 0.2 =
* Added header CSS style parameter to custom post type.

= 0.3 =
* Fixed - Fixed an issue where some themes would not render the parallax background image (such as the default themes).
* Added - Screenshots on Wordpress plugins directory.

= 0.4 =
* Added - Two new options to add the ability of disabling parallax scroll image or content when on mobile device.
* Added - Full width option. This option will over-ride the themes content area style and make the parallax full width.
* Fixed - Shortcodes in the parallax scroll post content now work correctly.

= 1.0 =
* Updated - Parallax.js has now been removed. The parallax is now driven from CSS. This will improve browser compatability, in particular with internet explorer.

= 1.1 =
* Fixed - Fixed full width issue where if more than one parallax was used in a single post/page they would not size correctly

= 1.2 =
* Added - New help menu's
* Added - Parallax image size option

= 1.3 =
* Fixed - Menu Position Bug

= 1.4 =
* Fixed - Images should appear better on mobile devices
* Added - Image size option just for mobile devices
* Added - Additional Div IDs

= 2.0 =
* Added - Background parallax image can now scroll at a different speed to the page.
* Added - New background scroll setpoint to admin page
* Added - Input sanitisation for number inputs
* Updated - Split admin setup parameters into sections, and added section descriptions
* Added - Added an option to use parallax.js as the parallax engine rather than CSS. (See http://pixelcog.github.io/parallax.js/ for information on parallax.js)
* Added - Added ability to target the CSS class of the Post content/title. Also added the ability to target specific parallax styles through the ID
* Updated - Updated the help files to be more in depth for customising and setting up. Also added more obvious message on admin page.
* Updated - Bug fixes. 


== Upgrade Notice ==

= 0.3 =
Fixed issue where parallax background image would not display on some themes.

= 0.4 =
New options added including full width. Shortcodes now work in the post content.

= 1.0 =
Parallax.js has now been removed. The parallax is now driven from CSS. This will improve browser compatability, in particular with internet explorer.
PLEASE NOTE: Make a backup of parallax scroll plugin before upgrading. The plugin has been fundamentally changed by changing how the parallax works. This may mean that the new version does not appear as it use to.

= 1.1 =
Fixed full width issue where if more than one parallax was used in a single post/page they would not size correctly.

= 1.2 =
Added help menu's and an option to specify parallax image size.

= 1.3 =
Fixed Menu Position Bug

= 1.4 =
Images should appear better on mobile devices plus Image size option just for mobile devices.

= 2.0 =
Background parallax image can now scroll at a different speed to the page.
Added an option to use parallax.js as the parallax engine rather than CSS. (See http://pixelcog.github.io/parallax.js/ for information on parallax.js)
Added ability to target the CSS class of the Post content/title. Also added the ability to target specific parallax styles through the ID
Updated the help files to be more in depth for customising and setting up. Also added more obvious message on admin page.
Updated - Bug fixes. 