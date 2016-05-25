<?php
class Magee_Youtube {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_youtube', array( $this,'render' ) );
	
	}
	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
     function render( $args, $content = '') {
	     
		 $defaults =  Magee_Core::set_shortcode_defaults(
		     
			 array(
			     'type'               =>'',
			     'id'                    =>'',
				 'class'                 =>'',
				 'width'                 =>'',
				 'height'                =>'',
				 'mute'                  =>'',
				 'link'                  =>'',
				 'autoplay'        =>'',
				 'loop'            =>'',    
				 'controls'        =>'',  
				        'position'   => 'left'
			 ),$args
	     );
	    
		 extract( $defaults );
		 self::$args = $defaults;
		 if(is_numeric($width))
			$width = $width.'px';
		 if(is_numeric($height))
			$height = $height.'px'; 
		  if( $autoplay == 'yes'):
		    $autoplay = '1';
		 else:
		    $autoplay = '0';
	     endif;
		 if( $loop == 'yes'):
		    $loop = '1';
		 else:
		    $loop = '0';
	     endif;
		 if( $controls == 'yes'):
		    $controls = '1';
		 else:
		    $controls = '0';
	     endif;
		 if( $mute == 'yes'):
		    $mute = '1';
		 else:	 
		    $mute = '0';
		 endif;
		 $out = '';
		 
//		 $aaa = parse_url($link='https://vimeo.com/channels/staffpicks/153773597');
//		 print_r($aaa);
				$sid = substr($link,32,11);
				if( $width == '100%' || $height == '100%' && $width == '' || $height == ''):
				$out .= "<div id=\"youtube\" class=\"youtube-video " .$position . "\"><iframe id=\"player_".$sid."\" class=\"".$class."\" src=\"//www.youtube.com/embed/" . $sid . "?rel=0&controls=".$controls."&loop=".$loop."&playlist=".$sid."&autoplay=".$autoplay."&enablejsapi=".$mute."\" frameborder=\"0\" allowfullscreen></iframe>";
				
					$out .= "<script>
					if(document.getElementById('magee-sc-form-preview')){
						var tag = document.getElementById('magee-sc-form-preview').contentWindow.document.createElement('script');
						var tag = document.getElementById('magee-sc-form-preview').contentWindow.document.createElement('script');
						tag.src = \"//www.youtube.com/iframe_api\";
						var firstScriptTag = document.getElementById('magee-sc-form-preview').contentWindow.document.getElementsByTagName('script')[0];
						firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
						var player;
						function onYouTubeIframeAPIReady() {
						player = new YT.Player('player_" .$sid ."', {
						events: {
						'onReady': onPlayerReady
						}
						});
						}
						function onPlayerReady(event) {
						player.playVideo();
						event.target.mute();
						}
					}else{
					         var tag = document.createElement('script');
					         var tag = document.createElement('script');
    				         tag.src = \"//www.youtube.com/iframe_api\";
    				         var firstScriptTag = document.getElementsByTagName('script')[0];
    				         firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
					         var player;
					         function onYouTubeIframeAPIReady() {
					         player = new YT.Player('player_" .$sid ."', {
					         events: {
					         'onReady': onPlayerReady
					         }
					         });
					         }
					         function onPlayerReady(event) {
					         player.playVideo();
					         event.target.mute();
					         }
					
					}";
					         
					$out .=  '
					jQuery(function($) {
						if(jQuery("#magee-sc-form-preview").length>0){
						divwidth = $("#magee-sc-form-preview").contents().find("#youtube").width();
						width = $("#magee-sc-form-preview").contents().find("#player_'.$sid.'").width();
						height = $("#magee-sc-form-preview").contents().find("#player_'.$sid.'").height();
						op = height/width;
						$("#magee-sc-form-preview").contents().find("#player_'.$sid.'").width(divwidth-100);
						$("#magee-sc-form-preview").contents().find("#player_'.$sid.'").height(op*divwidth-100);
						}else{
							divwidth = $("#youtube").width();
							width = $("#player_'.$sid.'").width();
							height = $("#player_'.$sid.'").height();
							op = height/width;
							$("#player_'.$sid.'").width(divwidth);
							$("#player_'.$sid.'").height(op*divwidth);
							}
						});		
					
					
					</script>';		
				$out .= "</div>";
     			else:
				$out .= "<div id=\"youtube\" class=\"youtube-video " .$position . "\"><iframe id=\"player_".$sid."\" class=\"".$class."\" width=\"".$width."\" height=\"".$height."\" src=\"//www.youtube.com/embed/" . $sid . "?rel=0&controls=".$controls."&loop=".$loop."&playlist=".$sid."&autoplay=".$autoplay."&enablejsapi=".$mute."\" frameborder=\"0\" allowfullscreen></iframe>";
				
				$out .= "<script>
					if(document.getElementById('magee-sc-form-preview')){
						var tag = document.getElementById('magee-sc-form-preview').contentWindow.document.createElement('script');
						var tag = document.getElementById('magee-sc-form-preview').contentWindow.document.createElement('script');
						tag.src = \"//www.youtube.com/iframe_api\";
						var firstScriptTag = document.getElementById('magee-sc-form-preview').contentWindow.document.getElementsByTagName('script')[0];
						firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
						var player;
						function onYouTubeIframeAPIReady() {
						player = new YT.Player('player_" .$sid ."', {
						events: {
						'onReady': onPlayerReady
						}
						});
						}
						function onPlayerReady(event) {
						player.playVideo();
						event.target.mute();
						}
					}else{
					         var tag = document.createElement('script');
					         var tag = document.createElement('script');
    				         tag.src = \"//www.youtube.com/iframe_api\";
    				         var firstScriptTag = document.getElementsByTagName('script')[0];
    				         firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
					         var player;
					         function onYouTubeIframeAPIReady() {
					         player = new YT.Player('player_" .$sid ."', {
					         events: {
					         'onReady': onPlayerReady
					         }
					         });
					         }
					         function onPlayerReady(event) {
					         player.playVideo();
					         event.target.mute();
					         }
					
					}
					</script>";
				$out .= "</div>"; 
				endif;
				return $out;
		 		

		 
		 	 
	 } 
	 
}

new Magee_Youtube();