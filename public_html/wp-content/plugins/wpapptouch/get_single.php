<?php
require( $_SERVER['DOCUMENT_ROOT'].'/wp-load.php' ); // TESTING PAGE DIRECTLY

//$post_id = intval($_GET['id']);
$post_id = $_GET['id'];

	//If is not numeric get the id from url
	if (!is_numeric($post_id)) {
        $post_id = url_to_postid( $post_id );
    }

$post = get_post($post_id);
// $the_post = get_page($my_id); // Get page content
	
	// get Next & previous post ID
	$prev_post = get_previous_post(true);
	$next_post = get_next_post(true); // get_next_post( $in_same_cat, $excluded_categories ) //true or false - excluded empty
	//END get Next & previous post ID

$posts = array();

$posts[] = array(
	'category' => post_cat(get_the_category($post->ID)),
    'id' => $post->ID,
    'title' => $post->post_title,
		//'excerpt' => wpautop($the_post->post_excerpt),
    'content' => y_video(wpautop($post->post_content)),
	'fimg' => featured_img($post->ID),
    'permalink' => $tposthe_post->guid,
    'date' => str_replace("-", "/", substr($post->post_date, 0, 11)),
    'author_id' => $post->post_author,
    'author' => get_userdata($post->post_author)->display_name,
	'medias' => get_medias($post->post_content,$post->ID),
	'nbcomments' => get_comments_number($post->ID),
	'prev_post' => $prev_post->ID,
	'next_post' => $next_post->ID
	//'next_post' => the_next_post($the_post->ID)
	//'next_post' => get_adjacent_post(false,'',false) //False = in category, empty no exclude, False = next or true = previous
);

echo(json_encode(array('posts' => $posts)));
//echo $_GET['jsoncallback'].'('.json_encode(array('posts' => $posts)).')';

function featured_img($id){						
	
	$thumb = get_post_meta($id,'_thumbnail_id',false);
    $thumb = wp_get_attachment_image_src($thumb[0], false);
    $thumb = $thumb[0];
	
	if($thumb){ 
	$fimg = '<img src="'.$thumb.'" />';
	return $fimg;
	}	
}

function get_medias($content,$postID) {

	$audio_att = media_attachments('audio',$postID); // check if audio attachments
	$video_att = media_attachments('video',$postID); // check if video attachments

	// Check if audio in post, attachment, audio link ect...
	if($audio_att){ 
	$medias = '<audio controls="controls" preload="none"><source src="'.$audio_att.'" type="audio/mpeg">Your browser does not support the audio tag.</audio>';
	}else{ 
		if (preg_match('!(http(s)?:\/\/[^"].*?\.(mp3|aiff|m4a|wav|aac|3gp|ogg))!Ui', $content, $match)) { // Audio
		$media = $match[0];
		$medias = '<audio controls="controls" preload="none"><source src="'.$media.'" type="audio/mpeg">Your browser does not support the audio tag.</audio>';
		}
	}
		
	// Check if audio in post, attachment, audio link ect...
	$poster = 'http://www.podzic.com/wp-content/uploads/2011/12/musicpic.jpg'; // Poster temporaire
	if($video_att){ 
	$medias = '<video poster="'.$poster.'" controls="controls" preload="none"><source src="'.$video_att.'" />Your browser does not support the audio tag.</video>';
	}else{ 
		if (preg_match('!(http(s)?:\/\/[^"].*?\.(mp4|mov|mpeg|webm|m4a|m4v))!Ui', $content, $match)) { // Video
		$mediav = $match[0];
		$medias = '<video poster="'.$poster.'" controls="controls" preload="none"><source src="'.$mediav.'" />Your browser does not support the audio tag.</video>';							
		}
	}
	
	preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $content, $matches); // Youtube video
		if(isset($matches[2]) && $matches[2] != ''){
     	$y_id = $matches[2];
		$medias = '<div class="videoWrapper"><iframe src="http://www.youtube.com/embed/'.$y_id.'" frameborder="0" allowfullscreen></iframe></div>';
		}  
		
	return $medias;	
}

function media_attachments($type,$postID)
{					
	$args = array(
	'numberposts' => 1,
	'order'=> 'ASC',
	'orderby' => 'ID',
	//'mime_type' => 'audio/mpeg',
	'post_mime_type' => $type,
	'post_parent' => $postID,
	'post_status' => null,
	'post_type' => 'attachment'
	);
	
	$attachments = get_children( $args );
	
	//print_r($attachments);
	
	if ($attachments) {
		foreach( $attachments as $file ) {
			$attachmenturl=wp_get_attachment_url($file->ID);
			return $attachmenturl;
		}
	} else {
		$attachmenturl = '';
		return $attachmenturl;
	}
	
}

function post_cat($category)
{					
	$firstCategory = $category[0]->cat_name;

		if ($firstCategory) {
	return $firstCategory;
	} else {
		return $attachmenturl;
	}
	
}

function y_video($text)
{					
	$text = bracket($text);
	
	if (preg_match('#(<(object)(.+?)</object>)#is',$text,$found)) {        
		$embedcode = $found[1];
	}

	if (preg_match('#<object[^>]+>.+?http://www.youtube.com/v/([A-Za-z0-9\-_]+).+?</object>#s', $text, $matches)) { 
		$yb_id =  $matches[1];
		$iframe = '<div id="videoWrapper"><iframe id="video" width="500" height="300" src="http://www.youtube.com/embed/'.$yb_id.'" frameborder="0" allowfullscreen></iframe></div>';
		$text = str_replace($embedcode, $iframe, $text);
		return $text;
	} else {
    	return $text;
	}
	
}

function bracket($text) {					
	$text = preg_replace('#(\[(.+?)\])#is','',$text);  
    return $text;	
}
 ?>