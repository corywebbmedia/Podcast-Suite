// (c) 2012 Cory Webb Media, GNU/GPLv2 license.

// requires: plupload
// requires: plupload.html5
// requires: plupload.flash

var Upload = {
	config: {
		token: null,
		url_root: 'index.php?option=com_podcast&task=assets.upload&format=json',
		browse_button_id: null,
		container_id: null,
		chunk_size: '1mb'
	}
};

// Returns an uploader object. 
Upload.new_uploader = function () {
	
	if (arguments.length > 0) {
		if (typeof(arguments[0]) === 'object') {
			for (var attrname in arguments[0]) {
				this.config[attrname] = arguments[0][attrname];
			}
		} else {
			throw 'Non-object argument provided for new_uploader';
		}
	}

	var config = this.config;

	var uploader = new plupload.Uploader({
		runtimes : 'html5,flash',
		browse_button : config.browse_button_id,
		container: config.container_id,
		chunk_size: config.chunk_size,
		max_file_size : '1gb',
		url : Upload.config.url_root + '&' + Upload.config.token + '=1',
		flash_swf_url : Upload.url_root + 'media/com_podcast/js/plupload/plupload.flash.swf'
	});
	
	uploader.init();
	
	return uploader;
};