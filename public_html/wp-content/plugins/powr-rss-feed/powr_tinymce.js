tinymce.PluginManager.add('powr', function(editor, url) {
    function uniqueLabel(){
        return 'xxxxxxxx_'.replace(/[x]/g, function(c) {
            var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
            return v.toString(16);
        }) + new Date().getTime();
    }
    editor.addButton('powr', {
        title : 'POWr Plugin',
        tooltip: 'Insert POWr Plugin',
        //image : 'powr-icon.png',
        icon: 'icon powr-icon',
        type: 'menubutton',
        onclick : function(e) {
			var app_name = e.target.innerText.replace(/^\s+|\s+$/g, '');
			var app_shortcode = app_name.toLowerCase().replace(/ /g, '-');
			if( app_shortcode && !e.target.classList.contains('mce-menu-item-expand') && !e.target.parentElement.classList.contains('mce-menu-item-expand')){
		        var c = '[powr-'+app_shortcode+' id='+uniqueLabel()+']'; //For just shortcode
				//Set the content in the editor
				editor.selection.setContent(c);			
			}	
        },
        menu: [
            {
                text: 'Forms & Surveys',
                menu: [
					{text: 'Contact Form'},
					{text: 'Form Builder'},
					{text: 'Mailing List'},
                    {text: 'Order Form'},
					{text: 'Poll'},
					{text: 'Survey'}			 
                ]
            },
            {
                text: 'Galleries & Sliders',
                menu: [
					{text: 'Banner Slider'},
					{text: 'Event Gallery'},
					{text: 'Event Slider'},
                    {text: 'Flickr Gallery'},
					{text: 'Image Slider'},
					{text: 'Media Gallery'},
					{text: 'Microblog'},
					{text: 'Multi Slider'},
					{text: 'Photo Gallery'},
					{text: 'Video Gallery'},
					{text: 'Video Slider'},
                    {text: 'Vimeo Gallery'},
                    {text: 'Youtube Gallery'}
				]
			},	
            {
                text: 'Social',
                menu: [
                    {text: 'Comments'},
					{text: 'Facebook Feed'},
					{text: 'Instagram Feed'},
                    {text: 'Meerkat'},
                    {text: 'Pinterest Feed'},
                    {text: 'Reviews'},
					{text: 'RSS Feed'},
					{text: 'Social Feed'},
					{text: 'Social Media Icons'},
					{text: 'Tumblr Feed'},
					{text: 'Twitter Feed'},
                    {text: 'Vine Feed'}
                ]
                
            },
            {
                text: 'eCommerce',
                menu: [
                    {text: 'Ecommerce'},
                    {text: 'Digital Download'},
                    {text: 'Paypal Button'},
					{text: 'Plan Comparison'},
					{text: 'Price Table'}
                ]
            },
            {
                text: 'Miscellaneous',
                menu: [
					{text: 'About Us'},
					{text: 'Button'},
					{text: 'Countdown Timer'},
                    {text: 'Count Up Timer'},
                    {text: 'FAQ'},
                    {text: 'Graph'},
					{text: 'Hit Counter'},
					{text: 'Holiday Countdown'},
					{text: 'Map'},
                    {text: 'Popup'},
					{text: 'Resume'},
					{text: 'Tabs'},
					{text: 'Weather'}			                    
				]
            }
        ]
    });
});