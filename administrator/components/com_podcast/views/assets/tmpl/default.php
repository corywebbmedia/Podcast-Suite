<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('podcast.helper');

JHtml::_('behavior.mootools');
JHtml::_('behavior.tree', 'folders_tree', array('div' => 'folders', 'onClick' => 'Assets.file_tree'));

$doc = JFactory::getDocument();

$doc->addScript(JURI::root().'media/com_podcast/js/admin/mustache.js');

$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.flash.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html5.js');

$doc->addScript(JURI::root().'media/com_podcast/js/admin/upload.js');
$doc->addScriptDeclaration("Upload.config.token = '" . JUtility::getToken() . "';");
$doc->addScriptDeclaration("Upload.url_root = '" . JURI::root() . "';");

$doc->addScript(JURI::root().'media/com_podcast/js/admin/assets.js');
$doc->addScriptDeclaration("Assets.token = '" . JUtility::getToken() . "';");
$doc->addScriptDeclaration("Assets.folder_root = '" . PodcastHelper::getStorage()->getRoot() . "';");
$doc->addScriptDeclaration("Assets.url_root = '" . JURI::root() . "';");
$doc->addScriptDeclaration("Assets.storage_engine = '".PodcastHelper::getStorage()->getType()."';");

?>

<div class="width-30 fltlft">
	<fieldset>
		<legend><?php echo JText::_('COM_PODCAST_MEDIA_FOLDERS') ?></legend>
		<div id="folders"></div>
		<ul id="folders_tree">
		<?php
			echo $this->loadTemplate('folders');
		?>
		</ul>
		<div id="new_folder">
			<p><input type="text" name="new_folder_name" value="" id="new_folder_name" /> <input type="button" name="new_folder_button" value="<?php echo JText::_('COM_PODCAST_MEDIA_NEW_SUBFOLDER'); ?>" id="new_folder_button"></p>
		</div>
	</fieldset>
	<fieldset class="adminform" id="custom_media">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_CUSTOM_MEDIA') ?></legend>

			<label for="asset_enclosure_url"><?php echo JText::_('COM_PODCAST_EPISODE_CUSTOM_MEDIA_URL') ?></label><input type="text" name="asset_enclosure_url" value="" id="asset_enclosure_url">
			<label for="asset_enclosure_length"><?php echo JText::_('COM_PODCAST_EPISODE_CUSTOM_MEDIA_LENGTH') ?></label><input type="text" name="asset_enclosure_length" value="" id="asset_enclosure_length">
			<label for="asset_enclosure_type"><?php echo JText::_('COM_PODCAST_EPISODE_CUSTOM_MEDIA_TYPE') ?></label><input type="text" name="asset_enclosure_type" value="" id="asset_enclosure_type">
			<label for="asset_duration"><?php echo JText::_('COM_PODCAST_EPISODE_CUSTOM_MEDIA_DURATION') ?></label><input type="text" name="asset_duration" value="" id="asset_duration">
			<label for="asset_closed_caption"><?php echo JText::_('COM_PODCAST_EPISODE_CUSTOM_MEDIA_CLOSED_CAPTIONED') ?></label><select name="asset_closed_caption" id="asset_closed_caption">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
			<div class="clr"></div>
			<input type="button" value="<?php echo JText::_('COM_PODCAST_EPISODE_BUTTON_ADD_CUSTOM_MEDIA') ?>" class="button" id="add_custom_media" />

		</fieldset>
	<fieldset>
		<legend><?php echo JText::_('COM_PODCAST_MEDIA_UPLOADED_FILES') ?></legend>

		<div id="uploader_container">
			<ul id="upload_file_list"></ul>
		</div>
	</fieldset>
</div>

<div class="width-70 fltrt" id="files">

	<form action="<?php echo JRoute::_('index.php?option=com_podcast&view=assets') ?>" method="post" accept-charset="utf-8" name="adminForm" id="adminForm">
		<fieldset>
			<legend><?php echo JText::_('COM_PODCAST_MEDIA_ASSETS') ?></legend>
			<div class="filter-search fltlft">
				<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>&nbsp;</label>
				<input type="text" name="filter_search" id="search_assets" value="" title="<?php echo JText::_('COM_PODCAST_SEARCH_EPISODES'); ?>" size="50" />
				<button type="button" id="search_clear"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
			<div class="fltrt">
				<select name="engine" id="engine" onchange="Assets.page();">
					<option value=""><?php echo JText::_('COM_PODCAST_STORAGE_SELECT'); ?></option>
					<option value="custom"<?php if (JRequest::getString('filter_engine', '') == 'custom') echo ' selected="selected"'; ?>><?php echo JText::_('COM_PODCAST_STORAGE_CUSTOM'); ?></option>
					<option value="local"<?php if (JRequest::getString('filter_engine', '') == 'local') echo ' selected="selected"'; ?>><?php echo JText::_('COM_PODCAST_STORAGE_LOCAL'); ?></option>
				</select>
			</div>

		<table class="adminlist">
			<thead>
				<tr>
					<th width="1%">
						<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" id="check_all" />
					</th>
					<th class="title">
						<?php echo JText::_('COM_PODCAST_MEDIA_PATH') ?>
					</th>
					<th>
						<?php echo JText::_('COM_PODCAST_MEDIA_FILESIZE') ?>
					</th>
					<th class="title">
						<?php echo JText::_('COM_PODCAST_MEDIA_DURATION') ?>
					</th>
					<th><?php echo JText::_('COM_PODCAST_MEDIA_TYPE') ?></th>
				</tr>
			</thead>
			<tfoot id="media_pagination">
			</tfoot>
			<script type="text/html" id="pagination_template">
				<tr>
					<td align="center" colspan="20">
						<div class="pagination">
							<div class="button2-right" id="page_start"><div class="start"><a onclick="Assets.page(1);" title="Start" href="#assets"><?php echo JText::_('JLIB_HTML_START') ?></a></div></div>
							<div class="button2-right" id="page_prev"><div class="prev"><a onclick="Assets.page({{previous}});" title="Prev" href="#assets"><?php echo JText::_('JPREV') ?></a></div></div>
							<div class="button2-left" id="page_pages"><div class="page"></div></div>
							<div class="button2-left" id="page_next"><div class="next"><a onclick="Assets.page({{next}});" title="Next" href="#assets"><?php echo JText::_('JNEXT') ?></a></div></div>
							<div class="button2-left" id="page_last"><div class="end"><a onclick="Assets.page({{total}});" title="End" href="#assets"><?php echo JText::_('JLIB_HTML_END') ?></a></div></div>
							<div class="limit"><?php echo JText::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', '{{current}}', '{{total}}') ?></div>
						</div>
					</td>
				</tr>
			</script>
			<tbody id="media_list">

			</tbody>
			<script type="text/html" id="asset_template">
				<tr rel="{{podcast_asset_id}}">
					<td align="center" width="1%">
						<input type="checkbox" name="cid[]" value="{{podcast_asset_id}}" class="asset_checkbox" />
					</td>
					<td class="url">{{asset_enclosure_url}}</td>
					<td class="length">{{asset_enclosure_length}}</td>
					<td class="duration">{{asset_duration}}</td>
					<td class="type">{{asset_enclosure_type}}</td>
				</tr>
			</script>
		</table>
		</fieldset>
		<input type="hidden" name="boxchecked" value="0" id="boxchecked" />
		<input type="hidden" name="task" value="" id="task" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>

<div class="clr"></div>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">Podcast Suite v2.0</a> | Copyright &copy; 2012 <a href="http://www.corywebbmedia.com">Cory Webb Media, LLC</a></p>
</div>