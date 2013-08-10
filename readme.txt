=== Footer Text ===
Contributors:      bungeshea
Donate link:       http://bungeshea.com/donate/
Tags:              front-end, footer, admin, dashboard, visual, theme, footer text, shortcodes, template tags
Requires at least: 3.3
Tested up to:      3.6
Stable tag:        2.0
License:           MIT
License URI:       license.txt

Allow changing of the theme footer text easily from the dashboard

== Description ==

Provides an interface in the dashboard, similar to the post edit screen, that allows you to easily change the text displayed in the footer on the front-end. After installing the plugin, add the `footer_text()` template tag to your `footer.php` theme template where you want the text to display. For more options, see the [FAQ](http://wordpress.org/plugins/footer-text/faq).

You can use these shortcodes in the footer text editor:

* `[last_modified]` the date that the current page was last modified on
* `[page_link]` the full permalink of the current page, formatted. The content wrapped in this shortcode will be used as the link text
* `[year]` the current year eg: 2013

Visit the [plugin homepage](http://bungeshea.com/plugins/footer-text/), or contribute to its development at [GitHub](https://github.com/bungeshea/footer-text).

== Installation ==

1. Upload the `footer-text` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit *Appearance > Footer Text* to write your awesome footer text
1. Place the `footer_text()` template tag somewhere in your theme where you want the text displayed
1. Visit site. Observe.

== Frequently Asked Questions ==

= How can I display the footer text in my theme? =
You can use the `footer_text()` function to display the footer text, or the `get_footer_text()` function to return it for use in PHP. These template tags should generally be used in the `footer.php` file of your theme.

However, if the plugin isn't active, the template tag will result in an error. To solve this, you can use this code instead:

	do_action( 'footer_text', $default, $before, $after );

The `get_footer_text()` function returns the formatted footer text and accepts one parameter: `$default`, which will be returned if no text is set.

The `footer_text()` function outputs the formatted footer text and accepts three parameters: `$before`, `$after` and `$default`. `$before` will be outputted *before* the text, `$after` will be outputted *after* the text, and `$default` will be used instead of the text is none is set. If no text is set `$default` is empty, nothing will be displayed.

== Screenshots ==

1. Editing the footer text in the dashboard
2. Previewing the footer text on the Twenty Eleven theme

== Changelog ==

= 2.0 =
* Delete footer text from database on uninstall
* Add an action as an alternate way to display footer text
* Restructured code
* Fixed [page_link] shortcode
* Added custom 'edit_footer_text' capability

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.0 =
Lots of improvements; read the changelog
