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

$doc = JFactory::getDocument();

$doc->addScript(JURI::root().'media/com_podcast/js/admin/mustache.js');

$doc->addScript(JURI::root().'media/com_podcast/js/admin/assets-editor.js');
$doc->addScriptDeclaration("Assets.token = '" . JUtility::getToken() . "';");
$doc->addScriptDeclaration("Assets.folder_root = '" . PodcastHelper::getStorage()->getRoot() . "';");
$doc->addScriptDeclaration("Assets.url_root = '" . JURI::root() . "';");
$doc->addScriptDeclaration("Assets.storage_engine = '".PodcastHelper::getStorage()->getType()."';");
$doc->addScriptDeclaration("Assets.editor = '".JRequest::getString('editor', 'text')."';");

?>

<div class="width-100" id="files">

	<form action="<?php echo JRoute::_('index.php?option=com_podcast') ?>" method="post" accept-charset="utf-8" name="adminForm" id="adminForm">
		<fieldset>
			<legend><?php echo JText::_('COM_PODCAST_MEDIA_ASSETS') ?></legend>
			<div class="filter-search fltlft">
				<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>&nbsp;</label>
				<input type="text" name="filter_search" id="search_assets" value="" title="<?php echo JText::_('COM_PODCAST_SEARCH_EPISODES'); ?>" size="50" />
				<button type="button" id="search_clear"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>

		<table class="adminlist">
			<thead>
				<tr>
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
					<td class="url"><a href="#" class="title" data-id="{{podcast_asset_id}}">{{asset_enclosure_url}}</a></td>
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