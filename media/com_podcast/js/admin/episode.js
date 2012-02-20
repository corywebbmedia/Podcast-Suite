var EpisodeMedia = {
	assets: null,
	asset_ids: [],
	asset_default: null,
	episode_id: null,
	asset_list: 'episode_asset_list',
	asset_id_list: 'asset_ids',
	asset_default_input: 'asset_default',
	asset_template: 'episode_asset',
	asset_template_html: null
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

	// render markup
	var asset_html = Mustache.to_html(EpisodeMedia.asset_template_html, asset);
	$(EpisodeMedia.asset_list).innerHTML += asset_html;

	// update ids
	EpisodeMedia.asset_ids.push(parseInt(asset.asset_id, 10));
	EpisodeMedia.update_asset_id_list();
	
	// assign events
	$$('#' + EpisodeMedia.asset_list + ' .trash').addEvent('click', function () {
		EpisodeMedia.destroy(parseInt(this.get('rel'), 10));
	});
	
	$$('#' + EpisodeMedia.asset_list + ' .default-toggle').addEvent('click', function () {
		EpisodeMedia.change_default(parseInt(this.get('rel'), 10));
	});
};

EpisodeMedia.destroy = function (asset_id) {
	var new_ids = [];

	for (var i=0; i < EpisodeMedia.asset_ids.length; i++) {
		if (EpisodeMedia.asset_ids[i] !== asset_id) {
			new_ids.push(EpisodeMedia.asset_ids[i]);
		}
	}

	$$('#' + EpisodeMedia.asset_list + ' tr[rel=' + asset_id + ']').destroy();

	EpisodeMedia.asset_ids = new_ids;
	EpisodeMedia.update_asset_id_list();
};

EpisodeMedia.update_asset_id_list = function  () {
	$(EpisodeMedia.asset_id_list).value = EpisodeMedia.asset_ids.join(',');
};

EpisodeMedia.change_default = function  (asset_id) {
	$$('#' + EpisodeMedia.asset_list + ' tr[rel=' + EpisodeMedia.asset_default + '] span.default')
		.removeClass('default')
		.addClass('notdefault');

	$$('#' + EpisodeMedia.asset_list + ' tr[rel=' + asset_id + '] span.notdefault')
		.removeClass('notdefault')
		.addClass('default');

	EpisodeMedia.set_default(asset_id);
};

EpisodeMedia.set_default = function  (asset_id) {
	EpisodeMedia.asset_default = asset_id;
	$(EpisodeMedia.asset_default_input).value = asset_id;
};

EpisodeMedia.add_from_form = function () {
	
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

	EpisodeMedia.init();
});