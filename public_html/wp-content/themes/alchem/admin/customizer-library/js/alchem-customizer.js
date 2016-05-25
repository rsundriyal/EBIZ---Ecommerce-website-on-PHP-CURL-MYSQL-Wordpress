jQuery(document).ready( function( $ ) {
			
			$('#customize-theme-controls > ul').append('<li id="accordion-section-alchem-forums" class="accordion-section control-section control-section-forums" style="display: list-item;padding: 20px 10px 0;background: #fff;"><a href="https://www.mageewp.com/forums/alchem-theme/" target="_blank" class="">'+alchem_params.btn_forum+'</a></li>');
			
			$('#customize-theme-controls > ul').append('<li id="accordion-section-documentation" class="accordion-section control-section control-section-alchem-documentation" style="display: list-item;padding: 10px 10px 20px;background: #fff;"><a href="https://www.mageewp.com/manuals/theme-guide-alchem.html" target="_blank" class="">'+alchem_params.btn_documentation+'</a></li>');
								 
			if(alchem_params.theme_options_version=='1'){
		   $('#customize-theme-controls > ul').prepend('<li id="accordion-section-importer" class="accordion-section control-section control-section-importer" style="display: list-item;padding: 20px 10px 0;background: #fff;"><a href="#" id="import-theme-options" class="button">'+alchem_params.import_options+'</a><div class="import-status"></div><p>'+alchem_params.transfer+'</p></li>');
		   $(document).on('click','#import-theme-options',function(){
				   $('#accordion-section-importer .import-status').text(alchem_params.loading);									   
						$.ajax({type:"POST",dataType:"html",url:alchem_params.ajaxurl,data:"action=alchem_otpions_customize",
							success:function(data){
								  $('#accordion-section-importer .import-status').text(alchem_params.complete);
								 location.reload() ;
								},error:function(){
									$('#accordion-section-importer .import-status').text(alchem_params.error);		
									}});
                   });
			}
			
			$('#customize-info .preview-notice').append('<a href="https://www.mageewp.com/alchem-theme.html" style="margin-top:5px;background-color :#EA6F60;color: #fff; border: 0;" class="button alchem-pro-btn" target="_blank">'+alchem_params.btn_pro+'</a>');
					
			
		   } );