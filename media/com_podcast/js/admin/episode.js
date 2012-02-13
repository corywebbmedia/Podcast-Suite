var Episode = {
	token: null,
	url_root: null
};

Episode.new_uploader = function (options) {
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight',
		browse_button : options.browse_button,
		container: options.container,
		max_file_size : '1gb',
		url : 'index.php?option=com_podcast&task=asset.upload&' + Episode.token + '=1',
		flash_swf_url : Episode.url_root +' media/com_podcast/js/plupload/plupload.flash.swf',
		silverlight_xap_url : Episode.url_root + 'media/com_podcast/js/plupload/plupload.silverlight.xap'
	});

	uploader.bind('FilesAdded', function(up, files) {
	    for (i = 0; i < files.length; i++) {
	        $(options.file_list).innerHTML += '<li id="' + files[i].id + '">' + files[i].name + ' (' + plupload.formatSize(files[i].size) + ') <b></b></li>';
	    }
	});

	uploader.bind('UploadProgress', function(up, file) {
		$(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
	});

	$(options.upload_files).onclick = function() {
		uploader.start();
		return false;
	};
	
	uploader.init();
	
	return uploader;
};

Episode.init = function () {
	Episode.new_uploader({
		browse_button: 'pickfiles',
		container: 'upload', 
		upload_files: 'uploadfiles', 
		file_list: 'filelist' 
	});
};

window.addEvent('domready', function () {
	Episode.init();
});