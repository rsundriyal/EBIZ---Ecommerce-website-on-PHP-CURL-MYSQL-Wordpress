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
define('DB_NAME', 'ravisund_wordpressae1');

/** MySQL database username */
define('DB_USER', 'ravisund_wordae1');

/** MySQL database password */
define('DB_PASSWORD', 'KSahorAtwGGq');

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
define('AUTH_KEY', 'rG_}+Q^XMUhOc!-XtQI+t+y<eERxkWE{?HnP]orUI<=eBnA|=]SZs=mtr=bW*aKj+QuV*RwqP=_iUkXShoUsb$WOHBuxZsgbZ?{igcVsZD@gSSBku-+{pdF//oa*x{w/');
define('SECURE_AUTH_KEY', '>q>!&;u-_vli]Z>_<[d=TZJ[B?XhjtA$gYq_JzJ!hV^hkNcRBixIL?vtMbO]|O=^HikZ-u+LhXdBo%zW;q(Nx^(g;cl@*Lur<!*z@_A=&+tQY|uZG?Z=wxxpy!XzdVs+');
define('LOGGED_IN_KEY', 'VYlUEGaxIJ@+sDX+NXu=aw=nYvyrXwa%wWrw;+Wx{(=/<e-n%c?T&*!xfmQAXmb}dNrJYqoD;FGb^W?D%S?)jvV?[=<rv(b!XUB&pu|l;}i$EII+h*GkaGVegrow_m+B');
define('NONCE_KEY', '_K/(C==?ffbR>fFX;s{vKQT);cRhOoZS|IPSxx$vgFtf*%nLF/?%py%(P%db[A%a+oA[{([=ZL}(o=>J+KtzyVHWqK/QQetTWJy$@j<yIclG!FlsPgye%m%AM*VbZnqv');
define('AUTH_SALT', '>lHK{]nD%ojrM;eMMjOiDZrhz@ynru<jr&eV=)dmeq}yuhlz[=]nVPpM$$vV]PdG_Q(thtl|c/{Tpq%/[tnh)x^$+NmA$ukJqEeS<d[moQY!{iOB^c=]F>%<gx+%(TvU');
define('SECURE_AUTH_SALT', 'z=FTzS=d/ISo*IWZI^QVLU(vp^ck(aCxr/h(=nPjQ]qQOpAmpR)_v%is;iYnt)_kM+m{>Aj$ZKr<%Wz/a]-bG[R?i-ZyMV)LJZtzAZ(@zkHpwCB{LOzr>!mz{XSYQBwJ');
define('LOGGED_IN_SALT', 'aujgawr<^SGH;fv)rMXqnnK(w*nEF>q*NuePmBz(XAq%$ZZHORZeA*<|K{DMqYYLoI<RMQ-Qh-QhyZ^zIjrl{<J&jybz!C;rF+Ly%ccvkW$FucxVu*OmpLkaL+Vh[i_G');
define('NONCE_SALT', 'wJiqwVi<TSQ}{P==OR[GiwI(Kxu?|XP$d=?}jc+cM/yu{GI@>?iyqxhr|_m|HY@EK$OfNg&PAt|?Vw$$;sxTb|gduF@ifTJVLO(CW^qlrs&<=(e(n|WvzE);lK>YFFEC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_vcne_';

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

/**
 * Include tweaks requested by hosting providers.  You can safely
 * remove either the file or comment out the lines below to get
 * to a vanilla state.
 
if (file_exists(ABSPATH . 'hosting_provider_filters.php')) {
	include('hosting_provider_filters.php');
} */
