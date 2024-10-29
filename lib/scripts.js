(function($) {
	$(document).ready(function() {
		"use strict";
		$('.flexslider').flexslider({
			animation: "slide",
			namespace: "aw-",
			prevText: "",
			nextText: "",
			easing: "swing",
			smoothHeight: true,
			slideshow: false,
			smoothHeight: true,
			pauseOnHover: true,
			controlNav: true,
			customDirectionNav: $(".aw-custom-navigation a"),
			start: function(slider){
				$('body').removeClass('loading');
			}
		});
	});	
})(jQuery);