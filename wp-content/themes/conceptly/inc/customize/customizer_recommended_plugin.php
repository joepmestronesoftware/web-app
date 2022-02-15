<?php
/* Notifications in customizer */


require get_template_directory() . '/inc/customizer-notify/conceptly-customizer-notify.php';
$conceptly_config_customizer = array(
	'recommended_plugins'       => array(
		'clever-fox' => array(
			'recommended' => true,
			'description' => sprintf(__('Install and activate <strong>cleverfox</strong> plugin for taking full advantage of all the features this theme has to offer Conceptly.', 'conceptly')),
		),
	),
	'recommended_actions'       => array(),
	'recommended_actions_title' => esc_html__( 'Recommended Actions', 'conceptly' ),
	'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'conceptly' ),
	'install_button_label'      => esc_html__( 'Install and Activate', 'conceptly' ),
	'activate_button_label'     => esc_html__( 'Activate', 'conceptly' ),
	'conceptly_deactivate_button_label'   => esc_html__( 'Deactivate', 'conceptly' ),
);
Conceptly_Customizer_Notify::init( apply_filters( 'conceptly_customizer_notify_array', $conceptly_config_customizer ) );
?>