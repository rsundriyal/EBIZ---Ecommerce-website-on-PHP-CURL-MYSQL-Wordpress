jQuery(document).ready(function($){
								
								
$('.section-accordion').click(function(){
 var accordion_item = $(this).find('.heading span').data('accordion');
 $('.'+accordion_item).slideToggle();
 if( $(this).hasClass('close')){
	 $(this).removeClass('close').addClass('open');
	 $(this).find('.heading span.fa').removeClass('fa-plus').addClass('fa-minus');
	 }else{
		$(this).removeClass('open').addClass('close'); 
		$(this).find('.heading span.fa').removeClass('fa-minus').addClass('fa-plus');
		 }
	   
	 })	;

 $('.of-css-editor').each(function() {
        var editor = ace.edit($(this).attr('id'));
        var this_textarea = $('#' + $(this).data('textarea'));
        editor.setTheme("ace/theme/chrome");
        editor.getSession().setMode("ace/mode/css");
        editor.setShowPrintMargin( false );
    
        editor.getSession().setValue(this_textarea.val());
        editor.getSession().on('change', function(){
        this_textarea.val(editor.getSession().getValue());
		this_textarea.text(editor.getSession().getValue());
		  
        });
        this_textarea.on('change', function(){
											
          editor.getSession().setValue(this_textarea.val());
        });
      });


				
				//
 $('.alchem_shortcodes,.alchem_shortcodes_textarea').click(function(){
  var popup = 'shortcode-generator';

        if(typeof params != 'undefined' && params.identifier) {
            popup = params.identifier;
        }

        // load thickbox
        tb_show("Shortcodes", ajaxurl + "?action=magee_shortcodes_popup&popup=" + popup + "&width=" + 800);

        $('#TB_window').hide();
						})




 $('.alchem_shortcodes_textarea').on("click",function(){
			var id = $(this).next().find("textarea").attr("id");
			$('#alchem-shortcode-textarea').val(id);
		});																	   

$('.alchem_shortcodes_list li a.alchem_shortcode_item').on("click",function(){
													  
  var obj       = $(this);
  var shortcode = obj.data("shortcode");
  var form      = obj.parents("div#alchem_shortcodes_container form");
 
   jQuery.ajax({
		type: "POST",
		url: alchem_params.ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "alchem_shortcode_form" },
		success:function(data){
	
		   form.find(".alchem_shortcodes_list").hide();
		   form.find("#alchem-shortcodes-settings").show();
		   form.find("#alchem-shortcodes-settings .current_shortcode").text(shortcode);
		   form.find("#alchem-shortcodes-settings-inner").html(data);
		}
		});
	
});

jQuery(".alchem-shortcodes-home").bind("click",function(){
            jQuery("#alchem-shortcodes-settings").hide();
		    jQuery("#alchem-shortcodes-settings-innter").html("");
		    jQuery(".alchem_shortcodes_list").show();
		   
		});
		
// insert shortcode into editor
jQuery(".alchem-shortcode-insert").bind("click",function(e){

    var obj       = jQuery(this);
	var form      = obj.parents("div#alchem_shortcodes_container form");
	var shortcode = form.find("input#alchem-curr-shortcode").val();

	jQuery.ajax({
		type: "POST",
		url: alchem_params.ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "alchem_get_shortcode",attr:form.serializeArray()},
		
		success:function(data){
		
		jQuery.magnificPopup.close();
		form.find("#alchem-shortcodes-settings").hide();
		form.find("#alchem-shortcodes-settings-innter").html("");
		form.find(".alchem_shortcodes_list").show();
        form.find(".alchem-shortcode").val(data);
		if(jQuery('#alchem-shortcode-textarea').val() !="" ){
			var textarea = jQuery('#alchem-shortcode-textarea').val();
			if(textarea !== "undefined"){
		    var position = jQuery("#"+textarea).getCursorPosition();
			var content = jQuery("#"+textarea).val();
            var newContent = content.substr(0, position) + data + content.substr(position);
            jQuery("#"+textarea).val(newContent);
			
			}
			}else{
		window.alchem_wpActiveEditor = window.wpActiveEditor;
		// Insert shortcode
		window.wp.media.editor.insert(data);
		// Restore previous editor
		window.wpActiveEditor = window.alchem_wpActiveEditor;
		}
		},
		error:function(){
			jQuery.magnificPopup.close();
		// return false;
		}
		});
		// return false;
   });

 //preview shortcode

 $(".alchem-shortcode-preview").bind("click",function(e){

    var obj       = jQuery(this);
	var form      = obj.parents("div#alchem_shortcodes_container form");
	var shortcode = form.find("input#alchem-curr-shortcode").val();

	jQuery.ajax({
		type: "POST",
		url: alchem_params.ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "alchem_get_shortcode",attr:form.serializeArray()},
		
		success:function(data){
      
		jQuery.ajax({type: "POST",url: alchem_params.ajaxurl,dataType: "html",data: { shortcode: data, action: "alchem_shortcode_preview"},	
		success:function(content){
			$("#alchem-shortcode-preview").html(content);
	        tb_show(shortcode + " preview","#TB_inline?width=600&amp;inlineId=alchem-shortcode-preview",null);
			}
		});
	
		},
		error:function(){
			
		// return false;
		}
		});
		// return false;
   });

/////

 
 });