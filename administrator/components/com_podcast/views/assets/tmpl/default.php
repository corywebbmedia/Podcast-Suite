<?php
defined( '_JEXEC' ) or die;

JHtml::_('behavior.mootools');
JHtml::_('behavior.tree', 'folders_tree', array('div' => 'folders'));

$doc = JFactory::getDocument();

$doc->addScript(JURI::root().'media/com_podcast/js/admin/mustache.js');

$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.flash.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html5.js');

$doc->addScript(JURI::root().'media/com_podcast/js/admin/upload.js');
$doc->addScriptDeclaration("Upload.config.token = '" . JUtility::getToken() . "';");

$doc->addScript(JURI::root().'media/com_podcast/js/admin/assets.js');
$doc->addScriptDeclaration("Assets.token = '" . JUtility::getToken() . "';");

?>

<div class="width-30 fltlft">
    <fieldset>
        <legend>*Folders</legend>
        <div id="folders"></div>
        <ul id="folders_tree">
        <?php $this->setupFolders($this->folders); ?>
        </ul>
    </fieldset>
	<fieldset>
		<legend>*Uploaded Files</legend>

		<div id="uploader_container">
			<ul id="upload_file_list"></ul>
		</div>
	</fieldset>
</div>

<div class="width-70 fltrt" id="files">

	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="search_assets" value="" title="<?php echo JText::_('COM_PODCAST_SEARCH_EPISODES'); ?>" />
			<button type="button" id="search_clear"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
                <th width="1%"></th>
                <th class="title">
					*Path
				</th>
				<th class="title">
					*File
				</th>
                <th>*Uses</th>
                <th>*Status</th>
			</tr>
		</thead>
		<tfoot id="media_pagination">
		</tfoot>
        <script type="text/html" id="pagination_template">
            <tr>
                <td align="center" colspan="20">
                    <div class="pagination">
                        <div class="button2-right" id="page_start"><div class="start"><a onclick="AvailableAssets.page(0);" title="Start" href="#assets">*Start</a></div></div>
                        <div class="button2-right" id="page_prev"><div class="prev"><a onclick="AvailableAssets.page({{previous}});" title="Prev" href="#assets">*Prev</a></div></div>
                        <div class="button2-left" id="page_pages"><div class="page"></div></div>
                        <div class="button2-left" id="page_next"><div class="next"><a onclick="AvailableAssets.page({{next}});" title="Next" href="#assets">*Next</a></div></div>
                        <div class="button2-left" id="page_last"><div class="end"><a onclick="AvailableAssets.page({{total}});" title="End" href="#assets">*End</a></div></div>
                        <div class="limit">*Page {{current}} of {{total}}</div>
                    </div>
                </td>
            </tr>
        </script>
		<tbody id="media_list">

		</tbody>
        <script type="text/html" id="asset_template">
            <tr rel="{{podcast_asset_id}}">
                <td align="center" width="1%">
                    <span class="jgrid"><span class="{{media_default}} media-button default-toggle" rel="{{podcast_asset_id}}">&nbsp;</span></span>
                </td>
                <td class="url">{{asset_enclosure_url}}</td>
                <td class="length">{{asset_enclosure_length}}</td>
                <td class="duration">{{asset_duration}}</td>
                <td class="type">{{asset_enclosure_type}}</td>
                <td align="center" width="1%">
                    <span class="jgrid"><span class="trash media-button" rel="{{podcast_asset_id}}">&nbsp;</span></span>
                </td>
            </tr>
        </script>
	</table>

</div>

<div class="clr"></div>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">Podcast Suite v2.0</a> | Copyright &copy; 2012 <a href="http://www.corywebbmedia.com">Cory Webb Media, LLC</a></p>
</div>