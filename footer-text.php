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
 */

/**
 * Administration
 */
require plugin_dir_path( __FILE__ ) . 'admin.php';

/**
 * Shortcodes
 */
require plugin_dir_path( __FILE__ ) . 'shortcodes.php';

/**
 * Template Tags
 */
require plugin_dir_path( __FILE__ ) . 'template_tags.php';
