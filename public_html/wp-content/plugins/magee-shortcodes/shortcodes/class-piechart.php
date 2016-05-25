<?php
class Magee_Piechart {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_piechart', array( $this, 'render' ) );
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
				'class' =>'',
				'percent' => '80',
				'filledcolor'=>'#fdd200',
				'unfilledcolor'=>'#f5f5f5',
				'size' =>'200',
				'font_size' =>'40px'
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$chartID = uniqid('chart-');
		$uniq_class   = $chartID;
		$class       .= ' '.$uniq_class;
		$size         = str_replace('px','',absint($size));
		$html = '<style>.'.$uniq_class.' .chart-title{line-height: '.$size.'px;font-size:'.esc_attr($font_size).';}.'.$uniq_class.'{height:'.$size.'px;width:'.$size.'px;}</style>';
		$html .= '<div class="chart magee-chart-box '.esc_attr($class).'" data-percent="'.esc_attr($percent).'" id="'.$chartID.'">
                                                <div class="chart-title">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>
                                            </div>';
		$html .= '<script language="javascript">';
		$html .= "
		if(jQuery('#magee-sc-form-preview').length>0){
		jQuery('#magee-sc-form-preview').contents().find('#".$chartID."').easyPieChart({
                barColor: '".esc_attr($filledcolor)."',
                trackColor: '".esc_attr($unfilledcolor)."',
                scaleColor: false,
                lineWidth: 10,
                trackWidth: 10,
                size: ".absint($size).",
                lineCap: 'butt'
            }); 
		}else{
		jQuery(document).ready(function($){
		
		$('#".$chartID."').easyPieChart({
                barColor: '".esc_attr($filledcolor)."',
                trackColor: '".esc_attr($unfilledcolor)."',
                scaleColor: false,
                lineWidth: 10,
                trackWidth: 10,
                size: ".absint($size).",
                lineCap: 'butt'
            }); });}";

		$html .= '</script>';									
		return $html;
	} 
	
}

new Magee_Piechart();