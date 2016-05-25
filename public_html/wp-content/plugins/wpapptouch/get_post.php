<?php
require( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' ); // TESTING PAGE DIRECTLY
//require('http://www.podzic.com/wp-includes/functions.php');
//require_once(ABSPATH . '/wp-load.php');  

//$my_id = intval($_GET['id']);
$my_id = $_GET['id'];
$my_id = trim($my_id);

$s = $_GET['s']; //search
$s = trim($s);


$posts = array();

$numberposts = 10;
$offset = (intval($_GET['page']) - 1) * $numberposts;

$num_posts = wp_count_posts('post');

$num_pages = intval($num_posts->publish / $numberposts);
if ($num_posts->publish % $numberposts != 0) {
    $num_pages++;
}

if ($page <= $num_pages) {

    $args = array( 'numberposts' => $numberposts, 'offset'=> $offset );

 	if (!empty($s)) {	
	$myposts = new WP_Query('s='.$s.'&posts_per_page=10');
	}else{
  

	if (!empty($my_id)) {
	
		if (is_numeric ($my_id)) {
			
		  	$myposts = new WP_Query( 'cat='.$my_id.'&posts_per_page=10' ); 
			//echo 'Numeric: '; 
			//echo $my_id; 
		}else{
			$myposts = new WP_Query( 'post_type=page&posts_per_page=10' );
			//echo 'text: '; 
			//echo $my_id;  
    	}
	}else{
	$myposts = new WP_Query('orderby=date&posts_per_page=10');
	//echo 'is empty'; 
    }
}
	
    //foreach( $myposts as $post ) : setup_postdata($post);
	while ( $myposts->have_posts() ) : $myposts->the_post();
        $posts[] = array(
            'id' => $post->ID,
            //'title' => $post->post_title,
			//'title' => trunkString(ucwords(strtolower($post->post_title)), 55), // Trunk title
			//'title' => trunkString($post->post_title, 55), // Trunk title
			'title' => ucwords(strtolower($post->post_title)), // Trunk title
            'permalink' => $post->guid,
            'date' => str_replace("-", "/", substr($post->post_date, 0, 11)),
            'author_id' => $post->post_author,
            'author' => get_userdata($post->post_author)->display_name,
			//'get_thumb' => '<img width="80" height="80" src="http://www.allotoi.com/wp-content/uploads/matt-leinart-80x80.jpg" class="attachment-thumbnail wp-post-image" alt="matt-leinart" title="matt-leinart">',
			//'get_thumb' =>  $post->get_post_image,
			//'get_thumb' =>  get_the_post_thumbnail(),
			'get_thumb' => get_img($post->ID,$post->post_content), 
			//'excerpt' => $post->post_excerpt,
			
			//'excerpt' => trunkString($post->post_excerpt, 65) // Trunk title
			'excerpt' => wp_content($post->post_excerpt,$post->post_content) // Trunk title
			//'content' => wpautop($post->post_content, '<!--more-->', true)
            //'content' => wpautop(strstr($post->post_content, '<!--more-->', true)) // broken
        );
    endwhile;
	
	// Reset Query
	//wp_reset_query();

    echo(json_encode(array('posts' => $posts))); //ORI
	//echo $_GET['jsoncallback']."(".json_encode(array('posts' => $posts)).")";
	//echo $_GET['jsoncallback'].'('.json_encode(array('posts' => $posts)).')';
}

function get_img($postid, $content) { 
	
	$first_img = '';
	
	if ($first_img == '') {

	$thumb_id = get_post_meta($postid,'_thumbnail_id',false);
    $thumb1 = wp_get_attachment_image_src($thumb_id[0],'wp_small'); //default: thumbnail
	$thumb = $thumb1[0];
	
		if ($thumb == null) {
		$thumb2 = wp_get_attachment_image_src($thumb_id[0],'thumbnail'); //default: thumbnail
		$thumb = $thumb2[0];
		}
		$first_img = '<img src="'.$thumb.'" alt="default" title="default">';
	}
		
	if(empty($thumb)){ // look for image in post
		$first_img = '';
		$content = htmlspecialchars_decode($content);
		if (preg_match('(<img.+src="(.*)".*>)Uims', $content, $matches)) {
		$first_img = $matches[0];
		}
	}
		
		//$first_img = the_post_thumbnail();

		if(empty($first_img)){ //Defines a default image
 			//$img_dir = get_bloginfo('template_directory');
    	$first_img = '<img src="'.get_bloginfo("url").'/wp-content/plugins/wpapptouch/img/default.png'.'" alt="default" title="default">';
  		}

  return $first_img;	
}

function trunkString($str, $max) {
   	if(strlen($str) > $max)
      	{
      		// On la raccourci
      		$str = substr($str, 0, $max);
      		$last_space = strrpos($str, " ");
      		
			// Et on ajouter les ... à la fin de la chaine
      		$str = substr($str, 0, $last_space)."...";

      		return $str;
      	}
      	else
      	{
      		return $str;
      	}

}

function wp_content($excerpt,$content) {
	
	if (empty($excerpt)) {
   		$new_content = strip_tags($content);
	} else {
		$new_content = $excerpt;
	}
	$new_content = trunkString($new_content, 80);
	
	$new_content = bracket($new_content);
	
	return $new_content;
}

function bracket($text) {					
	$text = preg_replace('#(\[(.+?)\])#is','',$text);  
    return $text;	
}
?>