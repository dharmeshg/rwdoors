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
define('WP_HOME','https://www.rwdoors.com/');
define('WP_SITEURL','https://www.rwdoors.com/');
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'xxxxxx');

/** MySQL database username */
define('DB_USER', 'xxxxxx');

/** MySQL database password */
define('DB_PASSWORD', 'xxxxxx');

/** MySQL hostname */
define('DB_HOST', '');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
//define( 'WPE_APIKEY', '26afd161265ec0b181a829aef1ec24aee93205b4' );
define('WPLANG','');
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '.it^FL)KUD2,t  l2[VYw7WLMcsj=!nt9F, ^B$^a5PZ9z*w2ia%dJmnA#^Co+!T');
define('SECURE_AUTH_KEY',  '|R4M_=:LGE2lAWk]j#RzDgtF%P]U77D^H[--8}m(y cQ,kHb~]|#0(.)dPhJW71c');
define('LOGGED_IN_KEY',    'V_Y@v3Jvn5&(7YYlFypFQG5qZsK!%p`;.#hBWBcH^1@,e{xIW!<4 `X{,>7REw>V');
define('NONCE_KEY',        'c]56AvGJr9[Qd9Omr>;&wp+:mjswm,9kgnI%LY[5~oAeih0Ih#`3S?jk$]s)e}Q#');
define('AUTH_SALT',        '/(:l(fv28XyhplzKFi,E;gaLRCxs_)}VO2CJTkc&e[_(UFFN>Z[!h!^iI2,kNQ&Y');
define('SECURE_AUTH_SALT', '#fg(z.e.?Ax{v(@,/A?zP`UyA[@ 56afz8SXLj<}kty%Y1jZQvm-(|{Nc%*D&,SH');
define('LOGGED_IN_SALT',   'beMj3klL7b:9|mN]-CYxALn*TiF[g=,oE|a!1gfyP~k{$x>jvgRun`K3wN_{Sozl');
define('NONCE_SALT',       't#f~]e4q$[M(D8h/wP:Ncy&&v/(DhK6tg%E=<2^UZ$ukumh0n-d X{6(^XAwqbB<');

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
//define( 'WP_MEMORY_LIMIT', '256M' );
/* That's all, stop editing! Happy blogging. */
define('FORCE_SSL_ADMIN', true);
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
