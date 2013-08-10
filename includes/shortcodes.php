<?php

/**
 * Handles the shortcodes used by this plugin
 */

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
