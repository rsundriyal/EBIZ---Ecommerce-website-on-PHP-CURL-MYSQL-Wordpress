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
define('DB_NAME', 'ravisund_wordpress6ab');

/** MySQL database username */
define('DB_USER', 'ravisund_word6ab');

/** MySQL database password */
define('DB_PASSWORD', 'Zya7OqkjAQb7');

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
define('AUTH_KEY', 'rIKbUIyQxE-NHRIt=lCUdi+}WZ/kv|RBpcT[f$hLKYaV!NUGJ%(ZS(R+=y}>dUl}V@&LvrNI//B}_Imuv)qo!+Y{L<}d-P!+|W_*@V;+UY%yF}BYTz)VabmS(F(LnmWs');
define('SECURE_AUTH_KEY', '?Btx![IhqXaHEs)J-J/Ah$?uVB?($e[Mj>oYygM&@=HS+Rh?ktIPl|EDN_ncJ]|c_f<su?khSiDcmIrYQ_x{GyMtYjX]&QP!&qwysLw/Zv^e)[$$N/Dd@oaWDiHPwmK)');
define('LOGGED_IN_KEY', '*=Xul;Yw-uPYjmFlLoWIP@Xs%]r!/=f>_BXTpd<Lqy_bvc>sKG=X>hznlV*!=qlMd|MkW%Zfd^PNbSl{Pc;]X(TLzxV%n$F$wrjxZ<Dow|/W>NcriBaXkz-BelH%QX)W');
define('NONCE_KEY', 'g&___n(<sUPIniC<Z=t/tMjuteW/hQQ==DERF-VTpLxaVe-%^-?{lj=ST{$^[RrwauXpCWSwQjmd+AQqixEXDerF/dSE-DatrRDMo?yZWV&?^y*s)RM!NCu)JsUwFdm>');
define('AUTH_SALT', '_CQB<E;(J)zx(Sar}HMyyN|vs;!CI-V>YUgsEH[fIJ[k)H=;M/Npxa[Z^bj&plFf{SiMmWZDk))WpR%b_tqfe[pd$R]Xt$h[;PqI!&gA-m)=xX_sFkO{sf<_Q)en?rf@');
define('SECURE_AUTH_SALT', '(c>eluHYrejio-CQDpr!?NnvfA)}%|h@!WgKv=L}j_/PouB_GioU&{zb>KmI+tsZ!+DoX${;l>}qL]tGPE-!D=Ym-IF[I([)gkyl[WP<uCsLzosEeMT^OrVU+_lAuXxs');
define('LOGGED_IN_SALT', 'QQ)Yrg[XESm>rt(uBGlHMccc&{GF%c-y$--ZASP_hoz?U)J<@Cs!=GfXVUp=qQ]+l;vHIk&]?*G?)eUjYHqppcLog+{%cRU!y!Jj/+jVqobyUHXvwi|Pob])<GT/?}SU');
define('NONCE_SALT', ')p{ykDG$Y%?x*porZuR{NPc=HkaYyrYL[w*{b]HG%iJNtwphBhOz)<wf+xZfV^N>WOpDt(AY/=fqo%JxjeSN[/WD_t}_/PefHsX+(nup<lCx<cgdu{B{ZYS@U/d{P}DS');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_mnhq_';

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
