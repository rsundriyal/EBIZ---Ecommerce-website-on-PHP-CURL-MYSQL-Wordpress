jQuery(document).ready(function(){
	
	/**************************/
	/**** Generate uniq id ****/
	/**************************/
	
	function shop_isle_uniqid(prefix, more_entropy) {

	  if (typeof prefix === 'undefined') {
		prefix = '';
	  }

	  var retId;
	  var formatSeed = function(seed, reqWidth) {
		seed = parseInt(seed, 10)
		  .toString(16); // to hex str
		if (reqWidth < seed.length) { // so long we split
		  return seed.slice(seed.length - reqWidth);
		}
		if (reqWidth > seed.length) { // so short we pad
		  return Array(1 + (reqWidth - seed.length))
			.join('0') + seed;
		}
		return seed;
	  };

	  // BEGIN REDUNDANT
	  if (!this.php_js) {
		this.php_js = {};
	  }
	  // END REDUNDANT
	  if (!this.php_js.uniqidSeed) { // init seed with big random int
		this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
	  }
	  this.php_js.uniqidSeed++;

	  retId = prefix; // start with prefix, add current milliseconds hex string
	  retId += formatSeed(parseInt(new Date()
		.getTime() / 1000, 10), 8);
	  retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
	  if (more_entropy) {
		// for more entropy we add a float lower to 10
		retId += (Math.random() * 10)
		  .toFixed(8)
		  .toString();
	  }

	  return retId;
	}

	function shop_isle_refresh_general_control_values(){
		jQuery(".shop_isle_general_control_droppable").each(function(){
			var values = [];
			var th = jQuery(this);
			th.find(".shop_isle_general_control_repeater_container").each(function(){
				var icon_value = jQuery(this).find('select').val();
				var text = jQuery(this).find(".shop_isle_text_control").val();
				var link = jQuery(this).find(".shop_isle_link_control").val();
				var label = jQuery(this).find(".shop_isle_label_control").val();
				var subtext = jQuery(this).find(".shop_isle_subtext_control").val();
				var description = jQuery(this).find(".shop_isle_description_control").val();
				var image_url = jQuery(this).find(".custom_media_url").val();
				var id = jQuery(this).find(".shop_isle_box_id").val();
				if( (icon_value != '') || (text != '') || (image_url != '') || (subtext != '') || (label != '') || (link != '') || (description != '') ){
					values.push({
						"icon_value" : icon_value,
						"text" : text,
						"link" : link,
						"image_url" : image_url,
						"subtext" : subtext,
						"label" : label,
						"link"  : link,
						"description" : description,
						"id" : id
					});
				}

			});

			th.find('.shop_isle_repeater_colector').val(JSON.stringify(values));
			th.find('.shop_isle_repeater_colector').trigger('change');
		});
	}

    jQuery('#customize-theme-controls').on('click','.shop-isle-customize-control-title',function(){
        jQuery(this).next().slideToggle();
    });
    function media_upload(button_class) {

		jQuery('body').on('click', button_class, function(e) {
			var button_id ='#'+jQuery(this).attr('id');
			var display_field = jQuery(this).parent().children('input:text');
			var _custom_media = true;

			wp.media.editor.send.attachment = function(props, attachment){
				if ( _custom_media  ) {
					if(typeof display_field != 'undefined'){
						switch(props.size){
							case 'full':
								display_field.val(attachment.sizes.full.url);
								display_field.trigger('change');
								break;
							case 'medium':
								display_field.val(attachment.sizes.medium.url);
								display_field.trigger('change');
								break;
							case 'thumbnail':
								display_field.val(attachment.sizes.thumbnail.url);
								display_field.trigger('change');
								break;
							case 'shop_isle_team':
								display_field.val(attachment.sizes.shop_isle_team.url);
								display_field.trigger('change');
								break
							case 'shop_isle_services':
								display_field.val(attachment.sizes.shop_isle_services.url);
								display_field.trigger('change');
								break
							case 'shop_isle_customers':
								display_field.val(attachment.sizes.shop_isle_customers.url);
								display_field.trigger('change');
								break;
							default:
								display_field.val(attachment.url);
								display_field.trigger('change');
						}
					}
					_custom_media = false;
				} else {
					return wp.media.editor.send.attachment( button_id, [props, attachment] );
				}
			}
			wp.media.editor.open(button_class);
			window.send_to_editor = function(html) {

			}
			return false;
		});
	}

    media_upload('.custom_media_button_shop_isle');
    jQuery(".custom_media_url").live('change',function(){
        shop_isle_refresh_general_control_values();
        return false;
    });

	jQuery("#customize-theme-controls").on('change', '.shop_isle_icon_control',function(){
		shop_isle_refresh_general_control_values();
		return false;
	});

	jQuery(".shop_isle_general_control_new_field").on("click",function(){

		var th = jQuery(this).parent();
		var id = 'shop_isle_' + shop_isle_uniqid();
		if(typeof th != 'undefined') {

            var field = th.find(".shop_isle_general_control_repeater_container:first").clone();
            if(typeof field != 'undefined'){
                field.find(".shop_isle_general_control_remove_field").show();
                field.find("select").val('');
                field.find(".shop_isle_text_control").val('');
                field.find(".shop_isle_link_control").val('');
				field.find(".shop_isle_label_control").val('');
				field.find(".shop_isle_subtext_control").val('');
				field.find(".shop_isle_box_id").val(id);
                field.find(".custom_media_url").val('');
                th.find(".shop_isle_general_control_repeater_container:first").parent().append(field);
                shop_isle_refresh_general_control_values();
            }

		}
		return false;
	 });

	jQuery("#customize-theme-controls").on("click", ".shop_isle_general_control_remove_field",function(){
		if( typeof	jQuery(this).parent() != 'undefined'){
			jQuery(this).parent().parent().remove();
			shop_isle_refresh_general_control_values();
		}
		return false;
	});

	jQuery("#customize-theme-controls").on('keyup', '.shop_isle_text_control',function(){
		 shop_isle_refresh_general_control_values();
	});

	jQuery("#customize-theme-controls").on('keyup', '.shop_isle_link_control',function(){
		shop_isle_refresh_general_control_values();
	});

	jQuery("#customize-theme-controls").on('keyup', '.shop_isle_label_control',function(){
		shop_isle_refresh_general_control_values();
	});

	jQuery("#customize-theme-controls").on('keyup', '.shop_isle_subtext_control',function(){
		shop_isle_refresh_general_control_values();
	});

	/*Drag and drop to change order*/
	jQuery(".shop_isle_general_control_droppable").sortable({
		update: function( event, ui ) {
			shop_isle_refresh_general_control_values();
		}
	});


	/* Forum and Documentation links in customizer */

	jQuery( '#customize-theme-controls > ul' ).prepend('<li class="accordion-section shop-isle-upsells">');

	jQuery( '.shop-isle-upsells' ).append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="http://themeisle.com/forums/forum/shopisle/" class="button" target="_blank">{support}</a>'.replace('{support}',objectL10n.support));

	jQuery( '.shop-isle-upsells' ).append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="http://themeisle.com/documentation-shop-isle/" class="button" target="_blank">{documentation}</a>'.replace('{documentation}',objectL10n.documentation));

});
