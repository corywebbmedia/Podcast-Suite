<?php defined('_JEXEC') or die; ?>

<label>Search</label><input type="text" id="file_search" value="" /> <input type="hidden" id="file_limitstart" value="0" /> <input type="hidden" id="file_limit" value="20" />

<div class="clr"></div>

<ul id="file_list">
</ul>

<ul id="file_pagination">
</ul>

<div class="clr"></div>

<script type="text/javascript">
window.addEvent('domready', function() {
    loadFilelist();
    $('file_search').addEvent('keyup', function() {
        loadFilelist();
    });
    $$('.asset_remove').addEvent('click', function() {
        console.info(this);
        removeExtraAsset(this.getParent());
    });
});

function setDefault(item) {
    $('jform_item_enclosure_url').set('value', item.get('data-url'));
    $('jform_item_enclosure_length').set('value', item.get('data-length'));
    $('jform_item_duration').set('value', item.get('data-duration'));
    $('jform_item_enclosure_type').set('value', item.get('data-type'));
    var assets = JSON.decode($('jform_item_assets').get('value'));
    assets.shift();
    assets.unshift(item.get('data-id'));
    assets = JSON.encode(assets);
    $('jform_item_assets').set('value', assets.replace(/\"/g, ''));
}

function removeExtraAsset(asset)
{
    var assets = JSON.decode($('jform_item_assets').get('value'));
    var id = asset.get('data-id').toInt();
    assets.erase(id);
    assets = JSON.encode(assets);
    $('jform_item_assets').set('value', assets.replace(/\"/g, ''));
    asset.destroy();
}

function setExtraAsset(item) {
    var assets = JSON.decode($('jform_item_assets').get('value'));
    var li = new Element('li');
    li.set('html', '<img src="<?php echo JURI::root(); ?>media/com_podcast/images/icons/delete-16.png" title="Remove Asset" class="asset_remove" /> File: '+item.get('data-url')+'<br />Media Length: '+item.get('data-length')+'<br />Media Duration: '+item.get('data-duration')+'<br />Media Type: '+item.get('data-type'));
    li.set('data-id', item.get('data-id'));
    li.getElement('.asset_remove').addEvent('click', function() {
        removeExtraAsset(this.getParent());
    });
    $('extra_assets').adopt(li);
    
    assets.push(item.get('data-id'));
    assets = JSON.encode(assets);
    $('jform_item_assets').set('value', assets.replace(/\"/g, ''));
}

function changePage(page) {
    $('file_limitstart').set('value', page.get('data-limitstart'));
    loadFilelist();
}

function loadFilelist() {
    var list = new Request({
        url: 'index.php?option=com_podcast&task=assets.getAssets',
        data: 'search='+$('file_search').get('value')+'&limitstart='+$('file_limitstart').get('value')+'&limit='+$('file_limit').get('value'),
        onSuccess: function(response) {
            $('file_list').empty();
            $('file_pagination').empty();
            
            var json = JSON.decode(response);

            // Load list of items
            json.list.each(function(item) {
                var li = new Element('li');
                li.set('html', '<img src="<?php echo JURI::root(); ?>media/com_podcast/images/icons/default-16.png" title="Set as default" class="asset_default" /> <img src="<?php echo JURI::root(); ?>media/com_podcast/images/icons/add-16.png" title="Add to assets" class="asset_add" /> ' + item.asset_enclosure_url);
                li.set('data-length', item.asset_enclosure_length);
                li.set('data-type', item.asset_enclosure_type);
                li.set('data-duration', item.asset_duration);
                li.set('data-url', item.asset_enclosure_url);
                li.set('data-id', item.asset_id);
                li.getElement('.asset_default').addEvent('click', function() {
                    setDefault(this.getParent());
                });
                li.getElement('.asset_add').addEvent('click', function() {
                    setExtraAsset(this.getParent());
                });
                $('file_list').adopt(li);
            });
            
            // Setup pagination
            for (i = 1; i <= json.pagination['pages.total']; i++) {
                var li = new Element('li');
                li.set('text', i);
                li.set('data-limitstart', (i * json.pagination['limit']) - json.pagination['limit']);
                li.addEvent('click', function() {
                    changePage(this);
                })
                $('file_pagination').adopt(li);
            }
        }
    }).send();
}
</script>