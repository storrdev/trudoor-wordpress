<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache














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
//Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home3/buckeye/public_html/dev/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'buckeye_wrdp1');

/** MySQL database username */
define('DB_USER', $_ENV['DB_USER']);

/** MySQL database password */
define('DB_PASSWORD', $_ENV['DB_PASS']);

/** MySQL hostname */
define('DB_HOST', $_ENV['DB_HOST']);

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
define('AUTH_KEY',         '*TBh2Z)=i6|1PY67X3u|7xz/)S5j/RQ?(DoH4<!Ob019J\`<De*?\`AUE43h\`@~?qSP~9vP)r@hj)@S#C2S/');
define('SECURE_AUTH_KEY',  '');
define('LOGGED_IN_KEY',    'R0*W1E?uxq((zXlP!@D<\`OMJnZ6\`\`9#CV?PUJ|ZFAfBH)AE5OklgnPdT~5v>F-:^qf2K');
define('NONCE_KEY',        '7B-opDL@viE-\`3n*mwuE0lr!>-D*$hwXen?;FHJ\`jZ5A_Z=t1OLpZ!OgHwSe2=@?gT1lkb*F*q');
define('AUTH_SALT',        '1A-n<vSU\`-\`88/L/;)hEmzv79dnHlAc:tl$>Hbrjzm0:yd;0KlshR2F^P;#mHf3g=j/~=zJ$e|3u');
define('SECURE_AUTH_SALT', 'S9_=G=y?zn(02UGoOz\`-!#^7@YNB)hS|6l~k/q4@w6^uPTnnUse(DtLAFU>bI;@6V$XhZUN)/Twa3|05e');
define('LOGGED_IN_SALT',   '*I9?JVGU(_J!@Psx=kvAbW#HCoHrGpEOChxjL|5QHGS~59p76Kh0>I324/$IoPSrYhjWa_N?^G');
define('NONCE_SALT',       'iVie6i^/FK:T;Z2>z|TamHEGfedQM/fZoEYvCZ5>ej5)lrohk^j|S9WIeKd^g!<VtvoAlc-bv');

/**#@-*/

/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each a unique
* prefix. Only numbers, letters, and underscores please!
*/
$table_prefix  = 'wp_';

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
