<?php
/**
 * @package alchem
 */
  $display_image = alchem_option('archive_display_image','yes');
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('entry-box-wrap'); ?>>
  <article class="entry-box">
  <?php if ( $display_image == 'yes' && has_post_thumbnail() ): ?>
      <div class="feature-img-box">
          <div class="img-box figcaption-middle text-center from-top fade-in">
              <a href="<?php the_permalink();?>">
                  	<?php the_post_thumbnail(); ?>
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
      <?php endif; ?>
      <div class="entry-main">
          <div class="entry-header">
          <?php the_title( sprintf( '<a href="%s" rel="bookmark"><h1 class="entry-title">', esc_url( get_permalink() ) ), '</h1></a>' ); ?>
              <?php if ( 'post' == get_post_type() ) : ?>
              <ul class="entry-meta">
                  <?php alchem_posted_on(); ?>
              </ul>
              <?php endif; ?>
          </div>
          <div class="entry-summary"><?php echo alchem_get_summary();?></div>
          <div class="entry-footer">
              <a href="<?php the_permalink();?>" class="btn-normal"><?php _e( 'Read More', 'alchem' );?> &gt;&gt;</a>
          </div>
      </div>
  </article>
</div>