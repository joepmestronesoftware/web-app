<?php

class Conceptly_Customizer_Notify {

	private $recommended_actions;

	
	private $recommended_plugins;

	
	private static $instance;

	
	private $recommended_actions_title;

	
	private $recommended_plugins_title;

	
	private $dismiss_button;

	
	private $install_button_label;

	
	private $activate_button_label;

	
	private $conceptly_deactivate_button_label;

	
	public static function init( $config ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Conceptly_Customizer_Notify ) ) {
			self::$instance = new Conceptly_Customizer_Notify;
			if ( ! empty( $config ) && is_array( $config ) ) {
				self::$instance->config = $config;
				self::$instance->setup_config();
				self::$instance->setup_actions();
			}
		}

	}

	
	public function setup_config() {

		global $conceptly_customizer_notify_recommended_plugins;
		global $conceptly_customizer_notify_recommended_actions;

		global $install_button_label;
		global $activate_button_label;
		global $conceptly_deactivate_button_label;

		$this->recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
		$this->recommended_plugins = isset( $this->config['recommended_plugins'] ) ? $this->config['recommended_plugins'] : array();

		$this->recommended_actions_title = isset( $this->config['recommended_actions_title'] ) ? $this->config['recommended_actions_title'] : '';
		$this->recommended_plugins_title = isset( $this->config['recommended_plugins_title'] ) ? $this->config['recommended_plugins_title'] : '';
		$this->dismiss_button            = isset( $this->config['dismiss_button'] ) ? $this->config['dismiss_button'] : '';

		$conceptly_customizer_notify_recommended_plugins = array();
		$conceptly_customizer_notify_recommended_actions = array();

		if ( isset( $this->recommended_plugins ) ) {
			$conceptly_customizer_notify_recommended_plugins = $this->recommended_plugins;
		}

		if ( isset( $this->recommended_actions ) ) {
			$conceptly_customizer_notify_recommended_actions = $this->recommended_actions;
		}

		$install_button_label    = isset( $this->config['install_button_label'] ) ? $this->config['install_button_label'] : '';
		$activate_button_label   = isset( $this->config['activate_button_label'] ) ? $this->config['activate_button_label'] : '';
		$conceptly_deactivate_button_label = isset( $this->config['conceptly_deactivate_button_label'] ) ? $this->config['conceptly_deactivate_button_label'] : '';

	}

	
	public function setup_actions() {

		// Register the section
		add_action( 'customize_register', array( $this, 'conceptly_plugin_notification_customize_register' ) );

		// Enqueue scripts and styles
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'conceptly_customizer_notify_scripts_for_customizer' ), 0 );

		/* ajax callback for dismissable recommended actions */
		add_action( 'wp_ajax_quality_customizer_notify_dismiss_action', array( $this, 'conceptly_customizer_notify_dismiss_recommended_action_callback' ) );

		add_action( 'wp_ajax_ti_customizer_notify_dismiss_recommended_plugins', array( $this, 'conceptly_customizer_notify_dismiss_recommended_plugins_callback' ) );

	}

	
	public function conceptly_customizer_notify_scripts_for_customizer() {

		wp_enqueue_style( 'conceptly-customizer-notify-css', get_template_directory_uri() . '/inc/customizer-notify/css/conceptly-customizer-notify.css', array());

		wp_enqueue_style( 'conceptly-plugin-install' );
		wp_enqueue_script( 'conceptly-plugin-install' );
		wp_add_inline_script( 'conceptly-plugin-install', 'var pagenow = "customizer";' );

		wp_enqueue_script( 'conceptly-updates' );

		wp_enqueue_script( 'conceptly-customizer-notify-js', get_template_directory_uri() . '/inc/customizer-notify/js/conceptly-customizer-notify.js', array( 'customize-controls' ));
		wp_localize_script(
			'conceptly-customizer-notify-js', 'ConceptlyCustomizercompanionObject', array(
				'conceptly_ajaxurl'            => esc_url(admin_url( 'admin-ajax.php' )),
				'conceptly_template_directory' => esc_url(get_template_directory_uri()),
				'conceptly_base_path'          => esc_url(admin_url()),
				'conceptly_activating_string'  => __( 'Activating', 'conceptly' ),
			)
		);

	}

	
	public function conceptly_plugin_notification_customize_register( $wp_customize ) {

		
		require_once get_template_directory() . '/inc/customizer-notify/conceptly-customizer-notify-section.php';

		$wp_customize->register_section_type( 'Conceptly_Customizer_Notify_Section' );

		$wp_customize->add_section(
			new Conceptly_Customizer_Notify_Section(
				$wp_customize,
				'Conceptly-customizer-notify-section',
				array(
					'title'          => $this->recommended_actions_title,
					'plugin_text'    => $this->recommended_plugins_title,
					'dismiss_button' => $this->dismiss_button,
					'priority'       => 0,
				)
			)
		);

	}

	
	public function conceptly_customizer_notify_dismiss_recommended_action_callback() {

		global $conceptly_customizer_notify_recommended_actions;

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			
			if ( get_theme_mod( 'conceptly_customizer_notify_show' ) ) {

				$conceptly_customizer_notify_show_recommended_actions = get_theme_mod( 'conceptly_customizer_notify_show' );
				switch ( $_GET['todo'] ) {
					case 'add':
						$conceptly_customizer_notify_show_recommended_actions[ $action_id ] = true;
						break;
					case 'dismiss':
						$conceptly_customizer_notify_show_recommended_actions[ $action_id ] = false;
						break;
				}
				echo esc_html($conceptly_customizer_notify_show_recommended_actions);
				
			} else {
				$conceptly_customizer_notify_show_recommended_actions = array();
				if ( ! empty( $conceptly_customizer_notify_recommended_actions ) ) {
					foreach ( $conceptly_customizer_notify_recommended_actions as $conceptly_lite_customizer_notify_recommended_action ) {
						if ( $conceptly_lite_customizer_notify_recommended_action['id'] == $action_id ) {
							$conceptly_customizer_notify_show_recommended_actions[ $conceptly_lite_customizer_notify_recommended_action['id'] ] = false;
						} else {
							$conceptly_customizer_notify_show_recommended_actions[ $conceptly_lite_customizer_notify_recommended_action['id'] ] = true;
						}
					}
					echo esc_html($conceptly_customizer_notify_show_recommended_actions);
				}
			}
		}
		die(); 
	}

	
	public function conceptly_customizer_notify_dismiss_recommended_plugins_callback() {

		$action_id = ( isset( $_GET['id'] ) ) ? $_GET['id'] : 0;

		echo esc_html($action_id); 

		if ( ! empty( $action_id ) ) {

			$conceptly_lite_customizer_notify_show_recommended_plugins = get_theme_mod( 'conceptly_customizer_notify_show_recommended_plugins' );

			switch ( $_GET['todo'] ) {
				case 'add':
					$conceptly_lite_customizer_notify_show_recommended_plugins[ $action_id ] = false;
					break;
				case 'dismiss':
					$conceptly_lite_customizer_notify_show_recommended_plugins[ $action_id ] = true;
					break;
			}
			echo esc_html($conceptly_customizer_notify_show_recommended_actions);
		}
		die(); 
	}

}
