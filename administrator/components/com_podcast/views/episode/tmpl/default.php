<?php
defined( '_JEXEC' ) or die;

JHTML::_('behavior.mootools');

$doc = JFactory::getDocument();

$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.gears.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.silverlight.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.flash.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html4.js');
$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.html5.js');

$doc->addScript(JURI::root().'media/com_podcast/js/admin/mustache.js');

$doc->addScript(JURI::root().'media/com_podcast/js/admin/upload.js');
$doc->addScriptDeclaration("Upload.token = '" . JUtility::getToken() . "';");
$doc->addScriptDeclaration("Upload.url_root = '" . JURI::root() . "';");

$doc->addScript(JURI::root().'media/com_podcast/js/admin/episode.js');
$doc->addScriptDeclaration("EpisodeMedia.episode_id = '" . $this->item->episode_id . "';");

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
			<legend><?php echo JText::_('*Episode Media'); ?></legend>
            <table class="adminlist">
                <thead>
                    <tr>
                        <th class="title">
                            <?php echo JText::_('*Default'); ?>
                        </th>
                        <th class="title">
                            <?php echo JText::_('*File'); ?>
                        </th>
                        <th class="title">
                            <?php echo JText::_('*Duration'); ?>
                        </th>
                        <th class="title">
                            <?php echo JText::_('*Remove'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody id="episode_asset_list">
                </tbody>
				<script type="text/html" id="episode_asset">
					<tr rel="{{asset_id}}">
						<td align="center">
							<span class="{{media_default}} media-button">&nbsp;</span>
						</td>
						<td>{{asset_enclosure_url}}</td>
						<td>{{asset_duration}}</td>
						<td align="center">
							<span class="media-delete media-button" rel="{{asset_id}}">&nbsp;</span>
						</td>
					</tr>
				</script>
            </table>
            <div class="media-toolbar">
				<input type="button" name="upload_media" value="Upload" id="upload_media" class="button" />
				<input type="button" name="add_custom" value="Add Custom" id="add_custom" class="button" />
				<input type="button" name="browse_available" value="Browse Available" id="browse_available" class="button" />
            </div>
		</fieldset>

		<fieldset class="adminform" id="available">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_ASSETS'); ?></legend>
			<table class="adminlist">
			    <thead>
			        <tr>
			            <th width="1%">
			                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
			            </th>
			            <th class="title">
			                <?php echo JText::_('*Default'); ?>
			            </th>
			            <th class="title">
			                <?php echo JText::_('*File'); ?>
			            </th>
			            <th class="title">
			                <?php echo JText::_('*Length'); ?>
			            </th>
			            <th class="title">
			                <?php echo JText::_('*Duration'); ?>
			            </th>
			            <th class="title">
			                <?php echo JText::_('*Type'); ?>
			            </th>
			        </tr>
			    </thead>
			    <tfoot></tfoot>
			    <tbody id="available_items">

			    </tbody>
			</table>
		</fieldset>

		<fieldset class="adminform" id="custom_media">
			<legend>Custom Media</legend>


		</fieldset>

    </div>

	<input type="hidden" name="asset_ids" value="" id="asset_ids" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div class="clr"></div>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">Podcast Suite v2.0</a> | Copyright &copy; 2012 <a href="http://www.corywebbmedia.com">Cory Webb Media, LLC</a></p>
</div>