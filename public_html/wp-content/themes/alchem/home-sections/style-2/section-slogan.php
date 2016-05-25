<?php 
  // section slogan 
  
   global $allowedposttags,$alchem_home_animation;
   $section_hide    = absint(alchem_option('section_10_hide',0));
   $content_model   = absint(alchem_option('section_10_model',0));
   $section_id      = esc_attr(sanitize_title(alchem_option('section_10_id')));
   $section_color   = esc_attr(alchem_option('section_10_color'));
   $section_title   = wp_kses(alchem_option('section_10_title'), $allowedposttags);
   $section_content = wp_kses(alchem_option('section_10_content'), $allowedposttags);
   $button_text     = esc_attr(alchem_option('section_10_button_text'));
   $button_link     = esc_attr(alchem_option('section_10_button_link'));
   $button_target   = esc_attr(alchem_option('section_10_button_target'),'_blank');
   $section_content = str_replace('\\\'','\'',$section_content);
   $section_content = str_replace('\\"','"',$section_content);
 ?> 
 <?php if( $section_hide != '1' ):?> 
 <section class="section magee-section parallax-scrolling alchem-home-section-10 alchem-home-style-2" id="<?php echo $section_id;?>">
  <div class="section-content" style="color:<?php echo $section_color;?>;">
  <div class="container">
  <?php if( $content_model == 0 ):?>
   <div class="<?php echo $alchem_home_animation;?>" data-animationduration="1.2" data-animationtype="fadeInDown" data-imageanimation="no"> 
    <div class=" row">
<div class="col-md-4_5">
  <h1 class="magee-heading" id=""><span class="heading-inner"> <span style="font-family: 'Playfair Display'; font-size: 24px;"><?php echo $section_title;?></span></span></h1>
</div>
<div class="col-md-1_5">
  <div style="height: 30px;"></div>
  <div style="text-align:left;">
  <?php if( $button_text!='' ):?>
    <a href="<?php echo $button_link;?>" target="<?php echo $button_target;?>" class=" magee-btn-normal btn-rounded btn-md" id=""><?php echo $button_text;?></a>
    <?php endif;?>
    </div>
</div>
    
    </div>
    <?php else:?>
 <?php echo do_shortcode($section_content);?>
 <?php endif;?>
  </div>
  </div>
</section>
<?php endif;?>