<?php
 /**
 * Enqueue scripts and styles.
 */
function conceptly_scripts() {
	
	// Styles
	
	wp_enqueue_style('conceptly-menus',get_template_directory_uri().'/assets/css/menus.css');
	wp_enqueue_style('bootstrap-min',get_template_directory_uri().'/assets/css/bootstrap.min.css');

	wp_enqueue_style('conceptly-typography', get_template_directory_uri() .'/assets/css/typography/typograhpy.css');

	wp_enqueue_style('font-awesome',get_template_directory_uri().'/assets/css/fonts/font-awesome/css/font-awesome.min.css');

	wp_enqueue_style('conceptly-wp-test',get_template_directory_uri().'/assets/css/wp-test.css');
	wp_enqueue_style('conceptly-widget',get_template_directory_uri().'/assets/css/widget.css');
	wp_enqueue_style('conceptly-color',get_template_directory_uri().'/assets/css/colors/default.css');
	wp_enqueue_style( 'conceptly-style', get_stylesheet_uri() );
	wp_enqueue_style('conceptly-responsive',get_template_directory_uri().'/assets/css/responsive.css');


	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '1.0', true);

	wp_enqueue_script('conceptly-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), false, true);
	
	wp_enqueue_script( 'conceptly-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'conceptly_scripts' );

//Customizer Enqueue for Premium Buttons
function conceptly_premium_css()	{
	wp_enqueue_style('conceptly-style-customizer',get_template_directory_uri(). '/assets/css/style-customizer.css');
}
add_action('customize_controls_print_styles','conceptly_premium_css');

if ( ! function_exists( 'conceptly_admin_scripts' ) ) :
function conceptly_admin_scripts() {
    wp_enqueue_media();	
	wp_enqueue_style( 'conceptly-admin-styles', get_template_directory_uri() .'/assets/css/admin.css' );
    wp_enqueue_script( 'conceptly-admin-script', get_template_directory_uri() . '/assets/js/conceptly-admin-script.js', array( 'jquery' ), '', true );
    wp_localize_script( 'conceptly-admin-script', 'conceptly_ajax_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) )
    );
}
endif;
add_action( 'admin_enqueue_scripts', 'conceptly_admin_scripts' );
