<?php 
// section team
   global $allowedposttags,$alchem_home_animation;
   $section_hide    = absint(alchem_option('section_6_hide',0));
   $content_model   = absint(alchem_option('section_6_model',0));
   $section_id      = esc_attr(sanitize_title(alchem_option('section_6_id')));
   $section_color   = esc_attr(alchem_option('section_6_color'));
   $section_title   = wp_kses(alchem_option('section_6_title'), $allowedposttags);
   $sub_title       = wp_kses(alchem_option('section_6_sub_title'), $allowedposttags);
   $section_content = wp_kses(alchem_option('section_6_content'), $allowedposttags);
   $columns         = absint(alchem_option('section_6_columns',4));
   $col             = $columns>0?12/$columns:3;
   $section_content = str_replace('\\\'','\'',$section_content);
   $section_content = str_replace('\\"','"',$section_content);
 ?> 
 <?php if( $section_hide != '1' ):?>
  <section class="section magee-section alchem-home-section-6 alchem-home-style-2" id="<?php echo $section_id;?>">
  <div class="section-content" style="color:<?php echo $section_color;?>;">
  <div class="container">
  <?php if( $content_model == 0 ):?>
  <?php if( $section_title != '' ):?>
    <h2 class="section-title"><?php echo $section_title;?></h2>
    <div class="section-subtitle"><?php echo do_shortcode($sub_title);?></div>
    <div style="height: 60px;"></div>
    <?php endif;?>   
    
    <?php
	 $team_item = '';
	 $team_str  = '';
	 for( $j=0; $j<8; $j++ ){
	   
	  $avatar      =  esc_url(alchem_option('section_6_avatar_'.$j));
	  $link        =  esc_url(alchem_option('section_6_link_'.$j));
	  $name        =  esc_attr(alchem_option('section_6_name_'.$j));
	  $byline      =  esc_attr(alchem_option('section_6_byline_'.$j));
	  $description = wp_kses(alchem_option('section_6_desc_'.$j), $allowedposttags);
	 
	  
	  if( $avatar != '' ):
      if( $link!='' )
	  $image = '<a href="'.$link.'" target="_blank"><img src="'.$avatar.'" alt="'.$name.'" style="border-radius: 0; display: inline-block;border-style: solid;" />
        <div class="img-overlay primary">
          <div class="img-overlay-container">
            <div class="img-overlay-content"><i class="fa fa-link"></i></div>
          </div>
        </div>
        </a>';
		else
		$image = '<img src="'.$avatar.'">
        <div class="img-overlay primary">
          <div class="img-overlay-container">
            <div class="img-overlay-content"></div>
          </div>
        </div>';
	 $icons = '';
	for( $k=0;$k<4;$k++){
		$icon = str_replace('fa-','',esc_attr(alchem_option('section_6_social_icon_'.$j.'_'.$k)));
		$link = esc_url(alchem_option('section_6_social_link_'.$j.'_'.$k));
		if( $icon != '' ){
		$icons .= '<li><a href="'.$link.'"><i class="fa fa-'.$icon.'"></i></a></li>';
		}
		}
	
	  $team_item .= '<div class="col-md-'.$col.'">
	  <div class="'.$alchem_home_animation.'" data-animationduration="0.9" data-animationtype="fadeInDown" data-imageanimation="no">
						<div class="magee-person-box" id="">
						  <div class="person-img-box">
							<div class="img-box figcaption-middle text-center fade-in">'.$image.'</div>
						  </div>
						  <div class="person-vcard text-center">
							<h3 class="person-name" style="text-transform: uppercase;">'.$name.'</h3>
							<h4 class="person-title" style="text-transform: uppercase;">'.$byline.'</h4>
							<p class="person-desc">'.do_shortcode($description).'</p>
							<ul class="person-social">
							 '.$icons.'
							</ul>
						  </div>
						</div>
						</div>
					  </div>';
	  $m = $j+1;
	  if( $m % $columns == 0 ){
	        $team_str .= '<div class="row">'.$team_item.'</div>';
	        $team_item = '';
	   }
	   endif;
	   
	 }
	 if( $team_item != '' ){
		    $team_str .= '<div class="row">'.$team_item.'</div>';
	      
		   }
		
	 echo $team_str;
	?>
 <?php else:?>
 <?php echo do_shortcode($section_content);?>
 <?php endif;?>
  </div>
  </div>
</section>
<?php endif;?>