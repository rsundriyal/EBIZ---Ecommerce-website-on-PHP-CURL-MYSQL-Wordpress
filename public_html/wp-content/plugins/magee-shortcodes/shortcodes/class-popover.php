<?php
class Magee_Popover {

	public static $args;
    private  $id;
	private  $num;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_popover', array( $this, 'render' ) );
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
				'id' 					=>'magee-popover',
				'class' 				=>'',
				'title'					=>'',	
				'triggering_text' 		=>'',
				'trigger'				=>'click',
				'placement'				=>'top',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$uniqid = uniqid('popover-');
		$this->id = $id.$uniqid;
			
		$html= sprintf('<span class="popover-preview %s" id="%s" data-toggle="popover" data-trigger="%s" data-placement="%s" 
		data-content="%s" data-original-title="%s" >%s</span>',$class,$id,$trigger,$placement,do_shortcode( Magee_Core::fix_shortcodes($content)),$title,$triggering_text);
		$html .= "<script>
		jQuery(function($){
			if(jQuery('#magee-sc-form-preview').length>0){
				$('#magee-sc-form-preview').ready(function(){
					$('#magee-sc-form-preview').contents().find('.popover-preview').css({\"position\":\"relative\",\"top\":\"100px\",\"left\":\"200px\"});
					$('#magee-sc-form-preview').contents().find('.popover-preview').on('".$trigger."',function(){
						if($('#magee-sc-form-preview').contents().find('.popover').length>0){
						$('#magee-sc-form-preview').contents().find('.popover').remove();
						}else{
						var html = '<div class=\"popover-preview-hidden popover fade ".$placement." in\" role=\"tooltip\" id=\"$uniqid\" style=\"display: block;\"><div class=\"arrow\"></div><h3 class=\"popover-title\">".$title."</h3><div class=\"popover-content\">".do_shortcode( Magee_Core::fix_shortcodes($content))."</div></div>';			
						$('#magee-sc-form-preview').contents().find('span').after(html);	
						var hidden = $('#magee-sc-form-preview').contents().find('.popover-preview-hidden');
							if(hidden.attr('class').indexOf('top')>=0){
								size = ($('#magee-sc-form-preview').contents().find('.popover-preview').width()/2+200-hidden.width()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":\"25px\",\"left\":size+\"px\"});}
							if(hidden.attr('class').indexOf('bottom')>=0){
								size = ($('#magee-sc-form-preview').contents().find('.popover-preview').width()/2+200-hidden.width()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":\"116px\",\"left\":size+\"px\"});}
							if(hidden.attr('class').indexOf('left')>=0){
								size_width = (200-(hidden.width()+10)).toString();
								size_height = ($('#magee-sc-form-preview').contents().find('.popover-preview').height()/2+100-hidden.height()/2).toString();
								hidden.css({\"position\":\"absolute\",\"top\":size_height+\"px\",\"left\":size_width+\"px\"});}
							if(hidden.attr('class').indexOf('Right')>=0){
								size_width = (200+$('#magee-sc-form-preview').contents().find('.popover-preview').width()).toString();
								size_height = ($('#magee-sc-form-preview').contents().find('.popover-preview').height()/2+100-hidden.height()/2).toString();
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

new Magee_Popover();