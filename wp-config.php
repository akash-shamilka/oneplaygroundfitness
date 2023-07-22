<?php
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
define( 'DB_NAME', 'oneplaygroundfitness' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'K]~59/YCY4d&koe2afQh8RTU2%q66-h,[*]Er!&[+s&A]`EA5:2m1wgpTpP(X+jG' );
define( 'SECURE_AUTH_KEY',  '<Ek$FRFvjYe>BHRh,Sz.^w-m+lx|F1Wd0i#}c--GC?Y>sN[O9Yye.zesk8K`+kcb' );
define( 'LOGGED_IN_KEY',    'iQvoF?^&nT2^Pvp=O1fsV-XAbPN~_U:Wr7s/AT4#aNiwf@RWPl~Q5Y;S&m3*~}Jm' );
define( 'NONCE_KEY',        'HCsaVUHs*WzOK=@5QC0w,3)$,@+||XlPooW3/S{|SfoAV!KZwV17B]u44B!Z`9~w' );
define( 'AUTH_SALT',        '[TuS40CNG(iLzJ&TZXK|3YW1T;]{[M25d2KI$$#ylOol9@ME<-^ d;JLmi#woSBo' );
define( 'SECURE_AUTH_SALT', 'Z-*[Z{G=JKX+NxQcO?A.n{Lab%mEtiR$%@^Es/<nx2,q/ r_YRwd0b8Zo4&A<+OY' );
define( 'LOGGED_IN_SALT',   '[_SJUIuebobeU7Hm =y}6,#c>jO)r%`6i[%3v*v?{Td ?RgDRK8l$hfC[{}&?-H9' );
define( 'NONCE_SALT',       'tr-mG#5E,O{k?Tpvd|Y]XsQfBVKpFB]u&c~FZww7+)CFR RO2(`/>gF KUB)-S2W' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
