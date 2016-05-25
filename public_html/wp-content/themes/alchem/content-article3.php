<?php  
 $display_image = alchem_option('archive_display_image','yes');
 $col_image   = '';
 $has_post_thumbnail = 0;
 $col_content = 'col-md-12';
  if (  $display_image == 'yes' && has_post_thumbnail() ) :
 $col_image   = 'col-md-4';
 $col_content = 'col-md-8';
 $has_post_thumbnail = 1;
 endif;
		
 ?>
 <div id="post-<?php the_ID(); ?>" <?php post_class("entry-box-wrap"); ?>>
                                        <article class="entry-box row">
                                            <div class="entry-aside <?php echo $col_image ;?>">
                                                 <?php if (  $has_post_thumbnail == 1 ) : ?>
                                            <div class="feature-img-box">
                                                <div class="img-box figcaption-middle text-center from-top fade-in">
                                                    <a href="<?php the_permalink();?>">
                                                        <?php the_post_thumbnail();  ?>
                                                        <div class="img-overlay">
                                                            <div class="img-overlay-container">
                                                                <div class="img-overlay-content">
                                                                    <i class="fa fa-link"></i>
                                                                </div>
                                                            </div>                                                        
                                                        </div>
                                                    </a>
                                                </div>                                                 
                                            </div>
                                            <?php endif;?>
                                            </div>
                                            <div class="entry-main <?php echo $col_content ;?>">
                                                <div class="entry-header">
                                                    <a href="<?php the_permalink();?>"><h1 class="entry-title"><?php the_title();?></h1></a>
                                                   <?php alchem_posted_on();?>
                                                </div>
                                                <div class="entry-summary">
                                                   <?php echo alchem_get_summary();?>
                                                </div>
                                                <div class="entry-footer">
                                                    <a href="<?php the_permalink();?>" class="pull-right"><?php _e('Read More','alchem');?> &gt;&gt;</a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>