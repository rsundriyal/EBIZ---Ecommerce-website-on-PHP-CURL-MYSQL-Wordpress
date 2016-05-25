/********************************
** adamrob.co.uk - 20JAN2015
** Parallax Scroll Wordpress Plugin
**
** For Help and Support please visit www.adamrob.co.uk
**
** fullwidth.js
** Provides full width functionality regardless of
** parent divs by re-sizing the container div to the
** same height as the absolute positioned parallax
********************************/

jQuery(document).ready(function($){

	//retrieve variables
	var parallaxoptions = parallax_script_options;
	
	//Iterate over all full width parallax containers
	$('.'+parallaxoptions.parallaxcontainerid).each(function(i, obj) {

		//Alter the height of this container based on its content
		$(this).css("height", $(this).find('.'+parallaxoptions.parallaxdivid).css("height") );
	});

});