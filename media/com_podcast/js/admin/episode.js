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
    
    uploader.bind('FileUploaded', function(up, file, info) {
        if (info.status == 200) {
            var json = JSON.decode(info.response);
            var replace = confirm('Would you like to set '+json.enclosure_url+' as the default media item?');
            if (replace) {
                $('jform_item_enclosure_url').set('value', json.enclosure_url);
                $('jform_item_enclosure_type').set('value', json.enclosure_type);
                $('jform_item_duration').set('value', json.enclosure_duration);
                $('jform_item_enclosure_length').set('value', json.enclosure_length);
                var assets = JSON.decode($('jform_item_assets').get('value'));
                assets.shift();
                assets.unshift(json.asset_id);
                assets = JSON.encode(assets);
                $('jform_item_assets').set('value', assets.replace(/\"/g, ''));
            }
        }
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
	var availableSlide = new Fx.Slide('available');
	availableSlide.hide();

	$('available_toggle').addEvent('click', function() {
		availableSlide.toggle();
	});

	Episode.init();
});