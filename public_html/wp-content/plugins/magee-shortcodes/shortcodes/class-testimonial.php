<?php
class Magee_Testimonial {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_testimonial', array( $this, 'render' ) );
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
				'style'					=>'normal',
				'name'					=>'',
				'avatar'					=>'',
				'byline'			=>'',
				'alignment'				=>'none',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$txtalign='';
		$txtbox='';
		$txtsl = 'style1';				
		if($alignment=='center')
		{
			$txtalign='text-center';
			$txtsl = 'style2';
		}
		if($style == 'box')
		{
			$txtbox='testimonial-boxed';
		}
		$divcont = sprintf('<div class="testimonial-content"><div class="testimonial-quote">%s</div></div>',do_shortcode( Magee_Core::fix_shortcodes($content)));
		$divimg = sprintf('<div class="testimonial-avatar"><img src="%s" class="img-circle"></div>',$avatar);
		$divauthor = sprintf('<div class="testimonial-author"><h4 class="name" style="text-transform: uppercase;color: #000;">%s</h4><div class="title">%s</div></div>',$name,$byline);
		$divtitle = sprintf('<div class="testimonial-vcard %s"> %s %s </div>',$txtsl,$divimg,$divauthor);
		$html = sprintf('<div class="magee-testimonial-box %s %s %s" is="%s">%s %s</div>',$txtalign,$txtbox,$class,$id,$divcont,$divtitle);		
   	
		return $html;
	}
	
}

new Magee_Testimonial();