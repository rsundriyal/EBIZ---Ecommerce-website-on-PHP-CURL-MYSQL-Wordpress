/********************************
** adamrob.co.uk - 8MAR2016
** Parallax Scroll Wordpress Plugin
**
** For Help and Support please visit www.adamrob.co.uk
**
** scroll.js
** Allows the background image to scroll at
** a different speed
********************************/

//jQuery(document).scroll(function($){
jQuery(document).on("load ready scroll",function($){

	//retrieve variables
	var parallaxoptions = parallax_script_scroll_options;

	//Iterate over all full width parallax containers
	jQuery('.'+parallaxoptions.parallaxcontainerid).each(function(i, obj) {

		//get the image
		var img = new Image;
		img.src = jQuery(this).css('background-image').replace('url', '').replace('(', '').replace(')', '').replace('"', '').replace('"', '');
		var bgImgWidth = img.width;
		var bgImgHeight = img.height;


		//Finde the position of the section
		secPosition=jQuery(this).offset().top;
		secHeight=jQuery(this).height();
		secScrollablePx = bgImgHeight-secHeight;
		scrollPos = jQuery(window).scrollTop();
		screenHeight = jQuery(window).height();



		//Detect if the parallax section is on the screen.
		//Only allow the control if its visible.
		if(((scrollPos+screenHeight)>=secPosition)&&( scrollPos<=(secPosition+secHeight))){

			var thisScrollPos = (scrollPos+screenHeight) - secPosition;				//The actual scroll position of the section in the browser window
			var thisScrollPosPercentage = (thisScrollPos / screenHeight) * 100;		//The percentage of the scroll
			var yPX = -(thisScrollPosPercentage/secScrollablePx) * 100;				//Percentage that is scrollable.
			//Speed multiplier (0.1 to 1)
			yPX=yPX+(yPX*(jQuery(this).attr("speed")*0.1)); 


			//Move the parallax image
			jQuery(this).css('background-position', '50% '+ yPX + 'px');

		}

	});

});


