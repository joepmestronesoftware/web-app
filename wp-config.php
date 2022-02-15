<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'DB4329689' );

/** MySQL database username */
define( 'DB_USER', 'U4329689' );

/** MySQL database password */
define( 'DB_PASSWORD', '2#kL9z9UpfaGgFnlWExIvHLtO' );

/** MySQL hostname */
define( 'DB_HOST', 'rdbms.strato.de' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1ycRApGutyeKuq2m1jV9i0X63TIkT8T4O29rCqvqybFMgIELIpc3TM6I7lGzM11P');
define('SECURE_AUTH_KEY',  'wt8KliuWQcsl3LRDkTDChziEDpezpaV1QYkSXdigPnQCDeWbLIuWzonBFsQ7VcIj');
define('LOGGED_IN_KEY',    'BdS9BjjMkzK2ok9oPQslz7eR2DvJ0zQ0wS6hqx3v7xqQXoASmbetOmym7iDTDJzN');
define('NONCE_KEY',        'jWfOd4usxkbYNHBRudU9xcbYfBPj0O6Ar5xBqpngyROMjFHzhj0yqVMhETL1poR4');
define('AUTH_SALT',        'jqfjOu5ZWwSO0gMmYoTTQYlvU1ceLx3OUWmxPuJuSImW36snxzrOu0gWuS6vGHJl');
define('SECURE_AUTH_SALT', 'yeJbneqrtcZ8ired1wfRAd8Jmpt9hdJpTCR5okGDymuiSg73ZS8asvX8jnCKLQl9');
define('LOGGED_IN_SALT',   'EHFLFjRXMy9wmuAXx6uhgeeqqFfC2gQkARWKw3jgnX8yoUJ4W0wUZLOl8YBRa4pL');
define('NONCE_SALT',       'WleiLEJgGIPFDRq9oUOvzuHlZ29KJbS7vpBtFMnuMdX10nmcj2A2UAhTbo1OejoC');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */



/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'r1dl_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

define( "WP_AUTO_UPDATE_CORE", "minor" );