window.addEvent('domready', function () {
    Assets.init();
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
    pagination_template_html: null
};

// Loads the assets
Assets.init = function() {
    Assets.search_string = $('search_assets').get('value');
    Assets.page(1);
    $('search_assets').addEvent('keyup', function() {
        Assets.search_string = this.get('value');
        Assets.page(Assets.pagination.current);
    });
};

// Render the assets returned from the server
Assets.render = function() {
    $(Assets.asset_list).empty();
    for (var i=0; i < Assets.assets.length; i++) {
		Assets.add_item(Assets.assets[i]);
	}
    
    Assets.setup_pagination();
};

// Adds an asset item to the table
Assets.add_item = function (asset) {
	// render markup
    asset.asset_enclosure_length = Assets.convertLength(asset.asset_enclosure_length);
    
	var asset_html = Mustache.to_html(Assets.asset_template_html, asset);
	$(Assets.asset_list).innerHTML += asset_html;
};

// Requests a new page
Assets.page = function(page) {
    new Request.JSON({
        url: 'index.php',
        onSuccess: function  (results) {
            Assets.assets = results.items;
            Assets.pagination = results.pagination;
            Assets.render();
        }
    }).get({
        option: 'com_podcast',
        page: page - 1,
        search: Assets.search_string,
        format: 'json',
        task: 'assets.list_available_assets'
    });
    Assets.asset_template_html = $(Assets.asset_template).innerHTML;
    Assets.pagination_template_html = $(Assets.pagination_template).innerHTML;
};

// Setup pagination
Assets.setup_pagination = function() {
    $(Assets.pagination_holder).innerHTML = Mustache.to_html(Assets.pagination_template_html, Assets.pagination);
    
    var pages = Assets.pagination;
    
    if (pages.current == '1') {
        $('page_start').getElement('div').set('html', '<span>'+$('page_start').getElement('a').get('text'));
        $('page_prev').getElement('div').set('html', '<span>'+$('page_prev').getElement('a').get('text'));
    }
    
    for (i = 1; i <= pages.total; i++) {
        if (i == pages.current) {
            $('page_pages').getElement('div').innerHTML += '<span>'+i+'</span>';
        }
        else {
            $('page_pages').getElement('div').innerHTML += '<a href="#assets" onclick="Assets.page('+i+');" title="'+i+'">'+i+'</a>';
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