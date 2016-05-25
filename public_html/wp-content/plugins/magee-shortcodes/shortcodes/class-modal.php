<?php
class Magee_Modal {

	public static $args;
    private  $id;
	private  $modal_anchor_text;
	private  $modal_content;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_modal', array( $this, 'render' ) );
		add_shortcode( 'ms_modal_anchor_text', array( $this, 'render_modal_anchor_text' ) );
		add_shortcode( 'ms_modal_content', array( $this, 'render_modal_content' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'id' 					=>'',
				'class' 				=>'',
				//'name'					=>'',	
				'title' 				=>'',
				'size' 					=>'small',
				'showfooter'			=>'yes',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$uniqid = uniqid('modal-');
		$this->id = $id.$uniqid;
		
		$sz ='';
		if($size == 'small'){
		$sz='modal-sm';
		}	
		if($size == 'large'){
		$sz='modal-lg';
		}
		
		$content = do_shortcode( Magee_Core::fix_shortcodes($content));
		
		$diva=sprintf(' <span class="%s" id="%s" data-toggle="modal" data-target="#%s_ModalLg" > %s</span>',$class,$id,$uniqid,do_shortcode( Magee_Core::fix_shortcodes($this->modal_anchor_text)));
		
		$divheadra = '<a type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></a>';
		$divheadrtitle =sprintf('<h4 class="modal-title" id="%s_ModalLgLabel">%s</h4>',$uniqid,$title);
		$divheadr = sprintf('<div class="modal-header">%s %s</div>',$divheadra,$divheadrtitle);
		$divbody = sprintf('<div class="modal-body">%s</div>',do_shortcode( Magee_Core::fix_shortcodes($this->modal_content)));
		$divfooter = '<div class="modal-footer"><a type="button" class="btn-normal" data-dismiss="modal" style="color:#fff">Close</a></div>';
		$divmodelcontent = sprintf('<div class="modal-content">%s %s %s</div>',$divheadr,$divbody ,$divfooter );
		$divmodel = sprintf('<div class="modal fade" id="%s_ModalLg" tabindex="-1" role="dialog" aria-labelledby="%s_ModalLgLabel" aria-hidden="true" style="display: none;">
                             <div class="modal-dialog %s"> %s</div></div>',$uniqid,$uniqid,$sz,$divmodelcontent);
		$html= sprintf('%s %s',$diva,$divmodel);
        $html .= '<script>
		jQuery(function($) {   
		   if($("#magee-sc-form-preview").length>0){
		      $("#magee-sc-form-preview").contents().find("span").on("click",function(){
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").addClass("in");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").attr("aria-hidden","false");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").css("display","block");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").css("padding-right","17px");
			  });
			  $("#magee-sc-form-preview").contents().find(".btn-normal").on("click",function(){
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").removeClass("in");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").attr("aria-hidden","true");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").css("display","none");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").css("padding-right","");
			  });
			  $("#magee-sc-form-preview").contents().find(".close").on("click",function(){
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").removeClass("in");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").attr("aria-hidden","true");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").css("display","none");
				  $("#magee-sc-form-preview").contents().find("#'.$uniqid.'_ModalLg").css("padding-right","");
			  });
		   }
		});		
		</script>';
		
		return $html;
	}
	
	/**
	 * Render the child shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
		function render_modal_anchor_text( $args, $content = '') {
		
		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
						 
		$this->modal_anchor_text = do_shortcode( Magee_Core::fix_shortcodes($content));
		 
	}
	
	/**
	 * Render the child shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
		function render_modal_content( $args, $content = '') {
		
		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
						 
		$this->modal_content = do_shortcode( Magee_Core::fix_shortcodes($content));
	
	}
	
}

new Magee_Modal();