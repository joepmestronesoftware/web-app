<?php
class conceptly_import_dummy_data {

	private static $instance;

	public static function init( ) {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof conceptly_import_dummy_data ) ) {
			self::$instance = new conceptly_import_dummy_data;
			self::$instance->conceptly_setup_actions();
		}

	}

	/**
	 * Setup the class props based on the config array.
	 */
	

	/**
	 * Setup the actions used for this class.
	 */
	public function conceptly_setup_actions() {

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'conceptly_import_customize_scripts' ), 0 );

	}
	
	

	public function conceptly_import_customize_scripts() {

	wp_enqueue_script( 'conceptly-import-customizer-js', get_template_directory_uri() . '/assets/js/conceptly-import-customizer.js', array( 'customize-controls' ) );
	}
}

$conceptly_import_customizers = array(

		'import_data' => array(
			'recommended' => true,
			
		),
);
conceptly_import_dummy_data::init( apply_filters( 'conceptly_import_customizer', $conceptly_import_customizers ) );