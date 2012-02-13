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

$doc->addScript(JURI::root().'media/com_podcast/js/admin/episode.js');
$doc->addScriptDeclaration("Episode.token = '" . JUtility::getToken() . "';");
$doc->addScriptDeclaration("Episode.url_root = '" . JURI::root() . "';");

?>

<form action="index.php?option=com_podcast&amp;episode_id=<?php echo $this->item->episode_id ?>" method="post" name="adminForm" class="form-validate">

	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_BASIC'); ?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('top-col-1') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>

		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_MEDIA'); ?></legend>

			<li id="upload">
			    <ul id="filelist"></ul>
			    <br />
			    <a id="pickfiles" href="javascript:;">[Select files]</a>
			    <a id="uploadfiles" href="javascript:;">[Upload files]</a>
			</li>

			<ul class="adminformlist">

				<li><?php echo $this->form->getLabel('item_enclosure_url'); ?>
				<?php echo $this->form->getInput('item_enclosure_url'); ?></li>

				<li><?php echo $this->form->getLabel('item_enclosure_length'); ?>
				<?php echo $this->form->getInput('item_enclosure_length'); ?></li>

				<li><?php echo $this->form->getLabel('item_duration'); ?>
				<?php echo $this->form->getInput('item_duration'); ?></li>

				<li><?php echo $this->form->getLabel('item_enclosure_type'); ?>
				<?php echo $this->form->getInput('item_enclosure_type'); ?></li>
			</ul>

		</fieldset>


		<fieldset class="adminform">

			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('bottom') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>


		</fieldset>
	</div>

	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_EPISODE_EXTENDED'); ?></legend>

			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('right') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>

		</fieldset>

        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_PODCAST_EPISODE_ASSETS'); ?></legend>
                <?php echo JHtml::_('tabs.start'); ?>
                <?php echo JHtml::_('tabs.panel', 'Files', 'files'); ?>
                <?php echo $this->loadTemplate('directory'); ?>
                <?php echo JHtml::_('tabs.panel', 'Upload', 'upload'); ?>
                <?php echo JHtml::_('tabs.end'); ?>
        </fieldset>
	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">Podcast Suite v2.0</a> | Copyright &copy; 2012 <a href="http://www.corywebbmedia.com">Cory Webb Media, LLC</a></p>
</div>