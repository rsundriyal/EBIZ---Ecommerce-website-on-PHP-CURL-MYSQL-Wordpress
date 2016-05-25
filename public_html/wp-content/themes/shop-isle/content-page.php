<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package shop-isle
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * @hooked shop_isle_page_content - 20
	 */
	do_action( 'shop_isle_page' );
	?>
</article><!-- #post-## -->
