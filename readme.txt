=== Simple Custom Content ===

Plugin Name: Simple Custom Content
Plugin URI: http://perishablepress.com/simple-custom-content/
Description: Easily add custom content to your posts and feeds.
Tags: customize, content, custom-content, posts, feeds, shortcodes
Author URI: http://monzilla.biz/
Author: Jeff Starr
Contributors: specialk
Donate link: http://m0n.co/donate
Requires at least: 3.4
Tested up to: 3.8
Stable tag: trunk
Version: 20140305
License: GPLv2 or later

Simple Custom Content is the easy way to add custom content to your posts and feeds.

== Description ==

[Simple Custom Content](http://perishablepress.com/simple-custom-content/) enables you to add custom content to all of your posts and all of your feeds, and provides several shortcodes for adding custom content in specific posts, pages, and just about anywhere in your theme. Ideal for adding copyright information, distribution policy, thank-you messages, custom links, special offers, etc.

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

Upload and activate. Visit the SCS Settings page to add some custom content. Visit the [SCS Homepage](http://perishablepress.com/simple-custom-content/) for more information.

== Upgrade Notice ==

To upgrade SCS, remove old version and replace with new version. Nothing else needs done.

== Screenshots ==

Screenshots and more info available at the [SCS Homepage](http://perishablepress.com/simple-custom-content/#screenshots)

== Changelog ==

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

To ask a question, visit the [SCS Homepage](http://perishablepress.com/simple-custom-content/) or [contact me](http://perishablepress.com/contact/).

== Donations ==

I created this plugin with love for the WP community. To show support, consider purchasing one of my books: [The Tao of WordPress](http://wp-tao.com/), [Digging into WordPress](http://digwp.com/), or [.htaccess made easy](http://htaccessbook.com/).

Links, tweets and likes also appreciated. Thank you! :)
