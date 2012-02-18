window.addEvent('domready', function () {
	var availableSlide = new Fx.Slide('available');
	availableSlide.hide();

	var customSlide = new Fx.Slide('custom_media');
	customSlide.hide();

	$('browse_available').addEvent('click', function() {
		customSlide.hide();
		availableSlide.toggle();
	});
	
	$('add_custom').addEvent('click', function () {
		availableSlide.hide();
		customSlide.toggle();
	});
});