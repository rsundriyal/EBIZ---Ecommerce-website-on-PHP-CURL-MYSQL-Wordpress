<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package alchem
 */

if ( ! function_exists( 'alchem_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function alchem_paging_nav($echo='echo',$wp_query='') {
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

	$pagination = array(
	'base' => @add_query_arg('paged','%#%'),
	'format'             => '?page=%#%',
	'total'              => $wp_query->max_num_pages,
	'current'            => $current,
	'show_all'           => false,
	'end_size'           => 1,
	'mid_size'           => 2,
	'prev_next'          => true,
	'prev_text'          => __(' Prev', 'alchem'),
	'next_text'          => __('Next ', 'alchem'),
	'type'               => 'list',
	'add_args'           => false,
	'add_fragment'       => '',
	'before_page_number' => '',
	'after_page_number'  => ''
);
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
		
	if( $wp_query->max_num_pages > 1 ){
    if($echo == "echo"){
    echo '<nav class="post-pagination post-list-pagination" role="navigation">
                                    <div class="post-pagination-decoration"></div>
                                    '.paginate_links($pagination).'</nav>'; 
	}else
	{
	
	return '<nav class="post-pagination post-list-pagination" role="navigation">
                                    <div class="post-pagination-decoration"></div>'.paginate_links($pagination).'</nav>';
	}
	
	}
}
endif;

if ( ! function_exists( 'alchem_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function alchem_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
    <nav class="post-pagination" role="navigation">
                                        <div class="post-pagination-decoration"></div>
                                        <ul class="text-center">
                                        <?php
											previous_post_link( '<li class="nav-previous">%link</li>', __( 'Last', 'alchem' ) );
											next_post_link(     '<li class="nav-next">%link</li>',     __( 'Next', 'alchem' ) );
										?>
                                        </ul>
                                    </nav>  
                                    
	<!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'alchem_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function alchem_posted_on( $echo = true ) {
	$return = '';
	$display_post_meta = alchem_option('display_post_meta','yes');
		
	if( $display_post_meta == 'yes' ){
		
	  $display_meta_author     = alchem_option('display_meta_author','yes');
	  $display_meta_date       = alchem_option('display_meta_date','yes');
	  $display_meta_categories = alchem_option('display_meta_categories','yes');
	  $display_meta_comments   = alchem_option('display_meta_comments','yes');
	  $display_meta_readmore   = alchem_option('display_meta_readmore','yes');
	  $display_meta_tags       = alchem_option('display_meta_tags','yes');
	  $date_format             = alchem_option('date_format','M d, Y');
	
		
	   $return .=  '<ul class="entry-meta">';
	  if( $display_meta_date == 'yes' )
		$return .=  '<li class="entry-date"><i class="fa fa-calendar"></i>'. get_the_date( $date_format ).'</li>';
	  if( $display_meta_author == 'yes' )
		$return .=  '<li class="entry-author"><i class="fa fa-user"></i>'.get_the_author_link().'</li>';
	  if( $display_meta_categories == 'yes' )		
		$return .=  '<li class="entry-catagory"><i class="fa fa-file-o"></i>'.get_the_category_list(', ').'</li>';
	  if( $display_meta_comments == 'yes' )	
		$return .=  '<li class="entry-comments pull-right">'.alchem_get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'alchem'), __( '<i class="fa fa-comment"></i> % ', 'alchem'), 'read-comments', '').'</li>';
        $return .=  '</ul>';
	}
    if( $echo == true )
	echo $return;
	else
	return $return;

}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function alchem_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'alchem_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'alchem_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so alchem_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so alchem_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in alchem_categorized_blog.
 */
 function alchem_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'alchem_categories' );
}
add_action( 'edit_category', 'alchem_category_transient_flusher' );
add_action( 'save_post',     'alchem_category_transient_flusher' );



// Custom comments list
   
function alchem_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   $date_format        = alchem_option('date_format','M d, Y');
   ?>
   
   
   <li <?php comment_class("comment media-comment"); ?> id="comment-<?php comment_ID() ;?>">
                                                <div class="media-avatar media-left">
                                                   <?php echo get_avatar($comment,'70','' ); ?>
                                                </div>
                                                <div class="media-body">
                                                    <div class="media-inner">
                                                        <h4 class="media-heading clearfix">
                                                           <?php echo get_comment_author_link();?> - <?php comment_date( $date_format ); ?> <?php edit_comment_link(__('(Edit)','alchem'),'  ','') ;?>
                                                           <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
                                                        </h4>
                                                        
                                                        <?php if ($comment->comment_approved == '0') : ?>
                                                                 <em><?php _e('Your comment is awaiting moderation.','alchem') ;?></em>
                                                                 <br />
                                                              <?php endif; ?>
                                                              
                                                        <div class="comment-content"><?php comment_text() ;?></div>
                                                    </div>
                                                </div>
                                            </li>
                                            
                                            

<?php
        }

function alchem_allow_data_event_content() {
global $allowedposttags, $allowedtags;

$allowedposttags["div"]['data-animationduration'] = true;
$allowedtags["div"]['data-animationduration'] = true;

$allowedposttags["div"]['data-animationtype'] = true;
$allowedtags["div"]['data-animationtype'] = true;

$allowedposttags["div"]['data-imageanimation'] = true;
$allowedtags["div"]['data-imageanimation'] = true;
}
add_action( 'init', 'alchem_allow_data_event_content' );