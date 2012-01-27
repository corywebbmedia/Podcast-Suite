<?php defined( '_JEXEC' ) or die; ?>

<form action="index.php?option=com_podcast&amp;feed_item_id=<?php echo $this->item->feed_item_id ?>"
	method="post" name="adminForm" class="form-validate">

	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_FEED_ITEM_BASIC'); ?></legend>
			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('top-col-1') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>

			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('top-col-2') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
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
			<legend><?php echo JText::_('COM_PODCAST_FEED_ITEM_EXTENDED'); ?></legend>

			<ul class="adminformlist">
				<?php foreach ($this->form->getFieldset('right') as $field): ?>
					<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
				<?php endforeach ?>
			</ul>


		</fieldset>

	</div>

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">podcastsuite.com</p>
</div>