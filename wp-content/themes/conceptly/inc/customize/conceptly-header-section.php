<?php
function conceptly_header_setting( $wp_customize ){
	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
		 /*==== Header Setting Panel ==== */
		 $wp_customize->add_panel(
		 'header_section',
			array(
				'priority'      => 30,
				'capability' =>'edit_theme_options',
				'title' => __('Header Section','conceptly'),
				)
		);
	
	/*=========================================
	Conceptly Site Identity
	=========================================*/
	$wp_customize->add_section(
        'title_tagline',
        array(
        	'priority'      => 1,
            'title' 		=> __('Site Identity','conceptly'),
			'panel'  		=> 'header_section',
		)
    );
	
	// Logo Width // 
	if ( class_exists( 'Cleverfox_Customizer_Range_Slider_Control' ) ) {
		$wp_customize->add_setting( 
			'logo_width' , 
				array(
				'default' => '140',
				'capability'     => 'edit_theme_options',
				'sanitize_callback' => 'conceptly_sanitize_number_range',
				'transport'         => 'postMessage',
			) 
		);

		$wp_customize->add_control( 
		new Cleverfox_Customizer_Range_Slider_Control( $wp_customize, 'logo_width', 
			array(
				'section'  => 'title_tagline',
				'label'    => __( 'Logo Width','conceptly' ),
				'input_attrs' => array(
					'min'    => 0,
					'max'    => 500,
					'step'   => 1,
					//'suffix' => 'px', //optional suffix
				),
			) ) 
		);	
	}
	/*=========================================
	Header search & cart Settings Section
	=========================================*/
	// Header search & cart Setting Section // 
	$wp_customize->add_section(
        'header_search_cart',
        array(
        	'priority'      => 3,
            'title' 		=> __('Header Search','conceptly'),
			'panel'  		=> 'header_section',
		)
    );
	
	// hide/show  search settings
	$wp_customize->add_setting( 
		'hide_show_search' , 
			array(
			'default' => 1,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_search', 
		array(
			'label'	      => esc_html__( 'Hide / Show Search', 'conceptly' ),
			'section'     => 'header_search_cart',
			'settings'    => 'hide_show_search',
			'type'        => 'ios', // light, ios, flat
		) 
	));
	
	// Header search Setting // 
	$wp_customize->add_setting(
    	'header_search',
    	array(
			'default' => 'fa-search',
			'sanitize_callback' => 'conceptly_sanitize_select_icon',
			'capability' => 'edit_theme_options',
			
		)
	);	

	$wp_customize->add_control(new Conceptly_Icon_Picker_Control($wp_customize, 
		'header_search',
		array(
		    'label'   => __('Search Icon','conceptly'),
		    'section' => 'header_search_cart',
			'settings'=> 'header_search',
			'iconset' => 'fa',
		) ) 
	);
	
	/*=========================================
	Sticky Header Section
	=========================================*/
	
	// Sticky Header Section Settings
	$wp_customize->add_section(
        'sticky_header',
        array(
        	'priority'      => 3,
            'title' 		=> __('Sticky Header','conceptly'),
			'panel'  		=> 'header_section',
		)
    );
	
	
	$wp_customize->add_setting( 
		'sticky_header_setting' , 
			array(
			'default' => '1',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'sticky_header_setting', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'conceptly' ),
			'section'     => 'sticky_header',
			'settings'    => 'sticky_header_setting',
			'type'        => 'ios', // light, ios, flat
		) 
	));
	
	/*=========================================
	Header Get a Quote button
	=========================================*/
	// Header Get a Quote Section // 
	$wp_customize->add_section(
        'header_get_button',
        array(
        	'priority'      => 3,
            'title' 		=> __('Button Setting','conceptly'),
			'panel'  		=> 'header_section',
		)
    );
	//Header Get_button Hide/Show Setting // 
	$wp_customize->add_setting( 
		'hide_show_get_button' , 
			array(
			'default' => 0,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_get_button', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'conceptly' ),
			'section'     => 'header_get_button',
			'settings'    => 'hide_show_get_button',
			'type'        => 'ios', // light, ios, flat
			'priority' => 2,
		) 
	));
	
	// get-button // 
	$wp_customize->add_setting(
    	'header_get',
    	array(
			'sanitize_callback' => 'conceptly_sanitize_text',
			'capability' => 'edit_theme_options',
			'transport'         => $selective_refresh,
		)
	);	

	$wp_customize->add_control( 
		'header_get',
		array(
		    'label'   		=> __('Button Label','conceptly'),
		    'section' 		=> 'header_get_button',
			'settings' 		 => 'header_get',
			'type'		 =>	'text',
			'priority' => 6,
		)  
	);
	// Link// 
	$wp_customize->add_setting(
    	'header_btn_link',
    	array(
			'sanitize_callback' => 'conceptly_sanitize_url',
			'capability' => 'edit_theme_options',
		)
	);	

	$wp_customize->add_control( 
		'header_btn_link',
		array(
		    'label'   		=> __('Button Link','conceptly'),
		    'section' 		=> 'header_get_button',
			'type'		 =>	'text',
			'priority' => 7,
		)  
	);

};
add_action( 'customize_register', 'conceptly_header_setting' );

// header selective refresh
function conceptly_home_header_section_partials( $wp_customize ){
	// hide_show_search
	$wp_customize->selective_refresh->add_partial(
		'hide_show_search', array(
			'selector' => '#navigate .search-button',
			'container_inclusive' => true,
			'render_callback' => 'header_search_cart',
			'fallback_refresh' => true,
		)
	);
	// header_search_icon
	$wp_customize->selective_refresh->add_partial( 
	'header_search', array(
		'selector'            => '#navigate	.search-button',
		'settings'            => 'header_search',
		'render_callback'  => 'conceptly_search_render_callback',
	
	) );
	
	// hide_show_get_button
	$wp_customize->selective_refresh->add_partial(
		'hide_show_get_button', array(
			'selector' => '#navigate .boxed-btn',
			'container_inclusive' => true,
			'render_callback' => 'header_get_button',
			'fallback_refresh' => true,
		)
	);
	// header_get_button
	$wp_customize->selective_refresh->add_partial( 
	'header_get', array(
		'selector'            => '#navigate .boxed-btn',
		'settings'            => 'header_get',
		'render_callback'  => 'conceptly_quote_render_callback',
	
	) );
}
add_action( 'customize_register', 'conceptly_home_header_section_partials' );

// Header Get_button
function conceptly_quote_render_callback() {
	return get_theme_mod( 'header_get' );
}

// search 
function conceptly_search_render_callback() {
	return get_theme_mod( 'header_search' );
}