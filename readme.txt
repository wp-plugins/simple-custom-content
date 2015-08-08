=== Simple Custom Content ===

Plugin Name: Simple Custom Content
Plugin URI: https://perishablepress.com/simple-custom-content/
Description: Easily add custom content to your posts and feeds.
Tags: customize, content, custom-content, posts, feeds, shortcodes
Author: Jeff Starr
Author URI: http://monzilla.biz/
Donate link: http://m0n.co/donate
Contributors: specialk
Requires at least: 4.0
Tested up to: 4.3
Stable tag: trunk
Version: 20150808
Text Domain: scc
Domain Path: /languages/
License: GPL v2 or later

Simple Custom Content is the easy way to add custom content to your posts and feeds.

== Description ==

[Simple Custom Content](https://perishablepress.com/simple-custom-content/) enables you to add custom content to all of your posts and all of your feeds, and provides several shortcodes for adding custom content in specific posts, pages, and just about anywhere in your theme. Ideal for adding copyright information, distribution policy, thank-you messages, custom links, special offers, etc.

**Options**

For each of the "all-posts" and "all-feeds" options, you can specify where you would like to display the custom content:

* At the beginning of the post or feed
* At the end of the post or feed
* At both the beginning and end of the post or feed
* Or do not display custom content (disable)

For the shortcodes options, you basically get to add custom content for the following shortcodes:

* `[scs_feed]` - custom content displayed wherever the shortcode is included in feed items
* `[scs_post]` - custom content displayed wherever the shortcode is included in posts
* `[scs_both]` - custom content displayed wherever in both posts and feeds
* `[scs_alt]` - bonus shortcode that displays custom content wherever you want

Additionally there is a "Restore Default Options" setting that basically does what it says.

== Installation ==

Upload and activate. Visit the SCS Settings page to add some custom content. Visit the [SCS Homepage](https://perishablepress.com/simple-custom-content/) for more information.

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

== Upgrade Notice ==

To upgrade SCS, remove old version and replace with new version. Nothing else needs done.

== Screenshots ==

Screenshots and more info available at the [SCS Homepage](https://perishablepress.com/simple-custom-content/#screenshots)

== Changelog ==

**20150808**

* Tested on WordPress 4.3
* Updated minimum version requirement

**20150507**

* Tested with WP 4.2 + 4.3 (alpha)
* Changed a few "http" links to "https"

**20150315**

* Tested with latest version of WP (4.1)
* Increased minimum version to WP 3.8
* Renamed plugin title in WP menu
* Removed deprecated screen_icon()
* Added Text Domain and Domain Path to file header
* Added $scs_wp_vers for minimum version check
* Streamline/fine-tune plugin code
* Changed text domain from scs to scc
* Added .pot translation template in /languages/
* Added $allowedposttags to wp_kses() validation
* Exclude pages from simple_custom_content_posts()

**20140925**

* Tested on latest version of WordPress (4.0)
* Increased min-version requirement to WP 3.7
* Added conditional check for min-version function

**20140305**

* Bugfix: now using isset() for toggling admin panel custom classes, resolves PHP error "undefined index"

**20140123**

* Tested with latest version of WordPress (3.8)
* Added trailing slash to load_plugin_textdomain()
* Fixed 3 incorrect _e() tags in core file

**20131106**

* Tested with latest version of WordPress (3.7)
* General code cleanup and maintenance
* Removed closing `?>` from simple-custom-content.php
* Added line to prevent direct loading of the script
* Added uninstall.php file
* Added "rate this plugin" links
* Added i18n support

**20130713**

* General code check n clean
* Improved localization support
* Overview and Updates admin panels toggled open by default

**20130104**

* Added margins to submit buttons

**20121025**

* Initial plugin release

== Frequently Asked Questions ==

To ask a question, visit the [SCS Homepage](https://perishablepress.com/simple-custom-content/) or [contact me](https://perishablepress.com/contact/).

== Donations ==

I created this plugin with love for the WP community. To show support, you can [make a donation](http://m0n.co/donate) or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

Links, tweets and likes also appreciated. Thanks! :)
