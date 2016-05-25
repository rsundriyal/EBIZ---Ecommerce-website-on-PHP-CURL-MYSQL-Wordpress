<?php
class Magee_List {

	public static $args;
    private  $id;
	private  $icon_a;
	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_shortcode( 'ms_list', array( $this, 'render_parent' ) );
        add_shortcode( 'ms_list_item', array( $this, 'render_child' ) );
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
				'icon' 					=>'',
				'icon_color' 			=>'',
				'icon_boxed' 			=>'no',
				'background_color' 		=>'',
				'boxed_shape' 			=>'circle',
				'item_border' 			=>'no',
				'item_size' 			=>'12px',
				'class' 				=>'',

			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
        if(is_numeric($item_size))
		$item_size = $item_size.'px';
		  
		$uniq_class = uniqid('list-');
		$class = ' '.$uniq_class;
    	$this->icon_a=$icon;
		

		if($item_border == 'yes')
		{
		   $class .=  ' magee-icon-list icon-list-border';
		}
		 
		if($icon_boxed == 'yes'){
			$class .=  ' '.$uniq_class.'-icon-list-'.$boxed_shape;
		}
		if( stristr($icon,'fa-')):
		$textstyle=' .'.$uniq_class.' ul {margin: 0;} .'.$uniq_class.' li{list-style-type: none;padding-bottom: .8em;position: relative;padding-left: 2em;font-size:'.$item_size.'}
			.'.$uniq_class.' li i{text-align: center;width: 1.6em;height: 1.6em;line-height: 1.6em;position: absolute;top: 0;
				left: 0;background-color: '.$background_color.';color: '.$icon_color.';} 
			.'.$uniq_class.'-icon-list-circle li i {border-radius: 50%;} .'.$uniq_class.'-icon-list-square li i {border-radius: 0;}';
		else:
		$textstyle=' .'.$uniq_class.' ul {margin: 0;} .'.$uniq_class.' li{list-style-type: none;padding-bottom: .8em;position: relative;padding-left: 2em;font-size:'.$item_size.'}
			.'.$uniq_class.' li img{text-align: center;width: 1.6em;height: 1.6em;line-height: 1.6em;position: absolute;top: 0;
				left: 0;background-color: '.$background_color.';color: '.$icon_color.';} 
			.'.$uniq_class.'-icon-list-circle li img{border-radius: 50%;} .'.$uniq_class.'-icon-list-square li img{border-radius: 0;}';
		endif;
		
			
		$styles = sprintf( '<style type="text/css" scoped="scoped">%s </style>', $textstyle);
		$html= sprintf(' %s<ul class="magee-icon-list %s" id="%s">%s</ul>',$styles,$class,$id,do_shortcode( Magee_Core::fix_shortcodes($content)));
				   		
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
			), $args
		);

		extract( $defaults );
		self::$args = $defaults;
		if( stristr($this->icon_a,'fa-')):				 
		$html =sprintf('<li><i class="fa %s"></i> %s</li>',$this->icon_a,do_shortcode( Magee_Core::fix_shortcodes($content)));
		else:
		$html =sprintf('<li><img src="%s" class="image_instead"/> %s</li>',$this->icon_a,do_shortcode( Magee_Core::fix_shortcodes($content))); 
		endif;
		return $html;
	}
}

new Magee_List();