<?php


class Magee_Progress {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_progress', array( $this, 'render' ) );
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
				'id' 				=>'',
				'class' 			=>'',
				//'style'				=>'normal',
				'percent'           => '50',
				'text'              =>'',
				'height'            => 30,
				'color'        =>'',
				'direction'        => 'left',
				'textposition'     => 'on',
				'number' => 'yes',
				'rounded' =>'on',
				'striped' =>'none',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$percent = str_replace('%','',$percent);
		$percent = esc_attr($percent).'%';
		$css_style = 'width: '.esc_attr($percent).';';
		if(is_numeric($height))
		$height      = $height.'px';
		$line_height = '';
		$bar_height  = '';
		if( $height ){
		$bar_height = 'height:'.esc_attr($height).';';
		$line_height = 'line-height:'.esc_attr($height).'';
		}
		
		if( $direction == 'left' ){
			$a = 'left';
			$b = 'right';
			}
			else{
			 $a = 'right';
			 $b = 'left';
				}
		  $progress = '';
		  $progress_bar = '';
		  
		if( $textposition == 'above' ){
			$progress .= ' progress-sm';
			}
			
		
        if($number == 'no')
		$percent = '';
		if($rounded == 'on')
		$progress .= ' rounded';
		
		if($striped == 'none')
		$progress_bar .= ' none-striped';
		if($striped == 'striped')
		$progress_bar .= ' progress-bar-striped';
		if($striped == 'striped animated')
		$progress_bar .= ' progress-bar-striped animated hinge infinite';
		
		
		
		
		if( $color )
		$css_style .= 'background-color:'.esc_attr($color).';'; 
		
		$html = '<div class="magee-progress-box '.esc_attr($class).'" id="'.esc_attr($id).'">';
		
			if( $textposition == '2' ){
				$html .= '<div class="porgress-title text-'.$a.' clearfix">'.esc_textarea($text).' <div class="pull-'.$b.'">'.esc_attr($percent).'</div></div>';
				}
			  $html .= '<div class="progress '.$progress.'" style="'.$bar_height.'">
                                                    <div class="progress-bar pull-'.$a.' '.esc_attr($progress_bar).'" role="progressbar" aria-valuenow="'.esc_textarea($text).'" aria-valuemin="0" aria-valuemax="100" style="'.$css_style.'">';
			if( $textposition == '1' ){								
              $html .= '<div class="progress-title text-'.$a.' clearfix" style="'.$line_height.'">'.esc_textarea($text).' <div class="pull-'.$b.'">'.esc_attr($percent).'</div></div>';
			}
              $html .= ' </div></div>';
			  											
	   $html .= '</div>';
		return $html;
	} 
	
}

new Magee_Progress();