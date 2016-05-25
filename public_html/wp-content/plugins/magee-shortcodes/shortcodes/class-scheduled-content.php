<?php
class Magee_Scheduled_content {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_scheduled_content', array( $this, 'render' ) );
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
				'time'               => '',
				'day_week'           => '',
				'day_month'          => '',
				'months'              => '',
				'years'               => '',
				'class'              => '',
				'id'                 => '',
			), $args
		);
		extract( $defaults );
		self::$args = $defaults;
		$html = '<div class="'.esc_attr($class).'" id="'.esc_attr($id).'">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</div>';
		if($time !== ''){
			  
		      $time = preg_replace( "/[^0-9-,:]/", '', esc_attr($time) );
			 
			  if($time !== ''):
			  
			  $time = explode(',',$time);
			  $count = count($time);
			  
			  for($i=0;$i<$count;$i++){
			  if(stristr($time[$i],'-')){
			  $time[$i] = explode('-',$time[$i]);
			  $time[$i] = range($time[$i][0],$time[$i][1]);
			  $time[$i] = implode(',',$time[$i]);}
			  }
			  $time = implode(',',$time);
			  $now = date('h',time());
			  for($k=0;$k<10;$k++){
				  if($now == '0'.$k){
				  $now = $k;
				  }
			  }
			  $now = (string)$now;
			  
			  if(strpos($time,$now) === false){
			  return ;			
			  }	
			  endif;		  		      			  			
		}
		
		if($day_week !== ''){
		       $day_week = preg_replace( "/[^0-9-,]/", '', $day_week);
			   
			   if($day_week !=='')
		       $day_week = explode(',',$day_week);
			   $count = count($day_week);
			   
			   for($i=0;$i<$count;$i++){
				   if(stristr($day_week[$i],'-')){
				   $day_week[$i] = explode('-',$day_week[$i]);
				   $day_week[$i] = range($day_week[$i][0],$day_week[$i][1]);
				   $day_week[$i] = implode(',',$day_week[$i]);
				   }  
			   }
			   	$day_week = implode(',',$day_week);
				$nowday = date('w',time());
				if( stristr($day_week,$nowday) === false) 
			    return ;	
			    
			
			  
		}
		
		if($day_month !==''){
		       $day_month = preg_replace( "/[^0-9-,]/", '', $day_month); 
			   if($day_month !=='')
			   $day_month = explode(',',$day_month);
			   $count = count($day_month);
			   
			   for($i=0;$i<$count;$i++){
				   if(stristr($day_month[$i],'-')){
				   $day_month[$i] = explode('-',$day_month[$i]);
				   $day_month[$i] = range($day_month[$i][0],$day_month[$i][1]);
				   $day_month[$i] = implode(',',$day_month[$i]);
				   }  
			   }
			   $day_month = implode(',',$day_month);
			   $day_month = explode(',',$day_month);
			   for($k=0;$k<count($day_month);$k++){
				   if($day_month[$k] < 10){ 
				   $day_month[$k] = '0'.$day_month[$k] ;
				   }
			   }
			   $day_month = implode(',',$day_month);
			   $nowday = date('j',time());
			   if((int)$nowday < 10)
			   $nowday = '0'.$nowday;
			    
			   if(stristr($day_month,$nowday) === false)
			   return ;
		
		}
		
		if($months !== ''){
		       $months = preg_replace( "/[^0-9-,]/",'', $months); 
		       if($months !== '')
			   $months = explode(',',$months);
			   $count = count($months);
			   
			   for($i=0;$i<$count;$i++){
				   if(stristr($months[$i],'-')){
				   $months[$i] = explode('-',$months[$i]);
				   $months[$i] = range($months[$i][0],$months[$i][1]);
				   $months[$i] = implode(',',$months[$i]);
				   }  
			   }
			   $months = implode(',',$months);	
			   $months = explode(',',$months);
			   
			   for($k=0;$k<count($months);$k++){
				   if($months[$k] < 10){ 
				   $months[$k] = '0'.$months[$k] ;
				   }
			   }	  
			   $months = implode(',',$months);			     					
			   $nowmonth =  date( 'n', time());
			   if((int)$nowmonth <10)
			   $nowmonth = '0'.$nowmonth;
			   
			   if(stristr($months,$nowmonth) === false){
			   return ;}
			    
		}
		
		if($years !==''){
		       $years =  preg_replace( "/[^0-9-,]/", '', $years); 
		       if($years !=='')
			   $years = explode(',',$years);			   
			   $count = count($years);
			   
			   for($i=0;$i<$count;$i++){
				   if(stristr($years[$i],'-')){
				   $years[$i] = explode('-',$years[$i]);
				   $years[$i] = range($years[$i][0],$years[$i][1]);
				   $years[$i] = implode(',',$years[$i]);
				   }  
			   }
			   $years = implode(',',$years);
			   $nowyear =  date( 'Y', time());
			   if(stristr($years,$nowyear) === false)
			   return ;
			   
		}
		return $html ;	
		
		
	}
	
}

new Magee_Scheduled_content();		