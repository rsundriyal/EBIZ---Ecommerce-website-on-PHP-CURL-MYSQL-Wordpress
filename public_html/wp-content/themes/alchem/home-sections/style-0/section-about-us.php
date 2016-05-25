<?php 
// section ahout us
   global $allowedposttags;
   $section_hide    = absint(alchem_option('section_5_hide',0));
   $section_id      = esc_attr(sanitize_title(alchem_option('section_5_id')));
   $section_color   = esc_attr(alchem_option('section_5_color'));
   $section_title   = wp_kses(alchem_option('section_5_title'), $allowedposttags);
   $sub_title       = wp_kses(alchem_option('section_5_sub_title'), $allowedposttags);
   $section_content = wp_kses(alchem_option('section_5_content'), $allowedposttags);
   $section_content = str_replace('\\\'','\'',$section_content);
   $section_content = str_replace('\\"','"',$section_content);

 ?> 
 <?php if( $section_hide != '1' ):?>
 <section class="section magee-section alchem-home-section-5 parallax-scrolling alchem-home-style-0" id="<?php echo $section_id;?>">
 <div class="section-content" style="color:<?php echo $section_color;?>;">
 <div class="container">
 <?php if( $section_title != '' ):?>
    <h2 style="text-align: center"><?php echo $section_title;?></h2>
    <div class=" divider divider-border center" id="" style="margin-top: 30px;margin-bottom:50px;width:80px;">
      <div class="divider-inner primary" style="border-bottom-width:3px; "></div>
    </div>
    <?php endif;?>
 <?php echo do_shortcode($section_content);?>
  </div>
  </div>
</section>
 <?php endif;?>   