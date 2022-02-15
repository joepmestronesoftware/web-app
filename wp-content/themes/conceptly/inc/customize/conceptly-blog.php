<?php
function conceptly_blog_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';	
	/*=========================================
	Blog Section Panel
	=========================================*/
		$wp_customize->add_section(
			'blog_setting', array(
				'title' => esc_html__( 'Blog Section', 'conceptly' ),
				'panel' => 'conceptly_frontpage_sections',
				'priority' => apply_filters( 'conceptly_section_priority', 110, 'conceptly_blog' ),
			)
		);
	/*=========================================
	Blog Settings Section
	=========================================*/
	// Blog Settings Section // 
	$wp_customize->add_setting( 
		'hide_show_blog' , 
			array(
			'default' =>  esc_html__( '1', 'conceptly' ),
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_blog', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'conceptly' ),
			'section'     => 'blog_setting',
			'type'        => 'ios', // light, ios, flat
			'priority' => 2,
		) 
	));
	
	// Blog Title // 
	$wp_customize->add_setting(
    	'blog_title',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_html',
			'transport'         => $selective_refresh,
		)
	);	
	
	$wp_customize->add_control( 
		'blog_title',
		array(
		    'label'   => __('Title','conceptly'),
		    'section' => 'blog_setting',
			'type'           => 'text',
			'priority' => 5,
		)  
	);
	
	// Blog Description // 
	$wp_customize->add_setting(
    	'blog_description',
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_text',
			'transport'         => $selective_refresh,
		)
	);	
	
	$wp_customize->add_control( 
		'blog_description',
		array(
		    'label'   => __('Description','conceptly'),
		    'section' => 'blog_setting',
			'type'           => 'textarea',
			'priority' => 6,
		)  
	);
	
	// Blog Content Section // 

	// Blog Display Setting // 
	if ( class_exists( 'Cleverfox_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting(
			'blog_display_num',
			array(
				'default'			=> __('3','conceptly'),
				'capability'     	=> 'edit_theme_options',
				'sanitize_callback' => 'conceptly_sanitize_number_range',
				'priority' => 10,
			)
		);
		
		$wp_customize->add_control( 
		new Cleverfox_Customizer_Range_Slider_Control( $wp_customize, 'blog_display_num', 
			array(
				'section'  => 'blog_setting',
				'label'    => __( 'No of Posts Display','conceptly' ),
				'input_attrs' => array(
					'min'    => 1,
					'max'    => 500,
					'step'   => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);
	}
}
add_action( 'customize_register', 'conceptly_blog_setting' );

// Blog selective refresh
function conceptly_home_blog_section_partials( $wp_customize ){

	// hide show blog
	$wp_customize->selective_refresh->add_partial(
		'hide_show_blog', array(
			'selector' => '#latest-news',
			'container_inclusive' => true,
			'render_callback' => 'blog_setting',
			'fallback_refresh' => true,
		)
	);
	// title
	$wp_customize->selective_refresh->add_partial( 'blog_title', array(
		'selector'            => '#latest-news .section-title h2',
		'settings'            => 'blog_title',
		'render_callback'  => 'conceptly_blog_title_render_callback',
	
	) );
	
	// description
	$wp_customize->selective_refresh->add_partial( 'blog_description', array(
		'selector'            => '#latest-news .section-title p',
		'settings'            => 'blog_description',
		'render_callback'  => 'conceptly_blog_desc_render_callback',
	
	) );
	}

add_action( 'customize_register', 'conceptly_home_blog_section_partials' );

// title
function conceptly_blog_title_render_callback() {
	return get_theme_mod( 'blog_title' );
}
// description
function conceptly_blog_desc_render_callback() {
	return get_theme_mod( 'blog_description' );
}