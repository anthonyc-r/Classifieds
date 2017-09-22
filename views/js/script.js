$(document).ready(function() {
	//setHeaderScroll();
});

function setHeaderScroll() {
	var $header = $("header");
	var slideSpeed = 200;
	var lastScroll = 0;
	var newScroll = 0;
	$(window).scroll(function() {
		newScroll = $(window).scrollTop();
		//difference in y
		var dy = lastScroll - newScroll;
		//Scrolling up - make header slidedown
		if (dy > 0) {
			$header.stop().slideDown(slideSpeed);
		}
		//Scrolling down - slideUp header
		else if (dy < 0) {
			$header.stop().slideUp(slideSpeed);
		}
		//Ready for next occurance
		lastScroll = newScroll;
	});
}