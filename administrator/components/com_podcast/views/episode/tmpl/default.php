<?php
defined( '_JEXEC' ) or die;

JHTML::_('behavior.mootools');

$doc = JFactory::getDocument();

$doc->addScript(JURI::root().'media/com_podcast/js/plupload/plupload.full.js');
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
                            <?php echo JText::_('*Length'); ?>
                        </th>
                        <th class="title">
                            <?php echo JText::_('*Duration'); ?>
                        </th>
                        <th class="title">
                            <?php echo JText::_('*Type'); ?>
                        </th>
                        <th class="title">
                            <?php echo JText::_('*Remove'); ?>
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
            <div class="media-toolbar">
				<input type="button" name="upload_media" value="Upload" id="upload_media" class="button" />
				<input type="button" name="add_custom" value="Add Custom" id="add_custom" class="button" />
				<input type="button" name="browse_available" value="Browse Available" id="browse_available" class="button" />
            </div>
		</fieldset>

		<fieldset class="adminform" id="available">
            <a name="assets"></a>
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_ASSETS'); ?></legend>
            <label>*Search: </label><input type="text" value="" id="search_assets" size="30" />
			<table class="adminlist">
			    <thead>
			        <tr>
			            <th width="1%">
			                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
			            </th>
			            <th class="title" width="70%">
			                <?php echo JText::_('*File'); ?>
			            </th>
			            <th class="title" width="10%">
			                <?php echo JText::_('*Length'); ?>
			            </th>
			            <th class="title" width="10%">
			                <?php echo JText::_('*Duration'); ?>
			            </th>
			            <th class="title" width="10%">
			                <?php echo JText::_('*Type'); ?>
			            </th>
			        </tr>
			    </thead>
			    <tfoot id="available_asset_pagination"></tfoot>
                <script type="text/html" id="asset_pagination">
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
			<legend>Custom Media</legend>

			<label for="asset_enclosure_url">URL</label><input type="text" name="asset_enclosure_url" value="" id="asset_enclosure_url">
			<label for="asset_enclosure_length">Enclosure Length</label><input type="text" name="asset_enclosure_length" value="" id="asset_enclosure_length">
			<label for="asset_enclosure_type">Enclosure Type</label><input type="text" name="asset_enclosure_type" value="" id="asset_enclosure_type">
			<label for="asset_duration">Duration</label><input type="text" name="asset_duration" value="" id="asset_duration">
			<label for="asset_closed_caption">Closed Captioned</label><select name="asset_closed_caption" id="asset_closed_caption">
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
            <div class="clr"></div>
            <input type="button" value="*Add Custom Media" class="button" id="add_custom_media" />

		</fieldset>

    </div>

	<input type="hidden" name="asset_default" value="" id="asset_default" />
	<input type="hidden" name="asset_ids" value="" id="asset_ids" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div class="clr"></div>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">Podcast Suite v2.0</a> | Copyright &copy; 2012 <a href="http://www.corywebbmedia.com">Cory Webb Media, LLC</a></p>
</div>