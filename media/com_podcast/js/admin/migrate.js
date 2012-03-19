// (c) 2012 Cory Webb Media, GNU/GPLv2 license.

var MigratePodcast = {
	token: null,
	tasks: ['import_feeds',
			'import_podcast_assets',
			'import_podcast_episodes',
			'translate_plugin_tags'],
	files: null,
	existing_joomla: null
};

MigratePodcast.perform_task = function (task_num) {
	if (task_num === MigratePodcast.tasks.length) {
		MigratePodcast.import_files();
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
			MigratePodcast.display_status_update(response.message);

			if (response.status === 'success') {
				MigratePodcast.perform_task(task_num + 1);
			} else {
				MigratePodcast.display_status_update('FAILED');
			}
		}
	}).post(req);
};

MigratePodcast.import_files = function () {
	var req = {
		option: 'com_podcast',
		format: 'json',
		task: 'migrate.get_import_files',
		joomla_path: MigratePodcast.existing_joomla
	};

	new Request.JSON({
		url: 'index.php',
		onSuccess: function (response) {
			MigratePodcast.files = response;
			MigratePodcast.import_single_file(0);
		}
	}).post(req);
};

MigratePodcast.import_single_file = function (file_num) {
	if (file_num === MigratePodcast.files.length) {
		MigratePodcast.finish_migration();
		return;
	}

	var req = {
		option: 'com_podcast',
		format: 'json',
		task: 'migrate.import_file',
		file: MigratePodcast.files[file_num],
		joomla_path: MigratePodcast.existing_joomla
	};

	req[MigratePodcast.token] = 1;

	new Request.JSON({
		url: 'index.php',
		onSuccess: function (response) {
			if (response.status === 'success') {
				MigratePodcast.display_status_update(response.message);
				MigratePodcast.import_single_file(file_num + 1);
			} else {
				MigratePodcast.display_status_update('FILE IMPORT FAILED');
			}
		}
	}).post(req);
	
};

MigratePodcast.display_status_update = function (message) {
	var item = new Element('li', {html: message});
	item.inject($('migration_statuses'));
};

MigratePodcast.start_migration = function () {
	MigratePodcast.existing_joomla = $('path_to_old_joomla_site').get('value');
	MigratePodcast.perform_task(0);
};

MigratePodcast.finish_migration = function () {
	MigratePodcast.display_status_update('COMPLETE');
};

window.addEvent('domready', function () {
	$('thebigscarybutton').addEvent('click', MigratePodcast.start_migration);
});