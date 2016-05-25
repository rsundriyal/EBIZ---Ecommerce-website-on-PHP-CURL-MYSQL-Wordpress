<?php
  // section testimonials 
  
   global $allowedposttags,$alchem_home_animation;
   $section_hide    = absint(alchem_option('section_7_hide',0));
   $content_model   = absint(alchem_option('section_7_model',0));
   $section_id      = esc_attr(sanitize_title(alchem_option('section_7_id')));
   $section_color   = esc_attr(alchem_option('section_7_color'));
   $section_title   = wp_kses(alchem_option('section_7_title'), $allowedposttags);
   $sub_title       = wp_kses(alchem_option('section_7_sub_title'), $allowedposttags);
   $section_content = wp_kses(alchem_option('section_7_content'), $allowedposttags);
   $columns         = absint(alchem_option('section_7_columns',3));
   $col             = $columns>0?12/$columns:4;
   $section_content = str_replace('\\\'','\'',$section_content);
   $section_content = str_replace('\\"','"',$section_content);
 ?> 
 <?php if( $section_hide != '1' ):?> 
 <section class="section magee-section parallax-scrolling alchem-home-section-7 alchem-home-style-1" id="<?php echo $section_id;?>">
  <div class="section-content" style="color:<?php echo $section_color;?>;">
  <div class="container">
  <?php if( $content_model == 0 ):?>
  <?php if( $section_title != '' ):?>
    <h2 class="section-title"><?php echo $section_title;?></h2>
    <div style="text-align:center;"><?php echo do_shortcode($sub_title);?></div>
    <div style="height: 80px;"></div>
    <?php endif;?>
    <div class="<?php echo $alchem_home_animation;?> " data-animationduration="0.9" data-animationtype="fadeIn" data-imageanimation="no" id="">
    <div class="magee-carousel multi-carousel home-page-testimonial" id="">
                                        <div class="multi-carousel-inner">
                                           <div id="home-page-testimonial" class="owl-carousel owl-theme">
                                           
                                              <?php
	 $testimonial   = '';
	 $testimonials  = '';
	 $animationtype = array('fadeInLeft','fadeInDown','fadeInRight','fadeInLeft','fadeInUp','fadeInRight');
	 for( $j=0; $j<6; $j++ ){
	   
	  $avatar      =  esc_url(alchem_option('section_7_avatar_'.$j));
	  $name        =  esc_attr(alchem_option('section_7_name_'.$j));
	  $byline      =  esc_attr(alchem_option('section_7_byline_'.$j));
	  $description = wp_kses(alchem_option('section_7_desc_'.$j), $allowedposttags);
	  
	  if( $description != '' ):
	  $image = '';
	  if( $avatar != '' )
	  $image = '<img src="'.$avatar.'" style="width:150px; display:inline-block;" class="img-circle">';
	
 $testimonial   .= '<div class="item">
  <div class="row">
    <div class="col-md-10">
      <div style="height: 50px;"></div>
      <div style="font-family: \'Dancing Script\';font-size:18px;text-align:center;">'.do_shortcode($description).'</div>
    </div>
    <div class="col-md-2">
      <div style="height: 20px;"></div>
      <p style="text-align:center;">'.$image.'</p>
      <div style="font-family: \'Playfair Display\';font-size: 18px; font-weight: bold; text-align: center;">'.$name.'</div>
      <div style="text-align: center;">'.$byline.'</div>
    </div>
  </div>
</div>';


	
	   endif;
	 }

	 echo $testimonial;
	  ?>     
                                           
                                           </div>
                                           </div>
                                           
                                           <!-- Controls -->
                                        <div class="multi-carousel-nav style2 nav-bg  nav-rounded">
                                            <a href="javascript:;" class="carousel-prev" role="button" data-slide="prev">
                                                <span class="multi-carousel-nav-prev"></span>
                                            </a>
                                            <a class="carousel-next"  href="javascript:;"  role="button" data-slide="next">
                                                <span class="multi-carousel-nav-next"></span>
                                            </a>
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