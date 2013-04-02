=== Footer Text ===
Contributors: bungeshea
Donate link: http://bungeshea.com/donate/
Tags: front-end, footer, admin
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: 1.0
License: MIT
License URI: license.txt

Allow changing of the front-end footer text easily from the dashboard

== Description ==

Provides an interface in the dashboard, similar to the post edit screen, that allows you to easially change the text displayed in the footer on the front-end. After installing the plugin, add the `footer_text()` template tag to your `footer.php` theme template where you want the text to display.

Visit the [plugin homepage](http://bungeshea.com/plugins/footer-text/), or contribute to its development at [GitHub](https://github.com/bungeshea/footer-text/).

== Installation ==

1. Upload `footer-text.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit *Appearence > Footer Text* to write your awesome footer text
1. Place the `footer_text()` template tag somewhere in your theme where you want the text displayed
1. Visit site. Observe.

If you'd like to bundle this file with a theme so users don't need to install this plugin as well, copy the `footer-text.php` file to your theme's directory, and include this code in your theme's `functions.php`:

    include_once( get_template_directory_uri() . '/footer-text.php' );

Then use the `footer_text()` template tag in your theme templates.

== Frequently Asked Questions ==

= How can I display the footer text in my theme? =
You can use the `footer_text()` function to display the footer text, or the `get_footer_text()` function to return it for use in PHP. These template tags should generally be used in the `footer.php` file of your theme.

However, if the plugin isn't active, the template tag will result in an error. To solve this, you can use this code instead:

   <?php if ( function_exists( 'footer_text' ) ) footer_text(); ?>

= Can I bundle this plugin with my theme so users don't need to install this plugin? =

Sure thing! Just follow the instructions in the **Installation** section.

== Screenshots ==

1. Editing the footer text in the dashboard
2. Previewing the footer text on the Twenty Eleven theme

== Changelog ==

= 1.0 =
* Initial release
