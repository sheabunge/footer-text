<?php
/**
 * Plugin Name: Footer Text
 * Plugin URI: http://bungeshea.com/plugins/footer-text/
 * Description: Allow changing of the footer text easily from the dashboard
 * Author: Shea Bunge
 * Author URI: http://bungeshea.com
 * License: MIT
 * License URI: http://opensource.org/licenses/mit-license.php
 * Version: 1.0
 */

/** Dashboard Administration Menu ********************************************/

/**
 * Add the footer text options page to
 * the 'Appearance' dashboard menu
 *
 * @uses add_theme_page() To register the new submenu
 *
 * @return void
 *
 * @since 1.0
 */
function add_footer_text_options_page() {
	$theme_page = add_theme_page(
		__( 'Footer Text', 'footer-text' ), // Name of page
		__( 'Footer Text', 'footer-text' ), // Label in menu
		'edit_theme_options',               // Capability required
		'footer-text',                      // Menu slug, used to uniquely identify the page
		'render_footer_text_options_page'   // Function that renders the options page
	);
}
add_action( 'admin_menu', 'add_footer_text_options_page' );

/**
 * Display the footer text options page
 * and save posted text to the database
 *
 * @uses update_option() To save the text to the database
 * @uses screen_icon() To display the dashboard menu icon
 * @uses wp_editor() For a visual editor
 * @uses get_option() To retrieve the current text from the database
 * @uses submit_button() To generate a form submit button
 *
 * @return void
 *
 * @since 1.0
 */
function render_footer_text_options_page() {

	if ( isset( $_POST['footer_text'] ) )
		update_option( 'theme_footer_text', stripslashes( $_POST['footer_text'] ) );

	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php _e( 'Footer Text', 'footer-text' ); ?></h2>


		<form method="post" action="" style="margin: 20px 0;">
			<?php
				wp_editor( get_option( 'theme_footer_text', '' ), 'footer_text' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/** Template Tags ******************************************************/

/**
 * Fetches the footer text from the database
 * with formatting functions applied
 *
 * @return string The formatted footer text
 *
 * @since 1.0
 */
function get_footer_text( $default = '' ) {
	return apply_filters( 'the_content', get_option( 'theme_footer_text', $default ) );
}

/**
 * Retrieves the footer text and displays it if it is set
 * Nothing is displayed if the footer text is not set
 *
 * @uses get_footer_text() To retrieve the footer text
 *
 * @param string $before The text to display before the footer text
 * @param string $after The text to display after the footer text
 * @param string $default What to display if no text is set
 * @return void
 *
 * @since 1.0
 */
function footer_text( $before = '', $after = '', $default = '' ) {

	$footer_text = get_footer_text( $default );
	$output = ( empty( $footer_text ) ? '' : $before . $footer_text . $after );

	echo $output;
}

/** Shortcodes ********************************************************/

/**
 * Returns a formatted link to
 * the current page's permalink
 *
 * @uses get_permalink()
 *
 * @return string
 *
 * @since 1.0
 */
function footer_text_shortcode_permalink() {
	$label = ( isset( $atts ) ? (string) $atts : get_permalink() );
	return sprintf ( '<a href="%1$s">%2$s</a>', get_permalink(), $label );
}

/**
 * Returns the date when the current page
 * was last modified
 *
 * @uses the_modified_date()
 *
 * @return string
 *
 * @since 1.0
 */
function footer_text_shortcode_last_modified() {
	return the_modified_date( 'd/m/Y', '<time>', '</time>', false );
}

/**
 * Registers our shortcodes with WordPress
 *
 * @uses add_shortcode()
 *
 * @since 1.0
 */
function add_footer_text_shortcodes() {
	add_shortcode( 'last_modified', 'footer_text_shortcode_last_modified' );
	add_shortcode( 'page_link', 'footer_text_shortcode_permalink' );
}
add_action( 'init', 'add_footer_text_shortcodes' );
