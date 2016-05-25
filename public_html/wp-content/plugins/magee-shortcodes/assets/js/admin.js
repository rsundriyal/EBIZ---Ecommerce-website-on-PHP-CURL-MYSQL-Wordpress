jQuery(document).ready(function($){

$('.magee_shortcodes,.magee_shortcodes_textarea').click(function(){
  var popup = 'shortcode-generator';

        if(typeof params != 'undefined' && params.identifier) {
            popup = params.identifier;
        }
		
        var magee = "Magee Shortcodes<span class='shortcode_show_name'></span><a class='link-doc' target='_blank' href='https://www.mageewp.com/magee-shortcode-guide.html'>Document</a><a   class='link-forum' target='_blank' href='https://www.mageewp.com/forums/magee-shortcode/'>Forums</a>";
        // load thickbox
	    var height = $(window).height()-150;
        tb_show(magee, ajaxurl + "?action=magee_shortcodes_popup&popup=" + popup + "&width=800&height="+height);
       // $('#TB_window').hide();
	   
  })




$('.magee_shortcodes_textarea').on("click",function(){
			var id = $(this).next().find("textarea").attr("id");
			$('#magee-shortcode-textarea').val(id);
		});																	   

$(document).on("click",'a.magee_shortcode_item',function(){
  								  
  var obj       = $(this);
  var shortcode = obj.data("shortcode");
  var form      = obj.parents("div#magee_shortcodes_container form");
 
   $.ajax({
		type: "POST",
		url: ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "magee_shortcode_form" },
		success:function(data){
		   form.find(".magee_shortcodes_list").hide();
		   form.find("#magee-shortcodes-settings").show();
		   form.find("#magee-shortcodes-settings .current_shortcode").text(shortcode);
		   form.find("#magee-shortcodes-settings #magee-shortcode").val(shortcode);
		   form.find("#magee-shortcodes-settings-inner").html(data);
		   var myOptions = {
		   change: function(event, ui){
			   $('.magee_shortcodes_container .wp-color-picker-field').each(function(){	
					var color = $(this).parents('.wp-picker-container').find('.wp-color-result').css("background-color")						 
					$(this).css("background-color",color);
					var  top = parseInt($(this).parents('.wp-picker-container').find('a.iris-square-value').css("top").replace('px',''));
					var percent = parseInt($(this).parents('.wp-picker-container').find('div.iris-slider-offset span').css("bottom"));
					if(top < 87 && percent < 97){
						$(this).css("color","black");
						}else{
							$(this).css("color","white");
							}
			   });
			   },
			};

		   $('.magee_shortcodes_container .wp-color-picker-field').wpColorPicker(myOptions);	
		   $.ajax({
			  type: "POST",
			  url: ajaxurl,
			  dataType: "html",
			  data: {action:'magee_control_button'},
			  success:function(data){ $('#TB_window').append(data);
			  var content_height = $('#TB_window').outerHeight();
              var title_height = $('#TB_title').outerHeight();
			  var footer_height = $('#TB_footer').outerHeight();
	          $('#TB_ajaxContent').css({'height':content_height-title_height-footer_height-15});
			  //colorpicker controls
			  $('.magee_shortcodes_container .wp-color-picker-field').each(function(){
					var color = $(this).attr('value');
					$(this).css("background-color",color);
					var since = 0 ;
					var show = $(this); 
					$(this).parents('.wp-picker-container').find('.wp-picker-holder').mouseover(function(e){
						since = 0;			
						event.cancelBubble=true;
					});
					$(this).parents('.wp-picker-container').find('.wp-picker-holder').mouseout(function(e){
						since = 1;			
						event.cancelBubble=true;
					});
					$(document).mousedown(function(){
						if(since == 1){
							
							show.parents('.wp-picker-container').find('.wp-picker-holder').css("display","none");
							}						   
					});
					$(this).click(function(){
						$(this).parents('.wp-picker-container').find('.wp-picker-holder').css("display","block");	   
					});	
					
			  });
			  //add shortcode name 
			  $('#TB_ajaxWindowTitle> span:first-child').before("&nbsp;<i class='fa fa-angle-right title_icon' ></i>&nbsp;");
			  $('#TB_ajaxWindowTitle> span').append($("#magee-shortcodes-settings-inner h2").text());
			  //when image compare to be hidden
			  if($('h2.shortcode-name').text() == 'Image Compare Shortcode'){
				  $('.TB_footer .magee-shortcodes-preview').css("display","none") ;
			  }
			  //input number controls
			  
			  $('.magee-form-number').each(function(){
				  var number_obj = $(this);
				  var number = parseInt($(this).attr('max'));
				  var total =parseInt($(this).parent('.field').find('.probar').width());
				  var op = total/number;
				  var val = parseInt($(this).val());
				  var left = op*val.toString();
				  $(this).parent('.field').find('.probar-control').css('left',left);							
				  $(this).parents('.param-item').find('.probar').click(function(e){
						e = e||window.event;
						var x2 = e.clientX;
						var x3 = $(this).parents('.param-item').find('.probar').offset().left;
						
						var lv = (x2-x3)/total*100;
						$(this).parents('.param-item').find('.probar-control').css('left',lv.toString()+'%');
						number_obj.val(Math.round(parseInt($(this).parents('.param-item').find('.probar-control').css('left'))/op));	
				  });										
				  $(this).change(function(){
						if(parseInt($(this).val()) > number){
							$(this).parents('.param-item').find('.probar-control').css('left','100%');
							}else{
							newleft = op*parseInt($(this).val()).toString();
						    $(this).parents('.param-item').find('.probar-control').css('left',newleft);	
								}				  												
						 });
				  var z  = 0 ;
				  var x1,y1;
				  $(this).parents('.param-item').find('.probar-control').mousedown(function(e){								 
						 z = 1;
						 e = e||window.event;    
						 x1 = $(this).parents('.param-item').find('.probar').offset().left;
						 y1 = x1 + total;
						 
						 });
				 
				 $(document).mousemove(function(e){								
						 if(z == 1){	 
							 var e=e||window.event;		
							 var x = e.clientX;
							 if(x>y1 || x< x1){
									 if(x>y1){	 
										number_obj.parents('.param-item').find('.probar-control').css('left','100%') ;								   
										 }
									 if(x < x1){
										   number_obj.parents('.param-item').find('.probar-control').css('left','0%')	 ;			   																					 
										 }
								 }else{
								 var pc = (x-x1)/total*100;
								 number_obj.parents('.param-item').find('.probar-control').css('left',pc.toString()+'%');
								 number_obj.val(Math.round(parseInt(number_obj.parents('.param-item').find('.probar-control').css('left'))/op));							   										
								 }
							 }
						
						 });
				  $(document).mouseup(function(){
						 z = 0;												
						 })	;			  			   																						
              });
			  
			  //input choose controls 
			  $('.choose-show').each(function(){
				  if($(this).find('.choose-show-param').eq(0).is(':hidden') && $(this).find('.choose-show-param').eq(1).is(':hidden')){
				  var value = $(this).find('.choose-show-param').eq(0).attr('name');
				  $(this).parents('.param-item').find('.magee-form-choose').val(value);
				  $(this).find('.choose-show-param').eq(0).css('display','block');
				     if($(this).find('.choose-show-param').eq(0).text() == 'Yes'){$(this).css({'background-color':'#CCF7D5','color': '#17A534','font-weight': 'bold'});}
					 if($(this).find('.choose-show-param').eq(0).text() == 'No'){$(this).css({'background-color':'#FFDEDE','color': '#ff0000','font-weight': 'bold'});}
				  }else{
				  if($(this).find('.choose-show-param').eq(0).is(':hidden')){
					  var value = $(this).find('.choose-show-param').eq(1).attr('name');
					  $(this).parents('.param-item').find('.magee-form-choose').val(value);
					  if($(this).find('.choose-show-param').eq(1).text() == 'Yes'){$(this).css({'background-color':'#CCF7D5','color': '#17A534','font-weight': 'bold'});}
					  if($(this).find('.choose-show-param').eq(1).text() == 'No'){$(this).css({'background-color':'#FFDEDE','color': '#ff0000','font-weight': 'bold'});}
					  }else{
					  var value = $(this).find('.choose-show-param').eq(0).attr('name');
				      $(this).parents('.param-item').find('.magee-form-choose').val(value);
					  if($(this).find('.choose-show-param').eq(0).text() == 'Yes'){$(this).css({'background-color':'#CCF7D5','color': '#17A534','font-weight': 'bold'});}
					  if($(this).find('.choose-show-param').eq(0).text() == 'No'){$(this).css({'background-color':'#FFDEDE','color': '#ff0000','font-weight': 'bold'});}
					  }	  					  					  
				  }									
													
													
			  });
			 
			  //date picker
			  $(".magee-form-datetime").combodate(); 
			  var year = $("select.year option:selected").text();
			  var month = $("select.month option:selected").text();
			  var day = $("select.day option:selected").text();
			  var hour = $("select.hour option:selected").text();
			  var minute = $("select.minute option:selected").text();
			  $(".magee-form-date").val(year+'-'+month+'-'+day+'  '+hour+':'+minute);
			  }});
		     
		   		
		},
		error:function(){
			}
		});
  
});

//preview
$(document).on("click",'.magee-shortcodes-preview',function(e){	
																	
					 var data1={							   
                                action:"js"
                            };
					    e.stopPropagation();
					    var preview_height = $("#TB_window").height()-40;
						
                        $("#preview").css({"display":"block","position": "absolute","width": "1200px","height":preview_height,"top": "0px","left": "-200px"});  
						
						var height = $("#preview").height()-$(".preview-title").height()-50;
						var  iframe = "<iframe id='magee-sc-form-preview' width='100%' height='"+height.toString()+"'></iframe>";	
						
					    if($("#magee-sc-form-preview").length>0){
							
						$("#magee-sc-form-preview").remove();
						}		
						$("#preview").append(iframe);	
						$.ajax({
							type: "POST",
						    url: ajaxurl,
							dataType: "html",
							data:{action: "js" },   
							success:function(data){	
							   $("#magee-sc-form-preview").contents().find("head").append(data);	
							},
							error:function(){
								}
					    });
						//$.post(ajaxurl, data1,function(responsive) {  
                                									
                        //});		
						
						var html = $('#magee_shortcodes_container form').serializeArray();
						var shortcode = $('#magee_shortcodes_container form').find("input#magee-shortcode").val();
						var data=
						$.ajax({
							type: "POST",
						    url: ajaxurl,
							dataType: "html",   
							data:{name:shortcode,  action:"say",preview:html},
							success:function(data){
								$("#magee-sc-form-preview").contents().find("body").append(data); 
								
								},   
							error:function(){
								}   
							   
						});
						
				}) ;			

$(document).on("click","a.magee-shortcodes-home",function(){
            var height = $(window).height()-150;
	        $('#TB_ajaxContent').css('height',height);		
            $("#magee-shortcodes-settings").hide();
			$("#TB_footer").remove();
		    $("#magee-shortcodes-settings-innter").html("");
		    $(".magee_shortcodes_list").show();
			$("#TB_ajaxWindowTitle").find("i").remove();
			$("#TB_ajaxWindowTitle").find("span").html('');
			$("#TB_ajaxWindowTitle").html($("#TB_ajaxWindowTitle").html().replace(/&nbsp;/g,''));
			$("#preview").css("display","none");													  
			$("#magee-sc-form-preview").remove();
		});
		
// insert shortcode into editor
$(document).on("click",".magee-shortcode-insert",function(e){

    var obj       = $(this);
	var form      = $("#magee_shortcodes_container form");
	var shortcode = form.find("input#magee-shortcode").val();

	$.ajax({
		type: "POST",
		url: ajaxurl,
		dataType: "html",
		data: { shortcode: shortcode, action: "magee_create_shortcode",attr:form.serializeArray()},
		
		success:function(data){
	
		window.magee_wpActiveEditor = window.wpActiveEditor;
		// Insert shortcode
		window.wp.media.editor.insert(data);
		// Restore previous editor
		window.wpActiveEditor = window.magee_wpActiveEditor;
tb_remove();
		},
		error:function(){
			tb_remove();
		// return false;
		}
		});
		// return false;
   });

 //iconpicker
 $(document).on("click",".iconpicker i",function(e){
    var icon = $(this).data('name');
	$('.iconpicker i').removeClass('selected');
	$(this).parent('.iconpicker').siblings('.icon-val').find('input').val(icon);
	$(this).addClass('selected');
	$(this).parent('.iconpicker').css('display','none');
  });
 
 
     // activate upload button
    $('.magee-upload-button').live('click', function(e) {
	    e.preventDefault();

        upid = $(this).attr('data-upid');

        if($(this).hasClass('remove-image')) {
            $('.magee-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', '').hide();
            $('.magee-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', '');
            $('.magee-upload-button[data-upid="' + upid + '"]').text('Upload').removeClass('remove-image');

            return;
        }

        var file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select Image',
            },
	        frame: 'post',
            multiple: false  // Set to true to allow multiple files to be selected
        });

	    file_frame.open();

        $('.media-menu a:contains(Insert from URL)').remove();

        file_frame.on( 'select', function() {
            var selection = file_frame.state().get('selection');
            selection.map( function( attachment ) {
                attachment = attachment.toJSON();

                $('.magee-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
                $('.magee-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

            });

            $('.magee-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
            $('.media-modal-close').trigger('click');
        });

	    file_frame.on( 'insert', function() {
		    var selection = file_frame.state().get('selection');
		    var size = jQuery('.attachment-display-settings .size').val();

		    selection.map( function( attachment ) {
			    attachment = attachment.toJSON();

			    if(!size) {
				    attachment.url = attachment.url;
			    } else {
				    attachment.url = attachment.sizes[size].url;
			    }

			    $('.magee-upload-button[data-upid="' + upid + '"]').parent().find('img').attr('src', attachment.url).show();
			    $('.magee-upload-button[data-upid="' + upid + '"]').parent().find('input').attr('value', attachment.url);

		    });

		    $('.magee-upload-button[data-upid="' + upid + '"]').text('Remove').addClass('remove-image');
		    $('.media-modal-close').trigger('click');
	    });
    });

    //	column remove and add
	 $(document).on('click',"a.child-clone-row-remove.magee-shortcodes-button",function(){
			
			$(this).parents(".column-shortcode-inner")	.remove();
	        
			
												 
	 });
	 $(document).on('click',"a.child-shortcode-add",function(){
			var html = '<div class="param-item"><a id="child-shortcode-remove" href="#" class="child-clone-row-remove magee-shortcodes-button ">Remove</a></div>';
			$clone = $(this).parents("#magee_shortcodes_container").children(".column-shortcode-inner").eq(0).clone(true);
			$clone.removeClass("column-shortcode-inner hidden");
			$clone.addClass("column-shortcode-inner");
			$(".shortcode-add").before($clone.append(html));	
			
	 });

	// type choose to show
	$(document).on('click','.choose-show',function(){
		$(this).each(function(){
			if($(this).find(".choose-show-param").eq(0).is(':hidden')){
			   $(this).find(".choose-show-param").eq(1).css("display","none");
			   var value = $(this).find(".choose-show-param").eq(0).attr("name");
			   $(this).parents('.param-item').find(".magee-form-choose").val(value);
			   $(this).find(".choose-show-param").eq(0).css("display","block");
			   if($(this).find(".choose-show-param").eq(0).text() == 'Yes'){$(this).css({'background-color':'#CCF7D5','color': '#17A534','font-weight': 'bold'});}
			   if($(this).find(".choose-show-param").eq(0).text() == 'No'){$(this).css({'background-color':'#FFDEDE','color': '#ff0000','font-weight': 'bold'});}
			}else{
				   $(this).find(".choose-show-param").eq(0).css("display","none");
				   var value = $(this).find(".choose-show-param").eq(1).attr("name");
				   $(this).parents('.param-item').find(".magee-form-choose").val(value);
				   $(this).find(".choose-show-param").eq(1).css("display","block");	
				   if($(this).find(".choose-show-param").eq(1).text() == 'Yes'){$(this).css({'background-color':'#CCF7D5','color': '#17A534','font-weight': 'bold'});}
				   if($(this).find(".choose-show-param").eq(1).text() == 'No'){$(this).css({'background-color':'#FFDEDE','color': '#ff0000','font-weight': 'bold'});}
			}											  
		});
	});
    // change end time for countdown
	$(document).on('change',"span.combodate select",function(){													 
		var year = $("select.year option:selected").text();
		var month = $("select.month option:selected").text();
		var day = $("select.day option:selected").text();
		var hour = $("select.hour option:selected").text();
        var minute = $("select.minute option:selected").text();
		$(".magee-form-date").val(year+'-'+month+'-'+day+'  '+hour+':'+minute);											  											  						 
	});
	//choose icon to show
	$(document).on('click',".custom_icon",function(){
			$(this).each(function(){
				$(this).parents(".param-item").find(".iconpicker").css('display','block');
			});		
	});
	$(document).on('click',".magee-preview-delete",function(){
			$("#preview").css('display','none');	
			$("#magee-sc-form-preview").remove();
	});
      
 });