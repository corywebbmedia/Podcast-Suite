// (c) 2012 Cory Webb Media, GNU/GPLv2 license.
// requires uploader

window.addEvent('domready', function () {
	Assets.init();

	var uploader = Upload.new_uploader({
		browse_button_id: 'upload_toolbar_button',
		container: 'uploader_container'
	});
	
	uploader.bind('FilesAdded', function () {
		uploader.start();
	});

	uploader.bind('BeforeUpload', function	(up) {
		up.settings.url = Upload.config.url_root + '&' + Upload.config.token + '=1' + '&folder=' + Assets.folder_current;
	});

	uploader.bind('FilesAdded', function(up, files) {
		for (i = 0; i < files.length; i++) {
			var existing = $('upload_file_list').get('html');
			$('upload_file_list').set('html', existing + '<li id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></li>');
		}
	});

	uploader.bind('UploadProgress', function(up, file) {
		$$('#' + file.id + ' b')[0].set('html', '<span>' + file.percent + "%</span>");
	});
	
	uploader.bind('FileUploaded', function(up, file, info) {
		if (info.status == 200) {
			var json = JSON.decode(info.response);
			Assets.page(Assets.pagination.current);
		}
	});

	$('check_all').addEvent('click', Assets.toggle_checks);
	
	$('scan_toolbar_button').addEvent('click', Assets.scan);
	
	$('new_folder_button').addEvent('click', Assets.add_folder);
});

var Assets = {
	assets: null,
	token: null,
	folders: [],
	pagination: null,
	search_string: '',
	asset_list: 'media_list',
	asset_template: 'asset_template',
	asset_template_html: null,
	pagination_holder: 'media_pagination',
	pagination_template: 'pagination_template',
	pagination_template_html: null,
	folder_root: null,
	folder_current: null,
	storage_engine: null,
	url_root: null,
	scanTotal: 0,
	scanCurrent: 1,
	scanFiles: null
};

// Loads the assets
Assets.init = function() {
	Assets.search_string = $('search_assets').get('value');
	Assets.page(1);
	$('search_assets').addEvent('keyup', function() {
		Assets.search_string = this.get('value');
		Assets.page(Assets.pagination.current);
	});

	$('search_clear').addEvent('click', function() {
		Assets.search_string = '';
		$('search_assets').set('value', '');
		Assets.page(1);
	});

	Assets.folder_current = Assets.folder_root;
	
	$('add_custom_media').addEvent('click', function() {
		CustomAsset.add();
	});
};

// Render the assets returned from the server
Assets.render = function() {
	$(Assets.asset_list).empty();
	for (var i=0; i < Assets.assets.length; i++) {
		Assets.add_item(Assets.assets[i]);
	}

	// Add click events to the freshly rendered checkboxes
	$$('.asset_checkbox').addEvent('click', Assets.toggle_check);

	Assets.setup_pagination();
};

// Adds an asset item to the table
Assets.add_item = function (asset) {
	// render markup
	asset.asset_enclosure_length = Assets.convertLength(asset.asset_enclosure_length);
	
	var asset_html = Mustache.to_html(Assets.asset_template_html, asset);
	var existing_html = $(Assets.asset_list).get('html');
	$(Assets.asset_list).set('html', existing_html + asset_html);
};

// Requests a new page
Assets.page = function(page) {
	new Request.JSON({
		url: 'index.php',
		onSuccess: function	 (results) {
			Assets.assets = results.items;
			Assets.pagination = results.pagination;
			Assets.render();
		}
	}).get({
		option: 'com_podcast',
		page: page - 1,
		search: Assets.search_string,
		engine: $('engine').get('value'),
		format: 'json',
		task: 'assets.list_available_assets'
	});
	Assets.asset_template_html = $(Assets.asset_template).get('html');
	Assets.pagination_template_html = $(Assets.pagination_template).get('html');
};

// Setup pagination
Assets.setup_pagination = function() {
	$(Assets.pagination_holder).set('html', Mustache.to_html(Assets.pagination_template_html, Assets.pagination));
	
	var pages = Assets.pagination;
	
	if (pages.current == '1') {
		$('page_start').getElement('div').set('html', '<span>'+$('page_start').getElement('a').get('text'));
		$('page_prev').getElement('div').set('html', '<span>'+$('page_prev').getElement('a').get('text'));
	}
	
	var existing = null;
	for (i = 1; i <= pages.total; i++) {
		if (i == pages.current) {
			existing = $('page_pages').getElement('div').get('html');
			$('page_pages').getElement('div').set('html', existing + '<span>'+i+'</span>');
		}
		else {
			existing = $('page_pages').getElement('div').get('html');
			$('page_pages').getElement('div').set('html', existing + '<a href="#assets" onclick="Assets.page('+i+');" title="'+i+'">'+i+'</a>');
		}
	}
	
	if (pages.current == pages.total) {
		$('page_last').getElement('div').set('html', '<span>'+$('page_last').getElement('a').get('text'));
		$('page_next').getElement('div').set('html', '<span>'+$('page_next').getElement('a').get('text'));
	}
};

// Function to change length to human readable values
Assets.convertLength = function(bytes) {
	if (!bytes) bytes = 0;
	var kilobyte = 1024;
	var megabyte = kilobyte * 1024;
	var gigabyte = megabyte * 1024;
	var terabyte = gigabyte * 1024;
	var precision = 2;

	if ((bytes >= 0) && (bytes < kilobyte)) {
		return bytes + ' B';
	} else if ((bytes >= kilobyte) && (bytes < megabyte)) {
		return (bytes / kilobyte).toFixed(precision) + ' KB';
	} else if ((bytes >= megabyte) && (bytes < gigabyte)) {
		return (bytes / megabyte).toFixed(precision) + ' MB';
	} else if ((bytes >= gigabyte) && (bytes < terabyte)) {
		return (bytes / gigabyte).toFixed(precision) + ' GB';
	} else {
		return bytes + ' B';
	}
};

Assets.file_tree = function(node, state) {
	var filter = "/" + node.text;
	var current = node;

	if (Assets.storage_engine == 'amazons3') {
		filter = Assets.filterS3(node);
		Assets.folder_current = node.text;
	} else {
		filter = Assets.recrusive_file_path(current, Assets.folder_root) + '/';
		Assets.folder_current = filter;
	}

	if (filter === Assets.folder_root) {
		filter = '';
	}
	
	$("search_assets").set("value", filter);
	

	Assets.search_string = filter;
	Assets.page(1);
};

Assets.rebuild_tree = function() {
	new Request.HTML({
		url: 'index.php?option=com_podcast&view=assets&format=raw&layout=default_folders',
		onSuccess: function  (responseTree, responseElements, responseHTML, responseJavaScript) {
			$('folders').set('html', '');
			var folders_tree = new Element('ul', {id: 'folders_tree', html: responseHTML});
			folders_tree.inject($('folders'), 'after');
			tree = new MooTreeControl({div: 'folders', mode: 'folders', grid: true, theme: Assets.url_root + '/media/system/images/mootree.gif', onClick: Assets.file_tree},{text: 'Root', open: true});
			tree.adopt('folders_tree');
		}
	}).get();
};

Assets.add_folder = function() {

  var request_vars = {
		option: 'com_podcast',
		format: 'json',
		task: 'assets.create_folder',
		folder: Assets.folder_current + '/' + $('new_folder_name').get('value')
  };

  request_vars[Assets.token] = 1;

  new Request.JSON({
		url: 'index.php',
		onSuccess: function	 (result) {
			Assets.rebuild_tree();
		},
		onFailure: function	 (xhr) {
			throw xhr;
		}
	}).post(request_vars);
};

Assets.filterS3 = function(node) {
	var filter = Assets.folder_root;
	return filter.replace("bucket", node.text);
};

Assets.recrusive_file_path = function (node, path) {
	if (node.parent === null) {
		return path; 
	}
	
	return path + Assets.recrusive_file_path(node.parent, '') + '/' + node.text;
};

Assets.toggle_checks = function	 (check_all) {

	if (check_all.target.checked === true) {
		$$('.asset_checkbox').each(function (item) {
			item.checked = true;
		}); 
		
		$('boxchecked').set('value', $$('.asset_checkbox').length);
	} else {
		$$('.asset_checkbox').each(function (item) {
			item.checked = false;
		});
		
		$('boxchecked').set('value', '0');
	}
};

Assets.toggle_check = function	(check) {
	var checked = parseInt($('boxchecked').get('value'), 10);

	if (check.target.checked === true) {
		checked++;
	} else {
		checked--;
	}

	$('boxchecked').set('value', checked);
};

Assets.scan = function () {
	Assets.scanCurrent = 0;
	new Request.JSON({
		url: 'index.php?'+Assets.token+'=1',
		onSuccess: function	(responseJSON) {
			Assets.scanTotal = responseJSON.length;
			Assets.scanFiles = responseJSON;
			i = 0;
			//console.info('Checking 1-10 of '+Assets.scanTotal);
			while (Assets.scanCurrent < Assets.scanTotal)	{
				Assets.syncFiles();
				//console.info('Checking '+Assets.scanCurrent+'-'+(Assets.scanCurrent+9)+ ' of '+Assets.scanTotal);
				i++;
			}
			Assets.page(1);
		}
	}).get({
		option: 'com_podcast',
		format: 'json',
		task: 'assets.scan'
	});
}

Assets.syncFiles = function () {
	// Send a request to check 10 at a time
	var items = Assets.scanFiles.splice(0, 10);
	Assets.scanCurrent += 10;
	
	new Request({
		url: 'index.php?'+Assets.token+'=1',
		method: 'post',
		data: {
			option: 'com_podcast',
			view: 'assets',
			items: JSON.encode(items),
			format: 'json',
			task: 'assets.scan_files'
		},
		onSuccess: function(response) {
			console.info(response);
			
		}
	}).send();
	
	if (Assets.scanCurrent >= Assets.scanTotal) return false;
	return true;
}

// Custom Asset method for adding a new asset
CustomAsset = {
	add: function() {
		var asset = {
			asset_enclosure_url: $('asset_enclosure_url').get('value'),
			asset_enclosure_length: $('asset_enclosure_length').get('value'),
			asset_enclosure_type: $('asset_enclosure_type').get('value'),
			asset_duration: $('asset_duration').get('value'),
			asset_closed_caption: $('asset_closed_caption').get('value')
		};
		
		var req = new Request({
			url: 'index.php?'+Assets.token+'=1',
			data: {
				option: 'com_podcast',
				view: 'assets',
				asset: asset,
				format: 'json',
				task: 'assets.add_custom_asset'
			},
			onSuccess: function(response) {
				if (response > 0) {
					Assets.page();
				}
			}
		}).send();
	}
};