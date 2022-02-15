<?php
/**
 * Check if WordPress is managed (including safemode) or not
 *
 * @return boolean
 */
function strato_is_managed() {
	if (
		// installation is managed if .managed file is set
		strato_is_managed_file_existing() ||
		// check if WordPress is installed in a safemode path
		strato_is_root_safemode_path()
	) {
		return true;
	}

	return false;
}

/**
 * Check if the plugins must be used or not, based on its location:
 *
 * * wp-content/plugins -> optional
 * * wp-content/mu-plugins -> required
 *
 * @return boolean
 */
function strato_is_must_use_plugin_folder() {
	$plugin_path = Strato_Assistant::get_plugin_dir_path();

	if ( strpos( $plugin_path, 'mu-plugins' ) === false ) {
		return false;
	} else {
		return true;
	}
}

/**
 * Open/closed managed contracts have a `.managed` file in the root folder
 *
 * @return boolean
 */
function strato_is_managed_file_existing() {
	$abspath = Strato_Assistant::get_abspath();

	// open/closed managed contracts has a `.managed` file in the root folder
	if (
		file_exists( $abspath . '/.managed' ) &&
		is_readable( $abspath . '/.managed' )
	) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if plugin is a safemode installation
 *
 * @return boolean
 */
function strato_is_root_safemode_path() {
	$abspath = Strato_Assistant::get_abspath();

	if (
		preg_match( '/^app\d{5,15}$/', basename( $abspath ) ) ||
		preg_match( '/^trial\d{9,15}$/', basename( $abspath ) )
	) {
		return true;
	} else {
		return false;
	}
}
