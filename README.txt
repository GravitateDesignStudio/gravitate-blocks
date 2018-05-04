=== Gravitate Blocks ===
Contributors: Gravitate, bferdinand
Tags: Gravitate, Content Blocks, ACF, Advanced Custom Fields
Requires at least: 3.5
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily add content to your site with Gravitate Blocks.

== Description ==

**Warning:** If you have been using version 1.1.0 or below updating may break the current blocks. We recommend copying the "grav-blocks" folder from the plugin to your theme folder before updating.

**Description:** Welcome to Gravitate Blocks: A content solution using WordPress and Advanced Custom Fields that allows clients to build an extremely flexible and stylish webpage without worrying about the code, layout or design. Clients select the type of content, add the content, and the system does the rest.

==Requirements==

- ACF Pro v5
- jQuery
- WordPress 3.5 or above


== Installation ==

1. Upload the `gravitate-blocks` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You can configure the Plugin Settings in `Settings` -> `Gravitate Blocks`


== Changelog ==

= 3.0.0 =


= 1.7.5 =
* Bug fix - fixed issue with supplying post id instead of attachment id to image functions.
* Added new excerpt filtering checkbox for all excerpts

= 1.7.4 =
* Bug fix - fixed an issue with columns on media content block
* Styling change for WordPress dashboard menu

= 1.7.3 =
* Bug fix - fixed a php error with the display function

= 1.7.2 =
* Bug fix - responsive images causing js error on non block enabled pages

= 1.7.1 =
* Bug fix - fixed an issue where not specifying an image with responsive images caused an empty img tag

= 1.7.0 =
* Added Responsive image functionality
* Added function to return image tag
* Added function to return WP image sizes
* Added function to return responsive image sizes
* Added filter for grav_link_fields
* Changed "Content" block to always have at least 1 column
* Bug fix - added https for vimeo
* Bug fix - Resolved issue with background colors

= 1.6.1 =
* Updated $block_index to be a public variable
* Bug fix - Found intermittent class error on activation
* Moved Gravitate Blocks out of settings

= 1.6.0 =
* Added filter grav_block_background_colors
* Added filter grav_block_background_style
* Added option for unique IDs for each block
* Updated sub field setup for blocks
* Updated block handler to use CSS method which is filterable

= 1.5.0 =
* Added filter grav_block_background_colors
* Added filter grav_hide_on_screen
* Added filter grav_column_widths
* Added filter grav_block_mediacontent_columns
* Link fields now required after choosing a link type.
* Added ability to remove the WordPress Content box from Gravitate Block enabled areas
* Bug Fix - Display issue for custom blocks with a description

= 1.4.0 =
* Added filter for grav_get_css
* Added filter for grav_block_content_columns
* Added public variable for current block GRAV_BLOCKS::$current_block_name
* Added classes for flexgrid ordering for media with content block
* Bug Fix - Fixed description display issue on call to action block
* Bug Fix - Correct discrepancy between displays of testimonial and quote block (with update you no longer need to add quotes for either block)
* Bug Fix - Resolved PHP Warnings
* Bug Fix - Resolved order issue with block "Media with Content"

= 1.3.1 =
* Bug Fix - Fixed a display issue for the block background images

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
