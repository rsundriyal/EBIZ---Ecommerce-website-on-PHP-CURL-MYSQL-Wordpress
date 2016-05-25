=== Better User Search ===
Contributors: dale3h
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=E8UETG65PQJC2
Tags: user, users, search, admin, backend, woocommerce, customers, meta
Requires at least: 3.1
Tested up to: 4.4.2
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Improves the search for users in the admin significantly: Search for first name, last, email and much more of users instead of only nicename.

== Description ==

Better User Search is a must have plugin if you're running WooCommerce. Without it, you're stuck trying to remember every
customer's username.

Better User Search is used to improve the user search functionality in the admin/backend.

WordPress by default only allows you to search for users by username/nicename. Using Better User Search, you will be able
to search by first name, last name, email address and any custom user meta field that already exists in the user meta table.

On top of that, there is an "OR" feature provided. Just include the word "or" (case-insensitive) in your search query
and the plugin will search for any user that matches at least 1 of the search terms.

"OR" Search Example:
Let's find all WooCommerce customers in Texas or Florida. To do this, first make sure that `billing_state` and `shipping_state`
are setup in the Better User Search settings. Now head to the Users page and type "TX or FL" into the search field.

It really is that simple!

== Installation ==

1. Upload the **better-user-search** folder to the **/wp-content/plugins/** directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit 'Settings > User Search' and adjust your configuration.

== Other Notes ==

Special characters like quotes are escaped, problems with the query may appear when trying to search for other non-alphanumeric characters.

== Frequently Asked Questions ==

= What is the answer to life, the universe and everything? =
42

== Screenshots ==

1. Settings page (Settings > User Search )
2. Users page

== Changelog ==

= 1.1.1 =
* Fix: PHP notices - thanks @SooBahkDo
* Notes: Added WordPress 4.4.2 compatibility

= 1.1.0 =
* Feature: Auto detect WooCommerce for default searchable meta keys
* Fix: Bug when using "or" keyword multiple times in search query
* Fix: PHP error for "get_current_screen" when updating to 1.0.5 - thanks @mqfell
* Fix: Cleanup leftover plugin data when uninstalling

= 1.0.5 =
* Feature: Better searching for WooCommerce customers on the orders page

= 1.0.4 =
* Improvement: Optimized MySQL query when populating the plugin's searchable meta keys table

= 1.0.3 =
* Fix: Now compatible with "Admin Columns Pro" plugin - thanks @mqfell

= 1.0.2 =
* Fix: Optimized search algorithm to be faster
* Fix: MySQL collation error when using WordPress 4.2 or later

= 1.0.1 =
* Fix: MySQL error when wp_users and wp_usermeta tables had mismatched collations

= 1.0 =
* Just getting started...

== Upgrade Notice ==

= 1.0.5 =
Better User Search is now enabled on the WooCommerce customer search on the orders page!

= 1.0.3 =
Now compatible with Admin Columns Pro!

= 1.0 =
First release of the Better User Search plugin. Enjoy!
