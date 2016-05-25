=== Dokan Multivendor (Lite) ===
Contributors: tareq1988, wedevs
Donate Link: http://tareq.co/donate/
Tags: woocommerce, multivendor, multi-vendor, paypal, shop, vendor, seller, store, sell, online, amazon, dokan, ebay, Etsy, multi seller, multi store, multi vendor, multi vendors, multistore, multivendor, product vendor, product vendors, vendor, vendor system, vendors, wc market place, wc marketplace, wc vendors, woo vendors, woocommerce market place, woocommerce marketplace, woocommerce multi vendor,  commission rate, e-commerce, ebay, ecommerce, yith, yithemes
Requires at least: 4.4
Tested up to: 4.4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The pioneer multi-vendor plugin for WordPress. Start your own marketplace in minutes!

== Description ==

> #### This is a **Lite** version of the **Dokan** plugin.
> Get the [**Pro Version**](https://wedevs.com/products/plugins/dokan/?utm_source=wporg&utm_medium=cta&utm_campaign=dokan-lite) which includes bunch of features that were removed from this version.

A multi-vendor plugin leveraging the power of WooCommerce.


= Features =
**Marketplace with Independent Stores**

  * Every seller gets their own store with a unique URL and branding.
  * Show a store banner with contact details
  * Contact seller and show the store location map. (**Pro feature**)

**Dashboard For Each Seller**

  * Don't need to visit the WordPress admin area.
  * Sellers can manage their products and orders from your site frontend.

**Earn From Each Sale**

  * As a site owner, get a cut from each sale. That way you and your users both earn money.
  * Take a percentage from each sale. e.g. 20% goes to site owner for every order.
  * Per seller percentage override. Take different cut from different seller. (**Pro feature**)

**Product Management**

  * Create and manage your products from the frontend.
  * Create simple and/or variable products. (**Pro Feature**)
  * Sellers have option to manage product shipping, attributes. (**Pro Feature**)
  * Seller can mange downloadable product permission: expiry date and download limit. (**Pro Feature**)

**Reports (Pro Feature)**

  * Every seller can see his/her own sales report and see a bird eye view on the sales they are making.
  * Order overview and filter by Sale by date, Top sellers, Top earners.
  * Export order reports

**Coupon Management (Pro Feature)**

  * Manage and offer discounts for each products.
  * Set expiry and restriction for coupons.

**Manage Product Reviews (Pro Feature)**

  * You can manage the reviews on your products.
  * Approve/unapprove reviews.
  * See all the reviews for your products left by customers.


= Additional Pro Features =

  * Admin have additional option inside of his admin panel of Dokan
     * Admin can view and mange seller list
     * Admin can view his as well as every seller’s earning reports individually
     * Dokan Pro has update and support option for customer.
     * Dokan tools option has page installer and Sync table option
  * Settings tab has those option like-
     * **General**
        * Admin can enable/disable the map on the store page.
        * Admin can enable/disable the contact form on the store page
        * Admin can also enable/disable the store sidebar from theme.
     * **Selling Options**
        * Admin can manage new product status
        * Admin can set the order status for withdraw
        * Admin can seth threshold withdraw day for the seller
        * Admin can change the seller store URL
        * Admin can also enable/disable the permission of review editing for the seller
  * **Widgets**
     * Best seller widget
     * Featured seller widget
     * Store contact widget
     * Store location widget

And much more. Checkout the [**Pro Version**](https://wedevs.com/products/plugins/dokan/?utm_source=wporg&utm_medium=footer&utm_campaign=dokan-lite)

= Author =
Brought to you by [Tareq Hasan](http://tareq.wedevs.com) from [weDevs](http://wedevs.com)

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

= Q. Can I add a payment method? =
A. Just use any standard WooCommerce payment gateway.

= Q. How do withdrawals work? =
A. Right now, we offer PayPal, Bank and Skrill (pro) withdraw method for "Dokan". For PayPal withdraw, you can generate Mass Payment File to payout your sellers at once. Other methods are manual though.

= Q. Does Dokan integrate with BuddyPress? =
A. Not for the moment. We have plans to integrate with BuddyPress via an add-on in the near future.

= Q. Is Dokan responsive? =
A. Yes, Dokan is fully responsive. We take mobile first approach and it displays very well in mobile and tablet devices. We are using Twitter Bootstrap as a framework and it just works.

= Q. Does it supports variable products? =
A. The **Pro** version does! You can seller normal products, downloadable products and variable products with your own attributes.

= Q. Can each vendor customize his store? =
A. Right now we have options for only changing the store banner page. We are working on a better customizable seller store page.

= Q. Does Dokan supports PayPal adaptive payments? =
A. Yes it does! We have [an add-on](http://wedevs.com/plugin/dokan/paypal-adaptive-payments/) that brings PayPal adaptive payment support.

= Q. Will it be possible to take a cut or commission from the sales? =
A. Yes, that's how Dokan works. In every sales, you can cut a commission from a order. That's configurable from Dokan settings.

= Q. Can Dokan be used in a single seller mode? =
A. Obviously, you can use this on a single seller site to give them a nice front-end experience.

= Q. How to upgrade to the Pro version?
A. You just delete the free version and install and activate the pro version. Nothing complicated! All your data will be safe on the database and some extra features will be added. You can even ask the support team to help you to migrate.


== Screenshots ==

1. Admin Dashboard
2. Withdraw requests from sellers
3. Settings &rarr; General
4. Settings &rarr; Selling Options
5. Settings &rarr; Page Settings
6. Seller Dashboard in site frontend
7. Frontend &rarr; Products Listing
8. Frontend &rarr; Create a new Product
9. Frontend &rarr; Edit a product
10. Frontend &rarr; Product &rarr; Options
11. Frontend &rarr; Product &rarr; Inventory
12. Frontend &rarr; Orders Listing
13. Frontend &rarr; Orders &rarr; Details
14. Frontend &rarr; Submit withdraw request
15. Frontend &rarr; Store Settings
15. Frontend &rarr; Individual Seller Store

== Changelog ==

= v2.4.10 -> February 24, 2016 =
---------------------
- [new] New dashboard menu added for 'store link', 'edit account' and 'sign out'
- [fix] Remove repeated data rendering on admin panel dokan earning section
- [fix] Terms and condition not showing on registration issue
- [fix] Dashboard/orders page single view responsive issue
- [fix] Product edit and add issue on Firefox and IE browser
- [fix] Product variation save and update issues

= v2.4.9 -> February 01, 2016 =
---------------------
- [new] Plugin help page added
- [new] Seller search added on store listing
- [tweak] Some validation on contact seller email handler and after sent hook updated
- [tweak] Category check added on new product add without reloading page
- [tweak] Auto suggestion and clear button on flat view variation product attributes input field
- [fix] Downloadable file change in product after order issue fixed
- [fix] Order status translation issue on order listing page
- [fix] Email not send to seller on new order issue fixed
- [fix] Allow float number for seller percentage
- [fix] SEO hook updated for YOAST to make compatible with WP 4.4
- [fix] Browser jump issue in tab view on click of tabs

= v2.4.8 -> November 21, 2015 =
---------------------
- [tweak] Email template override system added
- [fix] Change dokan SEO admin option section
- [fix] Ajax url fixed to prevent conflict
- [fix] Fix Arrow (reverted) for pagination
- [fix] Hide unapproved comment from store review tab
- [fix] Update cart discount meta on suborder create

= v2.4.7 -> October 20, 2015 =
---------------------
- [fix] Fix Coupon discount redundancy
- [fix] Fix product gallery image delete issue on tab view
- [fix] Fix translation issue on user migration form
- [fix] Fix Store listing template view for not logged-in user
- [fix] parent sub-order creation on unsuccessful payment by card
- [fix] Store page breadcrumb fixed to show Store name and listing link properly


= v2.4.6 -> October 12, 2015 =

- [tweak] Added terms and condition option field on Registration form
- [fix] Remove required for product per page field on store settings
- [fix] Fix delete variation product issue on tab view for seller
- [fix] Fix redundant data for guest users
- [fix] Fix responsive issue on front page product listing
- [fix] Seller store banner size to cover
- [fix] Store template fix for Twenty Twelve theme


= v2.4.5 -> September 14, 2015 =

 * [fix] Fix responsive style issue for store page
 * [fix] Fix undefined parent order object issue on creat sub-order
 * [fix] Fix seller dashboard product comments count on widget

= v2.4.4 -> September 4, 2015 =

 * [new] Seller balance re-sync by checking unexpected order button added on tools page
 * [fix] Make some text translatable on contact seller widget
 * [fix] Optimize sql query to make regenerate process fast
 * [fix] Fix WooCommerce deactivate dependency issue
 * [fix] Fix plugin bulk activate issue with dokan welcome page

= v2.4.3 -> August 25, 2015 =

 * [new] Welcome page on activation with re-sync button added
 * [tweak] Visual Progress bar added for re-sync Order progress
 * [fix] Sub-order duplicate issue fixed
 * [fix] Fix WP editor compatible to 4.3
 * [fix] Compatible with WordPress 4.3 widget __construct functions
 * [fix] Fix table name in sync table sql
 * [fix] Fix store review rewrite problem, Move store functionality in Dokan_Pro_Store class
 * [fix] Fix seller migration template loader
 * [fix] Fix same seller multiple product type shipping issue
 * [fix] Fix flat rate shipping issue for multi seller

= v2.4.2 -> August 12, 2015 =

 * [tweak] New hook on store header: dokan_store_before_social
 * [tweak] Re-arrange dokan admin settings fields
 * [tweak] Add field on seller store settings to manage store product per page
 * [tweak] Sellers redirected to dashboard after login
 * [fix] Feature seller widget display template path
 * [fix] Best seller widget display seller name changed to store name
 * [fix] Fix problem with showing variation data on order details
 * [fix] Update "dokan_create_seller_order" function to save variation order meta on sub-order
 * [fix] Update "dokan_post_input_box" function to add option for making text field and number field required
 * [fix] Fix balance separator problem on withdraw
 * [fix] Fix total sales balance display on seller dashboard page
 * [fix] Keep value saved of override shipping fields meta even when the option unchecked
 * [fix] English language phrases correction on several place
 * [fix] Fix calculation of sub-orders in WooCommerce dashboard status widget sales query

= 2.4.1 (August 1, 2015) =
 * [new] Pro version rewrite to Free

= 1.0 =
Initial version released


== Upgrade Notice ==

Nothing here
