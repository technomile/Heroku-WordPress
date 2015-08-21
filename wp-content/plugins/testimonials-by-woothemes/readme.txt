=== Testimonials by WooThemes ===
Contributors: woothemes, mattyza, jameskoster
Donate link: http://woothemes.com/
Tags: testimonials, widget, shortcode, template-tag, feedback, customers
Requires at least: 3.4.2
Tested up to: 3.9.1
Stable tag: 1.5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Show off what your customers are saying about your business and how great they say you are, using our shortcode, widget or template tag.

== Description ==

"Testimonials by WooThemes" is a clean and easy-to-use testimonials management system for WordPress. Load in what your customers are saying about your business, and display the testimonials via a shortcode, widget or template tag on your website.

Looking for a helping hand? [View plugin documentation](http://wordpress.org/plugins/testimonials-by-woothemes/other_notes/).

Looking to contribute code to this plugin? [Fork the repository over at GitHub](http://github.com/woothemes/testimonials/).
(submit pull requests to the latest "release-" branch)

== Usage ==

To display your testimonials via a theme or a custom plugin, please use the following code:

`<?php do_action( 'woothemes_testimonials' ); ?>`

To add arguments to this, please use any of the following arguments, using the syntax provided below:

* 'limit' => 5 (the maximum number of items to display)
* 'per_row' => 3 (when creating rows, how many items display in a single row?)
* 'orderby' => 'menu_order' (how to order the items - accepts all default WordPress ordering options)
* 'order' => 'DESC' (the order direction)
* 'id' => 0 (display a specific item)
* 'display_author' => true (whether or not to display the author information)
* 'display_avatar' => true (whether or not to display the author avatar)
* 'display_url' => true (whether or not to display the URL information)
* 'echo' => true (whether to display or return the data - useful with the template tag)
* 'size' => 50 (the pixel dimensions of the image)
* 'title' => '' (an optional title)
* 'before' => '&lt;div class="widget widget_woothemes_testimonials"&gt;' (the starting HTML, wrapping the testimonials)
* 'after' => '&lt;/div&gt;' (the ending HTML, wrapping the testimonials)
* 'before_title' => '&lt;h2&gt;' (the starting HTML, wrapping the title)
* 'after_title' => '&lt;/h2&gt;' (the ending HTML, wrapping the title)
* 'category' => 0 (the ID/slug of the category to filter by)

The various options for the "orderby" parameter are:

* 'none'
* 'ID'
* 'title'
* 'date'
* 'menu_order'

`<?php do_action( 'woothemes_testimonials', array( 'limit' => 10, 'display_author' => false ) ); ?>`

The same arguments apply to the shortcode which is `[woothemes_testimonials]` and the template tag, which is `<?php woothemes_testimonials(); ?>`.

== Usage Examples ==

Adjusting the limit and image dimension, using the arguments in the three possible methods:

do_action() call:

`<?php do_action( 'woothemes_testimonials', array( 'limit' => 10, 'size' => 100 ) ); ?>`

woothemes_testimonials() template tag:

`<?php woothemes_testimonials( array( 'limit' => 10, 'size' => 100 ) ); ?>`

[woothemes_testimonials] shortcode:

`[woothemes_testimonials limit="10" size="100"]`

== Installation ==

Installing "Testimonials by WooThemes" can be done either by searching for "Testimonials by WooThemes" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via WordPress.org.
1. Upload the ZIP file through the "Plugins > Add New > Upload" screen in your WordPress dashboard.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action( 'woothemes_testimonials' ); ?>` in your templates, or use the provided widget or shortcode.

== Frequently Asked Questions ==

= The plugin looks unstyled when I activate it. Why is this? =

"Testimonials by WooThemes" is a lean plugin that aims to keep it's purpose as clean and clear as possible. Thus, we don't load any preset CSS styling, to allow full control over the styling within your theme or child theme.

= How do I contribute? =

We encourage everyone to contribute their ideas, thoughts and code snippets. This can be done by forking the [repository over at GitHub](http://github.com/woothemes/testimonials/).

== Screenshots ==

1. The testimonials management screen within the WordPress admin.

== Upgrade Notice =

= 1.5.4 =
* 2015-07-07
* Removes deprecated constructor call for WP_Widget

= 1.4.1 =
* Fixes display of testimonials when no "id" parameter is set.

= 1.4.0 =
* Adds "per_row" functionality, a "columns-X" CSS class on the wrapper, support for multiple comma-separated ID values in the "id" argument and a "no-image" CSS class if no image is available for the item.

= 1.3.2 =
* Adds filters for the single testimonials and testimonial archives URL slugs
* Adds a flush_rewrite_rules() call on plugin activation

= 1.3.1 =
* Fixes bug where testimonial text doesn't display (incorrectly placed action hook).

= 1.3.0 =
* Adds "woothemes_testimonials_content" filter and shortcode support. Adds "testimonial-category" taxonomy.

= 1.2.1 =
* Minor bugfixes in the "order" directions options.
* Adds support for random ordering in the widget.

= 1.2.0 =
* Adds basic WPML support.
* Enhancements to the widget output.
* Adds new arguments for controlling the HTML wrapping the testimonials, as well as wrapping the title.

= 1.1.0 =
* Added avatar display options and performed routine plugin maintenance.

= 1.0.0 =
* Initial release. Woo!

== Changelog ==

= 1.5.4 =
* 2015-07-07
* Removes deprecated constructor call for WP_Widget

= 1.5.3 =
* 2014-07-03
* Fix - $post global in template inadvertently removed in 1.5.2.

= 1.5.2 =
* 2014-07-02.
* Tweak - If a URL is set the avatar will link to it.
* Tweak - More tag works as expected.
* Fix - Dont override global $post variable.

= 1.5.1 =
* 2014-03-26.
Fix - Potential division by zero notice.
Tweak - Default post type args are now filterable: `woothemes_testimonials_post_type_args` (props lkraav).
Tweak - Remove unused assets.
Tweak - Avatar no longer links to testimonial url.
Tweak - oEmbed in testimonial content now works.

= 1.5.0 =
* 2014-01-02.
* Default testimonial args now filterable.
* Schema friendly markup.
* 'Testimonials Per Row' option added to widget.
* UI tweaks for wp 3.8.
* Added woothemes_testimonials_author_link_text filter.

= 1.4.1 =
* 2013-08-22.
* Fixes display of testimonials when no "id" parameter is set.

= 1.4.0 =
* 2013-08-20.
* Adds "per_row" functionality and a "columns-X" CSS class on the wrapper.
* Adds support for multiple comma-separated ID values in the "id" argument.
* Adds a "no-image" CSS class if no image is available for the item.
* Renames the effect CSS class to include "effect-" as a prefix (for example, "effect-fade").
* Adds "woothemes_testimonials_single_slug" as a filter for the single testimonials URL slug
* Adds "woothemes_testimonials_archive_slug" as a filter for the testimonials archive URL slug
* Adds a flush_rewrite_rules() call on plugin activation

= 1.3.1 =
* 2013-04-30.
* Fixes bug where testimonial text doesn't display (incorrectly placed action hook).

= 1.3.0 =
* 2013-04-30.
* Adds "woothemes_testimonials_content" filter for modifying the content of testimonials when outputting the testimonials list.
* Adds default filters to the "woothemes_testimonials_content" hook, enabling shortcodes in the content field.
* Adds "testimonial-category" taxonomy and necessary logic for displaying testimonials from a specified category.
* Makes sure the ".avatar" CSS class is applied when using the featured image instead of a Gravatar.
* Fixes typo in the widget's class name.

= 1.2.1 =
* 2013-01-03
* Minor bugfixes in the "order" directions options.
* Adds support for random ordering in the widget.
* Allow the "size" parameter to receive an array when used with the template tag or do_action() call.

= 1.2.0 =
* 2012-11-28
* Adds basic WPML support to the get_features() method.
* Moves the "title" outside of the ".testimonials" DIV tag.
* Adds "before" and "after" arguments for filtering the HTML for the container. Integrate the $before_widget and $after widget variables to use these parameters with the widget.
* Adds "before_title" and "after_title" arguments, for filtering the title's wrapping HTML. Integrate the $before_title and $after_title widget variables to use these parameters with the widget.

= 1.1.0 =
* 2012-11-08
* Added option to display or hide the avatar.
* Fixed bug where %%AVATAR%% tag was displaying if no avatar image was available for a testimonial.

= 1.0.0 =
* 2012-10-23
* Initial release. Woo!
