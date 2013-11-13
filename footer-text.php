<?php
/**
 * Plugin Name: Footer Text
 * Plugin URI:  http://bungeshea.com/plugins/footer-text/
 * Description: Allow changing of the theme footer text easily from the dashboard
 * Author:      Shea Bunge
 * Author URI:  http://bungeshea.com
 * License:     MIT
 * License URI: http://opensource.org/licenses/MIT
 * Version:     1.0
 * Text Domain: footer-text
 * Domain Path: /languages
 */

/**
 * Administration
 */
require plugin_dir_path( __FILE__ ) . 'includes/admin.php';

/**
 * Shortcodes
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes.php';
$GLOBALS['footer_text_shortcodes'] = new Footer_Text_Shortcodes();

/**
 * Template Tags
 */
require plugin_dir_path( __FILE__ ) . 'includes/template-tags.php';
