=== Plugin Name ===
Contributors: josk79
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=5T9XQBCS2QHRY&lc=NL&item_name=Jos%20Koenis&item_number=wordpress%2dplugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: woocommerce, coupons, discount
Requires at least: 4.0.0
Tested up to: 4.5.2
Stable tag: 2.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Additional functionality for WooCommerce Coupons: Allow discounts to be automatically applied, applying coupons via url, etc...

== Description ==

"WooCommerce Extended Coupon Features" adds functionality to the WooCommerce coupons and allows for automatic discount rules. 
Very easy to use, the functionality is conveniently integrated to the WooCommerce Edit Coupon panel.

Compatible with WooCommerce 2.5.5. Backwards compatible with older WooCommerce versions (2.2.8 confirmed).

Full documentation is available at [www.soft79.nl](http://www.soft79.nl/documentation/wjecf).

* *Auto coupons*: Allow coupons to be automatically added to the users cart if it's restrictions are met,
* Apply coupon via an url,
* Restrict coupon by shipping method,
* Restrict coupon by payment method,
* Restrict coupon by a combination of products
* Restrict coupon to certain customer roles
* (PRO) Add *free products* to the customer's cart based on coupon rules
* (PRO) Allow a cart discount to be applied based on quantity / subtotal of matching products
* (PRO) Set Auto Coupon priorities (Useful for 'Individual Use Only'-coupons)
* (PRO) API to allow developers to use functions of this plugin

For more information or the PRO version please visit [www.soft79.nl](http://www.soft79.nl)

= Example: Auto coupon =

Let the customer have a discount of $ 5.00 when the cart reaches $ 50.00. 

1. Create a coupon, let's name it *auto_50bucks* and enter a short description e.g. *$ 50.00 order discount*
2. On the General tab: Select discount type *Cart discount*, and set the coupon amount to $ 5.00
3. On the Usage restrictions tab: Set minimum spend to $ 50.00 and check the *Auto coupon*-box

Voila! The discount will be applied when the customer reaches $ 50.00 and a descriptive message will be shown.

If the restrictions are no longer met, it will silently be removed from the cart.

= Example: Apply coupon via an URL =

Apply coupon through an url like this:

1. Use the url www.example.com/url-to-shop?apply_coupon=my_coupon

Voila! Any coupon can be applied this way.


This plugin has been tested in combination with WPML and qTranslate-X.

== Installation ==

1. Upload the plugin in the `/wp-content/plugins/` directory, or automatically install it through the 'New Plugin' menu in WordPress
2. Activate the plugin through the 'Plugins' menu in WordPress

= How to create an automatically added coupon? =

1. Create a coupon through the 'Coupons' menu in WooCommerce. TIP: Name it auto_'whatever' so it will be easy to recognize the auto coupons
2. Setup the coupon as you'd normally would. Make sure you enter a description for the coupon and set usage restrictions
3. In the "Miscellaneous" tab, check the box *Auto coupon*
4. Voila! That's it

== Frequently Asked Questions ==

= Is the plugin translatable? =

Yes, all string values are translatable through the supplied POT/PO/MO files. In WPML translatable items appear in the context `woocommerce-jos-autocoupon` in "String Translations".

= Why isn't my coupon applied using www.example.com?apply_coupon=my_coupon ? =

The coupon will only be applied if the url links to a WooCommerce page (e.g. product loop / cart / product detail ).

= The cart is not updated after changing the payment method =

In your theme add class "update_totals_on_change" to the container (div / p / whatever) that holds the payment method radio buttons.
You can do this by overriding woocommerce/templates/checkout/payment.php (place it in your_template/woocommerce/checkout/).

= The cart is not updated after changing the billing email address =

Paste this snippet in your theme's functions.php:
`
//Update the cart preview when the billing email is changed by the customer
add_filter( 'woocommerce_checkout_fields', function( $checkout_fields ) {
	$checkout_fields['billing']['billing_email']['class'][] = 'update_totals_on_change';
	return $checkout_fields;	
} );
`

= Can I make a donation? =

Sure! [This](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=5T9XQBCS2QHRY&lc=NL&item_name=Jos%20Koenis&item_number=wordpress%2dplugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted) is the link. Greatly appreciated!

== Screenshots ==

1. Allow a coupon to be applied automatically by checking "Auto coupon".
2. Extra restrictions. E.g. Quantity or subtotal of matching products.
3. (PRO) A free product has been applied to the cart
4. Additionals restrictions based on shipping or payment method or the customer

== Changelog ==

= 2.3.3 =
* FIX: limit_usage_to_x_items: Removed call to get_discount_amount from coupon_has_a_value; it is redundant and caused limit_usage_to_x_items to change
* (PRO) FEATURE: Filters wjecf_free_product_amount_for_coupon, wjecf_bogo_product_amount_for_coupon and wjecf_set_free_product_amount_in_cart
* (PRO) FEATURE: Keep track of by-url-coupons (?apply_coupon=) and apply when they validate
* (PRO) FIX: Experimental feature 'Allow discount on cart with excluded items' didn't work since 2.2.3
* (PRO) FIX: Invalid free product quantity applied when using both BOGO and FREE products in a single coupon.
* (PRO) FIX: limit_usage_to_x_items: Possible wrong discount on combination of limit_usage_to_x_items and _wjecf_apply_discount_to

= 2.3.2 =
* FEATURE: Display custom error message when coupon is invalidated by this plugin
* FIX: apply_coupon redirected to wrong url when home_url contained a subdirectory
* FIX: Remove add-to-cart when redirecting for apply_coupon
* FIX: Auto Coupon Backwards compatability for WooCommerce versions prior to 2.3.0 that don't have hook woocommerce_after_calculate_totals
* TRANSLATION: Persian. Thanks to Ehsan Shahnazi.

= 2.3.1.1 =
* TRANSLATION: Brazilian Portuguese. Thanks to Francisco.

= 2.3.1 =
* FIX: WPML Compatibility for AND Products / AND Categories
* FIX: Redirect to page without ?apply_coupon= after applying coupon by url
* FIX: Auto coupon meta_query issue (thanks to hwillson)
* FIX: Compatibility with WooCommerce prior to 2.2.9 (WC_Cart::get_cart_item)
* (PRO) FIX: Free products: Add variant attributes to cart items for variable products
* (PRO) FEATURE: Apply discount only to the cheapest product

= 2.3.0 =
* (PRO) FEATURE: Allow customer to choose a free product
* (PRO) FEATURE: Setting the priority of auto coupons (Useful for Individual use coupons)
* (PRO) FEATURE: Display extra columns on the Coupon Admin page (auto coupon, individual use, priority, free products)
* (PRO) TWEAK: Free products: Display 'Free!' as subtotal for free products, (adaptable with filter 'wjecf_free_cart_item_subtotal' )
* (PRO) FIX: Free products: Plugin wouldn't always detect the free products in cart and kept appending free products
* (PRO) Introduction of the API for developers, see wjecf-pro-api.php
* FEATURE: Filter to only display Auto Coupons on the Coupon Admin page
* FIX: Compatibilty PHP 5.4
* FIX: Rewritten and simplified Autocoupon removal/addition routine making it more robust
* FIX: Multiplier value calculation (as for now only used for Free Products)
* FIX: Coupon must never be valid for free products (_wjecf_free_product_coupon set in cart_item)
* INTERNAL: Refactoring of all classes
* INTERNAL: New log for debugging

= 2.2.5.1 =
* FIX: When checkbox 'Individual use' was ticked, Autocoupons would be removed/added multiple times

= 2.2.5 =
* (PRO) FEATURE: BOGO On all matching products
* FIX: Changed WooCommerce detection method for better Multi Site support
* (PRO) FIX: Free products: Fixed an inconsistency that could cause a loop on removal/adding of free variant products
* (PRO) TWEAK: Free products: Hooking before_calculate_totals for most cases but also on woocommerce_applied_coupon, which is required when one coupon is replaced by another
* INTERNAL: Check if classes already exist before creating them

= 2.2.4 =
* FEATURE: Online documentation added
* FEATURE: Use AND-operator for the selected categories (default is OR)
* FIX: Backwards compatibility with WooCommerce 2.3.7 (WC_Cart::is_empty)
* FIX: Backwards compatibility with WooCommerce < 2.3.0 (WC_Coupon::is_type, Chosen in stead of Select2)

= 2.2.3 =
* (PRO) FEATURE: Allow discount on cart with excluded items
* (PRO) FEATURE: Free products!
* FEATURE: Allow coupon in cart even if minimum spend not reached
* FEATURE: New coupon feature: Minimum / maximum price subtotal of matching products in the cart
* COSMETIC: Admin Extended coupon features in multiple tabs
* FIX: Create session cookie if no session was initialized when applying coupon by url
* TWEAK: Auto coupon: Use woocommerce_after_calculate_totals hook for update_matched_autocoupons
* API: New function: $wjecf_extended_coupon_features->get_quantity_of_matching_products( $coupon )
* API: New function: $wjecf_extended_coupon_features->get_subtotal_of_matching_products( $coupon )

= 2.2.1 =
* FIX: Prevent mulitple apply_coupon calls (for example through ajax)
* FIX: Don't redirect to cart when using WooCommerce's ?add-to-cart=xxx in combination with ?apply_coupon=xxx as this would prevent the application of the coupon.

= 2.2.0 =
* FIX: Lowered execution priority for apply_coupon by url for combinations with add-to-cart.
* FEATURE: New coupon feature: Excluded customer role restriction
* FEATURE: New coupon feature: Customer / customer role restriction
* FEATURE: New coupon feature: Minimum / maximum quantity of matching products in the cart
* FEATURE: New coupon feature: Allow auto coupons to be applied silently (without displaying a message)
* TWEAK: Moved all settings to the 'Extended features'-tab on the admin page.
* FIX: 2.0.0 broke compatibility with PHP versions older than 5.3
* FIX: Changed method to fetch email addresses for auto coupon with email address restriction
* FILTER: Filter wjecf_coupon_has_a_value (An auto coupon will not be applied if this returns false)
* FILTER: Filter wjecf_coupon_can_be_applied (An auto coupon will not be applied if this returns false)
* INTERNAL: db_version tracking for automatic updates
* INTERNAL: Consistent use of wjecf prefix. 
* INTERNAL: Renamed meta_key woocommerce-jos-autocoupon to _wjecf_is_auto_coupon

= 2.0.0 =
* RENAME: Renamed plugin from "WooCommerce auto added coupons" to "WooCommerce Extended Coupon Features"
* FEATURE: Restrict coupons by payment method
* FEATURE: Restrict coupons by shipping method	
* FEATURE: Use AND-operator for the selected products (default is OR)
* FIX: Validate email restrictions for auto coupons
* Norwegian translation added (Thanks to Anders Zorensen)

= 1.1.5 =
* FIX: Cart total discount amount showing wrong discount value in newer WooCommerce versions (tax)
* Performance: get_all_auto_coupons select only where meta woocommerce_jos_autocoupon = yes (Thanks to ircary)

= 1.1.4 =
* Translation support through .mo / .po files
* Included translations: Dutch, German, Spanish (Thanks to stephan.sperling for the german translation)

= 1.1.3.1 =
* FIX: Apply auto coupon if discount is 0.00 and free shipping is ticked	

= 1.1.3 =
* Don't apply coupon if the discount is 0.00
* Allow applying multiple coupons via an url using *?apply_coupon=coupon_code1,coupon_code2

= 1.1.2 =
* Minor change to make the plugin compatible with WooCommerce 2.3.1
* Loop through coupons in ascending order

= 1.1.1 =
* Tested with Wordpress 4.0

= 1.1.0 =
* Allow applying coupon via an url using *?apply_coupon=coupon_code*

= 1.0.1 =
* Don't add the coupon if *Individual use only* is checked and another coupon is already applied.

= 1.0 =
* First version ever!
