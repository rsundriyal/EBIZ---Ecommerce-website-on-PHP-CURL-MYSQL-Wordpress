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

jQuery(document).ready(function($){
								
 // counter up
 
  $('.magee-counter-box .counter-num').counterUp({
            delay: 10,
            time: 1000
        });
  //  tooltip
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
	
	//  chart box
	$('.magee-chart-box').easyPieChart({
                barColor: '#fdd200',
                trackColor: '#f5f5f5',
                scaleColor: false,
                lineWidth: 10,
                trackWidth: 10,
                size: 200,
                lineCap: 'butt'
            });
	
	 //  feature box
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
			
			
			
});