<?php
$store_user    = get_userdata( get_query_var( 'author' ) );
$store_info    = dokan_get_store_info( $store_user->ID );
$store_tabs    = dokan_get_store_tabs( $store_user->ID );
$social_fields = dokan_get_social_profile_fields();
?>
<div class="profile-frame">

    <?php if ( isset( $store_info['banner'] ) && !empty( $store_info['banner'] ) ) { ?>
    <style type="text/css">
        .profile-frame {
            background-image: url('<?php echo wp_get_attachment_url( $store_info['banner'] ); ?>');
        }
    </style>
    <?php } ?>

    <div class="profile-info-box">
        <div class="profile-img">
            <?php echo get_avatar( $store_user->ID, 80 ); ?>
        </div>

        <div class="profile-info">
            <ul class="dokan-store-info">

                <?php if ( isset( $store_info['store_name'] ) ) { ?>
                    <li class="store-name"><?php echo esc_html( $store_info['store_name'] ); ?></li>
                <?php } ?>
                <?php if ( isset( $store_info['address'] ) && !empty( $store_info['address'] ) ) { ?>
                    <li class="dokan-store-address"><i class="fa fa-map-marker"></i>
                        <?php echo dokan_get_seller_address( $store_user->ID ); ?>
                    </li>
                <?php } ?>

                <?php if ( isset( $store_info['phone'] ) && !empty( $store_info['phone'] ) ) { ?>
                    <li class="dokan-store-phone">
                        <i class="fa fa-mobile"></i>
                        <a href="tel:<?php echo esc_html( $store_info['phone'] ); ?>"><?php echo esc_html( $store_info['phone'] ); ?></a>
                    </li>
                <?php } ?>

                <?php if ( isset( $store_info['show_email'] ) && $store_info['show_email'] == 'yes' ) { ?>
                    <li class="dokan-store-email">
                        <i class="fa fa-envelope-o"></i>
                        <a href="mailto:<?php echo antispambot( $store_user->user_email ); ?>"><?php echo antispambot( $store_user->user_email ); ?></a>
                    </li>
                <?php } ?>

                <li>
                    <i class="fa fa-star"></i>
                    <?php dokan_get_readable_seller_rating( $store_user->ID ); ?>
                </li>
            </ul>

            <?php do_action( 'dokan_store_before_social', $store_user, $store_info ); ?>

            <?php if ( $social_fields ) { ?>
                <ul class="store-social">
                    <?php foreach( $social_fields as $key => $field ) { ?>
                        <?php if ( isset( $store_info['social'][ $key ] ) && !empty( $store_info['social'][ $key ] ) ) { ?>
                            <li>
                                <a href="<?php echo esc_url( $store_info['social'][ $key ] ); ?>" target="_blank"><i class="fa fa-<?php echo $field['icon']; ?>"></i></a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div> <!-- .profile-info -->
    </div> <!-- .profile-info-box -->
</div> <!-- .profile-frame -->

<?php if ( $store_tabs ) { ?>
    <div class="dokan-store-tabs">
        <ul class="dokan-list-inline">
            <?php foreach( $store_tabs as $key => $tab ) { ?>
                <li><a href="<?php echo esc_url( $tab['url'] ); ?>"><?php echo $tab['title']; ?></a></li>
            <?php } ?>
            <?php do_action( 'dokan_after_store_tabs', $store_user->ID ); ?>
        </ul>
    </div>
<?php } ?>