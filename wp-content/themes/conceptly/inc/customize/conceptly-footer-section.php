<?php
function conceptly_footer( $wp_customize ) {
$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';
	// Footer Panel // 
	$wp_customize->add_panel( 
		'footer_section', 
		array(
			'priority'      => 34,
			'capability'    => 'edit_theme_options',
			'title'			=> __('Footer Section', 'conceptly'),
		) 
	);

	// Footer Setting Section // 
	$wp_customize->add_section(
        'footer_copyright',
        array(
            'title' 		=> __('Copyright Content','conceptly'),
			'panel'  		=> 'footer_section',
		)
    );
	

	// Copyright Content Hide/Show Setting // 
	// copyright Hide/ Show Setting // 
	$wp_customize->add_setting( 
		'hide_show_copyright' , 
			array(
			'default' => '1',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_copyright', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'conceptly' ),
			'section'     => 'footer_copyright',
			'type'        => 'ios', // light, ios, flat
			'priority' => 2,
		) 
	));

	// Copyright Content Setting // 
	$conceptly_copyright = esc_html__('Copyright &copy; [current_year] [site_title] | Powered by [theme_author]', 'conceptly' );
	$wp_customize->add_setting(
    	'copyright_content',
    	array(
	        'default'			=> $conceptly_copyright,
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_html'
		)
	);	

	$wp_customize->add_control( 
		'copyright_content',
		array(
		    'label'   		=> __('Copyright Content','conceptly'),
		    'section'		=> 'footer_copyright',
			'type' 			=> 'textarea',
			'priority' => 5,
		)  
	);

	/*=========================================
	Footer Payment Icon Section
	=========================================*/
	// Footer Setting Section // 
	$wp_customize->add_section(
        'footer_icon',
        array(
            'title' 		=> __('Payment Icon','conceptly'),
			'panel'  		=> 'footer_section',
		)
    );
	

	// Payment Icon Hide/Show Setting // 
	$wp_customize->add_setting( 
		'hide_show_payment' , 
			array(
			'default' => '1',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_checkbox',
			'transport'         => $selective_refresh,
		) 
	);
	
	$wp_customize->add_control( new Conceptly_Customizer_Toggle_Control( $wp_customize, 
	'hide_show_payment', 
		array(
			'label'	      => esc_html__( 'Hide / Show Section', 'conceptly' ),
			'section'     => 'footer_icon',
			'type'        => 'ios', // light, ios, flat
			'priority' => 2,
		) 
	));

	/**
	 * Customizer Repeater for add payment icon
	 */
		$wp_customize->add_setting( 'footer_Payment_icon', 
			array(
			 'sanitize_callback' => 'conceptly_repeater_sanitize',
			)
		);
		
		$wp_customize->add_control( 
			new Conceptly_Repeater( $wp_customize, 
				'footer_Payment_icon', 
					array(
						'label'   => esc_html__('Payment Icon','conceptly'),
						'section' => 'footer_icon',
						'add_field_label'                   => esc_html__( 'Add New Icon', 'conceptly' ),
						'item_name'                         => esc_html__( 'Icon', 'conceptly' ),
						'priority' => 5,
						
						'customizer_repeater_icon_control' => true,
						'customizer_repeater_link_control' => true,			
				
					) 
				) 
			);

	// Footer Background Section // 	 
	$wp_customize->add_section(
        'footer_background',
        array(
            'title' 		=> __('Background','conceptly'),
			'panel'  		=> 'footer_section',
		)
    );
	
	
	//footer widgets Background Image // 
    $wp_customize->add_setting( 
    	'footer_background_setting' , 
    	array(
			'capability'     	=> 'edit_theme_options',
			'sanitize_callback' => 'conceptly_sanitize_url',
		) 
	);
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize , 'footer_background_setting' ,
		array(
			'label'          => __( 'Footer Background Image', 'conceptly' ),
			'section'        => 'footer_background',
		) 
	));
}
add_action( 'customize_register', 'conceptly_footer' );

// footer selective refresh
function conceptly_footer_section_partials( $wp_customize ){
	
	// hide_show_copyright
	$wp_customize->selective_refresh->add_partial(
		'hide_show_copyright', array(
			'selector' => '#footer-copyright .copyright-text',
			'container_inclusive' => true,
			'render_callback' => 'footer_copyright',
			'fallback_refresh' => true,
		)
	);
	// hide_show_payment
	$wp_customize->selective_refresh->add_partial(
		'hide_show_payment', array(
			'selector' => '#footer-copyright .payment-method',
			'container_inclusive' => true,
			'render_callback' => 'footer_icon',
			'fallback_refresh' => true,
		)
	);	
	}
add_action( 'customize_register', 'conceptly_footer_section_partials' );