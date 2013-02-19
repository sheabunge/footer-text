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

function add_footer_text_options_page() {
	$theme_page = add_theme_page(
		__( 'Footer Text', 'footer-text' ),	// Name of page
		__( 'Footer Text', 'footer-text' ),	// Label in menu
		'edit_theme_options',          		// Capability required
		'footer-text', 	               		// Menu slug, used to uniquely identify the page
		'render_footer_text_options_page'	// Function that renders the options page
	);
}
add_action( 'admin_menu', 'add_footer_text_options_page' );


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


function get_footer_text() {
	return get_option( 'theme_footer_text', '' );
}

function footer_text() {
	echo get_footer_text();
}