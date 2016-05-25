<div class="wrap">  
    <div id="icon-themes" class="icon32"></div>  
    <h2>Grid/List View Settings</h2>  
    <?php settings_errors(); ?>  

    <?php $active_tab = isset( $_GET[ 'tab' ] ) ? @ $_GET[ 'tab' ] : 'buttons'; ?>  

    <h2 class="nav-tab-wrapper">  
        <a href="?page=br-list-grid-view&tab=buttons" class="nav-tab <?php echo $active_tab == 'buttons' ? 'nav-tab-active' : ''; ?>"><?php _e('Buttons', 'BeRocket_LGV_domain') ?></a>
        <a href="?page=br-list-grid-view&tab=product_count" class="nav-tab <?php echo $active_tab == 'product_count' ? 'nav-tab-active' : ''; ?>"><?php _e('Product Count', 'BeRocket_LGV_domain') ?></a>
        <a href="?page=br-list-grid-view&tab=liststyle" class="nav-tab <?php echo $active_tab == 'liststyle' ? 'nav-tab-active' : ''; ?>"><?php _e('List Style', 'BeRocket_LGV_domain') ?></a>
        <a href="?page=br-list-grid-view&tab=css" class="nav-tab <?php echo $active_tab == 'css' ? 'nav-tab-active' : ''; ?>"><?php _e('CSS', 'BeRocket_LGV_domain') ?></a>
        <a href="?page=br-list-grid-view&tab=javascript" class="nav-tab <?php echo $active_tab == 'javascript' ? 'nav-tab-active' : ''; ?>"><?php _e('JavaScript', 'BeRocket_LGV_domain') ?></a>
    </h2>  

    <form class="lgv_submit_form" method="post" action="options.php">  
        <?php 
        if( $active_tab == 'buttons' ) { 
            settings_fields( 'br_lgv_buttons_page_option' );
            do_settings_sections( 'br_lgv_buttons_page_option' );
            echo '<input type="submit" class="button-primary" value="' . __('Save Changes', 'BeRocket_LGV_domain') . '" />';
        } else if( $active_tab == 'product_count' ) {
            settings_fields( 'br_lgv_product_count_option' );
            do_settings_sections( 'br_lgv_product_count_option' );
            echo '<input type="submit" class="button-primary" value="' . __('Save Changes', 'BeRocket_LGV_domain') . '" />';
        } else if( $active_tab == 'liststyle' ) {
            settings_fields( 'br_lgv_liststyle_option' );
            do_settings_sections( 'br_lgv_liststyle_option' ); 
        } else if( $active_tab == 'css' ) {
            settings_fields( 'br_lgv_css_option' );
            do_settings_sections( 'br_lgv_css_option' ); 
        } else if( $active_tab == 'javascript' ) {
            settings_fields( 'br_lgv_javascript_option' );
            do_settings_sections( 'br_lgv_javascript_option' );
            echo '<input type="submit" class="button-primary" value="' . __('Save Changes', 'BeRocket_LGV_domain') . '" />';
        }
        ?>
    </form> 

    <h4><?php _e('WooCommerce AJAX Product Filters developed by', 'BeRocket_LGV_domain') ?> <a href="http://berocket.com" target="_blank">BeRocket</a></h4>
</div>