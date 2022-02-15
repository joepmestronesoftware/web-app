<?php
/**
 *
 * @package Conceptly
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses conceptly_header_style()
 */
function conceptly_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'conceptly_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 2000,
		'height'                 => 200,
		'flex-height'            => true,
		'wp-head-callback'       => 'conceptly_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'conceptly_custom_header_setup' );

if ( ! function_exists( 'conceptly_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see conceptly_custom_header_setup().
 */
function conceptly_header_style() {
	$header_text_color = get_header_textcolor();

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.site-title,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;
