<?php
$sidebar    = alchem_option('blog_archive_sidebar');
$layout     = alchem_option('layout');
$blog_pagination_type = alchem_option('blog_pagination_type');

$infinite_scroll = '';
if( $blog_pagination_type == 'infinite_scroll' )
$infinite_scroll = 'alchem-infinite-scroll';
?>
        <section class="page-title-bar title-left no-subtitle" style="background:;">
            <div class="container">
                <hgroup class="page-title text-light">
                    <h1><?php echo esc_attr(alchem_option('blog_title'));?></h1>
                    <?php if(alchem_option('blog_subtitle')):?>
                    <h3><?php echo esc_attr(alchem_option('blog_subtitle'));?></h3>
                    <?php endif;?>
                </hgroup>
                    
                <div class="clearfix"></div>            
            </div>
        </section>

	   <div class="page-wrap">
            <div class="container">
                <div class="page-inner row <?php echo alchem_get_content_class($sidebar);?>">
                    <div class="col-main">
                        <section class="page-main" role="main" id="content">
                            <div class="page-content" id="<?php echo $infinite_scroll;?>">
                                <!--blog list begin-->
                                <div class="blog-list-wrap">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format()); ?>

			<?php endwhile; ?>
			<?php 
			alchem_paging_nav('echo'); 
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div><!-- #blog-list-wrap -->
	  </div><!-- #page-content -->
       <div class="post-attributes"></div>
    </section><!-- #page-main -->
    </div><!-- #col-main -->
    
    <?php if( $sidebar == 'left' || $sidebar == 'both'  ): ?>
    <div class="col-aside-left">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                            <?php get_sidebar('archiveleft');?>
                            </div>
                        </aside>
                    </div>
            <?php endif; ?>
            <?php if( $sidebar == 'right' || $sidebar == 'both'  ): ?>        
                    <div class="col-aside-right">
                        <div class="widget-area">
                           <?php get_sidebar('archiveright');?>
                            </div>
                    </div>
             <?php endif; ?>
                    <!-- #col-side -->
    </div><!-- #page-inner -->
    </div><!-- #container -->
    </div><!-- #page-wrap -->