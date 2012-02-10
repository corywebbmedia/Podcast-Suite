<?php defined('_JEXEC') or die; ?>

<label>Search</label><input type="text" id="file_search" value="" /> <input type="hidden" id="file_limitstart" value="0" /> <input type="hidden" id="file_limit" value="2" />

<div class="clr"></div>

<ul id="file_list">
</ul>

<ul id="file_pagination">
</ul>

<div class="clr"></div>

<script type="text/javascript">
window.addEvent('domready', function() {
    loadFilelist();
    $('file_search').addEvent('keypress', function() {
        loadFilelist();
    });
});

function setDefault(item) {
    console.info(item);
    $('jform_item_enclosure_url').set('value', item.get('data-url'));
    $('jform_item_enclosure_length').set('value', item.get('data-length'));
    $('jform_item_duration').set('value', item.get('data-duration'));
    $('jform_item_enclosure_type').set('value', item.get('data-type'));
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
                li.set('text', item.asset_enclosure_url);
                li.set('data-length', item.asset_enclosure_length);
                li.set('data-type', item.asset_enclosure_type);
                li.set('data-duration', item.asset_duration);
                li.set('data-url', item.asset_enclosure_url);
                li.set('data-id', item.asset_id);
                li.addEvent('click', function() {
                    setDefault(this);
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