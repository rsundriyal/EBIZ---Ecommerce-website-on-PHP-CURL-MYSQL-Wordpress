 <!--Footer-->
 <?php 
 $display_footer_widgets    = alchem_option('display_footer_widgets','no'); 
 $footer_columns            = alchem_option('footer_columns','1'); 
// $copyright_text            = alchem_option('copyright_text',''); 
 $tooltip_position          = alchem_option('footer_social_tooltip_position','top'); 
 $footer_special_effects    = alchem_option('footer_special_effects','');
 $footer_class =  $footer_special_effects == 'footer_sticky'? 'fxd-footer':'';
 ?>
        <footer class="<?php echo $footer_class;?>">
        <?php if( $display_footer_widgets == 'yes' ):?>
            <div class="footer-widget-area">
                <div class="container">
                    <div class="row">
                    <?php 
					for( $i=1;$i<=$footer_columns; $i++ ){
					?>
                    <div class="col-md-<?php echo 12/$footer_columns; ?>">
                    <?php
							if(is_active_sidebar("footer_widget_".$i)){
	                           dynamic_sidebar("footer_widget_".$i);
                               }
							?>
                    </div>
                    
                    <?php }?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="footer-info-area">
                <div class="container text-center"> 
                 <?php echo alchem_get_social('footer','footer-sns', $tooltip_position);?>
                    <div class="clearfix"></div>
                    <?php 
					 wp_nav_menu(array('theme_location'=>'footer_menu','depth'=>1,'fallback_cb' =>false,'menu_class'=>'footer-links','link_before' => '', 'link_after' => '','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
					?>
                    
                    <div class="site-info">
                    <?php printf(__('Powered by <a href="%s" target="_blank">WordPress</a>. Designed by <a href="%s" target="_blank">Magee Themes</a>.','alchem'),esc_url('http://wordpress.org/'),esc_url('http://www.mageewp.com/'));?>
                    </div>
                    
                </div>
            </div>          
        </footer>
    </div>  
    <?php wp_footer(); ?>
</body>
</html>