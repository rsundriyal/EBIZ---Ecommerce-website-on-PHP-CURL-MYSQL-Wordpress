<?php
class Magee_Tabs {

	public static $args;
    private  $id;
	private  $num;
	private  $item_tital;
	private  $colorid;
	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_tabs', array( $this, 'render_parent' ) );
        add_shortcode( 'ms_tab', array( $this, 'render_child' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render_parent( $args, $content = '') {

		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'id' 					=>'',
				'class' 				=>'',
				'title_color'			=>'',
				'style'					=>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$uniqid = uniqid('tabs-');
		$this->id = $id.$uniqid;
        $this->num = 1;
		$this->item_tital='';
		$this->colorid = uniqid('tab');
		$items_content = do_shortcode(Magee_Core::fix_shortcodes($content));		
		$txtsty1='';
		$tab_content_class = '';
		
		switch($style)
		{
			case 'simple':
				$class .=' tab-line ';
				$txtsty1 = ' list-inline ';
				break;
			case 'simple justified':
				$class .=' tab-line ';
				$txtsty1 = ' list-inline nav-justified ';
				break;
			case 'button':
				$class .=' tab-pills ';
				$txtsty1 = ' nav nav-pills ';
				break;
			case 'button justified':
				$class .=' tab-pills ';
				$txtsty1 = ' nav nav-pills nav-justified';
				break;
			case 'normal':
				$class .=' tab-normal ';
				$txtsty1 = ' nav nav-tabs ';
				break;
			case 'normal justified':
				$class .=' tab-normal ';
				$txtsty1 = ' nav nav-tabs nav-justified';
				break;
			case 'vertical':
				$class .=' tab-normal tab-vertical tab-vertical-left clearfix ';
				$txtsty1 = ' nav nav-tabs nav-stacked pull-left ';
				$tab_content_class = 'pull-left';
				break;
			case 'vertical right':
				$class .=' tab-normal tab-vertical tab-vertical-right clearfix ';
				$txtsty1 = ' nav nav-tabs nav-stacked pull-right ';
				break;
		}
		
		
		$textstyle = ' .'.$this->colorid.', .'.$this->colorid.' i{color:'.$title_color.'}';
		$styles = sprintf( '<style type="text/css" scoped="scoped">%s </style>', $textstyle);
		$html= $styles.'<div class="magee-tab-box '.$class.'" role="tabpanel" data-example-id="togglable-tabs id='.$id.'">
               <ul id="myTab1" class="list-inline '.$txtsty1.'" role="tablist">'.$this->item_tital.'
               </ul><div id="myTabContent" class="tab-content '.$tab_content_class.'">'.$items_content.'</div></div>';
		$html .= '<script>
		jQuery(function($) {
	      if($("#magee-sc-form-preview").length>0){
		     if($("#magee-sc-form-preview").contents().find(".magee-tab-box>ul>li").length>0){
				 num = $("#magee-sc-form-preview").contents().find(".magee-tab-box>ul>li").length;
				 for($i=0;$i<num;$i++){
					 $("#magee-sc-form-preview").contents().find(".magee-tab-box>ul>li").eq($i).on("click",function(e){
					     e.preventDefault();	  
						 if($(this).attr("class") == ""){
						 $(this).addClass("active").siblings().attr("class",""); 
						 $(this).find("a").attr("aria-expanded","true");
						 $(this).siblings().find("a").attr("aria-expanded","false");
						 $(this).parents(".magee-tab-box").find(".tab-pane").eq($(this).index()).addClass("active in").siblings().removeClass("active in");
						 }
					 });
				 }
			 
			 }
		  
		  
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
	function render_child( $args, $content = '') {
		
		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'title' =>'',
				'icon' =>'',
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		$itemId = ' '.$this->id."-".$this->num;
		
		$tabid = uniqid('tab-');
		
		$txtstyle='';
		$txtbl = ' falas';
		$txtat = '' ;
		if($this->num == 1)
		{
			$txtstyle='active';
			$txtbl = 'true';
			$txtat = 'active in';
		}
        $this->item_tital .= sprintf(' <li role="presentation" class="'.$txtstyle.'"><a href="#'.$tabid.'" id="'.$tabid.'-tab" role="tab" data-toggle="tab" aria-controls="'.$tabid.'" aria-expanded="'.$txtbl.'"><h4 class="tab-title '.$this->colorid.' "> <i class="fa '.$icon.'"></i>'.$title.'</h4></a></li>');
				 
		 $html = '<div role="tabpanel" class="tab-pane fade '.$txtat.'" id="'.$tabid.'"><p>'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</p></div>';
		 
  		$this->num++;
		return $html;
	}
}

new Magee_Tabs();