<?php


class Magee_Timeline {

	public static $args;
    private  $id;
	private  $column;
	private  $style;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_timeline', array( $this, 'render' ) );
		add_shortcode( 'ms_timeline_item', array( $this, 'render_child' ) );
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
				'id' =>'magee-timeline',
				'class' =>'',
				'columns'=>'4',
			), $args
		);
		
		extract( $defaults );
		self::$args    = $defaults;
		$this->columns = $columns;

		$html  = '<div class="magee-timeline text-center '.esc_attr($class).'"  id="'.esc_attr($id).'"><ul class="row">';
		$html .= do_shortcode( Magee_Core::fix_shortcodes($content));
        $html .= '</ul></div>';
										
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
				'time' =>'',
				'title' =>'',
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		$columns  = absint($this->columns);
		
		if( $columns >= 5 || $columns <=0 )
		$this->columns = 5;
		
		if( $this->columns == 5 )
		$col = 'col-md-1_'.$this->columns;
		else
		$col = 'col-md-'.(12/$this->columns);
		
        $html = '<li class="feature-box timeline-box '.$col.'">
                                                <div class="timeline-year">
                                                    '.esc_attr($time).'
                                                </div>
                                                <h3>'.esc_attr($title).'</h3>
                                                <p>'.$content.'</p>
                                            </li>';
											
											

		return $html;
	}
	
	
}

new Magee_Timeline();