<?php
// Do not allow direct access!
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

class Strato_Assistant_Auto_Updater {

	/**
	 * Strato_Assistant_Auto_Updater constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'enable_assets_individual_updates' ), 1 );

		if ( Strato_Assistant_Config::get( 'auto_updates', 'features' ) ) {
			add_action( 'init', array( $this, 'enable_all_assets_updates' ), 1 );

			add_filter( 'plugin_auto_update_setting_html', array( $this, 'modify_auto_update_plugin_setting' ), 10, 0 );

			add_filter( 'theme_auto_update_setting_template', array( $this, 'modify_auto_update_theme_setting' ), 10, 0 );
			add_filter( 'theme_auto_update_setting_html', array( $this, 'modify_auto_update_theme_setting' ), 10, 0 );
		}
	}

	/**
	 * Both inform the user of the enforced plugins auto-update process and prevent him to try to override it
	 * (which won't work anyway as the global enabling setup overrides the user-selected options)
	 */
	public function modify_auto_update_theme_setting() {
		return '<p><span class="assistant-auto-update">
					' . apply_filters( 'strato_assistant_auto_update_hint_theme', __( 'Permanently active', 'strato-assistant' ) ) . '
				</span></p>';
	}

	/**
	 * Both inform the user of the enforced themes auto-update process and prevent him to try to override it
	 * (which won't work anyway as the global enabling setup overrides the user-selected options)
	 */
	public function modify_auto_update_plugin_setting() {
		return '<p><span class="assistant-auto-update">
					' . apply_filters( 'strato_assistant_auto_update_hint_plugin', __( 'Permanently active', 'strato-assistant' ) ) . '
				</span></p>';
	}

	/**
	 * Enable WordPress to automatically update plugins and themes to newest version
	 * https://make.wordpress.org/core/2020/07/15/controlling-plugin-and-theme-auto-updates-ui-in-wordpress-5-5/)
	 */
	public function enable_all_assets_updates() {
		// Enable all plugin auto-updates
		add_filter( 'auto_update_plugin', '__return_true' );

		// Enable all theme auto-updates
		add_filter( 'auto_update_theme', '__return_true' );
	}

	/**
	 * Enable the option individually for each plugin/theme, so that if the global option is set to off
	 * the assets are still doing auto-updates (now with the possibility for the user to disable them)
	 */
	public function enable_assets_individual_updates() {
		if ( get_option( 'strato_assistant_individual_auto_updates', false ) === false ) {

			// Manually enable the option pro plugin
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
			update_site_option( 'auto_update_plugins', array_keys( get_plugins() ) );

			// Manually enable the option pro theme
			update_site_option( 'auto_update_themes', array_keys( wp_get_themes() ) );

			update_option( 'strato_assistant_individual_auto_updates', true );
		}
	}
}

new Strato_Assistant_Auto_Updater();