<?php
/*
  Template Name: Front Page
 */
get_header(); 
?>
<div id="alchem-home-sections">
<?php 
global $alchem_homepage_sections,$alchem_home_animation;

$detect = new Mobile_Detect;
$isMobile = 0;
	if( $detect->isMobile() && !$detect->isTablet() ){
		$isMobile = 1;
		}
$home_style            = absint(alchem_option('home_style',0));
$alchem_home_animation = esc_attr(alchem_option('home_animation'));

if( $alchem_home_animation == 'yes' && $isMobile == 0 )
   $alchem_home_animation = 'alchem-animated';
   else
   $alchem_home_animation = '';
foreach(  $alchem_homepage_sections as $k=>$v ){
get_template_part('home-sections/style-'.$home_style.'/section',$k);
}
?> 
</div>
<?php get_footer(); ?>