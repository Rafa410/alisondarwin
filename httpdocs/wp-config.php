<?php
define( 'WP_CACHE', true );
define('WP_DEBUG_DISPLAY', false);
 // Added by PH Speed
define('DISALLOW_FILE_EDIT', false);
define('CONCATENATE_SCRIPTS', false);
define('WP_AUTO_UPDATE_CORE', 'minor');// Esta opción es imprescindible para garantizar que las actualizaciones de WordPress pueden gestionarse correctamente en el paquete de herramientas de WordPress. Si está instancia de WordPress ya no está gestionada por el paquete de herramientas de WordPress, elimine esta línea.
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
define('DB_NAME', 'wordpress_93');

/** MySQL database username */
define('DB_USER',       'wordpress_e5');

/** MySQL database password */
define('DB_PASSWORD',       '6p?4buN7');

/** MySQL hostname */
define('DB_HOST', 'localhost:3306');

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
define('AUTH_KEY',       '*gu*J4eTKbj%sNBa^yz8p3pAR7mi*CrqB7I4NIZH!cn@8GRdAUnqfZ2AQgRmu8AX');
define('SECURE_AUTH_KEY',       'oa6N)N@Z#cvQJDs#O&fPYM9FG*BdBNGXkD4URendG2)py7353KND311ljhZyQ%Sz');
define('LOGGED_IN_KEY',       'e3p@2Hdo8!C1Jpgwon3UpN12sHN%qHI4FgaeU4LWI9v&fwT%VJQ*JLSBxGOWfP40');
define('NONCE_KEY',       'hDASRtlv1en1JtLN5F^1es5l(pegCuJ4%G9qmj2)imHlOEsyF@1thTO3s7lP81qM');
define('AUTH_SALT',       'PF&FoEXGuMqFVFfW@LP@6Z^#tpCjRAVPgmegWwg)SpO%Gp^2*Eowe&LvW9eV1OyO');
define('SECURE_AUTH_SALT',       'W#Nu)XdP#!MNo637!ADc9O%TIe1bib@i)kwOlxBiJn&uMTL^1pgeBys1j7ESMs4p');
define('LOGGED_IN_SALT',       'dnttVvB8pXMBaLS4*8rQc!fDEYn)Sq61gNcVLicnO*f2g9BMH9IrsHtU&8Nw(naW');
define('NONCE_SALT',       '^rsZE3vpqtA(t9vGRvomjr8ZCG)NgmYZmk7YQFXIf4#y4)Wnt^7q1pV3Zwa8lsVd');
/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '1Ph3wg_';

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

/* Multisite */
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'alisondarwin.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

define( 'WP_ALLOW_MULTISITE', true );

define ('FS_METHOD', 'direct');
