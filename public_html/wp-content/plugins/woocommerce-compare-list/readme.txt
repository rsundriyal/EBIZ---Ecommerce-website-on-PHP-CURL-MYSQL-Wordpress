=== WooCommerce Compare List ===
Contributors: themeisle
Tags: woocommerce, compare, compare products, product compare, compare page, compare list, seo
Requires at least: 3.6
Tested up to: 4.4.2
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.opensource.org/licenses/gpl-license.php

WooCommerce Compare List plugin adds ability to easily compare products of your WooCommerce driven shop.

== Description ==

### WooCommerce Compare List Plugin ###

The plugin adds a simple and easy to use and setup products compare feature. Compared products are shown on front end as an aggregate table of all products attributes. Users will easily compare products and make their choice. You can also use **products-compare** shortcode to embed compare tables and **WooCommerce Recent Compares** widget to help your users to get back to their compares.

### SEO friendly ###

The plugin uses endpoints technique to build SEO friendly URLs for compare page. The compare page will have following URL:

**http://{yourdomain.name}/{compare-page-slug}/{endpoint-slug}/{product_id}-{product_id}-{product_id}-{etc}/**

This approach allows users to share their compare lists between their friends to help them choose a product.

### Use shortcode ###

You can use **[products-compare ids="..." atts="..."]** shortcode to embed compare table into your posts or pages. It will give you ability to write neat product review stories where you can compare different products.

Use **ids** attribute to enter comma/space separated list of products id, which should be displayed in the compare table. The **atts** attribute allows you to filter attributes list which should be displayed in the table. Enter comma separated list of attribute slugs which you can find at product attributes page.

### Configuration ###

After you install the plugin, you need to go to WooCommerce settings page. The new tab **Compare List** will appear there. That tab contains following settings:

**Compare page** - this is required option and you should select a page which will be used to display compare tables.

**Show in catalog** - this option allows you to enable or disable compare buttons rendering at products catalog page. If you uncheck this option, then no buttons will appear at product catalog pages.

**Show in product page** - this option is responsible for rendering compare buttons at single product page. If you uncheck this option, then no buttons will appear at single product pages.

**Endpoint slug** - this option responsible for endpoint slug, which is used in the compare page URL building.

**Compare button text** - use this option to override compare button text.

**Remove button text** - use this option to override remove compare button text.

== Installation ==

1. Upload plugin to the `/wp-content/plugins/` directory
1. Activate **WooCommerce Compare List** plugin through the 'Plugins' menu in WordPress
1. Go to WooCommerce settings page and open **Compare List** tab
1. Select compare page, which will display comparison table
1. Go to WordPress permalink settings and resave settings to flush rewrite rules

== Screenshots ==

1. Compare buttons at products catalog
2. Compare buttons at single product page

== Changelog ==

= 1.1 =

* Implemented [products-compare ids="..." atts="..."] shortcode.
* Implemented **Recent Compares** widget.

= 1.0.0 =

* Initial version of the plugin has been developed

= 1.1.1 =

* Update author name