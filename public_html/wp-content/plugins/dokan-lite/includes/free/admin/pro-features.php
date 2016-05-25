<div class="wrap">
    <h2><?php _e( 'Dokan - Pro Features', 'dokan' ); ?></h2>

    <?php
    // $add_ons = get_transient( 'dokan_addons' );

    // if ( false === $add_ons ) {
    //     $response = wp_remote_get( 'http://wedevs.com/api/dokan/addons.php', array('timeout' => 15) );
    //     $add_ons  = wp_remote_retrieve_body( $response );

    //     if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) {
    //         return false;
    //     }

    //     set_transient( 'dokan_addons', $add_ons, 12 * HOUR_IN_SECONDS );
    // }

    // $add_ons = json_decode( $add_ons );
    

    require_once DOKAN_FREE_ADMIN_DIR . '/pro-feature-list.php';

    if ( count( $pro_features ) ) {
        foreach ($pro_features as $pro_feature) {
            ?>

            <div class="pro-feature">
                <div class="pro-feature-thumb">
                    <a href="<?php echo $pro_feature['url']; ?>" target="_blank">
                        <img src="<?php echo $pro_feature['thumbnail']; ?>" alt="<?php echo esc_attr( $pro_feature['title'] ); ?>" />
                    </a>
                </div>

                <div class="pro-detail">
                    <h3 class="title">
                        <a href="<?php echo $pro_feature['url']; ?>" target="_blank"><?php echo $pro_feature['title']; ?></a>
                    </h3>

                    <div class="text"><?php echo $pro_feature['desc']; ?></div>
                </div>

                <!-- <div class="pro-links">
                    <?php if ( class_exists( $pro_feature['class'] ) ) { ?>
                        <a class="button button-disabled" href="<?php echo $pro_feature['url']; ?>" target="_blank">Installed</a>
                    <?php } else { ?>
                        <a class="button" href="<?php echo $pro_feature['url']; ?>" target="_blank">View Details</a>
                    <?php } ?>
                </div> -->
            </div>

            <?php
        }
    } else {
        echo '<div class="error"><p>Error fetching add-ons. Please reload the page again!</p></div>';
    }
    ?>

    <style type="text/css">
        .pro-feature {
            width: 525px;
            float: left;
            margin: 20px;
            border: 1px solid #E6E6E6;
        }

        .pro-feature-thumb img {
            width: 525px;
            height: 250px;
        }

        .pro-detail {
            padding: 10px 20px;
            min-height: 100px;
            background: #fff;
        }

        .pro-detail h3.title {
            margin: 5px 0 10px;
            padding: 0;
        }

        .pro-detail h3.title a {
            text-decoration: none;
            color: #111;
        }

        .pro-links {
            padding: 10px;
            background: #F5F5F5;
            border-top: 1px solid #E6E6E6;
        }

        a.button.disabled {
            background: #eee;
        }
    </style>

</div>