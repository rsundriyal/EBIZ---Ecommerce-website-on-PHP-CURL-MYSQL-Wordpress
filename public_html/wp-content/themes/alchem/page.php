<?php
/**
 * The template for displaying all pages.
 *
 * @package alchem
 */
get_header(); 
global  $alchem_page_meta,$alchem_banner_position,$alchem_banner_type;

$detect  = new Mobile_Detect;
$sidebar ='none';
$enable_page_title_bar     = esc_attr(alchem_option('enable_page_title_bar','yes'));
$page_title_bg_parallax    = esc_attr(alchem_option('page_title_bg_parallax'));
$page_title_align          = esc_attr(alchem_option('page_title_align','left'));
$display_breadcrumb        = esc_attr(alchem_option('display_breadcrumb','yes'));
$breadcrumbs_on_mobile     = esc_attr(alchem_option('breadcrumbs_on_mobile_devices','yes'));
$breadcrumb_menu_prefix    = esc_attr(alchem_option('breadcrumb_menu_prefix',''));
$breadcrumb_menu_separator = esc_attr(alchem_option('breadcrumb_menu_separator','/'));
$sidebar                   = isset($alchem_page_meta['page_layout'])?esc_attr($alchem_page_meta['page_layout']):'none';
$left_sidebar              = esc_attr(alchem_option('left_sidebar_pages',''));
$right_sidebar             = esc_attr(alchem_option('right_sidebar_pages',''));

$display_title_bar         = isset($alchem_page_meta['display_title_bar'])?esc_attr($alchem_page_meta['display_title_bar']):'';
$full_width                = isset($alchem_page_meta['full_width'])?esc_attr($alchem_page_meta['full_width']):'no';

if( $full_width  == 'no' )
 $container = 'container';
else
 $container = 'container-fullwidth';

if( $display_title_bar !='' )
$enable_page_title_bar = $display_title_bar ;

$title_bar_css_class = '';
if($page_title_bg_parallax=="yes")
$title_bar_css_class = 'parallax-scrolling';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php if( $enable_page_title_bar == 'yes' ):?>
<section class="page-title-bar title-<?php echo $page_title_align;?> no-subtitle <?php echo $title_bar_css_class;?>">
            <div class="container">
                <hgroup class="page-title text-light">
                    <h1><?php the_title();?></h1>
                    <!--<h3>This is a subtitle for the page.</h3>-->
                </hgroup>
                <?php if( $display_breadcrumb == 'yes' && !$detect->isMobile()):?>
                <?php alchem_get_breadcrumb(array("before"=>"<div class='breadcrumb-nav text-light'>".$breadcrumb_menu_prefix,"after"=>"</div>","show_browse"=>false,"separator"=>$breadcrumb_menu_separator));?>
                <?php endif;?>
                <?php if( $breadcrumbs_on_mobile == 'yes' && $detect->isMobile()):?>
                <?php alchem_get_breadcrumb(array("before"=>"<div class='breadcrumb-nav text-light'>".$breadcrumb_menu_prefix,"after"=>"</div>","show_browse"=>false,"separator"=>$breadcrumb_menu_separator));?>
                <?php endif;?>
                <div class="clearfix"></div>            
            </div>
        </section>
<?php endif;?>
   
 <div class="post-wrap">
            <div class="<?php echo $container;?>">
                <div class="page-inner row <?php echo alchem_get_content_class($sidebar);?>">
                        <div class="col-main">
             <?php while ( have_posts() ) : the_post(); ?>

			<?php  get_template_part( 'content', 'page' ); ?>

		<?php endwhile; // end of the loop. ?>
                        </div>
                        <?php if( $sidebar == 'left' || $sidebar == 'both'  ): ?>
       <div class="col-aside-left">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                            <?php get_sidebar('pageleft');?>
                            </div>
                        </aside>
                    </div>
            <?php endif; ?>
            <?php if( $sidebar == 'right' || $sidebar == 'both'  ): ?>        
                    <div class="col-aside-right">
                        <div class="widget-area">
                           <?php get_sidebar('pageright');?>
                            </div>
                    </div>
             <?php endif; ?>
                    </div>
                </div>
            </div>
      </article>
<?php get_footer(); ?>