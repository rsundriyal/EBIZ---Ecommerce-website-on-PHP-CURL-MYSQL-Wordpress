<?php


class Magee_Countdowns {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_countdowns', array( $this, 'render' ) );
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
				'id' =>'magee-countdowns',
				'class' =>'',
				'topicon' => '',
				'fontcolor' => '',
				'backgroundcolor' => '',
				'endtime' => date('Y-m-d H:i:s',strtotime(' 1 month')),
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$countdownsID = uniqid('countdowns');
		$addclass = uniqid('countdown');
		$class .= ' '.$addclass;
		$css_style = '';
		$boxed = '';
		if( $backgroundcolor )
		$css_style .= '#'.$countdownsID.' .magee-counter-box{background-color:'.$backgroundcolor.';}';
		$boxed = 'boxed';
		if( $fontcolor)
		$css_style .= '#'.$countdownsID.' .magee-counter-box h3.counter-title{color:'.$fontcolor.'; }';
		$css_style .= '#'.$countdownsID.' .magee-counter-box{color:'.$fontcolor.';}';
		$html = '<style type="text/css">'.$css_style.'</style>';
		
		$html .= '<div class="magee-countdown-wrap center-block '.esc_attr($class).'" id="'.esc_attr($id).'">
                                        <ul class="magee-countdown row" id="'.$countdownsID.'">
                                            <li class="col-sm-3">
											  <div class="magee-counter-box '.$boxed.'">
                                                <div class="counter days">
                                                    <span class="counter-num"></span>
                                                </div>
                                                <h3 class="counter-title">
                                                    '.__('Days','magee-shortcodes' ).'
                                                </h3>
											  </div>
                                            </li>
                                            <li class="col-sm-3">
											  <div class="magee-counter-box '.$boxed.'">
                                                <div class="counter hours">
                                                    <span class="counter-num"></span>
                                                </div>
                                                <h3 class="counter-title">
                                                    '.__('Hours','magee-shortcodes' ).'
                                                </h3>
											  </div>	
                                            </li>
                                            <li class="col-sm-3">
											 <div class="magee-counter-box '.$boxed.'">
                                                <div class="counter minutes">
                                                    <span class="counter-num"></span>
                                                </div>
                                                <h3 class="counter-title">
                                                    '.__('Minutes','magee-shortcodes' ).'
                                                </h3>
											  </div>	
                                            </li>
                                            <li class="col-sm-3">
											  <div class="magee-counter-box '.$boxed.'">
                                                <div class="counter seconds">
                                                    <span class="counter-num"></span>
                                                </div>
                                                <h3 class="counter-title">
                                                    '.__('Seconds','magee-shortcodes' ).'
                                                </h3>
											  </div>	
                                            </li>
                                        </ul>
                                    </div>';
		$html .= '<script language="javascript">';
		$html .= 'jQuery(function($) {';
		$html .= 'if($("#magee-sc-form-preview").length>0){';
		$html .= '$("#magee-sc-form-preview").ready(function(){
		$("#magee-sc-form-preview").contents().find("#'.$countdownsID.'").countdown("'.$endtime.'", function(event) {
                $("#magee-sc-form-preview").contents().find("#'.$countdownsID.' .days .counter-num").text(
                    event.strftime("%D")
                );
                $("#magee-sc-form-preview").contents().find("#'.$countdownsID.' .hours .counter-num").text(
                    event.strftime("%H")
                );
                $("#magee-sc-form-preview").contents().find("#'.$countdownsID.' .minutes .counter-num").text(
                    event.strftime("%M")
                );
                $("#magee-sc-form-preview").contents().find("#'.$countdownsID.' .seconds .counter-num").text(
                    event.strftime("%S")
                );
            });
			});}else{';
		$html .= '$(document).ready(function(){
		        $("#'.$countdownsID.'").countdown("'.$endtime.'", function(event) {
                $("#'.$countdownsID.' .days .counter-num").text(
                    event.strftime("%D")
                );
                $("#'.$countdownsID.' .hours .counter-num").text(
                    event.strftime("%H")
                );
                $("#'.$countdownsID.' .minutes .counter-num").text(
                    event.strftime("%M")
                );
                $("#'.$countdownsID.' .seconds .counter-num").text(
                    event.strftime("%S")
                );
            });
			
				});}';
		$html .= '})';		
		$html .= '</script>';
											
		return $html;
	} 
	
}

new Magee_Countdowns();