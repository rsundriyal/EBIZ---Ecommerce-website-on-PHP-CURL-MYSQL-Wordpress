<?php
/**
 * Template Name: Blank Template
 *
 * @package Alchem
 * @since Alchem 1.0
 */
get_header('blank'); 
?>
<article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

  <?php while ( have_posts() ) : the_post(); ?>

			<?php  the_content(); ?>

		<?php endwhile; // end of the loop. ?>
                       
      </article>
<?php get_footer('blank'); ?>