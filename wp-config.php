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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define('WP_CACHE', true);
//define( 'WPCACHEHOME', '/home/mandeehernandez/public_html/wp-content/plugins/wp-super-cache/' );
define('DB_NAME', 'a37f950dce08677491e7df5a22c62cba');

/** MySQL database username */
define('DB_USER', '48e44f72cbd8fda2ba73d0bb9f7363f9');

/** MySQL database password */
define('DB_PASSWORD', 'f8d68204f0167dc0aa01f334da81973f');

/** MySQL hostname */
define('DB_HOST', 'code2pixels-mysql-database');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'COekYLanpjOzjaj6zBhhU1bIctmI8ErZCxfdiYtWbJyXis9lKPeNc7sYy2LHBEQw');
define('SECURE_AUTH_KEY',  '4z36qo3vflfFyffnsFdjidwty0K4cd6C4w1BMVSaiBLba4KpRGUr81bT4C05tmzS');
define('LOGGED_IN_KEY',    'oiQW5kmZlZKukqNynYu20rXEHODoeJKbO5KbBLXbqX64FTcxF11C1bShCWeXijpk');
define('NONCE_KEY',        'HUh9qsnX0VSYrbbPB688gDGV4yIhmjTYrjzHMStKr1oYmwOSZqztMWe4YsARnsXP');
define('AUTH_SALT',        'bVlsVibZGL9qONhCLPCqyVRREW9rWTWdKYj2pybouewKbhHbnLsSEiOMjSR2HfaV');
define('SECURE_AUTH_SALT', 'WdIkmmm5xrfwbxGlFNt7oKqvyYuwBeeuQvihHHkP6VHwGok9nmfitvvkjIrf7AId');
define('LOGGED_IN_SALT',   'jZCCheTPOKfsmbq70OlRImvC6DImQ3Ay10QKCOSszcv4GLDSe1d6h6OX8xJhIH3h');
define('NONCE_SALT',       '1LK0jf4fSd73Zteo0nsYXvKFXxf9L2kqcJxkJcu7sENbzCnQ20vDnoTCyiWrcdL8');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
//define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

define( 'UPLOADS', 'wp-content/uploads' );
	
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');