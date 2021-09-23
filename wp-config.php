<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
define( 'FORCE_SSL_ADMIN', true ); // Redirect All HTTP Page Requests to HTTPS - Security > Settings > Enforce SSL
// END iThemes Security - Do not modify or remove this line

define( 'WP_CACHE', true ); // Added by WP Rocket
define( 'WP_ACCESSIBLE_HOSTS', 'wp-rocket.me,*wp-rocket.me,*.wordpress.org,localhost' );
define( 'WP_ROCKET_EMAIL', 'aram@hoopscollege.com');
/** Enable W3 Total Cache */
 // Added by WP Hummingbird
/** Enable W3 Total Cache */
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
define('DB_NAME', 'hc_courses');
/** MySQL database username */
define('DB_USER', 'dap');
/** MySQL database password */
define('DB_PASSWORD', 'D1ck0987!');
/** MySQL hostname */
define('DB_HOST', 'localhost');
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');
/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define( 'WPMS_ON', true ); 
/**define( 'WPMS_SMTP_PASS', 'qakqik-cidxak-saWry2' );**/
define( 'WP_MEMORY_LIMIT', '256M' );
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY','ofR)+ ?t<fS9NPvoDL(bzGvJ5tsv}dD][!$h*Nb=-qe~52Oynqtu`~]iUp?$)%_Z');
define('SECURE_AUTH_KEY','M!@&UP,{IfA,3l82EGQ!]O*]5;vs=|#0GD1!O/M+F;#?t4|p~#gN$s{)({|/xTF~');
define('LOGGED_IN_KEY','F]9@6;fY{RJkI}D&A?PsL_B^Jh.ste2#6IUr`%LBtNO8TIt&rM{_zPK=f5%LPI~J');
define('NONCE_KEY','sM3p2AJXgP8VN<0PVwBq.L|Q-9i)QbfI31FSjZ)3xKXDncza$8DwImIIL+nP|A<H');
define('AUTH_SALT', 'l:dunP&%{^:x(Zkfz^Q~eEZDyfzM!`L[7pC~e>^qmzb2bpP0Gp+R_eo:zvCW:_L_');
define('SECURE_AUTH_SALT','s3X^0=~4v?35j!k<U2eD}5dtg nau+F=y9|b Ps]vOKr[_ch%:Fh2vB+ugL9rim?');
define('LOGGED_IN_SALT','!d-=Wj;5x?Q@aEAu,4y_=E- 7;4zEq:.!gan}P#Y8`;cuGiCb59}^KyS7`,AV3k2');
define('NONCE_SALT','MfpX2x5%ih*_ImRlwt5e`NL2J%A;#Kz9BH|m(G#:)P<8WO]2hUi-t%lWy@PK_Db>');
define('FS_METHOD', 'direct');
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
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
define('wp_home','https://hoopscollege.com');
define('wp_siteURL','https://hoopscollege.com');
/*define("WP_CONTENT_URL", "http://static.hoopscollege.com");
define("COOKIE_DOMAIN", "www.hoopscollege.com");
*/
/* That's all, stop editing! Happy blogging. */
/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
/** Sets up WordPress vars and included files. */
define( 'CONCATENATE_SCRIPTS', false ); 
define( 'SCRIPT_DEBUG', true );
require_once(ABSPATH . 'wp-settings.php');
define( 'DISABLE_WP_CRON', true);
ini_set( 'allow_url_fopen', 1 );
define( 'WP_AUTO_UPDATE_CORE', true );
