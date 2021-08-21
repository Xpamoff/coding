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
define( 'DB_NAME', 'wp' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '2-9jwr!rydE/_+nJ=G3./jq^yR.8ed>Q0wFF.*um#tL4r$};DkTzdvHK=se~|ewb' );
define( 'SECURE_AUTH_KEY',  '#M{jZB<;(44>B`SP;~A!ryZ =]=fwwg.tKc5D^CDe%Iv?v)h?TlXNY?V<Y_KdAwZ' );
define( 'LOGGED_IN_KEY',    'k*>3R)g=jY(_kPUc/KC& u57o>0mbO[MxZ|`[HZ{?PB84iD-Dso s>l+?d2 *m/r' );
define( 'NONCE_KEY',        'CJ$O^)s9GFZbo&Ac11tQnDf`@h/+2W_p;`9qu7;]232k-8U`~SDJDY=;Oft|F7[H' );
define( 'AUTH_SALT',        '?!oK$A%-P5*Xrwq>>fV_;:Z)8)q:()=w<>iEI@1 ;H8G?T&G,QZHE2TR8~}|0q}1' );
define( 'SECURE_AUTH_SALT', 'yqj_Y;8n(}tWUJkwae|Go>S:v~P.6V:/6X&~BLo,7j:r^dbH9+xd*yB2/]#E&>Rv' );
define( 'LOGGED_IN_SALT',   ':B*W8t>ueGlmfTky4t/y*IzG%:|{=c!KYvO&32l+pJ,IWlhf B|:[X15Dlj!J;]H' );
define( 'NONCE_SALT',       '8K%4%_.XdN=*?,iZLoBw[@_>^MR&-@1!q+2ZE%(1(2MKu@Ht:Xq.^sh0)/p+u_Ir' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
