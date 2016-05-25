<?php
class Magee_Document {

    public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_document', array( $this, 'render' ) );
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
				'width'                 =>'',
				'height'                =>'',
				'responsive'            =>'',
				'url'                   =>'',
				'viewer'                =>'',
			), $args
		);
        extract( $defaults );
		self::$args = $defaults;
		
		$html = '';
		switch(esc_attr($viewer)){
		case 'google':
		$html .= '<div id="'.esc_attr($id).'" class="magee-document ' .esc_attr($class) . '" ><iframe src="//docs.google.com/viewer?url='.esc_url($url) .'&embedded=true" width="' . esc_attr($width) . 'px" height="'.esc_attr($height). 'px" ></iframe></div>';
		break;
		case 'microsoft':
		$html .= '<div id="'.esc_attr($id).'" class="magee-document ' .esc_attr($class) . '"><iframe src="//view.officeapps.live.com/op/embed.aspx?src='.esc_url($url) .'" width="' . esc_attr($width) . 'px" height="' .  esc_attr($height) . 'px" class="su-document' .esc_attr($class) . '" id="'.esc_attr($id).'"></iframe></div>';
		break;
		}
		
		if($responsive == 'yes'):
		$html .= '<script>';
		$html .= 'jQuery(function($) {
					 if($("#magee-sc-form-preview").length>0){
					 $("#magee-sc-form-preview").ready(function(){
					 width = $("#magee-sc-form-preview").contents().find(".magee-document").width();
						 if(width < '.$width.'){
						 op = '.$height.'/'.$width.';
						 $("#magee-sc-form-preview").contents().find("iframe").eq(0).width(width);
						 $("#magee-sc-form-preview").contents().find("iframe").eq(0).height(op*width);
						 }
					 });
					 }else{
					 $(document).ready(function(){
					  width = $(".magee-document").width();
						 if(width < '.$width.'){
						 op = '.$height.'/'.$width.';
						 $("iframe").eq(0).width(width);
						 $("iframe").eq(0).height(op*width);
						 }
					 });
					 }				  
			      });';	 
		$html .= '</script>';
		endif;
		
		return $html;
		
   }
}

new Magee_Document();		