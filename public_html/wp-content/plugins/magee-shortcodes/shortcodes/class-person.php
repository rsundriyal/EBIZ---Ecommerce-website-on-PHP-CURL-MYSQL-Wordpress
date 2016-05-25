<?php
class Magee_Person {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_person', array( $this, 'render' ) );
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
				'name'					=>'',
				'style'                 =>'',	
				'title' 				=>'',
				'link_target'           =>'',
				'overlay_color'         =>'',
				'overlay_opacity'       =>'0.5',
				'picture' 				=>'',
				'piclink'				=>'#',	
				'picborder' 			=>'0',
				'picbordercolor' 		=>'',
				'picborderradius'		=>'0',
				'iconboxedradius'		=>'4px',
				'iconcolor'				=>'#595959',	
				'link1'					=>'#',
				'link2' 				=>'#',
				'link3'					=>'#',				
				'link4' 				=>'#',
				'link5' 				=>'#',
				'icon1'					=>'',
				'icon2' 				=>'',
				'icon3'					=>'',				
				'icon4' 				=>'',
				'icon5' 				=>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($picborder))
		$picborder = $picborder.'px';
		if(is_numeric($picborderradius))
		$picborderradius = $picborderradius.'px';
		if(is_numeric($iconboxedradius))
		$iconboxedradius = $iconboxedradius.'px';
		
		$uniqid = uniqid('person-');
		$this->id = $id.$uniqid;
        $class .= ' '.$uniqid;
		$add_class = 'col-sm-6';
		
		if($overlay_color !='')
		$overlay_color = str_replace('#','',$overlay_color);
		$r = hexdec(substr($overlay_color,0,2)) ;
		$g = hexdec(substr($overlay_color,2,2)) ;
		$b = hexdec(substr($overlay_color,4,2)) ;		
		$textstyle1 = sprintf('.'.$uniqid.' .person-vcard.person-social li a i{ border-radius: %s; background-color:%s;}',$iconboxedradius,$iconcolor);
		$textstyle1 .= sprintf('.'.$uniqid.' .person-vcard.person-social li a img{ border-radius: %s; background-color:%s;}',$iconboxedradius,$iconcolor);
		$textstyle2 = sprintf('.'.$uniqid.' .img-box img{ border-radius: %s; display: inline-block;}',$picborderradius);
		
		$imgstyle = '';
		if( $picborder !='' )
		$imgstyle .= sprintf('.'.$uniqid.' .img-box img{border-width: %s;border-style: solid;}',$picborder);
		
		if( $picbordercolor !='' )
		$imgstyle .= sprintf('.'.$uniqid.' .img-box img{border-color: %s;}',$picbordercolor);
		if( $style == 'beside'){
        $afterstyle = '.person-vcard .person-title:after{margin-left:0;}';
		$leftstyle1 = '.person-social{text-align:left;}' ;
		$leftstyle2 = '.person-social li a i{margin-left:6px;} ' ;
 		$styles = sprintf( '<style type="text/css" scoped="scoped">%s %s %s %s %s %s</style>', $textstyle1,$textstyle2,$imgstyle,$afterstyle,$leftstyle1,$leftstyle2);
		}else{
		$styles = sprintf( '<style type="text/css" scoped="scoped">%s %s %s</style>', $textstyle1,$textstyle2,$imgstyle);
		}
		if($overlay_opacity !='')
		$divimgtitle =sprintf( '<div class="img-overlay primary" style="background-color:rgba(%s,%s,%s,%s);"><div class="img-overlay-container"><div class="img-overlay-content"><i class="fa fa-link"></i></div></div></div>',$r,$g,$b,$overlay_opacity);
		
		$divimga = sprintf('<a target="%s" href="%s" ><img src="%s">%s</a>',$link_target,$piclink,$picture,$divimgtitle);	
		if( $style == 'beside'){
		$divimg = sprintf('<div class="person-img-box %s"><div class="img-box figcaption-middle text-center fade-in">%s</div></div>',$add_class,$divimga);}
		else{
		$divimg = sprintf('<div class="person-img-box"><div class="img-box figcaption-middle text-center fade-in">%s</div></div>',$divimga);
		}
		$divname = sprintf('<h3 class="person-name" style="text-transform: uppercase;">%s</h3>',$name);


		$divtitle = sprintf('<h4 class="person-title" style="text-transform: uppercase;">%s</h4>',$title);

		
		$divcont = sprintf('<p class="person-desc">%s</p>',do_shortcode( Magee_Core::fix_shortcodes($content)));
		$divli = '';
		if($icon1 != ''){
		    if( stristr($icon1,'fa-')):
			$divli .= sprintf(' <li><a href="%s"><i class="fa %s"></i></a></li>',$link1,$icon1);
			else:
			$divli .= sprintf(' <li><a href="%s"><img src="%s" class="image_instead"/></i></a></li>',$link1,$icon1);
			endif;
			
		}
		if($icon2 != ''){
		    if( stristr($icon2,'fa-')):
			$divli .= sprintf(' <li><a href="%s"><i class="fa %s"></i></a></li>',$link2,$icon2);
			else:
			$divli .= sprintf(' <li><a href="%s"><img src="%s" class="image_instead"/></i></a></li>',$link2,$icon2);
			endif;  
		}
		if($icon3 != ''){
			if( stristr($icon3,'fa-')):
			$divli .= sprintf(' <li><a href="%s"><i class="fa %s"></i></a></li>',$link3,$icon3);
			else:
			$divli .= sprintf(' <li><a href="%s"><img src="%s" class="image_instead"/></i></a></li>',$link3,$icon3);
			endif;
		}
		if($icon4 != ''){
			if( stristr($icon4,'fa-')):
			$divli .= sprintf(' <li><a href="%s"><i class="fa %s"></i></a></li>',$link4,$icon4);
			else:
			$divli .= sprintf(' <li><a href="%s"><img src="%s" class="image_instead"/></i></a></li>',$link4,$icon4);
			endif;
		}
		if($icon5 != ''){
			if( stristr($icon5,'fa-')):
			$divli .= sprintf(' <li><a href="%s"><i class="fa %s"></i></a></li>',$link5,$icon5);
			else:
			$divli .= sprintf(' <li><a href="%s"><img src="%s" class="image_instead"/></i></a></li>',$link5,$icon5);
			endif;
		}	
		if( $style == 'beside'){
		
		$divul=sprintf('<div class="person-vcard text-left %s">%s %s %s<ul class="person-social" >%s</ul></div>',$add_class,$divname,$divtitle,$divcont,$divli);
		}else{
		$divul=sprintf('<div class="person-vcard text-center">%s %s %s<ul class="person-social" >%s</ul></div>',$divname,$divtitle,$divcont,$divli);
		}	
		if( $style == 'beside'){						
		$html=sprintf('%s<div class="magee-person-box %s person-box-horizontal row" id = "%s">%s %s</div>',$styles,$class,$id,$divimg,$divul);
        }else{
		$html=sprintf('%s<div class="magee-person-box %s " id = "%s">%s %s</div>',$styles,$class,$id,$divimg,$divul);
		}
		
		return $html;
	}
	
}

new Magee_Person();