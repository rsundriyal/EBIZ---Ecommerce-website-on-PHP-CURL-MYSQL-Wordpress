<?php
class Magee_Vimeo {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_vimeo', array( $this,'render' ) );
	
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
		 $sid = '';
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
		        if($link !== ''){
				preg_match( '/[0-9]+/',$link,$match);
				$sid = $match[0];
				}
				$out = "<div id=\"vimeo\" class=\"vimeo-video " .$position . "\">";
				if ($mute == 1) {
					wp_enqueue_script( 'jquery-froogaloop', 'https://f.vimeocdn.com/js/froogaloop2.min.js',
						array( 'jquery' ),
						null, // No version of the jQuery froogaloop2 Plugin.
						true 
					);
				}
				preg_match('/https/',$link,$link_match);
				
				if( $width == '100%' || $height == '100%' && $width == '' || $height == ''):
				if(implode($link_match) == ''){$out .= "<iframe id=\"player_" .$sid  ."\" class=\"" .$class ."\"  src=\"http://player.vimeo.com/video/" .$sid ."?api=1&player_id=player_" .$sid ."&title=0&amp;amp;byline=0&amp;amp;portrait=0&amp;amp;color=d01e2f&amp;amp;&loop=" .$loop. "&controls=" .$controls. "&autoplay=" .$autoplay. "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>" ;
				}else{
				$out .= "<iframe id=\"player_" .$sid  ."\" class=\"" .$class ."\"  src=\"https://player.vimeo.com/video/" .$sid ."?api=1&player_id=player_" .$sid ."&title=0&amp;amp;byline=0&amp;amp;portrait=0&amp;amp;color=d01e2f&amp;amp;&loop=" .$loop. "&controls=" .$controls. "&autoplay=" .$autoplay. "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";}
				$out .= '</div>';
				$out .= '<script>';
				if ($mute == 1){
				$out .= 'jQuery(function($) {
					if(jQuery("#magee-sc-form-preview").length>0){
					var vimeo_iframe = $("#magee-sc-form-preview").contents().find("#player_' .$sid .'")[0];
					var Froogaloop=function(){function e(a){return new e.fn.init(a)}function g(a,c,b){if(!b.contentWindow.postMessage)return!1;a=JSON.stringify({method:a,value:c});b.contentWindow.postMessage(a,h)}function l(a){var c,b;try{c=JSON.parse(a.data),b=c.event||c.method}catch(e){}"ready"!=b||k||(k=!0);if(!/^https?:\/\/player.vimeo.com/.test(a.origin))return!1;"*"===h&&(h=a.origin);a=c.value;var m=c.data,f=""===f?null:c.player_id;c=f?d[f][b]:d[b];b=[];if(!c)return!1;void 0!==a&&b.push(a);m&&b.push(m);f&&b.push(f);
return 0<b.length?c.apply(null,b):c.call()}function n(a,c,b){b?(d[b]||(d[b]={}),d[b][a]=c):d[a]=c}var d={},k=!1,h="*";e.fn=e.prototype={element:null,init:function(a){"string"===typeof a&&(a=document.getElementById(a));this.element=a;return this},api:function(a,c){if(!this.element||!a)return!1;var b=this.element,d=""!==b.id?b.id:null,e=c&&c.constructor&&c.call&&c.apply?null:c,f=c&&c.constructor&&c.call&&c.apply?c:null;f&&n(a,f,d);g(a,e,b);return this},addEvent:function(a,c){if(!this.element)return!1;
var b=this.element,d=""!==b.id?b.id:null;n(a,c,d);"ready"!=a?g("addEventListener",a,b):"ready"==a&&k&&c.call(null,d);return this},removeEvent:function(a){if(!this.element)return!1;var c=this.element,b=""!==c.id?c.id:null;a:{if(b&&d[b]){if(!d[b][a]){b=!1;break a}d[b][a]=null}else{if(!d[a]){b=!1;break a}d[a]=null}b=!0}"ready"!=a&&b&&g("removeEventListener",a,c)}};e.fn.init.prototype=e.fn;window.addEventListener?window.addEventListener("message",l,!1):window.attachEvent("onmessage",l);return window.Froogaloop=
window.$f=e}();
					var player = $f(vimeo_iframe);
					player.addEvent(\'ready\', function() {
					player.api(\'setVolume\', 0);
					});
					
					}else{
						var vimeo_iframe = $(\'#player_' .$sid .'\')[0];
						var player = $f(vimeo_iframe);
						player.addEvent(\'ready\', function() {
						player.api(\'setVolume\', 0);
						});
					
					}
					
					});';
				}	
				$out .= 'jQuery(function($) {
						if(jQuery("#magee-sc-form-preview").length>0){
						divwidth = $("#magee-sc-form-preview").contents().find("#vimeo").width();
						width = $("#magee-sc-form-preview").contents().find("#player_'.$sid.'").width();
						height = $("#magee-sc-form-preview").contents().find("#player_'.$sid.'").height();
						op = height/width;
						$("#magee-sc-form-preview").contents().find("#player_'.$sid.'").width(divwidth-100);
						$("#magee-sc-form-preview").contents().find("#player_'.$sid.'").height(op*divwidth-100);
						}else{
							divwidth = $("#vimeo").width();
							width = $("#player_'.$sid.'").width();
							height = $("#player_'.$sid.'").height();
							op = height/width;
							$("#player_'.$sid.'").width(divwidth);
							$("#player_'.$sid.'").height(op*divwidth);
							}
						});			        											
					    </script>'; 
							
				else:
				if(implode($link_match) == ''){
				$out .= "<iframe id=\"player_" .$sid  ."\" class=\"" .$class ."\" width=\"" .$width ."\" height=\"" .$height ."\" src=\"http://player.vimeo.com/video/" .$sid ."?api=1&player_id=player_" .$sid ."&title=0&amp;amp;byline=0&amp;amp;portrait=0&amp;amp;color=d01e2f&amp;amp;&loop=" .$loop. "&controls=" .$controls. "&autoplay=" .$autoplay. "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";}else{
				$out .= "<iframe id=\"player_" .$sid  ."\" class=\"" .$class ."\" width=\"" .$width ."\" height=\"" .$height ."\" src=\"https://player.vimeo.com/video/" .$sid ."?api=1&player_id=player_" .$sid ."&title=0&amp;amp;byline=0&amp;amp;portrait=0&amp;amp;color=d01e2f&amp;amp;&loop=" .$loop. "&controls=" .$controls. "&autoplay=" .$autoplay. "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>";
				}
				
				if ($mute == 1)
				{
					$out .= '<script>';
					$out .= 'jQuery(function($) {
					if(jQuery("#magee-sc-form-preview").length>0){
					var vimeo_iframe = $("#magee-sc-form-preview").contents().find(\'#player_' .$sid .'\')[0];
					var Froogaloop=function(){function e(a){return new e.fn.init(a)}function g(a,c,b){if(!b.contentWindow.postMessage)return!1;a=JSON.stringify({method:a,value:c});b.contentWindow.postMessage(a,h)}function l(a){var c,b;try{c=JSON.parse(a.data),b=c.event||c.method}catch(e){}"ready"!=b||k||(k=!0);if(!/^https?:\/\/player.vimeo.com/.test(a.origin))return!1;"*"===h&&(h=a.origin);a=c.value;var m=c.data,f=""===f?null:c.player_id;c=f?d[f][b]:d[b];b=[];if(!c)return!1;void 0!==a&&b.push(a);m&&b.push(m);f&&b.push(f);
return 0<b.length?c.apply(null,b):c.call()}function n(a,c,b){b?(d[b]||(d[b]={}),d[b][a]=c):d[a]=c}var d={},k=!1,h="*";e.fn=e.prototype={element:null,init:function(a){"string"===typeof a&&(a=document.getElementById(a));this.element=a;return this},api:function(a,c){if(!this.element||!a)return!1;var b=this.element,d=""!==b.id?b.id:null,e=c&&c.constructor&&c.call&&c.apply?null:c,f=c&&c.constructor&&c.call&&c.apply?c:null;f&&n(a,f,d);g(a,e,b);return this},addEvent:function(a,c){if(!this.element)return!1;
var b=this.element,d=""!==b.id?b.id:null;n(a,c,d);"ready"!=a?g("addEventListener",a,b):"ready"==a&&k&&c.call(null,d);return this},removeEvent:function(a){if(!this.element)return!1;var c=this.element,b=""!==c.id?c.id:null;a:{if(b&&d[b]){if(!d[b][a]){b=!1;break a}d[b][a]=null}else{if(!d[a]){b=!1;break a}d[a]=null}b=!0}"ready"!=a&&b&&g("removeEventListener",a,c)}};e.fn.init.prototype=e.fn;window.addEventListener?window.addEventListener("message",l,!1):window.attachEvent("onmessage",l);return window.Froogaloop=
window.$f=e}();
					var player = $f(vimeo_iframe);
					player.addEvent(\'ready\', function() {
					player.api(\'setVolume\', 0);
					});
					}else{
						var vimeo_iframe = $(\'#player_' .$sid .'\')[0];
						var player = $f(vimeo_iframe);
						player.addEvent(\'ready\', function() {
						player.api(\'setVolume\', 0);
						});
					
					}
					});';
					$out .= '</script>';
				}
				$out .= '</div>';
				endif;
				return $out;
		
		 	 
	 } 
	 
}

new Magee_Vimeo();