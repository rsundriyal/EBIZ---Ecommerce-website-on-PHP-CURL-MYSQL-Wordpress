<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$is_premium_activated = false;
if( is_array( $module_data['premium_constat'] ) ) {
    foreach( $module_data['premium_constat'] as $single_premium_constant ){
        if( defined( $single_premium_constant ) ) {
            $is_premium_activated = true;
            break;
        }
    }
}
else if( isset( $module_data['premium_constat'] ) && defined( $module_data['premium_constat'] ) ) {
    $is_premium_activated  = isset( $module_data['premium_constat'] ) && defined( $module_data['premium_constat'] );
}

$is_yith_repository = ( isset( $module_data['repository'] ) && $module_data['repository'] == 'yith'  );
$referral_arg = $refer_id > 0 ? '?refer_id='.$refer_id : '' ;
// yith repository
if ( $is_yith_repository ) {
    $plugin = $module_data;

    $plugin['author'] = '<a href="http://yithemes.com/">yithemes</a>';

    $plugin_icon_url = YJP_ASSETS_URL . '/images/plugins/' . $plugin['slug'] . '.jpg';
}
//wordpress repository
else {
    $plugin = $module_data['wp_info'];

    if ( ! empty( $plugin['icons']['svg'] ) ) {
        $plugin_icon_url = $plugin['icons']['svg'];
    }
    elseif ( ! empty( $plugin['icons']['2x'] ) ) {
        $plugin_icon_url = $plugin['icons']['2x'];
    }
    elseif ( ! empty( $plugin['icons']['1x'] ) ) {
        $plugin_icon_url = $plugin['icons']['1x'];
    }
    else {
        $plugin_icon_url = $plugin['icons']['default'];
    }
}

$title = wp_kses( $plugin['name'], $plugins_allowedtags );

// Remove any HTML from the description.
$description = strip_tags( $plugin['short_description'] );

$version     = wp_kses( $plugin['version'], $plugins_allowedtags );

$name = strip_tags( $title . ' ' . $version );

$author = wp_kses( $plugin['author'], $plugins_allowedtags );
if ( ! empty( $author ) ) {
    $author = ' <cite>' . sprintf( __( 'By %s' ), $author ) . '</cite>';
}

if( !empty( $referral_arg ) ) {
    $author = str_replace('http://yithemes.com/' , 'http://yithemes.com/'.$referral_arg , $author);
}

$action_links = array();
if ( $is_active ) {
    $action_links[] = '<a class="deactivate-now button" data-slug="' . $plugin['slug'] . '" href="' . wp_nonce_url( add_query_arg( array( 'action' => 'deactivate', 'module' => $plugin['slug'] ) ), 'deactivate-yit-plugin' ) . '" aria-label="' . sprintf( __( 'Deactivate %s now', 'yith-essential-kit-for-woocommerce-1' ), $plugin['slug'] ) . '" data-name="' . $plugin['name'] . '">' . __( 'Deactivate', 'yith-essential-kit-for-woocommerce-1' ) . '</a>';
}
else {

    if( $is_premium_activated ) {
        $url = '#';
        $active_class = 'disabled';
    } else {
        $url = wp_nonce_url( add_query_arg( array( 'action' => 'activate', 'module' => $plugin['slug'] ) ), 'activate-yit-plugin' );
        $active_class = '';
    }

    if( ! $is_premium_activated )
    $action_links[] = '<a class="activate-now button '.$active_class.'" data-slug="' . $plugin['slug'] . '" href="' . $url . '" aria-label="' . sprintf( __( 'activate %s now', 'yith-essential-kit-for-woocommerce-1' ), $plugin['slug'] ) . '" data-name="' . $plugin['name'] . '" >' . __( 'Activate', 'yith-essential-kit-for-woocommerce-1' ) . '</a>';
}

if(  ! $is_yith_repository ) {
    $details_link = network_admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=' . $plugin['slug'] .
        '&amp;TB_iframe=true&amp;width=600&amp;height=550' );
    /* translators: 1: Plugin name and version. */
    $action_links[] = '<a href="' . esc_url( $details_link ) . '" class="thickbox" aria-label="' . esc_attr( sprintf( __( 'More information about %s' ), $name ) ) . '" data-title="' . esc_attr( $name ) . '">' . __( 'More Details' ) . '</a>';
}

if ( $is_premium_activated ) {
    $premium_url = '#';
    $btn_class   = 'btn-premium installed';
    $btn_title   = __( 'Premium Activated' );
}
else if ( $is_premium_installed ) {
    $premium_url = get_admin_url(null,'plugins.php');
    $btn_class   = 'btn-premium toactive';
    $btn_title   = __( 'Activate Premium' );
}
else {
    $premium_url = 'http://yithemes.com/themes/plugins/' . ( isset( $module_data['premium-url'] ) ? $module_data['premium-url'] : $plugin['slug'] ).$referral_arg;
    $btn_class   = 'btn-premium tobuy';
    $btn_title   = __( 'Buy Premium Version' );
}


$action_links[] = '<a class="'.$btn_class.'" href="' . esc_url( $premium_url ) . '" aria-label="' . esc_attr( sprintf( __( 'Buy Premium Version of %s' ), $name ) ) . '" data-title="' . esc_attr( $name ) . '" target="_blank">' .$btn_title. '</a>';


$date_format            = __( 'M j, Y @ H:i' );
$last_updated_timestamp = strtotime( $plugin['last_updated'] );

?>
<div class="plugin-card plugin-card-<?php echo sanitize_html_class( $plugin['slug'] ); ?>">
    <div class="plugin-card-top">

        <?php if( $is_new ) : ?>

        <span class="product-icon"><img src="<?php echo YJP_ASSETS_URL . '/images/badge-new.png';?>" alt="New Icon"></span>

        <?php elseif( $is_recommended ) : ?>

                <span class="product-icon"><img src="<?php echo YJP_ASSETS_URL . '/images/badge-recommended.png';?>" alt="New Icon"></span>

        <?php endif ?>

        <a href="<?php echo esc_url( $details_link ); ?>" class="thickbox plugin-icon"><img src="<?php echo esc_attr( $plugin_icon_url ) ?>" /></a>

        <div class="name column-name">
            <h4>
                <a href="<?php echo esc_url( $details_link ); ?>" class="thickbox"><?php echo $title; ?></a>
            </h4>
        </div>
        <div class="action-links">
            <?php
            if ( $action_links ) {
                echo '<ul class="plugin-action-buttons"><li>' . implode( '</li><li>', $action_links ) . '</li></ul>';
            }
            ?>
        </div>
        <div class="desc column-description">
            <p><?php echo $description; ?></p>
            <p class="authors"><?php echo $author; ?></p>
        </div>
    </div>

    <div class="plugin-card-bottom">
        <div class="column-updated">
            <strong><?php _e( 'Last Updated:' ); ?></strong> <span title="<?php echo esc_attr( date_i18n( $date_format, $last_updated_timestamp ) ); ?>">
                    <?php printf( __( '%s ago' ), human_time_diff( $last_updated_timestamp ) ); ?>
                </span>
        </div>
        <?php if( isset( $plugin['rating'] ) ) : ?>
        <div class="vers column-rating">
            <?php wp_star_rating( array( 'rating' => $plugin['rating'], 'type' => 'percent', 'number' => $plugin['num_ratings'] ) ); ?>
            <span class="num-ratings">(<?php echo number_format_i18n( $plugin['num_ratings'] ); ?>)</span>
        </div>
        <div class="column-downloaded">
            <?php
            if ( $plugin['active_installs'] >= 1000000 ) {
                $active_installs_text = _x( '1+ Million', 'Active plugin installs' );
            }
            else {
                $active_installs_text = number_format_i18n( $plugin['active_installs'] ) . '+';
            }

            if ( $plugin['downloaded'] >= 1000000 ) {
                $download_text = _x( '1+ Million', 'Downloaded' );
            }
            else {
                $download_text = number_format_i18n( $plugin['downloaded'] ) . '+';
            }
            printf( __( '%s Download, %s Active Installs' ), $download_text, $active_installs_text );
            ?>
        </div>
        <?php endif; ?>

    </div>
</div>