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
define('DB_NAME', 'ravisund_wordpressf88');

/** MySQL database username */
define('DB_USER', 'ravisund_wordf88');

/** MySQL database password */
define('DB_PASSWORD', 'ryET4KQkYjhH');

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
define('AUTH_KEY', 'NziVyhBo$N|Srh}?c_Y>E+XtXQ{=&a$psj^NqzLuSUm}uL**vwbQRYHcROB=!qY?]UuZ<V&[|Qs>VkMB/F+dg(d?xuKviXbJJMeg/bJu=kffj|w*@s$_<NC>$[u/F$Qz');
define('SECURE_AUTH_KEY', '|lcvz)XfHuOP)FgI?LWvutevqi}$>hIwG*]L&_-ALql$UHwte|sJ$-Do<^ObHH_q-g%zyGZjnjbbX|ZOzlk@s-FqpMb}WYEgi]})lBb!kRGlFGLj%+((Ou*J*HOYlr+A');
define('LOGGED_IN_KEY', 'jB}<[-%[NMle%pY@Dm|SeDCG;sUCZ[L)ii{^PODi$qK?!z=$}RTNFuh??hxwyOT^T|/ybW<W|Fi/yQ}P)*aecxRIQX_hgb[qqCdUm}e([<)Q(?yv!CAblDWxaP-KoCn|');
define('NONCE_KEY', '=y>UHYWem^ZZsp/_T?=d)_O@wdXJfg^/P*h${YZ*VSKxe^UOu_tl@a(xvOX|?MW)hv*|T[=oL}orpB|m<QvR}&[[&qy*Cd|KkDigAssY!q;)=V_oaS[QxMO{<JpF^Z;&');
define('AUTH_SALT', 'ph-$TSSgRQNy<m?wk!XjlYO_%uGaSRsCMnrnuui<)_E/tA}TES^f;T?EDGE^eo+AV_tdDsUXqZtQx)WMVCxNPp[nnS(;FX*gLqsjW&BFE=p&niNuZmLbqKx-iPWjRL*Y');
define('SECURE_AUTH_SALT', '$?;]!osWCT&OoF!](W]hhlWB@OKSz;TaeBO+bE/>NThz-B(BDIAKK&-TFk<die>eA]keFNW^{<)Tqxi[o!-[UP}NBP[TWPYBG+-ARiQP^fZQNX&eu--xA@O;Pi^(OUJA');
define('LOGGED_IN_SALT', 'btFDslH<F][|u]PwAxhfcE%wBj</U%VnjOI@Drd!Nxu]kui;s]@Ser)Bjf=$icNNWQkDr!_}[XCjF*omyRCfcocohoCs[TWQJXIa&RhpRBs$UaX-k[dK={vPeZkBffzo');
define('NONCE_SALT', 'P{@KaWA@<TK^ttMYf=q<<XW(gdy&m]qAZzv=qthL;tM=vFMAJwrIV}-EWT)V!J]eTbsPusOnUqR%!$WAyC]DU;?m=nnZum+]$OjIKLCGV&KnU]gR?M/Lm$)%|bw%{u/<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_kotb_';

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
