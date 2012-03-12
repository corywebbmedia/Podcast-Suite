// (c) 2012 Cory Webb Media, GNU/GPLv2 license.

var MigratePodcast = {
	token: null,
	tasks: ['import_feeds',
			'import_podcast_episodes',
			'import_content_descriptions',
			'import_files',
			'translate_plugin_tags'],
	current_task: null,
	existing_joomla: null
};

MigratePodcast.tasks_complete = function  () {
	alert('done!');
};

MigratePodcast.perform_task = function (task_num) {
	if (task_num === MigratePodcast.tasks.length) {
		MigratePodcast.tasks_complete();
		return;
	}

	var req = {
		option: 'com_podcast',
		format: 'json',
		task: 'migrate.' + MigratePodcast.tasks[task_num],
		joomla_path: MigratePodcast.existing_joomla
	};

	req[MigratePodcast.token] = 1;

	new Request.JSON({
		url: 'index.php',
		onSuccess: function (response) {
			console.log(response);
			MigratePodcast.perform_task(task_num + 1);
		}
	}).post(req);
};

MigratePodcast.start_migration = function () {
	MigratePodcast.existing_joomla = $('path_to_old_joomla_site').get('value');
	MigratePodcast.perform_task(0);
};

window.addEvent('domready', function () {
	$('thebigscarybutton').addEvent('click', MigratePodcast.start_migration);
});