// counterUP
(function( $ ){
  "use strict";

  $.fn.counterUp = function( options ) {

    // Defaults
    var settings = $.extend({
        'time': 400,
        'delay': 10
    }, options);

    return this.each(function(){

        // Store the object
        var $this = $(this);
        var $settings = settings;

        var counterUpper = function() {
            var nums = [];
            var divisions = $settings.time / $settings.delay;
            var num = $this.text();
            var isComma = /[0-9]+,[0-9]+/.test(num);
            num = num.replace(/,/g, '');
            var isInt = /^[0-9]+$/.test(num);
            var isFloat = /^[0-9]+\.[0-9]+$/.test(num);
            var decimalPlaces = isFloat ? (num.split('.')[1] || []).length : 0;

            // Generate list of incremental numbers to display
            for (var i = divisions; i >= 1; i--) {

                // Preserve as int if input was int
                var newNum = parseInt(num / divisions * i);

                // Preserve float if input was float
                if (isFloat) {
                    newNum = parseFloat(num / divisions * i).toFixed(decimalPlaces);
                }

                // Preserve commas if input had commas
                if (isComma) {
                    while (/(\d+)(\d{3})/.test(newNum.toString())) {
                        newNum = newNum.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
                    }
                }

                nums.unshift(newNum);
            }

            $this.data('counterup-nums', nums);
            $this.text('0');

            // Updates the number until we're done
            var f = function() {
                $this.text($this.data('counterup-nums').shift());
                if ($this.data('counterup-nums').length) {
                    setTimeout($this.data('counterup-func'), $settings.delay);
                } else {
                    delete $this.data('counterup-nums');
                    $this.data('counterup-nums', null);
                    $this.data('counterup-func', null);
                }
            };
            $this.data('counterup-func', f);

            // Start the count up
            setTimeout($this.data('counterup-func'), $settings.delay);
        };

        // Perform counts when the element gets into view
        $this.waypoint(counterUpper, { offset: '100%', triggerOnce: true });
    });

  };

})( jQuery );

jQuery(document).ready(function($) {
								
            var s=$(".magee-feature-box.style2");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length){
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
				}
                t+=15;
                t+="px";
                $(s[i]).css({"padding-left":t});
            }
            var s=$(".magee-feature-box.style2.reverse");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length)
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
				
                t+=15;
                t+="px";
                $(s[i]).css({"padding-left":0,"padding-right":t});
            }
            var s=$(".magee-feature-box.style3");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length)
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
                t+="px";
                $(s[i]).find("h3").css({"line-height":t});
            }
            var s=$(".magee-feature-box.style4");
            for(i=0;i<s.length;i++) {
                var t=$(s[i]).find(".icon-box").outerWidth();
				if($(s[i]).find("img.feature-box-icon").length)
				var t=$(s[i]).find("img.feature-box-icon").outerWidth();
                t=t/2;
                t1=-t;
                t+="px";
                t1+="px";
                $(s[i]).css({"padding-top":t,"margin-top":t});
                $(s[i]).find(".icon-box").css({"top":t1,"margin-left":t1});
				$(s[i]).find("img.feature-box-icon").css({"top":t1,"margin-left":t1});
            }
  
 //
 
  $(".wow").each(function(){
	var duration = $(this).data("animationduration");
       if( typeof duration !== "undefined"){
		   $(this).css({"-webkit-animation-duration":duration+"s","animation-duration":duration+"s"});
		   }
    });
  //
  
  
								 
								 
 function DY_scroll(wraper,prev,next,img,speed,or)
 { 
  var wraper = $(wraper);
  var prev = $(prev);
  var next = $(next);
  var img = $(img).find('ul');
  var w = img.find('li').outerWidth(true);
  var s = speed;
  
  next.click(function()
       {
        img.animate({'margin-left':-w},function()
                  {
                   img.find('li').eq(0).appendTo(img);
                   img.css({'margin-left':0});
                   });
        });
 
  prev.click(function()
       {
        img.find('li:last').prependTo(img);
        img.css({'margin-left':-w});
        img.animate({'margin-left':0});
        });
 
  if (or == true)
  {
   ad = setInterval(function() { next.click();},s*1000);
   wraper.hover(function(){clearInterval(ad);},function(){ad = setInterval(function() { next.click();},s*1000);});
  }
 
 }
 
 DY_scroll('.multi-carousel','.multi-carousel-nav-prev','.multi-carousel-nav-next','.multi-carousel-inner',3,false);
 
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $("[data-animation]").mouseover(function(){
                var anmiationName=$(this).attr("data-animation");
                $(this).addClass("animated").addClass(anmiationName);
            });
            $("[data-animation]").mouseout(function(){
                var anmiationName=$(this).attr("data-animation");
                $(this).removeClass("animated").removeClass(anmiationName);
            });
 
 ////flipbox
 
 $('.magee-flipbox-wrap').each(function(){
	var front_height = $(this).find('.flipbox-front').outerHeight();
	var back_height  = $(this).find('.flipbox-back').outerHeight();
	var height = front_height>back_height?front_height:back_height;
	 	$(this).css({'height':height});	
 });
 
 // counter up
 
  $('.magee-counter-box .counter-num').counterUp({
            delay: 10,
            time: 1000
        });
  
  /* ------------------------------------------------------------------------ */
/*  animation													*/
/* ------------------------------------------------------------------------ */
										  
    $('.magee-animated').each(function(){
			 if($(this).data('imageanimation')==="yes"){
		         $(this).find("img,i.fa").css("visibility","hidden");	
		 }
		 else{
	           $(this).css("visibility","hidden");	
		 }		
		 
	 });
	
	if(jQuery().waypoint) {
		$('.magee-animated').waypoint(function() {
											  
			$(this).css({'visibility':'visible'});
			$(this).find("img,i.fa").css({'visibility':'visible'});	


			// this code is executed for each appeared element
			var animation_type       = $(this).data('animationtype');
			var animation_duration   = $(this).data('animationduration');
	        var image_animation      = $(this).data('imageanimation');
			 if(image_animation === "yes"){
						 
			$(this).find("img,i.fa").addClass("animated "+animation_type);

			if(animation_duration) {
				$(this).find("img,i.fa").css('-moz-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('-webkit-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('-ms-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('-o-animation-duration', animation_duration+'s');
				$(this).find("img,i.fa").css('animation-duration', animation_duration+'s');
			}
			
				 
			 }else{
			$(this).addClass("animated "+animation_type);

			if(animation_duration) {
				$(this).css('-moz-animation-duration', animation_duration+'s');
				$(this).css('-webkit-animation-duration', animation_duration+'s');
				$(this).css('-ms-animation-duration', animation_duration+'s');
				$(this).css('-o-animation-duration', animation_duration+'s');
				$(this).css('animation-duration', animation_duration+'s');
			}
			 }

			 
		},{ triggerOnce: true, offset: '90%' });
	}
  $("a[rel^='prettyPhoto']").prettyPhoto();
 });