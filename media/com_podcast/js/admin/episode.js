window.addEvent('domready', function () {
	var availableSlide = new Fx.Slide('available');
	availableSlide.hide();

	$('available_toggle').addEvent('click', function() {
		availableSlide.toggle();
	});
});