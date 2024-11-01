=== SWH Users Only ===
Contributors: swhplugins
Donate link: http://sinawebhost.ir/donate/
Tags: shortcode, access, swh, swhplugins
Requires at least: 4.0
Tested up to: 4.3.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

SWH Users Only allows you to hide some parts of your content from not logged in users using shortcode.

== Description ==

Using this plugin, you can use this shortcodes into your content to protect them from non logged in users:

* __Text:__
When you want to hide some parts of the content

`[swh-users-only] Hello World! [/swh-users-only]`


* __Image:__
When an image is related to your users and you have to restrict it's access

`[swh-users-only] <img src="file.jpg" /> [/swh-users-only]`


* __Shortcode:__
When it's important that a contact form and it's file uploader only be filled by users

`[swh-users-only] [contact-form-7 id="1234" title="Contact form 1"] [/swh-users-only]`


* __HTML:__
When a download link have to be shown only to registered users

`[swh-users-only] <a href="file.zip">Download File</a> [/swh-users-only]`

== Installation ==

1. Upload `swh-users-only.zip` to the `/wp-content/plugins/` directory
2. Extract .zip file
3. Activate the plugin through the "Plugins" menu in WordPress
4. Place `[swh-users-only] [/swh-users-only]` in every content you like, ex: Post, Page, Custom Post Type

== Frequently Asked Questions ==

= Is this plugin works in custom post type? =

Yes, It works in Posts, Pages and Custom Post Types

== Changelog ==

= 1.0 =
*Release Date - 3th Nov, 2015*

* First initial release