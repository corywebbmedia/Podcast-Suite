<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

JHTML::_('behavior.mootools');

$doc = JFactory::getDocument();


$doc->addScript(JURI::root().'media/com_podcast/js/admin/mustache.js');

$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.flash.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html5.js');
$doc->addScript(JURI::root().'media/com_podcast/js/admin/upload.js');
$doc->addScriptDeclaration("Upload.token = '" . JUtility::getToken() . "';");
$doc->addScriptDeclaration("Upload.url_root = '" . JURI::root() . "';");

$doc->addScript(JURI::root().'media/com_podcast/js/admin/episode.js');
$doc->addScriptDeclaration("EpisodeMedia.episode_id = '" . $this->item->episode_id . "';");
$doc->addScriptDeclaration("EpisodeMedia.token = '" . JUtility::getToken() . "';");

?>

<form action="index.php?option=com_podcast&amp;episode_id=<?php if (isset($this->item->episode_id)) echo (int) $this->item->episode_id ?>" method="post" name="adminForm" class="form-validate">

	<div class="width-50 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_BASIC'); ?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('top-col-1') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>
		</fieldset>
	</div>

	<div class="width-50 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_EXTENDED'); ?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('right') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>
		</fieldset>
	</div>

	<div class="clr"></div>

	<div class="width-100">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_MEDIA'); ?></legend>
			<table class="adminlist">
				<thead>
					<tr>
						<th class="title">
							<?php echo JText::_('COM_PODCAST_EPISODE_MEDIA_DEFAULT'); ?>
						</th>
						<th class="title">
							<?php echo JText::_('COM_PODCAST_EPISODE_MEDIA_FILE'); ?>
						</th>
						<th class="title">
							<?php echo JText::_('COM_PODCAST_EPISODE_MEDIA_LENGTH'); ?>
						</th>
						<th class="title">
							<?php echo JText::_('COM_PODCAST_EPISODE_MEDIA_DURATION'); ?>
						</th>
						<th class="title">
							<?php echo JText::_('COM_PODCAST_EPISODE_MEDIA_TYPE'); ?>
						</th>
						<th class="title">
							<?php echo JText::_('COM_PODCAST_EPISODE_MEDIA_REMOVE'); ?>
						</th>
					</tr>
				</thead>
				<tbody id="episode_asset_list">
				</tbody>
				<script type="text/html" id="episode_asset">
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
			<div id="uploader_container">
				<input type="button" name="upload_media" value="<?php echo JText::_('COM_PODCAST_EPISODE_BUTTON_UPLOAD') ?>" id="upload_media" class="button" />
				<input type="button" name="add_custom" value="<?php echo JText::_('COM_PODCAST_EPISODE_BUTTON_ADD_CUSTOM') ?>" id="add_custom" class="button" />
				<input type="button" name="browse_available" value="<?php echo JText::_('COM_PODCAST_EPISODE_BUTTON_BROWSE_AVAILABLE') ?>" id="browse_available" class="button" />
			</div>

			<div id="uploaded_files">
				<ul id="upload_file_list"></ul>
			</div>

		</fieldset>

		<fieldset class="adminform" id="available">
			<a name="assets"></a>
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_ASSETS'); ?></legend>
			<label><?php echo JText::_('COM_PODCAST_EPISODE_ASSETS_SEARCH'); ?> </label><input type="text" value="" id="search_assets" size="30" />
			<div class="fltrt">
				<select name="engine" id="engine" onchange="AvailableAssets.page();">
					<option value=""><?php echo JText::_('COM_PODCAST_STORAGE_SELECT'); ?></option>
					<option value="custom"<?php if (JRequest::getString('filter_engine', '') == 'custom') echo ' selected="selected"'; ?>><?php echo JText::_('COM_PODCAST_STORAGE_CUSTOM'); ?></option>
					<option value="local"<?php if (JRequest::getString('filter_engine', '') == 'local') echo ' selected="selected"'; ?>><?php echo JText::_('COM_PODCAST_STORAGE_LOCAL'); ?></option>
				</select>
			</div>
			<table class="adminlist">
				<thead>
					<tr>
						<th width="1%">
							<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
						</th>
						<th class="title" width="70%">
							<?php echo JText::_('COM_PODCAST_EPISODE_ASSETS_FILE'); ?>
						</th>
						<th class="title" width="10%">
							<?php echo JText::_('COM_PODCAST_EPISODE_ASSETS_LENGTH'); ?>
						</th>
						<th class="title" width="10%">
							<?php echo JText::_('COM_PODCAST_EPISODE_ASSETS_DURATION'); ?>
						</th>
						<th class="title" width="10%">
							<?php echo JText::_('COM_PODCAST_EPISODE_ASSETS_TYPE'); ?>
						</th>
					</tr>
				</thead>
				<tfoot id="available_asset_pagination"></tfoot>
				<script type="text/html" id="asset_pagination">
					<tr>
						<td align="center" colspan="20">
							<div class="pagination">
								<div class="button2-right" id="page_start"><div class="start"><a onclick="AvailableAssets.page(1);" title="Start" href="#assets"><?php echo JText::_('JLIB_HTML_START') ?></a></div></div>
								<div class="button2-right" id="page_prev"><div class="prev"><a onclick="AvailableAssets.page({{previous}});" title="Prev" href="#assets"><?php echo JText::_('JPREV') ?></a></div></div>
								<div class="button2-left" id="page_pages"><div class="page"></div></div>
								<div class="button2-left" id="page_next"><div class="next"><a onclick="AvailableAssets.page({{next}});" title="Next" href="#assets"><?php echo JText::_('JNEXT') ?></a></div></div>
								<div class="button2-left" id="page_last"><div class="end"><a onclick="AvailableAssets.page({{total}});" title="End" href="#assets"><?php echo JText::_('JLIB_HTML_END') ?></a></div></div>
								<div class="limit"><?php echo JText::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', '{{current}}', '{{total}}') ?></div>
							</div>
						</td>
					</tr>
				</script>
				<tbody id="available_asset_list" style="height: 350px;">
					<?php for ($i=0; $i<15; $i++) : ?>
					<tr>
						<td>Blank</td><td>Blank</td><td>Blank</td><td>Blank</td><td>Blank</td>
					</tr>
					<?php endfor; ?>
				</tbody>
				<script type="text/html" id="available_asset">
					<tr rel="{{podcast_asset_id}}">
						<td align="center">
							<span class="jgrid"><span class="publish add_asset" rel="{{podcast_asset_id}}">&nbsp;</span></span>
						</td>
						<td class="url">{{asset_enclosure_url}}</td>
						<td class="length">{{asset_enclosure_length}}</td>
						<td class="duration">{{asset_duration}}</td>
						<td class="type">{{asset_enclosure_type}}</td>
					</tr>
				</script>
			</table>
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

	</div>

	<input type="hidden" name="asset_default" value="" id="asset_default" />
	<input type="hidden" name="asset_ids" value="" id="asset_ids" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div class="clr"></div>

<div id="podcast_suite_link">
	<p><?php echo JText::_('COM_PODCAST_COPYRIGHT'); ?></p>
</div>