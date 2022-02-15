<?php	
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package conceptly
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists( 'conceptly_widgets_init' ) ) :
function conceptly_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar Widget Area', 'conceptly' ),
		'id' => 'conceptly-sidebar-primary',
		'description' => __( 'The Primary Widget Area', 'conceptly' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title">',
		'after_title' => '</h5>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'conceptly' ),
		'id' => 'conceptly-footer-widget-area',
		'description' => __( 'The Footer Widget Area', 'conceptly' ),
		'before_widget' => '<div class="col-lg-3 col-md-6 col-sm-12 mb-lg-0 mb-4"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );	
}
endif;
add_action( 'widgets_init', 'conceptly_widgets_init' );