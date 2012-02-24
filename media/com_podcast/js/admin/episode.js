var EpisodeMedia = {
	assets: null,
	asset_ids: [],
	asset_default: null,
	episode_id: null,
	asset_list: 'episode_asset_list',
	asset_id_list: 'asset_ids',
	asset_default_input: 'asset_default',
	asset_template: 'episode_asset',
	asset_template_html: null,
	token: null
};

EpisodeMedia.render = function () {
	for (var i=0; i < EpisodeMedia.assets.length; i++) {
		EpisodeMedia.add_item(EpisodeMedia.assets[i]);
	}
};

EpisodeMedia.add_item = function (asset) {
	// set data
	asset.media_default = function  () {
		if (asset.asset_default === "1") {
			return 'default';
		} else {
			return 'notdefault';
		}
	};
    
    asset.asset_enclosure_length = EpisodeMedia.convertLength(asset.asset_enclosure_length);
    
	// render markup
	var asset_html = Mustache.to_html(EpisodeMedia.asset_template_html, asset);
	$(EpisodeMedia.asset_list).innerHTML += asset_html;

	// update ids
	EpisodeMedia.asset_ids.push(parseInt(asset.podcast_asset_id, 10));
	EpisodeMedia.update_asset_id_list();
	
	// assign events
	$$('#' + EpisodeMedia.asset_list + ' .trash').addEvent('click', function () {
		EpisodeMedia.destroy(parseInt(this.get('rel'), 10));
	});
	
	$$('#' + EpisodeMedia.asset_list + ' .default-toggle').addEvent('click', function () {
		EpisodeMedia.change_default(parseInt(this.get('rel'), 10));
	});
};

EpisodeMedia.destroy = function (podcast_asset_id) {
	var new_ids = [];

	for (var i=0; i < EpisodeMedia.asset_ids.length; i++) {
		if (EpisodeMedia.asset_ids[i] !== podcast_asset_id) {
			new_ids.push(EpisodeMedia.asset_ids[i]);
		}
	}

	$$('#' + EpisodeMedia.asset_list + ' tr[rel=' + podcast_asset_id + ']').destroy();

	EpisodeMedia.asset_ids = new_ids;
	EpisodeMedia.update_asset_id_list();
};

EpisodeMedia.update_asset_id_list = function  () {
	$(EpisodeMedia.asset_id_list).value = EpisodeMedia.asset_ids.join(',');
};

EpisodeMedia.change_default = function  (podcast_asset_id) {
	$$('#' + EpisodeMedia.asset_list + ' tr[rel=' + EpisodeMedia.asset_default + '] span.default')
		.removeClass('default')
		.addClass('notdefault');

	$$('#' + EpisodeMedia.asset_list + ' tr[rel=' + podcast_asset_id + '] span.notdefault')
		.removeClass('notdefault')
		.addClass('default');

	EpisodeMedia.set_default(podcast_asset_id);
};

EpisodeMedia.set_default = function  (podcast_asset_id) {
	EpisodeMedia.asset_default = podcast_asset_id;
	$(EpisodeMedia.asset_default_input).value = podcast_asset_id;
};

EpisodeMedia.add_custom = function () {
	EpisodeMedia.add_from_form(EpisodeMedia.add_item);
};

EpisodeMedia.add_from_form = function (callback) {
	var asset = {
		asset_enclosure_url: $('asset_enclosure_url').value,
		asset_enclosure_length: $('asset_enclosure_length').value,
		asset_enclosure_type: $('asset_enclosure_type').value,
		asset_duration: $('asset_duration').value,
		asset_closed_caption: $('asset_closed_caption').value
	};

	var req = asset;
	req.option = 'com_podcast';
	req.format = 'json';
	req.task = 'assets.save';  

	req[EpisodeMedia.token] = 1;

	new Request.JSON({
		url: 'index.php',
		onSuccess: callback
	}).post(req);
};

EpisodeMedia.convertLength = function(bytes) {
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

EpisodeMedia.init = function () {
	new Request.JSON({
		url: 'index.php',
		onSuccess: function  (results) {
			EpisodeMedia.assets = results;
			
			for (var i=0; i < EpisodeMedia.assets.length; i++) {
				var asset = EpisodeMedia.assets[i];

				if (asset.asset_default === "1") {
					EpisodeMedia.set_default(parseInt(asset.asset_default, 10));
				}
			}
			
			EpisodeMedia.render();
		}
	}).get({
		option: 'com_podcast',
		format: 'json',
		task: 'assets.list_episode_assets',
		episode_id: EpisodeMedia.episode_id
	});
	
	EpisodeMedia.asset_template_html = $(EpisodeMedia.asset_template).innerHTML;
};

// Jeremy's Additions
var AvailableAssets = {
    loaded: false,
    assets: null,
    pagination: null,
    search_string: '',
    asset_ids: [],
	asset_list: 'available_asset_list',
    asset_template: 'available_asset',
	asset_template_html: null,
    pagination_holder: 'available_asset_pagination',
    pagination_template: 'asset_pagination',
    pagination_template_html: null
};

// Loads the assets
AvailableAssets.init = function() {
    if (!this.loaded) {
        AvailableAssets.page(1);
        $('search_assets').addEvent('keyup', function() {
            AvailableAssets.search_string = this.get('value');
            AvailableAssets.page(AvailableAssets.pagination.current);
        });
    }  
    
    this.loaded = true;
};

AvailableAssets.render = function() {
    $(AvailableAssets.asset_list).empty();
    for (var i=0; i < AvailableAssets.assets.length; i++) {
		AvailableAssets.add_item(AvailableAssets.assets[i]);
	}
    
    $$('#' + AvailableAssets.asset_list + ' .add_asset').addEvent('click', function () {
        var item = {
            podcast_asset_id: this.get('rel'),
            asset_enclosure_url: this.getParent('tr').getElement('td.url').get('text'),
            asset_duration: this.getParent('tr').getElement('td.duration').get('text')
        }
        if (EpisodeMedia.asset_ids.length == 0) item.asset_default = '1';
		EpisodeMedia.add_item(item);
	});
    
    AvailableAssets.setup_pagination();
};

AvailableAssets.add_item = function (asset) {
	// render markup
    asset.asset_enclosure_length = EpisodeMedia.convertLength(asset.asset_enclosure_length);
    
	var asset_html = Mustache.to_html(AvailableAssets.asset_template_html, asset);
	$(AvailableAssets.asset_list).innerHTML += asset_html;
};

AvailableAssets.page = function(page) {
    new Request.JSON({
        url: 'index.php',
        onSuccess: function  (results) {
            AvailableAssets.assets = results.items;
            AvailableAssets.pagination = results.pagination;
            AvailableAssets.render();
            $('available_asset_list').setStyle('height', 'auto');
        }
    }).get({
        option: 'com_podcast',
        page: page - 1,
        search: AvailableAssets.search_string,
        format: 'json',
        task: 'assets.list_available_assets'
    });
    AvailableAssets.asset_template_html = $(AvailableAssets.asset_template).innerHTML;
    AvailableAssets.pagination_template_html = $(AvailableAssets.pagination_template).innerHTML;
};

// Setup pagination
AvailableAssets.setup_pagination = function() {
    $(AvailableAssets.pagination_holder).innerHTML = Mustache.to_html(AvailableAssets.pagination_template_html, AvailableAssets.pagination);
    
    var pages = AvailableAssets.pagination;
    
    if (pages.current == '1') {
        $('page_start').getElement('div').set('html', '<span>'+$('page_start').getElement('a').get('text'));
        $('page_prev').getElement('div').set('html', '<span>'+$('page_prev').getElement('a').get('text'));
    }
    
    for (var i = 1; i <= pages.total; i++) {
        if (i == pages.current) {
            $('page_pages').getElement('div').innerHTML += '<span>'+i+'</span>';
        }
        else {
            $('page_pages').getElement('div').innerHTML += '<a href="#assets" onclick="AvailableAssets.page('+i+');" title="'+i+'">'+i+'</a>';
        }
    }
    
    if (pages.current == pages.total) {
        $('page_last').getElement('div').set('html', '<span>'+$('page_last').getElement('a').get('text'));
        $('page_next').getElement('div').set('html', '<span>'+$('page_next').getElement('a').get('text'));
    }
};

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
            url: 'index.php',
            data: {
                option: 'com_podcast',
                view: 'assets',
                asset: asset,
                episode_id: EpisodeMedia.episode_id,
                format: 'json',
                task: 'assets.add_custom_asset'
            },
            onSuccess: function(response) {
                if (response > 0) {
                    asset.podcast_asset_id = response;
                    EpisodeMedia.add_item(asset);
                }
            }
        }).send();
    }
};

window.addEvent('domready', function () {
	var availableSlide = new Fx.Slide('available');
	availableSlide.hide();

	var customSlide = new Fx.Slide('custom_media');
	customSlide.hide();

	$('browse_available').addEvent('click', function() {
		if (customSlide.open) {
            customSlide.slideOut().chain(function() {
                availableSlide.toggle();
            });
        } else {
            availableSlide.toggle();
        }
        // Load assets if we are opening the slider
        if (!availableSlide.open) {
            AvailableAssets.init();
        }
	});
	
	$('add_custom').addEvent('click', function () {
        if (availableSlide.open) {
            availableSlide.slideOut().chain(function() {
                customSlide.toggle();
            });
        } else {
            customSlide.toggle();
        }
	});
    
    $('add_custom_media').addEvent('click', function() {
        CustomAsset.add();
    });

	EpisodeMedia.init();
});