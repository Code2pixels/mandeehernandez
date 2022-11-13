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

// Set path constants
define('PROJECT_BASE_PATH', __DIR__);
define('PROJECT_VENDOR_PATH', PROJECT_BASE_PATH . '/vendor');
define('WORDPRESS_BASE_PATH', PROJECT_BASE_PATH . '/wordpress');

// Load Composer's autoloader
require_once PROJECT_VENDOR_PATH . '/autoload.php';

// Load dotenv?
if (class_exists('Dotenv\Dotenv') && file_exists(PROJECT_BASE_PATH . '/.env')) {
    Dotenv\Dotenv::createUnsafeImmutable(PROJECT_BASE_PATH)->load();
}

$is_local = getenv('WP_ENVIRONMENT') === 'localhost';

// Environment Config
define('IS_WPENGINE', (getenv('IS_WPENGINE') === 'true'));
define('WP_SITEURL',       getenv('WP_SITEURL'));
define('WP_HOME',          getenv('WP_HOME'));
define('WP_ENVIRONMENT',   getenv('WP_ENVIRONMENT'));

if (defined('WP_CLI') && WP_CLI) {
    $_SERVER['HTTP_HOST'] = $_SERVER['SERVER_NAME'] = explode('://', WP_SITEURL)[0];
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_HOST'));

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', getenv('DB_CHARSET'));

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', getenv('DB_COLLATE'));

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         getenv('AUTH_KEY'));
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY'));
define('NONCE_KEY',        getenv('NONCE_KEY'));
define('AUTH_SALT',        getenv('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT'));
define('NONCE_SALT',       getenv('NONCE_SALT'));

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix =  getenv('TABLE_PREFIX');

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

define('WP_DEBUG', (getenv('WP_DEBUG') === 'true'));
if (WP_DEBUG) {
    $wp_debug_display = false;
    $wp_debug_log_dir = __DIR__ . '/wp-content/logs';
    if ($is_local) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        $wp_debug_display = true;
        $wp_debug_log_dir = "/home/www-data$wp_debug_log_dir";
    }
    try {
        if (!file_exists(dirname($wp_debug_log_dir))) {
            mkdir(dirname($wp_debug_log_dir));
        }
    } catch (Exception $e) {
        error_log($e);
    }
    define('WP_DEBUG_DISPLAY', $wp_debug_display);
}

/* Disable plugin and theme installation locally */
if (!$is_local) {
    define('AUTOMATIC_UPDATER_DISABLED', true);
    define('DISALLOW_FILE_MODS', true);
}
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);

/* Other Wordpress config */
define('WP_ALLOW_REPAIR', (getenv('WP_ALLOW_REPAIR') === 'true'));
define('DISABLE_WP_CRON', (getenv('DISABLE_WP_CRON') === 'true'));
define('WP_DEFAULT_THEME',     getenv('WP_DEFAULT_THEME'));
define('WP_POST_REVISIONS',    intval(getenv('WP_POST_REVISIONS')));
define('WP_DISABLE_EMAILS', (getenv('WP_DISABLE_EMAILS') === 'true'));
define('WP_USE_LOCAL_INFILE', (getenv('WP_USE_LOCAL_INFILE') === 'true'));
define('WP_MEMORY_LIMIT',      getenv('WP_MEMORY_LIMIT'));
define('WP_MAX_MEMORY_LIMIT',  getenv('WP_MAX_MEMORY_LIMIT'));
define('WPE_GOVERNOR', (getenv('WPE_GOVERNOR') === 'true'));

/* Third party config */
define('WP_MAIL_FROM_ADDRESS', getenv('WP_MAIL_FROM_ADDRESS'));
define('WP_MAIL_FROM_NAME', getenv('WP_MAIL_FROM_NAME'));


define('WP_CACHE_KEY_SALT', getenv('WP_CACHE_KEY_SALT'));
define('WC_KEY', getenv('WC_KEY'));
define('WC_SECRET', getenv('WC_SECRET'));

global $redis_server;
$redis_server = array(
    'host' => getenv('REDIS_HOSTNAME'),
    'port' => getenv('REDIS_PORT'),
);

/**
 * SSL settings (in non dev environment):
 *   - For cases where Wordpress is sitting behind a proxy, check if the request to 
 *     the proxy was sent over SSL. If it is turn SSL on.
 * */
if (!$is_local) {
    if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
        $_SERVER['HTTPS'] = 'on';
    }
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', PROJECT_BASE_PATH . '/wordpress');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
