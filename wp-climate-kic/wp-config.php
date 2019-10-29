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
define( 'DB_NAME', 'climate-kic-malta' );

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
define( 'AUTH_KEY',         'Esm+U&a-~.g(WZze*@biSoZ3_<n18n>cY8pmxr%^, OuT5ClO|8q2tKPhnS<Y5;8' );
define( 'SECURE_AUTH_KEY',  '5(sh?D[D3aw/,I$N3mK:ZLtM`-mQ,)MUghV~^yc36jA[|o%Wf`xkYgAuQuYYT2 N' );
define( 'LOGGED_IN_KEY',    'hqw8N^7l_t,F%J|Cf:GO!XQh=dnJWNBRt9a.>lw<OJv`DIw,fniKM ^gnB|F|oTz' );
define( 'NONCE_KEY',        '^GJ8%#WFv62(4B_f[sYy7*@gbJPZHe}B1I5av6tJhuELUS7@tPl<`[:Ot@EJJ!pN' );
define( 'AUTH_SALT',        'v^~m</[.bC*{D]@3Lf*Lxn/VuzaXrryD8)eh~t jog;J Yb.7a4w{F`l y.lKO0=' );
define( 'SECURE_AUTH_SALT', '7Ukj<S,A6rtqHPA>:.nBH=E&frP}&IM*+&Z 3izQ(cxPCELn*#l#4,l^4RDpO.R/' );
define( 'LOGGED_IN_SALT',   'UwE51o]*T Z$:T{X+c=5Vi?`fRmb(QFP`<Vie)7da#6}2LrwyeEp+i#3Caw5/ |W' );
define( 'NONCE_SALT',       'Y#rMds3Yo&LW2lOvW8hce}z)R8*+]`~3eI+D5h1+W|g}ismrY@PdCMo88-15X>Y6' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
