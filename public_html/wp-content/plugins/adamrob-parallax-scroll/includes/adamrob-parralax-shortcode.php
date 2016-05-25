<?php

/********************************
** adamrob.co.uk - 2OCT2014
** Parallax Scroll Wordpress Plugin
**
** For Help and Support please visit www.adamrob.co.uk
**
** Shortcode
********************************/
/*
    V0.2 - 7OCT2014 - Added Header Style Parameter
    V0.4 - 31OCT2014 - Added disable on mobile parameters. Added full width option
    V1.0 - 13JAN2015 - Removed parallax.js and now using pure CSS
    v1.1 - 20JAN2015 - Fixed full width issue where more than one parallax used on one post
    V1.4 - 24FEB2015 - Added mobile sizing options
    V2.0 - 15MAR2016 - Added call to background scroll script
    				- Re-Added an option to use parallax.js
    				- Added classes and IDs to divs so users can style content/titles
*/

/***
** SHORTCODE
***/

function register_sc_parallax_scroll( $atts ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'id' => '0',
        ), $atts )
    );

    //**
    //SANITIZE ALL SHORTCODE INPUTS

    //Check for valid ID
    $postid = intval($id);
    if ($postid==0 || !is_int($postid)){ 
        //Return error
        return '<p><strong>Invalid Parallax ID</strong></p>';
    }


    //**
    //SETUP WP QUERY TO RETREIVE POST

    //Set up the arguments for query
    $args = array( 'page_id' => $postid,
                    'post_type' => array( PARALLAX_POSTTYPE ) );
    //Look up the header
    $post = new WP_Query( $args );


    //**
    //RETRIEVE THE POST AND DISPLAY

    //Check post exist
    if ( $post->have_posts() ) {
        while ( $post->have_posts() ) {
            $post->the_post();

            //**
            //CHECK AND SANITIZE POST INPUTS

            // check if the post has a Post Thumbnail assigned to it.
            if ( !has_post_thumbnail() ) { 
                //Error because of no image
                wp_reset_postdata();
                return '<p><strong> No Feature Image Defined!</strong>  Please specify your background image in the featured image meta box on the admin page. For more information please see the help menu from the parallax scroll admin pages.</p>';
            }

            //Get thumbnail url
            $thumb_id = get_post_thumbnail_id();
            $thumb_url_array = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true);
            $thumb_url = $thumb_url_array[0];

            //Get the height
            $pheight = absint(get_post_meta(get_the_id(), 'parallax_meta_height', true));
            //Check the height
            if ($pheight==0 || $pheight<PARALLAX_MINHEIGHT){
                //Set minimum height
                $pheight=PARALLAX_MINHEIGHT;
            }

            //Get v pos
            $vpos = esc_attr(get_post_meta(get_the_id(), 'parallax_meta_vpos', true));
            //Check for value
            if ($vpos == ''){
                $vpos=PARALLAX_DEFVPOS;
            }

            //Get h pos
            $hpos = esc_attr(get_post_meta(get_the_id(), 'parallax_meta_hpos', true));
            //Check for value
            if ($hpos == ''){
                $hpos=PARALLAX_DEFHPOS;
            }

            //Get parallaz image size
            $psize = absint(get_post_meta(get_the_id(), 'parallax_meta_pheight', true));
            $mobpsize = absint(get_post_meta(get_the_id(), 'parallax_meta_pheightmob', true));

            //Get parallax disable options
            $disableParImg=esc_attr(get_post_meta(get_the_id(), 'parallax_meta_DisableParImg', true));
            $disablePar=esc_attr(get_post_meta(get_the_id(), 'parallax_meta_DisableParallax', true));

            //Get style
            $hStyle = esc_html(get_post_meta(get_the_id(), 'parallax_meta_hstyle', true));

            //Get post content
            $theContent=apply_filters('the_content',get_the_content());

            //Get the full width option
            $fullWidthEnable=esc_attr(get_post_meta(get_the_id(), 'parallax_meta_FullWidth', true));

            //Get background scroll speed
            $bgScrollSpeed = absint(get_post_meta(get_the_id(), 'parallax_meta_speed', true));

            //Are we using parallax.js?
            $parallaxJS = esc_attr(get_post_meta(get_the_id(), 'parallax_meta_parallaxjs', true));;


            //Get padding
            $padding=20;

            //**
            //FIRST CHECK IF THE USER WANTS TO ENABLE IT
            if ($disablePar && wp_is_mobile()){
                //On a mobile device and user wants to disable
                //return nothing
                return;
            }

            //Create output placeholder
            $output="";

            //*Create IDs for parralax and container divs
            $parallaxFWStyleClass='';//_'.$postid;
            $containerFWStyleClass='';//_'.$postid;

            //**
            //INCLUDE EXTERNAL SCRIPTS
            wp_enqueue_style('parallax-CSS');

            //Check if full width is enabled
            if ($fullWidthEnable){
            	//include full width java script
            	wp_enqueue_script( 'parallax-script-fullwidth' );

            	//Rename IDs
            	$parallaxFWStyleClass='adamrob_parallax_fullwidth ';
            	$containerFWStyleClass='adamrob_parallax_container_fullwidth ';

                //Send parameters to script
                wp_localize_script('parallax-script-fullwidth', 'parallax_script_options', array(
                    'parallaxdivid' => $parallaxFWStyleClass,
                    'parallaxcontainerid' => $containerFWStyleClass
                ));

        	}

	      	//Check if Scroll Is Enabled
        	$parallaxScrollingClass='';
            if ($bgScrollSpeed>0 && $bgScrollSpeed < 9 && $parallaxJS==false){
            	//include full width java script
            	wp_enqueue_script( 'parallax-script-scroll' );

				$parallaxScrollingClass='adamrob_parallax_scrolling ';

                //Send parameters to script
                wp_localize_script('parallax-script-scroll', 'parallax_script_scroll_options', array(
                    'parallaxcontainerid' => $parallaxScrollingClass
                ));

        	}

        	//Check if we should use parallax.js to achieve effect
        	if ($parallaxJS==true){
        		//Attach script
        		wp_enqueue_script( 'parallax-script' );
        	}


            //Build the style tag for the parallax container
            $parallaxStyle='';
            if ($pheight!==PARALLAX_MINHEIGHT){
                //Use user defined height
                $parallaxStyle='height:'.$pheight.'px;';
            }elseif($pheight!==PARALLAX_MINHEIGHT && $theContent ==""){
                //Define the minimum height if no post content.
                //If there is post content, use min height from css
                $parallaxStyle='height:'.PARALLAX_MINHEIGHT.'px;';
            }

            //Enable parallax image?
            $ParallaxImgStyle='';
            if (!$disableParImg || wp_is_mobile()===FALSE){
                //Only show parallax if not on mobile.
                //or on a mobile and user wants it
                $ParallaxImgStyle='background-image: url('.$thumb_url.');';
            }

            //build style tag for background size
            $ParallaxSizeStyle='background-size: cover;';
            if (wp_is_mobile()==FALSE && $psize>0){
                //if user not on mobile and wants to change the size
                $ParallaxSizeStyle='background-size: '.$psize.'px;';
            }elseif(wp_is_mobile()&&isset($mobpsize)&&$mobpsize==0){
                //User is on mobile and wants to auto size
                //$ParallaxSizeStyle='background-size: 100% 100%;';
                $ParallaxSizeStyle='background-size: cover; background-attachment: scroll;';
            }elseif(wp_is_mobile()&&isset($mobpsize)&&$mobpsize>0){
                //User is on mobile and wants to use a different size
                $ParallaxSizeStyle='background-size: '.$mobpsize.'px;background-repeat: no-repeat; background-attachment: scroll;';
            }

            //Give the entire plugin a container if we are full width
            if ($fullWidthEnable){
                //Enables us to pad out when in full screen mode
                $output .= '<div id="parallax_container'.$postid.'" class="parallax-window-container '.$containerFWStyleClass.'">';
            };
            
            //Build the parallax container
            if ($parallaxJS==true){
            	//Use parallax.JS

            	//Check if we are full width
            	$parallaxJSpos = "";
            	if ($parallaxFWStyleClass==""){
            		$parallaxJSpos = " position: relative;";
            	}
            	if ($bgScrollSpeed>=10) $bgScrollSpeed = 9;
            	$output .= '<div id="parallax_'.$postid.'" class="adamrob_parallax '.$parallaxFWStyleClass.'" 
            					style="'.$parallaxStyle.$parallaxJSpos.'" 
            					data-parallax="scroll" data-image-src="'.$thumb_url.'" 
            					data-z-Index="1" 
            					data-ios-fix="true" 
            					data-android-fix="true"
            					data-speed="'.((10-$bgScrollSpeed)*0.1).'">';

            }else{
            	//use CSS Only Parallax
	            if(wp_is_mobile()&&isset($mobpsize)){
	                //Display static image
	                $output .= '<section id="parallax_'.$postid.'" class="'.$parallaxFWStyleClass.'" style="'.$parallaxStyle.$ParallaxImgStyle.$ParallaxSizeStyle.'">';
	            }else{
	                //display parallax image
	                $output .= '<section id="parallax_'.$postid.'" class="adamrob_parallax '.$parallaxFWStyleClass.$parallaxScrollingClass.'" style="'.$parallaxStyle.$ParallaxImgStyle.$ParallaxSizeStyle.'" speed="'.$bgScrollSpeed.'">';
	            }
        	}
            


            $output .= '<div id="parallax_'.$postid.'_content" class="adamrob_pcontainer" style="'.$parallaxStyle.'">';

            //Build the content if applicable
            if ($theContent==""){
                //Build the title
                $output .= '<table style="width:100%; height:100%; border-style:none; margin:0;"><tr>';
                $output .= '<td class="parallax-header" style="text-align:'.$hpos.'; vertical-align:'.$vpos.'; padding:'.$padding.'px; border-style:none;">';
                $output .= '<div id="parallax_'.$postid.'_posttitle" class="adamrob_parallax_posttitle" style="'.$hStyle.'">' . get_the_title() . '</div>';
                $output .= '</td></tr></table>';

            }else{
                //Build the title
                $output = $output . '<div id="parallax_'.$postid.'_posttitle" class="adamrob_parallax_posttitle" style="text-align:'.$hpos.'; padding:'.$padding.'px;">';
                $output = $output . '<div style="'.$hStyle.'">' . get_the_title() . '</div>';
                $output = $output . '</div>';

                //Build the content
                $output = $output . '<div id="parallax_'.$postid.'_postcontent" class="adamrob_parallax_postcontent" id="'.get_the_id().'_parallax_content_post" style="padding:'.$padding.'px;">';
                $output = $output . $theContent;
                $output = $output . '</div>';
            }

            //If we are full width close the container
            if ($fullWidthEnable){
                $output .= '</div>';
            }

            $output .= '</div>';
            if ($parallaxJS==true){
				$output .= '</div>';
            }else{
            	$output .= '</section>';
            }

        }
        //Reset query data
        wp_reset_postdata();
   
    } else {
        // none were found
        wp_reset_postdata();
        return '<p><strong> No Parallax Found! Check ID</strong></p>';
    }

    //Return the result
    return $output;
}

//Add the shortcode trigger
add_shortcode( PARALLAX_SHORTCODE, 'register_sc_parallax_scroll' );




?>