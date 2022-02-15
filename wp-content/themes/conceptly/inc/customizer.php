<?php
/**
 * conceptly Theme Customizer.
 *
 * @package conceptly
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function conceptly_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_setting('custom_logo')->transport = 'refresh';
	
	$wp_customize->add_panel(
		'conceptly_frontpage_sections', array(
			'priority' => 32,
			'title' => esc_html__( 'Homepage Sections', 'conceptly' ),
		)
	);
}
add_action( 'customize_register', 'conceptly_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function conceptly_customize_preview_js() {
	wp_enqueue_script( 'conceptly_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'conceptly_customize_preview_js' );


function conceptly_customizer_script() {
	wp_enqueue_script( 'conceptly-customizer-section', get_template_directory_uri() .'/assets/js/customizer-section.js', array("jquery"),'', true  );	
}
add_action( 'customize_controls_enqueue_scripts', 'conceptly_customizer_script' );