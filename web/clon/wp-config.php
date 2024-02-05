<?php
define('WP_CACHE', false);
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rxhvjzic_wp590' );

/** Database username */
define( 'DB_USER', 'rxhvjzic_wp590' );

/** Database password */
define( 'DB_PASSWORD', 'pX@8-83SYz' );

/** Database hostname */
define( 'DB_HOST', '10.0.11.105' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '0t8xaanj0f9btwlfuuv5h59fgflzlka6ue2tugrplmbpatj1wao1ulobvpyy30xo' );
define( 'SECURE_AUTH_KEY',  'bsuxwca9bni7maxi5ojhhipzlrhupsx0k2ujmttkwjrvdfn6hcz2vfocfszlswpb' );
define( 'LOGGED_IN_KEY',    'atvq4xnrzoxu9jkkc3akjc1cnjhmti1cervy6250pi1h5l6km5r7s2utrsix6ivn' );
define( 'NONCE_KEY',        'manivdit6myjo5s3nybgbzoxq9ddeflw613vuhfoqewvirj5wu27dtmcxm0xp5gj' );
define( 'AUTH_SALT',        'xt1hxy3hwiskw4obkpufsvhowdhvt40kdupvwpjrnonmuasienkq0ibhuxkmlkes' );
define( 'SECURE_AUTH_SALT', 'pguhnoayetcvydpxm8tit37xuotganmhl76np3odljzxr38swdfqrce3d47cifom' );
define( 'LOGGED_IN_SALT',   'z3corgdabhgjxsiglf6urfipqe1lgp5kkks8cats8yj9tajhnrjv0ibbew1aqasp' );
define( 'NONCE_SALT',       'gov02vmrqgq2zmrynv71ysa3gtsm4fkyigduoqghvuzytbc2lvymlw1hutzgsr0l' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpstg0_'; // Changed by WP STAGING

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
define('WP_LANG_DIR', __DIR__ . '/wp-content/languages');
define('WP_HOME', 'https://ospiaprovincia.org/web/clon');
define('WP_SITEURL', 'https://ospiaprovincia.org/web/clon');
define('DISABLE_WP_CRON', false);
if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
    define('WP_ENVIRONMENT_TYPE', 'staging');
}
define('WP_DEVELOPMENT_MODE', 'all');
if ( ! defined( 'WPSTAGING_DEV_SITE' ) ) {
    define('WPSTAGING_DEV_SITE', true);
}
define('UPLOADS', 'wp-content/uploads');
define('WP_PLUGIN_DIR', __DIR__ . "/wp-content/plugins");
define('WP_PLUGIN_URL', 'https://ospiaprovincia.org/web/clon/wp-content/plugins');
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
