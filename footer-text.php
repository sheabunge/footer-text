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
 * Format the footer text by applying the same filters that are
 * used with post content.
 *
 * We could use `apply_filters( 'the_content' )` but some plugins
 * do strange things to this and we don't want to break anything
 *
 * @since 1.0.1
 */
function footer_text_register_formatting_filters() {

	$filters = array(
		'do_shortcode',
		'wptexturize',
		'convert_smilies',
		'convert_chars',
		'wpautop',
		'shortcode_unautop',
		'capital_P_dangit',
	);

	foreach ( $filters as $filter ) {
		add_filter( 'get_footer_text', $filter );
	}

}

add_action( 'init', 'footer_text_register_formatting_filters' );

/** Dashboard Administration Menu ********************************************/

/**
 * Registers the 'edit_footer_text' cap with WordPress
 *
 * @since 1.0.1
 */
function add_footer_text_caps() {
	$roles = apply_filters( 'footer_text_roles', array( 'editor', 'administrator' ) );

	foreach ( $roles as $role ) {
		/* Retrieve the editor role to add the cap to */
    	$role = get_role( $role );

    	/* Add the capability to edit footer text */
    	$role->add_cap( 'edit_footer_text' );
    }
}
add_action( 'admin_init', 'add_footer_text_caps');

/**
 * Add the footer text options page to
 * the 'Appearance' dashboard menu
 *
 * @uses   add_theme_page() To register the new sub-menu
 * @return void
 * @since  1.0
 */
function add_footer_text_options_page() {
	add_theme_page(
		__( 'Footer Text', 'footer-text' ),
		__( 'Footer Text', 'footer-text' ),
		'edit_footer_text',
		'footer-text',
		'render_footer_text_options_page'
	);
}
add_action( 'admin_menu', 'add_footer_text_options_page' );

/**
 * Display the footer text options page
 * and save posted text to the database
 *
 * @uses   update_option() To save the text to the database
 * @uses   screen_icon()   To display the dashboard menu icon
 * @uses   wp_editor()     For a visual editor
 * @uses   get_option()    To retrieve the current text from the database
 * @uses   submit_button() To generate a form submit button
 *
 * @return void
 *
 * @since  1.0
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
 * @param  string $default What to use if no footer text is set
 * @return string          The formatted footer text
 *
 * @since  1.0
 */
function get_footer_text( $default = '' ) {

	/* Retrieve the footer text from the database */
	$footer_text = get_option( 'theme_footer_text', $default );

	/* Filter and return the text */
	return apply_filters( 'get_footer_text', $footer_text );
}

/**
 * Retrieves the footer text and displays it if it is set
 * Nothing is displayed if the footer text is not set
 *
 * @uses   get_footer_text() To retrieve the footer text
 *
 * @param  string $default   What to display if no text is set
 * @param  string $before    The text to display before the footer text
 * @param  string $after     The text to display after the footer text
 * @return void
 *
 * @since  1.0
 */
function footer_text( $default = '', $before = '', $after = '' ) {
	$footer_text = get_footer_text( $default );

	if ( $footer_text )
		echo $before . $footer_text . $after;
}


/**
 * Add an action as an alternate way to add footer text
 */
add_action( 'footer_text', 'footer_text', $default, $before, $after );

/** Shortcodes ********************************************************/

/**
 * Returns a formatted link to
 * the current page's permalink
 *
 * @uses   get_permalink()
 *
 * @param  array  $atts    Unused
 * @param  string $content The text the shortcode is wrapped around
 * @return string
 *
 * @since  1.0
 */
function footer_text_shortcode_permalink( $atts, $content ) {
	$label = ! empty( $content ) ? $content : get_permalink();
	return sprintf ( '<a href="%1$s">%2$s</a>', get_permalink(), $label );
}

/**
 * Returns the date when the current page
 * was last modified
 *
 * @uses   the_modified_date()
 * @return string
 * @since  1.0
 */
function footer_text_shortcode_last_modified() {
	return the_modified_date( 'd/m/Y', '<time>', '</time>', false );
}

/**
 * Returns the current year, ideal for
 * a copyright notice
 *
 * @return string
 * @since  1.0
 */
function footer_text_shortcode_current_year() {
	return '<time>' . date( 'Y' ) . '</time>';
}

/**
 * Returns an array of the shortcode tags to run
 * on the footer text, paired with their callbacks
 *
 * @return array
 * @since 1.0
 */
function get_footer_text_shortcode_tags() {
	$shortcode_tags = array(
		'last_modified' => 'footer_text_shortcode_last_modified',
		'page_link'     => 'footer_text_shortcode_permalink',
		'year'          => 'footer_text_shortcode_current_year',
	);

	return apply_filters( 'footer_text_shortcode_tags', $shortcode_tags );
}

/**
 * Registers our shortcodes with WordPress
 *
 * @uses  add_shortcode()
 * @since 1.0
 */
function add_footer_text_shortcodes() {
	$shortcode_tags = get_footer_text_shortcode_tags();

	foreach ( $shortcode_tags as $shortcode_tag => $callback )
		add_shortcode( $shortcode_tag, $callback );
}

add_action( 'init', 'add_footer_text_shortcodes' );

/**
 * Removes our custom shortcodes from the post content
 * so they don't interfere with anything
 *
 * @link   http://justintadlock.com/archives/2013/01/08/disallow-specific-shortcodes-in-post-content
 *
 * @param  string $content The post content with the custom shortcodes
 * @return string          The post content without the custom shortcodes
 *
 * @since  1.0
 */
function footer_text_post_content_remove_shortcodes( $content ) {

	/* Retrieve an array of all the shortcode tags */
	$shortcode_tags = get_footer_text_shortcode_tags();

	/* Loop through the shortcodes and remove them */
	foreach ( $shortcode_tags as $shortcode_tag => $callback )
		remove_shortcode( $shortcode_tag );

	/* Return the post content */
	return $content;
}

add_filter( 'the_content', 'footer_text_post_content_remove_shortcodes', 0 );

/**
 * Adds our shortcodes back to the post content when it's safe
 *
 * @see    http://justintadlock.com/archives/2013/01/08/disallow-specific-shortcodes-in-post-content
 *
 * @param  string $content The post content without the custom shortcodes
 * @return string          The post content with the custom shortcodes
 *
 * @since  1.0
 */
function footer_text_post_content_add_shortcodes( $content ) {

	/* Add the original shortcodes back. */
	add_footer_text_shortcodes();

	/* Return the post content. */
	return $content;
}

add_filter( 'the_content', 'footer_text_post_content_add_shortcodes', 99 );
