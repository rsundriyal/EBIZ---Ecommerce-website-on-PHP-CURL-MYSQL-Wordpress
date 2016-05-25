<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package alchem
 */

get_header(); 
$left_sidebar    = alchem_option('left_sidebar_search');
$right_sidebar   = alchem_option('right_sidebar_search');
$sidebar         = 'none';

if( $left_sidebar )
$sidebar = 'left';
if( $right_sidebar )
$sidebar = 'right';
if( $left_sidebar && $right_sidebar )
$sidebar = 'both';


$layout          = alchem_option('layout','boxed');
$container       = 'container';
if( $layout == 'wide' )
$container  = 'container-fullwidth';
?>
<!--Main Area-->
        <section class="page-title-bar title-left no-subtitle" style="background:;">
            <div class="container">
                <hgroup class="page-title text-light">
                    <h1><?php single_cat_title(__('Currently browsing','alchem')); ?> </h1>
                    <?php if(alchem_option('blog_subtitle')):?>
                    <h3><?php echo esc_attr(alchem_option('blog_subtitle'));?></h3>
                    <?php endif;?>
                </hgroup>
                    
                <div class="clearfix"></div>            
            </div>
        </section>

	   <div class="page-wrap">
            <div class="<?php echo $container;?>">
                <div class="page-inner row <?php echo alchem_get_content_class($sidebar);?>">
                    <div class="col-main">
                        <section class="page-main" role="main" id="content">
                            <div class="page-content">
                                <!--blog list begin-->
                                <div class="blog-list-wrap">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search'); ?>

			<?php endwhile; ?>

			<?php alchem_paging_nav('echo'); ?>

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

<?php get_footer(); ?>