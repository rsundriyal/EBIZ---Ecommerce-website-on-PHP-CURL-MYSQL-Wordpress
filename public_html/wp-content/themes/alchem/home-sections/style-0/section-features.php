<?php
//section features
   global $allowedposttags,$alchem_home_animation;
   $section_hide    = absint(alchem_option('section_4_hide',0));
   $content_model   = absint(alchem_option('section_4_model',0));
   $section_id      = esc_attr(sanitize_title(alchem_option('section_4_id')));
   $section_color   = esc_attr(alchem_option('section_4_color'));
   $section_title   = wp_kses(alchem_option('section_4_title'), $allowedposttags);
   $section_content = wp_kses(alchem_option('section_4_content'), $allowedposttags);
   $image           = esc_url(alchem_option('section_4_image'));
   $section_content = str_replace('\\\'','\'',$section_content);
   $section_content = str_replace('\\"','"',$section_content);

 ?> 
 <?php if( $section_hide != '1' ):?>
  <section class="section magee-section alchem-home-section-4 alchem-home-style-0" id="<?php echo $section_id;?>">
  <div class="section-content" style="color:<?php echo $section_color;?>;">
  <div class="container">
  <?php if( $content_model == 0 ):?>
  <?php if( $section_title != '' ):?>
    <h2 style="text-align: center"><?php echo $section_title;?></h2>
    <div class=" divider divider-border">
    </div>
    <?php endif;?>
    <div id="" class=" row">
      <div class=" col-md-2_5" id="">
        <div class=" divider divider-border">
        </div>
        <?php if($image !=''):?>
        <div class="<?php echo $alchem_home_animation;?>" data-animationduration="1.2" data-animationtype="fadeInDown" data-imageanimation="no">
        <img src="<?php echo $image;?>" alt=''><br>
        </div>
        <?php endif;?>
      </div>
      
      <div class=" col-md-3_5" id="">
      <?php 
	  
	  for( $j=0;$j<6;$j++):
	                                            
	  $feature_icon    =  esc_attr(alchem_option('section_4_feature_icon_'.$j));
	  $feature_icon    =  str_replace('fa-','',$feature_icon );
	  $feature_image   =  esc_attr(alchem_option('section_4_feature_image_'.$j));
	  $feature_title   =  esc_attr(alchem_option('section_4_feature_title_'.$j));
	  $feature_content =  wp_kses(alchem_option('section_4_feature_content_'.$j), $allowedposttags);
	  $link            =  esc_url(alchem_option('section_4_link_'.$j));
	  $target          =  esc_attr(alchem_option('section_4_target_'.$j));
	  if( $feature_icon !='' || $feature_image !='' || $feature_title!='' || $feature_content!='' ):
	  if( $link == "" )
	  $title = '<h3>'.$feature_title.'</h3>';
	  else
	  $title = '<a href="'.$link.'" target="'.$target.'"><h3>'.$feature_title.'</h3></a>';
	  
	  $icon            = '';
	  if( $feature_image !='' )
	  $icon  = '<img class="feature-box-icon"  src="'.$feature_image.'" alt="" />';
	  else
	  $icon  = '<i class="feature-box-icon fa fa-'.$feature_icon.' fa-fw"></i>';
	  
	  
	  ?>
      <div class="<?php echo $alchem_home_animation;?>" data-animationduration="1.2" data-animationtype="fadeInRight" data-imageanimation="no">
        <div class="magee-feature-box style2" data-os-animation="fadeOut" style="padding-left: 65px;">
          <div class="icon-box icon-circle" style="border-width: 0;background-color: #333;color: #fff;font-size: 20px;"> <?php echo $icon;?></div>
          <?php echo $title;?>
          <div class="feature-content">
            <p><?php echo do_shortcode($feature_content);?></p>
            <a href="<?php echo $link;?>" target="<?php echo $target;?>" class="feature-link"></a></div>
        </div>
        </div>
        <?php endif;?>
        <?php endfor;?>
      </div>
    </div>
    
    <?php else:?>
 <?php echo do_shortcode($section_content);?>
 <?php endif;?>
 </div>
  </div>
</section>
<?php endif;?>