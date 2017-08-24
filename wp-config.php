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
define('DB_NAME', 'pokermagasinet_com_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'iT-:)?XB<is)0Q:_rVV}vvr(-Wc5{62X?cf>G[w%S`W-iOFRXnv.G FXpLs(E4}<');
define('SECURE_AUTH_KEY',  '8`e2#gvxC$lskJgW[A+OO.lw?nJNIKz+kLVo[oG[76? -jjl=1zBK.nklo{N.#A#');
define('LOGGED_IN_KEY',    'h6oQ:Hwn>+6x}:mi4V:N5F;=Et0X<dnAMpL3$-jV-z~)vRx`qwEX[a+fitX`3Zxj');
define('NONCE_KEY',        'e~!Bg~$,5*;77`=]elqYSw@BU]8l?2|fvq(9Vm-=4&!<TmtE9&-?k:s+{Yr0E%*3');
define('AUTH_SALT',        'F0*Od<is|N~(48tZJ O|?Cvbdi-$_UgTsreDFt6H5FL.Al~3Jug9BK.kulJK! +_');
define('SECURE_AUTH_SALT', 'Rn&?iCE8newX),hh7z288GEKcRI! f%1*PvEQMU5Bdjh,9u$-ioa~,.hF4.C|9>]');
define('LOGGED_IN_SALT',   'W(j-2WD3SJ+30cAJO0n*N ^{KmD!xD~W~El] 1nI|p*8p&+mxTP-Ygg*8h2M~Urr');
define('NONCE_SALT',       '3X|D87RrFqb])h=7[ZK7n`rTZ`qUcN9LKxA}u@FCt,<1zX3lE;VDbbXnFvhN/r=p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ht_pokermagasinet_';

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

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
