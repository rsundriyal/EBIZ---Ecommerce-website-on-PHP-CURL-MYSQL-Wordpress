<?php
class Magee_Accordion {

	public static $args;
    private  $id;
	private  $num;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_accordion', array( $this, 'render_parent' ) );
        add_shortcode( 'ms_accordion_item', array( $this, 'render_child' ) );
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
				'id' =>'',
				'class' =>'',
				'style'=>'simple',
				'type' =>1
			), $args
		);
		

		extract( $defaults );
		self::$args = $defaults;
		$uniqid = uniqid('accordion-');
		$this->id = $id.$uniqid;
        $this->num = 1;

		$class .= ' style'.$type;
		
		$html = '<div class="panel-group magee-accordion accordion-'.$style.' '.esc_attr($class).'" role="tablist" aria-multiselectable="true" id="'.esc_attr($this->id).'">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>';
	    $html .= '<script>
	   jQuery(function($) {
	      if($("#magee-sc-form-preview").length>0){
			  if($("#magee-sc-form-preview").contents().find(".panel-heading").length>1){
			  num = $("#magee-sc-form-preview").contents().find(".panel-heading").length ;
				  for($i=0;$i<num;$i++){
					  $("#magee-sc-form-preview").contents().find(".panel-heading").eq($i).on("click",function(e){
					      e.preventDefault();	
						  if($(this).find("a").attr("class") == "accordion-toggle" || $(this).find("a").attr("class") == "accordion-toggle "){
						  $(this).find("a").addClass("collapsed");
						  $(this).find("a").attr("aria-expanded","false");
						  $(this).next().removeClass("in");		
						  }else{
						  $(this).find("a").removeClass("collapsed");
						  $(this).find("a").attr("aria-expanded","true");
						  $(this).next().addClass("in");
						  $(this).parent(".panel-default").siblings().find("a").addClass("collapsed");
						  $(this).parent(".panel-default").siblings().find("a").attr("aria-expanded","false");
						  $(this).parent(".panel-default").siblings().find(".panel-heading").next().removeClass("in");		
						  }
					   }); 
				  };
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
				'status' =>'',
				'icon' =>'',
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;

		if( $status == "open" ) {
		$status   = "in";
		$expanded = "true";
		$collapse = "";
		}
		else{
		$status = "";
		$expanded = "false";
		$collapse = "collapsed";
		}

        $itemId = 'collapse'.$this->id."-".$this->num;
		
		$html = '<div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="heading'.$itemId.'">
                                                        <a class="accordion-toggle '.$collapse.'" data-toggle="collapse" data-parent="#'.$this->id.'" href="#'.$itemId.'" aria-expanded="'.$expanded.'" aria-controls="'.$itemId.'">
                                                            <h4 class="panel-title">
                                                                <i class="fa '.$icon.'"></i> '.esc_attr($title).'
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <div id="'.$itemId.'" class="panel-collapse collapse '.$status.'" role="tabpanel" aria-labelledby="heading'.$itemId.'" aria-expanded="'.$expanded.'">
                                                        <div class="panel-body">
                                                          '.do_shortcode( Magee_Core::fix_shortcodes($content)).'
														  <div class="clear"></div>
                                                        </div>
                                                    </div>
                                                </div>';
         
$this->num++;
       
		return $html;
	}


}

new Magee_Accordion();