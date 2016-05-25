<?php
class Magee_Tooltip {

	public static $args;
    private  $id;


	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_tooltip', array( $this, 'render' ) );
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
				'title'					=>'',	
				'trigger'				=>'click',
				'placement'				=>'top',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;

		
		$html= sprintf('<span class="%s tooltip-text" id="%s" data-toggle="tooltip" data-trigger="%s" data-placement="%s" data-original-title="%s" >%s</span>',$class,$id,$trigger,$placement,$title,do_shortcode( Magee_Core::fix_shortcodes($content)));
        $html .= "<script>
		jQuery(function($){
			if(jQuery('#magee-sc-form-preview').length>0){
				$('#magee-sc-form-preview').ready(function(){
				$('#magee-sc-form-preview').contents().find('.tooltip-text').css({\"position\":\"relative\",\"top\":\"50px\",\"left\":\"200px\"});
					$('#magee-sc-form-preview').contents().find('.tooltip-text').on('".$trigger."',function(){
					   if($('#magee-sc-form-preview').contents().find('#tooltip-hidden').length>0){
					   $('#magee-sc-form-preview').contents().find('#tooltip-hidden').remove();
					   }else{
					   var html = '<div class=\"tooltip fade ".$placement." in\" id=\"tooltip-hidden\" role=\"tooltip\" style=\"display: block;\"><div class=\"tooltip-arrow\"></div><div class=\"tooltip-inner\">".$title."</div></div>';
					   $('#magee-sc-form-preview').contents().find('span.tooltip-text').after(html);
					   var hidden = $('#magee-sc-form-preview').contents().find('#tooltip-hidden');
							if(hidden.attr('class').indexOf('top')>=0){
								size = ($('#magee-sc-form-preview').contents().find('.tooltip-text').width()/2+200-hidden.width()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":\"25px\",\"left\":size+\"px\"});}
							if(hidden.attr('class').indexOf('bottom')>=0){
								size = ($('#magee-sc-form-preview').contents().find('.tooltip-text').width()/2+200-hidden.width()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":\"68px\",\"left\":size+\"px\"});}
							if(hidden.attr('class').indexOf('left')>=0){
								size_width = (200-(hidden.width()+10)).toString();
								size_height = ($('#magee-sc-form-preview').contents().find('.tooltip-text').height()/2+50-hidden.height()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":size_height+\"px\",\"left\":size_width+\"px\"});}
							if(hidden.attr('class').indexOf('right')>=0){
								size_width = (200+$('#magee-sc-form-preview').contents().find('.tooltip-text').width()).toString();
								size_height = ($('#magee-sc-form-preview').contents().find('.tooltip-text').height()/2+50-hidden.height()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":size_height+\"px\",\"left\":size_width+\"px\"});}	   
					   }  

					});
					
				});
		    }
		});
		</script>";	
		return $html;
	}
	
}

new Magee_Tooltip();