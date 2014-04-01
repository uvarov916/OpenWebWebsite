<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_openweb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'Ou}tFGOaV$O9<I5[_p1Hn}.UyBX]yBjqPF0)3P @185xWs4boWl?Yx{,u |#b2V~');
define('SECURE_AUTH_KEY',  'O;Ba_eCF<Ng?N.@Q<9yw4Y~?K3i91WPVtd<=1rDEriyR}n}t^9z6^=Mni&z,e{ys');
define('LOGGED_IN_KEY',    'Nd3WP}ph@SYCQTM^jsZJA4&X8n@yoh](v#nsC)o3a]3}[3vbSTq*oVe(wQfsRfa{');
define('NONCE_KEY',        'w5JN_F*E3K<HTOuU4er+o$sd{ loA-ftr/5n1N<pl?pIqQ<zt,{;W9]tWaaR|ct[');
define('AUTH_SALT',        'wo2Yh<Ux8r>:{QT5w/C^TmA8$7*;^._QM)jFv)qvfw_P|Q123r[><QW60b7^}:&L');
define('SECURE_AUTH_SALT', '_*kn39%I]O_~nJh7Q&^{qw65PIMSQ&;T1Wb} 9k{R;sR}!tq.i%O-6-MW-fu7{em');
define('LOGGED_IN_SALT',   '3L2&vxNa2ea pqW%d.g#rN|n4M/`K:)UlXzKel4T M4vk%j`+f<y*aW?J<tb:,sM');
define('NONCE_SALT',       'Es)Ic2)XLXqI=k/y=itm=cgtc~b]^SWxc=yv{HZxD1L*3N9|b%fg6Rd#qY{v0S{h');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ow_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
