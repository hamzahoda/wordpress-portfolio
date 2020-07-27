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
define( 'DB_NAME', 'portfolio' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'n$4prx4lsDw(VimB(pbvJ-E)]`k^!Bd }+$_x|)|#D&i^qZ z&4(i/i[n]o4{h@&' );
define( 'SECURE_AUTH_KEY',  '7a-8I(|)2^y1@o-Y1VnC.4&S].vyG1^_IN?RU C<Qq-Ot6e_<4Be;AEUL(BvCi*,' );
define( 'LOGGED_IN_KEY',    'Gc8<dxXwwZf]N&/A-:.<I7t_Hg>6u0VnR{XVuj:-7UiBoM3D%TU}[a[w@I9%2vhP' );
define( 'NONCE_KEY',        '0U~O7^V]zNFDGJD&a2n*LNP=E T$3.c27?O<nC;F+es&40:@:7kVQ`>1x/qC;F%G' );
define( 'AUTH_SALT',        'efJzn4+foVCQW1nds|Bq-qW7{+7_b_^p4oDMomhRszbolc74.-YksVaJjc9FV_v8' );
define( 'SECURE_AUTH_SALT', 'Dqo5dA5:1q,gVsijIAXqPPr/540L-lJ37v2#chUEG/kZO4(OuJrst/;dIBfouIb-' );
define( 'LOGGED_IN_SALT',   '!*.^G>IX<1nK,8@A~YE?sZlM3%[xQ<Wn8JrHoV.}H.$6>_p<gJ.> zU<@@M@Q9Z>' );
define( 'NONCE_SALT',       '._DYHG.V6eT|tN&y{XJcP>mR|a<tM`NBqlR=D1Ui!9ADay0Ip!;.vZ)I`||9|80|' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
