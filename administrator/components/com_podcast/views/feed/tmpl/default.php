<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

?>
<form action="index.php?option=com_podcast&amp;feed_id=<?php echo $this->item->feed_id ?>"
	method="post" name="adminForm" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_FEED'); ?></legend>
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
		
		<?php if ($this->item->feed_id) : ?>
		<fieldset class="adminform">
			
			<ul class="adminformlist">
				<li><label><?php echo JText::_('COM_PODCAST_FIELD_SHOW_SUBSCRIBE'); ?></label><input type="text" size="50" value="<?php echo str_replace('/administrator', '', JURI::current()); ?>?option=com_podcast&view=feed&format=raw&feed_id=<?php echo $this->item->feed_id; ?>" onclick="javascript:this.focus();this.select();" /></li>
			</ul>
			
		</fieldset>
		<?php endif; ?>
	</div>

	<div class="width-40 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_PODCAST_FEED_EXTENDED'); ?></legend>

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
	<p><?php echo JText::_('COM_PODCAST_COPYRIGHT'); ?></p>
</div>