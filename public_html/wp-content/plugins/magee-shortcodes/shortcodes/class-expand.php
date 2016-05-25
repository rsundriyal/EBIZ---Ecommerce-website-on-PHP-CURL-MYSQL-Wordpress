<?php
class Magee_Expand {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_expand', array( $this, 'render' ) );
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
				'more_icon'				=>'',	
				'more_text'				=>'',
				'less_icon'				=>'',	
				'less_text'				=>'',
				
			), $args
		);
		extract( $defaults );
		self::$args = $defaults;
		$uniqid = uniqid("control-");
        $html ='
		<div class="magee-expand '.esc_attr($class).'" id="'.esc_attr($id).'">
            <div class="expand-control '.$uniqid.'">';
		if( stristr($more_icon,'fa-')):
		$html	.=	'<i class="fa '.esc_attr($more_icon).'"></i> ';
		else:
		$html	.=	'<img src="'.esc_attr($more_icon).'" class="image-instead"/>';
		endif;
		$html	.=	esc_attr($more_text).'</div>
            <div class="expand-content" style="display:none;">
                '.do_shortcode( Magee_Core::fix_shortcodes($content)).'
            </div>
        </div>' ;
		$html .='
		<script>
        jQuery(function($) {
		     if("'.$less_icon.'".indexOf("fa-")>=0){
			 var more = \'<i class="fa '.esc_attr($less_icon).'"></i> '.esc_attr($less_text).'\';
			 }else{
			 var more = \'<img src="'.esc_attr($less_icon).'" class="image-instead"/>'.esc_attr($less_text).'\';
			 }
			 if("'.$more_icon.'".indexOf("fa-")>=0){
			 var less = \'<i class="fa '.esc_attr($more_icon).'"></i> '.esc_attr($more_text).'\';
			 }else{
			 var less = \'<img src="'.esc_attr($more_icon).'" class="image-instead"/>'.esc_attr($more_text).'\';
			 }
		     if($("#magee-sc-form-preview").length>0){
			 $("#magee-sc-form-preview").contents().find(".'.$uniqid.'").toggle(
				 function(){	      				  
							$(this).html(more);
						  },
				 function(){	      				  
							$(this).html(less);
						  }
				 );
			 $("#magee-sc-form-preview").contents().find(".'.$uniqid.'").click(function(){
				  $(this).parents(".magee-expand").find(".expand-content").slideToggle(500);
				 });    
			 }else{
				 $(".'.$uniqid.'").toggle(
				  function(){	      				  
							$(this).html(more);
						  },
				 function(){	      				  
							$(this).html(less);
						  }
				 );
				 $(".'.$uniqid.'").click(function(){
				  $(this).parents(".magee-expand").find(".expand-content").slideToggle(500);
				 });
			 }
		     
		   
		});
        </script>';
        return $html;
		
		
	}
}
new  Magee_Expand();		