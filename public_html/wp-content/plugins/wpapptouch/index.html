<?php 
$plugin_url = get_bloginfo('wpurl') . '/wp-content/plugins/wpapptouch';
$template_url = get_bloginfo("template_url");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<!--<meta name="viewport" content="width=device-width,user-scalable=no" /> -->
<link rel="apple-touch-icon" href="<?php echo $plugin_url ?>/img/iPhoneIcon_Small.png" />
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $plugin_url ;?>/img/iPhoneIcon_Medium.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $plugin_url ;?>/img/iPhoneIcon_Big.png" />

<title><?php echo get_bloginfo( 'name' ) ?></title>

<style type="text/css">  
html, body {
  margin: 0;
  padding: 0;
  	-webkit-user-select:none;
    -webkit-text-size-adjust:none;
}
#page {
  position: absolute;
  width: 100%;
  height: 100%;
}

#jqt ul.edgefullcontent li.blog-content a{
	color: #2E5CA9;
}
</style>

<link rel="stylesheet" href="<?php echo $plugin_url ?>/src/apple.min.css"/>
<link rel="stylesheet" href="<?php echo $plugin_url ?>/src/itabbar.css"/><!--CSS order are important -->
<link rel="stylesheet" href="<?php echo $plugin_url ?>/src/style.min.css"/>

<link rel="stylesheet" href="<?php echo $plugin_url ?>/src/add2home.css">
<script type="text/javascript" src="<?php echo $plugin_url ?>/src/add2home.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $plugin_url ?>/src/iscroll.min.js"></script>
<script type='text/javascript' src='<?php echo $plugin_url ?>/src/zepto.min.0.8.js'></script> 
<script type='text/javascript' src='<?php echo $plugin_url ?>/src/jqtouch.min.js'></script>  

<script type='text/javascript' src='<?php echo $plugin_url ?>/src/jqt.autotitles.min.js'></script>  

<script type='text/javascript' src='<?php echo $plugin_url ?>/src/videoresize.js'></script> 

<script type="text/javascript">
var INDEX_URL = '<?php echo $template_url; ?>/'; // Main url
var PLUGIN_URL = '<?php echo $plugin_url; ?>/'; // Main url
var BLOG_TITLE = '<?php echo get_bloginfo( "name" ) ?>';
var BLOG_DESC = '<?php echo get_bloginfo( "description" ); ?>';

var myScroll;
function loaded() {
	myScroll = new iScroll('wrapper');
}
//window.addEventListener('load', loaded, false);

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
document.addEventListener('DOMContentLoaded', setTimeout(function () { loaded(); }, 1000), false);

//document.addEventListener('DOMContentLoaded', setTimeout(function () { myScroll.refresh(); }, 500), false);
//Faster scrolling
var raw=iScroll.prototype._momentum; 
        iScroll.prototype._momentum= function (dist, time, maxDistUpper, maxDistLower, size){ 
            var ret=raw.apply(this,[ 
                dist, 
                time*1, 
                maxDistUpper, 
                maxDistLower, 
                size 
            ]); 
            return ret; 
        };
</script>


<script type="text/javascript" charset="utf-8">
if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))||(navigator.userAgent.match(/iPad/i))){
	var jQT = new $.jQTouch({
   		//cacheGetRequests: false,
    	icon: '<?php echo $plugin_url ?>/img/iPhoneIcon_Medium.png',
    	icon4: '<?php echo $plugin_url ?>/img/iPhoneIcon_Big.png',
    	addGlossToIcon: false,
    	startupScreen: '<?php echo $plugin_url ?>/img/istartup.png',
    	//statusBar: 'black-translucent',
    	themeSelectionSelector: '#jqt #themes ul',
		useFastTouch: true,
    	statusBar: 'default',
    	preloadImages: [
		'<?php echo $plugin_url ?>/img/loading.gif',
		'<?php echo $plugin_url ?>/img/iPhoneIcon_Medium.png',
		'<?php echo $plugin_url ?>/img/pinstripes2.gif',
		'<?php echo $plugin_url ?>/img/UIBack.png',
		'<?php echo $plugin_url ?>/img/UIBackPressed.png',
		]
	});
	//alert('is iPhone');
} else {	
	var jQT = new $.jQTouch({
    	//statusBar: 'black-translucent',
    	themeSelectionSelector: '#jqt #themes ul',
		useFastTouch: false,
    	statusBar: 'default',
    	preloadImages: [
		'<?php echo $plugin_url ?>/img/loading.gif',
		'<?php echo $plugin_url ?>/img/iPhoneIcon_Medium.png',
		'<?php echo $plugin_url ?>/img/pinstripes2.gif',
		'<?php echo $plugin_url ?>/img/UIBack.png',
		'<?php echo $plugin_url ?>/img/UIBackPressed.png',
		]
	});
	//alert('is not iPhone');
} 

sid = 0;
s = 0;

// Some sample Javascript functions:
$(function() {

	// Home view
$('#home').bind('pageAnimationEnd', function(e, info) {
		
	if (info.direction == 'in'){
		
		if (myScroll) {
        	myScroll.destroy();
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }
		
		$("#single .toolbar H1").empty(); // empty single H1 title for autotitle
		$("#singleappend").empty();
		
	}

}); //pageAnimationEnd



	// Page animations end with AJAX callback event, example 1 (load remote HTML only first time)
    $('#single').bind('pageAnimationEnd', function(e, info) {

		if (info.direction == 'in'){
		//alert('in do json')		
        var wp_url = PLUGIN_URL + 'get_single.php';

        showLoading();
		//alert('show loading')
		//$("#singleappend").empty().html('<div align="center"><img src="img/loading.gif" alt="Loading" width="32" height="32" id="imgloading" /></div>'); 
		
        $.getJSON(wp_url + '?id=' + sid, function(data) {

            $.each(data.posts, function(i, post) {

                if (post.title !== undefined) {

					var post_html = '<ul class="edgefullcontent">';
					post_html += '<li class="blog-content">';
					post_html += '<span class="info_post" id="cat" style=" float: right;  padding-right: 5px ;" > ' + post.category + '</span>';
                    post_html += '<span class="info_post">' + post.date + '</span>';
					post_html += '<h1>' + post.title + '</h1>';					
					if (post.fimg) post_html += post.fimg ;
                    post_html += '<p>' + post.content + '</p></li>';
					post_html += '<li class=""><div class="previous"><a class="singlenext" id="' + post.prev_post + '" href="#"><span class="nxtarrow"><</span> PREVIOUS</a></div><div class="next"><a class="singlenext" id="' + post.next_post + '" href="#">NEXT <span class="nxtarrow">></span> </a></div></li></ul>';
                   
				    $('#singleappend').html(post_html);
					
						if (myScroll) {
                            myScroll.destroy();
                            myScroll = null;
                        }

                        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
                            setTimeout(function() {
                                myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
                                //alert('New iscroll');
                            }, 0);
                        }
					
					getid();
					
					nextprev(post.prev_post, post.next_post, post.category);
					
					
			if (e.target.nodeName.toLowerCase() != "video") {
			e.preventDefault();
			e.stopPropagation();
			}

                } // if post.title !== undefined
				
				videosize();
				
            }); //each
				
				
				setTimeout(function () {myScroll.refresh();}, 2000);
				hideLoading();
				target_blank();

        }); //getjson
		} //if direction in

    }); //pageAnimationEnd
	
// Categories List
$('#categories').bind('pageAnimationEnd', function(e, info) {

if ((info.direction == 'in') && ($('ul#catappend').html())) {

	var sid = '';
 //alert('empty sid = '+sid);
	$("#postcat").empty();
	$("#showposts .toolbar H1").empty();
	$("#showposts .toolbar .back").html('Section');
	s = 0;
	//alert('not loading')

		if (myScroll) {
        	myScroll.destroy('div#' + e.target.id + ' #wrapper');
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }
	
}

    if ((info.direction == 'in') && ($('ul#catappend').is(':empty'))) { //if empty load ajax
        $("#showposts .toolbar H1").empty();
		$("#showposts .toolbar .back").html('Section');
		//$("#catappend").empty();
		//alert('first load')
            var wp_url = PLUGIN_URL + 'get_category.php';

			showLoading();

            $.getJSON(wp_url + '?', function(data) {
			
			
						if (myScroll) {
                            myScroll.destroy();
                            myScroll = null;
                        }

                        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
                            setTimeout(function() {
                                myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
                                //alert('New iscroll');
                            }, 0);
                        }

						
                $.each(data.categories, function(i, categories) {

                    if (categories.cat_name !== undefined) {                     

                        var post_html = '<li class="blog-content arrow"><a onClick="send(' + categories.id + ')" id=' + categories.id + ' href="#showposts" class="cat">';
                        post_html += categories.cat_name + '</a></li>';
                        $('#catappend').append(post_html);
						
						

                    } // if post.title !== undefined
					
                }); //each
				hideLoading();
            }); //getjson
        
    } //direction in end
}); //pageAnimationEnd
	

// Post List
$('#showposts').bind('pageAnimationEnd', function(e, info) {

if ((info.direction == 'in') && ($('ul#postcat').html())) { //if not empty don't load ajax
$("#single .toolbar H1").empty(); // empty single H1 title for autotitle
$("#singleappend").empty();

		if (myScroll) {
        	myScroll.destroy();
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }

}

	if ((info.direction == 'in') && ($('ul#postcat').is(':empty'))) { //if empty load ajax
		$("#single .toolbar H1").empty(); // empty single H1 title for autotitle
		$("#singleappend").empty();
		//alert('is empty')

            var wp_url = PLUGIN_URL + 'get_post.php';
			
			//alert('New sid = '+sid);
			showLoading();
			//alert(s);
			//var sid = $(this).attr('id'); 			
		
			$.getJSON(wp_url + '?s='+s+'&id=' + sid, function(data) {
			//$.getJSON(wp_url + '?id=' + sid, function(data) {
			//alert('getjson');
			
		if (myScroll) {
        	myScroll.destroy();
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }


                $.each(data.posts, function(i, post) {

                    if (post.title !== undefined) {
                        
						var post_html = '<li class="blog-content arrow"><a onClick="send(' + post.id + ')" id=' + post.id + ' href="#single">';	
                        post_html += post.get_thumb;
               			post_html += '<h2>' + post.title + '</h2>';
                		post_html += '<p>' + post.excerpt + '</p></a></li>';
						
						$('#postcat').append(post_html);						
	
                    } // if post.title !== undefined				

                }); //each
				hideLoading();
				//alert('hideloading');
            }); //getjson
		
    } //direction in end

}); //pageAnimationEnd


// Post List
$('#pages').bind('pageAnimationEnd', function(e, info) {

if ((info.direction == 'in') && ($('ul#pages_append').html())) { //if not empty don't load ajax

$("#single .toolbar H1").empty(); // empty single H1 title for autotitle
$("#singleappend").empty();

		if (myScroll) {
        	myScroll.destroy();
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }

}

	if ((info.direction == 'in') && ($('ul#pages_append').is(':empty'))) { //if empty load ajax
		$("#single .toolbar H1").empty(); // empty single H1 title for autotitle
		$("#singleappend").empty();

            var wp_url = PLUGIN_URL + 'get_post.php';
			
			//alert('New sid = '+sid);
			showLoading();
			//alert(s);
			//var sid = $(this).attr('id'); 			
		
			$.getJSON(wp_url + '?id=' + sid, function(data) {
			//$.getJSON(wp_url + '?id=' + sid, function(data) {
			//alert('getjson');
			
		if (myScroll) {
        	myScroll.destroy();
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }


                $.each(data.posts, function(i, post) {

                    if (post.title !== undefined) {
                        
						var post_html = '<li class="blog-content arrow"><a onClick="send(' + post.id + ')" id=' + post.id + ' href="#single">';	
                        post_html += post.get_thumb;
               			post_html += '<h2>' + post.title + '</h2>';
                		post_html += '<p>' + post.excerpt + '</p></a></li>';
						
						$('#pages_append').append(post_html);						
	
                    } // if post.title !== undefined				

                }); //each
				hideLoading();
				//alert('hideloading');
            }); //getjson
		
    } //direction in end

}); //pageAnimationEnd


	$('#search').bind('pageAnimationEnd', function(e, info) {

		if (info.direction == 'in'){
		
				if (myScroll) {
        	myScroll.destroy();
            myScroll = null;
        }

        if ($('div#' + e.target.id + ' #wrapper').get(0)) {
         	setTimeout(function() {
            	myScroll = new iScroll($('div#' + e.target.id + ' #wrapper').get(0));
			}, 0);
        }
		
		$("#showposts .toolbar H1").empty(); // marche pas parce que pas encole loader, peut etre if direction out
		$("#postcat").empty();
		
		}

	}); //pageAnimationEnd

}); //end function()
</script>

<script type="text/javascript">			
// Home 
$(document).ready(function() {

	$('.scroll').wrap('<div id="wrapper" />').attr('id', 'scroller');
	
	// if text input field value is not empty show the "X" button
	$("#searchid").keyup(function() {
		$("#x").show();
		//if ($.trim($("#search").val()) == "") {
		if ($("#searchid").val() == "") {
			$("#x").hide();
		}
	});
	// on click of "X", delete input field value and hide "X"
$("#x").bind(clickEventType, function() {
	$("#searchid").focus().val("");
	$(this).hide();
}); //X BUTTON END

    var wp_url = PLUGIN_URL + 'get_post.php';

    showLoading();
	
	$.getJSON(wp_url + '?', function(data) {

        $.each(data.posts, function(i, post) {

            if (post.title !== undefined) {

                var post_html = '<li class="blog-content arrow"><a onClick="send(' + post.id + ')" id=' + post.id + ' href="#single">';
                //post_html += '<div class="float_right">' + post.date + '</div>';
                post_html += post.get_thumb;
                post_html += '<h2>' + post.title + '</h2>';
                post_html += '<p>' + post.excerpt + '</p></a></li>';

                // Append html string to container div 
                $('#allpost').append(post_html);
                //if ( i == 5 ) return false;								
            }
        });
				
			hideLoading();
			setTimeout(function () { myScroll.refresh(); }, 100);

    });
	
}); // end document ready

</script>

</head>

<body>
<div id="page">

<div class="searchbox">
  	<div id="form">
        <input id="searchid" name="s" placeholder="Search" type="search" autocapitalize="off" />     
        <span id="x"></span>
    
</div>     <a href="#showposts" class="nodecoration"><div onTouchStart="moveDown();" class="my_button" id="my_button">Search</div></a> 
</div>

<div id="jqt">

<!-- #home -->
	<div id="home" class="current">
		<div class="toolbar">
			<h1><script type="text/javascript">document.write(BLOG_TITLE);</script></h1>
			 <a class="button slideup" id="infoButton" href="#about">About</a>
        </div>
            <div class="scroll">
			<ul class="edgecontent allpost" id="allpost"></ul>
            </div>
	</div>
<!-- End #home -->
    
<!-- #single -->
	<div id="single" class="">
		<div class="toolbar">
			<h1></h1>
            <a class="back" href="#">Back</a>		
        </div>
		<div class="scroll">
            <div id="singleappend"></div>         
		</div>
	</div>
<!-- End #single -->

<!-- #categories -->
	<div id="categories">
		<div class="toolbar">
			<h1>Sections</h1>
		</div>
		<div class="scroll">       
			<ul class="edgetoedge" id="catappend"></ul>
		</div>
	</div>
<!-- End #categories -->

<!-- #showposts -->
	<div id="showposts">
		<div class="toolbar">
			<h1></h1>
            <a class="back" href="#">Sections</a>
        </div>
		<div class="scroll">
			<ul class="edgecontent allpost" id="postcat"></ul>
		</div>
	</div>
<!-- End #showposts -->

<!-- #pages -->
	<div id="pages">
		<div class="toolbar">
			<h1></h1>
        </div>
		<div class="scroll">
			<ul class="edgecontent allpost" id="pages_append"></ul>
		</div>
	</div>
<!-- End #pages -->
 
<!-- #search -->
   <form id="search"  class="form">
		<div class="toolbar">
			<h1>Search</h1>
        </div>
		<div class="scroll">
			<ul class="edgetoedge"><li>Search <?php echo get_bloginfo( 'name' ) ?></li></ul>     
        </div>
    </form>
<!-- End #search -->
    
    <!-- #about -->
    <div id="about" class="selectable">
		<p><img src="<?php echo $plugin_url ?>/img/iPhoneIcon_Small.png" /></p>
		<p><strong><a href="http://wpapptouch.com" target="_blank">WPapptouch.com</a></strong><br>
		  Version 0.1 beta<br>
	  <a href="http://wpapptouch.com" target="_blank">By Gino Côté</a></p>
	  <p><em>Create powerful Wordpress mobile web apps with<br> WPapptouch.</em></p>
		<p>
			<a href="http://twitter.com/wpapptouch" target="_blank">@wpapptouch on Twitter</a></p>
		<p><br><a href="#" class="grayButton goback">Close</a></p>
	</div>
    <!-- End #about -->

</div> <!-- End #jqt -->

<div id="loading"><p><img src="<?php echo $plugin_url ?>/img/loading.gif" /></p></div>

<nav id="tabbar">
    <ul >
     <!-- Action & navigation -->
<li><a href="#home" class="current flip"><strong>Home</strong><div class="home"></div></a></li>    
<li><a href="#categories" class="flip"><strong>Sections</strong><div class="list"></div></a></li>
<li><a onTouchStart="send('pages')" href="#pages" class="flip"><strong>Pages</strong><div class="page"></div></a></li>
<li><a href="#search" class=""><strong>Search</strong><div class="search2"></div></a></li>
<li><a href="#about" id="li_tab" class="flip"><strong>More</strong><div class="more"></div></a></li>
    </ul>
</nav>
</div> <!-- End #page -->
<script type="text/javascript">
//Show search
var visible = false;
function moveDown() {

        var height = $(".searchbox").height();
        $(".searchbox").css('-webkit-transform', 'translate3d(0px,+46px,0)');
		//$(".searchbox").show().css('-webkit-transform', 'translate3d(0px,+46px,0)');
		//$('#element').css('z-index'); 

}
function moveUp() {
    var height = $(".searchbox").height();
    $(".searchbox").css('-webkit-transform', 'translate3d(0px,0px,0)');
	//$(".searchbox").show().css('z-index', '200').css('-webkit-transform', 'translate3d(0px,0px,0)');
}

//ajax loading animation
function showLoading() {
  //$("div.container").show();
  $("#loading").show(); // If image gif
}

function hideLoading() {
  //$("div.container").hide();
  $("#loading").hide();  // If image gif
}

function nextprev(prev,next,cat) {
	if (prev === null) {
  		$(".previous").empty();
	}
	if (next === null) {
  		$(".next").empty();
	}
	if (cat === null) {
  		$("#cat").empty();
	}
}
function send(x) {
    sid = x;
	//alert ('Fonction '+sid);
	if(isNaN(sid)){ //not a number
	$("#pages .toolbar H1").empty(); // marche pas parce que pas encole loader, peut etre if direction out
	//$("ul#postcat").html(); 
	$("#pages .toolbar H1").html('Pages'); 
	//alert ('is not a number');
	} else {
	//$("#showposts .toolbar H1").empty();
	} 
	//return false;
}

//Hack, ajax jsonp search
$("#my_button").click(function(e) { // onclick event to the submit button - .tap or .click.
    $("ul#postcat").empty();
	s = $("#searchid").val(); // get the user-entered search term
	//sget(s)
	$('#showposts .toolbar H1').html(s);
	$("#pages .toolbar H1").html('Search'); 
	$("#showposts .toolbar .back").html('Search');
	//alert(s);
});

function target_blank() {
//make all external link blank & add Hash to internal
	$("#single .blog-content a").attr("href", function(i, href) {
    	if( window.location.hostname === this.hostname ) {
			$(this).attr('rel', 'url'); 
			$(this).attr('id', href); 
        	return "#";
    	}else{
			$(this).attr('target', '_blank'); 
			return href;
		}	
	});
	//alert for external link
	$('a[target="_blank"]').bind('click', function() {
		if (confirm('This External link opens in a new window.')) {
			return true;
		} else {
			return false;
		}
	});	
	
	//$('#singleappend a').bind('click', function() {
	$('a[rel="url"]').bind('click', function() {
		//var id_url = $(this).attr('rel');
		var id_url = $(this).attr('id');
		get_id_url(id_url);
		//alert(id_url);
	});	
	
	$('#single .blog-content a >  img').unwrap(); // remove images link

}

function getid() {
	//$(".singlenext").bind(clickEventType, function(e) {	
	$('.singlenext').bind('click', function() {
		var sid = (this.id);
		//alert(sid);
		get_id_url(sid);	
	}); //end
}

function get_id_url(id_url) {
sid = id_url;
//var sid = encodeURIComponent(id_url);
//alert(sid);
    var wp_url = PLUGIN_URL + 'get_single.php';
	
	showLoading();

    $.getJSON(wp_url + '?id=' + sid, function(data) {

        $.each(data.posts, function(i, post) {

            if (post.title !== undefined) {

                var post_html = '<ul class="edgefullcontent">';
				//var post_html = '<ul class="rounded"><li class=""><div class="singlenext" id="' + post.next_post + '">NEXT</div></li>';
                post_html += '<li class="blog-content">';
				post_html += '<span class="info_post" id="cat" style=" float: right;  padding-right: 5px ;" > ' + post.category + '</span>';
                post_html += '<span class="info_post">' + post.date + '</span>';
                post_html += '<h1>' + post.title + '</h1>';					
				if (post.fimg) post_html += post.fimg ;
                post_html += '<p>' + post.content + '</p></li>';
				post_html += '<li class=""><div class="previous"><a class="singlenext" id="' + post.prev_post + '" href="#"><span class="nxtarrow"><</span> PREVIOUS</a></div><div class="next"><a class="singlenext" id="' + post.next_post + '" href="#">NEXT <span class="nxtarrow">></span> </a></div></li></ul>';
				
				var post_title = post.title ;
				
                //$("#single .toolbar H1").empty(); // empty single H1 title for autotitle
				$('#singleappend').html(post_html);
				$('#single .toolbar H1').html(post_title);

				getid();	
				
				nextprev(post.prev_post, post.next_post, post.category);

            } // if post.title !== undefined
			videosize();
			
        }); //each	
		
		myScroll.scrollTo(0, 0, 0); //last number timer

		setTimeout(function () {myScroll.refresh();}, 2000);
		hideLoading();
		target_blank();
		
    }); //getjson
}

</script>
<script type='text/javascript' src='<?php echo $plugin_url ?>/src/itabbar.min.js'></script>
<script type='text/javascript' src='<?php echo $plugin_url ?>/src/functions.min.js'></script>  

</body>
</html>