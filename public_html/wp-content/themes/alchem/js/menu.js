////Menu options
var menuIconID = '';
jQuery(document).ready(function($){ 
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		jQuery('#edit-menu-item-menuimage-'+menuIconID).val(imgurl);
		jQuery('#menu-icon-'+menuIconID).attr('src', imgurl);
		jQuery('#menu-icon-'+menuIconID).show();
		jQuery('#bt-icon-add-'+menuIconID).hide();
		jQuery('#bt-icon-remove-'+menuIconID).show();
		tb_remove();
	};
});

function getMenuIcon(classID){
	menuIconID = classID;
	jQuery(document).ready(function($){ 
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
}

function removeMenuIcon(classID){
	jQuery(document).ready(function($){ 
		jQuery('#edit-menu-item-menuimage-'+classID).val('');
		jQuery('#menu-icon-'+classID).hide();
		jQuery('#bt-icon-add-'+classID).show();
		jQuery('#bt-icon-remove-'+classID).hide();
	});
}