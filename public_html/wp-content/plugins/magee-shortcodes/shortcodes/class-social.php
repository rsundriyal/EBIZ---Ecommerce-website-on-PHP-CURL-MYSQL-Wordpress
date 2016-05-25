<?php
class Magee_Social {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_social', array( $this, 'render' ) );
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
				'id' 					=>'magee-social',
				'class' 				=>'',
				'icon_size'				=>'',
				'effect_3d'				=>'no',
				'title'					=>'',
				'icon'					=>'',
				'iconlink'				=>'#',
				'iconcolor'				=>'#A0A0A0',
				'backgroundcolor'		=>'transparent',
				'iconboxedradius'		=>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($icon_size))
		$icon_size = $icon_size.'px';
		
		$uniqid = uniqid('social-');
		$this->id = $id.$uniqid;

		$uqid =  uniqid('tab');
		$sty3d='';
		$textstyle = sprintf(' .%s_social_icon_acolor{ color: %s !important ; background-color: %s !important; font-size: %s; }',
			$uqid,$iconcolor,$backgroundcolor,$icon_size);
		$styles = sprintf( '<style type="text/css" scoped="scoped">%s </style>', $textstyle);
		
		if ( $effect_3d=='yes')
		{
			$sty3d .=' icon-3d';
		}	
		
		switch($iconboxedradius)
		{
			case 'normal':

				break;					
			case 'boxed':
					$sty3d .=' icon-boxed';
				break;
			case 'rounded':
					$sty3d .=' icon-boxed rounded';
				break;
			case 'circle':
					$sty3d .=' icon-boxed circle';
				break;
		}
		
		if( stristr($icon,'fa-')):	
		$html=sprintf(' %s <a href="%s" Id="%s" class="fa %s magee-icon  %s %s %s_social_icon_acolor" data-toggle="tooltip" data-placement="top" title="" data-original-title="%s"></a>',
			$styles,$iconlink,$id,$icon,$sty3d,$class,$uqid,$title);
		else:
		$html=sprintf(' %s <a href="%s" Id="%s" class="fa magee-icon  %s %s %s_social_icon_acolor" data-toggle="tooltip" data-placement="top" title="" data-original-title="%s"><img src="%s" class="image_instead"/></a>',$styles,$iconlink,$id,$sty3d,$class,$uqid,$title,$icon);
			
		endif;
		$html .= "<script>
	    jQuery(function($) {
	      if($('#magee-sc-form-preview').length>0){
		  $('#magee-sc-form-preview').contents().find('a.magee-icon').css({\"position\":\"relative\",\"top\":\"50px\",\"left\":\"200px\"});
				 $('#magee-sc-form-preview').contents().find('a.magee-icon').on('click',function(e){
				    if($(this).attr('href') == '#'){
					   e.preventDefault();
				    }
				 });
				 $('#magee-sc-form-preview').contents().find('a.magee-icon').on('hover',function(){
				     if($('#magee-sc-form-preview').contents().find('#tooltip-hidden').length>0){
					   $('#magee-sc-form-preview').contents().find('#tooltip-hidden').remove();
					   }else{
					   var html = '<div class=\"tooltip fade top in\" id=\"tooltip-hidden\" role=\"tooltip\" style=\"display: block;\"><div class=\"tooltip-arrow\"></div><div class=\"tooltip-inner\">".$title."</div></div>';
					   $('#magee-sc-form-preview').contents().find('a.magee-icon').after(html);
					   var hidden = $('#magee-sc-form-preview').contents().find('#tooltip-hidden');
					   size = ($('#magee-sc-form-preview').contents().find('a.magee-icon').width()/2+200-hidden.width()/2).toString();
					   hidden.css({\"position\":\"absolute\",\"top\":\"20px\",\"left\":size+\"px\"});
					   }				   
			     });  
			  }
		  });           
		</script>";		
		return $html;
	}
	
}

new Magee_Social();