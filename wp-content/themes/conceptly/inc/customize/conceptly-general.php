<?php
function conceptly_breadcrumb_setting( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	/*=========================================
	Breadcrumb Settings Panel
	=========================================*/
	$wp_customize->add_panel( 
		'conceptly_general_settings', 
		array(
			'priority'      => 30,
			'capability'    => 'edit_theme_options',
			'title'			=> __('General', 'conceptly'),
		) 
	);
	/*=========================================
	Colors
	=========================================*/ 
	$wp_customize->add_section(
        'colors',
        array(
        	'priority'      => 1,
            'title' 		=> __('Colors','conceptly'),
			'panel'  		=> 'conceptly_general_settings',
		)
    );
	
	/*=========================================
	Breadcrumb Section
	=========================================*/ 
	$wp_customize->add_section(
        'breadcrumb_design',
        array(
        	'priority'      => 1,
            'title' 		=> __('Breadcrumb','conceptly'),
			'panel'  		=> 'conceptly_general_settings',
		)
    );
	
	$wp_customize->add_setting( 
		'hide_show_breadcrumb' , 
			array(
			'default' => '1',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_breadcrumb', 
		array(
			'label'	      => esc_html__( 'Breadcrumb Hide/Show', 'conceptly' ),
			'section'     => 'breadcrumb_design',
			'type'        => 'ios', // light, ios, flat
		) 
	));
	
	// Background Image // 
    $wp_customize->add_setting( 
    	'breadcrumb_background_setting' , 
    	array(
			'default' 			=> esc_url(get_template_directory_uri() .'/assets/images/bg/breadcrumb.jpg'),
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_url',	
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'breadcrumb_background_setting' ,
		array(
			'label'          => __( 'Background Image', 'conceptly' ),
			'section'        => 'breadcrumb_design',
		) 
	));
	
	$wp_customize->add_setting( 
		'breadcrumb_background_position' , 
			array(
			'default' => __( 'scroll', 'conceptly' ),
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_select',
		) 
	);
	
	$wp_customize->add_control(
		'breadcrumb_background_position' , 
			array(
				'label'          => __( 'Image Position', 'conceptly' ),
				'section'        => 'breadcrumb_design',
				'type'           => 'radio',
				'choices'        => 
				array(
					'fixed'=> __( 'Fixed', 'conceptly' ),
					'scroll' => __( 'Scroll', 'conceptly' )
			)  
		) 
	);
	
	// preloader Settings Section // 
	$wp_customize->add_section(
        'scroller_setting',
        array(
        	'priority'      => 1,
            'title' 		=> __('Scroller','conceptly'),
			'panel'  		=> 'conceptly_general_settings',
		)
    );
	
	// top scroller Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hide_show_scroller' , 
			array(
			'default' => '1',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_scroller', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'conceptly' ),
			'section'     => 'scroller_setting',
			'type'        => 'ios', // light, ios, flat
		) 
	));
}

add_action( 'customize_register', 'conceptly_breadcrumb_setting' );

// breadcrumb selective refresh
function conceptly_breadcrumb_section_partials( $wp_customize ){
	// hide show breadcrumb
	$wp_customize->selective_refresh->add_partial(
		'hide_show_breadcrumb', array(
			'selector' => '#breadcrumb-area',
			'container_inclusive' => true,
			'render_callback' => 'breadcrumb_design',
			'fallback_refresh' => true,
		)
	);
	
	// hide_show_scroller
	$wp_customize->selective_refresh->add_partial(
		'hide_show_scroller', array(
			'selector' => '#footer-copyright .scrollup',
			'container_inclusive' => true,
			'render_callback' => 'scroller_setting',
			'fallback_refresh' => true,
		)
	);
	}
add_action( 'customize_register', 'conceptly_breadcrumb_section_partials' );