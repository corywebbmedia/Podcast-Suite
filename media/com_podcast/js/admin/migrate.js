var MigratePodcast = {
	token: null
};

MigratePodcast.start_migration = function () {
	
};

window.addEvent('domready', function () {
	$('thebigscarybutton').addEvent('click', MigratePodcast.start_migration);
});