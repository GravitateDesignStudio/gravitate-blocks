=== Gravitate Blocks ===
Contributors: Gravitate, bferdinand
Tags: Gravitate, Content Blocks, ACF, Advanced Custom Fields
Requires at least: 3.5
Tested up to: 4.4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily manage Content Blocks.

== Description ==

**Warning:** If you have been using version 1.1.0 or below updating may break the current blocks. We recommend copying the "grav-blocks" folder from the plugin to your theme folder before updating.

**Description:** Welcome to Gravitate Blocks: A content solution using WordPress and Advanced Custom Fields that allows clients to build an extremely flexible and stylish webpage without worrying about the code, layout or design. Clients select the type of content, add the content, and the system does the rest.

==Requirements==

- ACF Pro
- jQuery
- WordPress 3.5 or above


== Installation ==

1. Upload the `gravitate-blocks` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can configure the Plugin Settings in `Settings` -> `Gravitate Blocks`


== Changelog ==

= 1.3.0 =
* Added filter for grav_is_viewable
* Added ability for block icon and description
* Added foundation 6 grid and flex grid option
* Bug Fix - Media Block `add padding` checkbox did reverse of what it said

= 1.2.1 =
* Bug Fix - Memory Leak issue
* Bug Fix - Resolved PHP Warning

= 1.2.0 =
* Changed block names and intention ( HTML became "Content", Button became "Call to Action", Image became "Media", Image Content became "Media with Content", Grid became "Media Gallery")
* Updated Call to Action block to allow for multiple buttons
* Updated block labels in admin panel settings to be consistent
* Changed layout of Content block in admin panel
* Added default CSS option to address some basic styling
* Added Foundation responsive grid to help with layout styling
* Added Colorbox to allow Media Gallery to show in a grouped modal window

= 1.1.0 =
* Added Search Filtering Option
* Updated Background Color Options to retain settings
* Added Option to Remove Color Picker
* Updated Developer Tab

= 1.0.0 =
* Initial Creation

== Todo ==

* Add More Blocks
