<?php defined( '_JEXEC' ) or die; ?>
<?php foreach ($this->items as $item): ?>
	<h3><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=item&media_id=' . $item->media_id) ?>"><?php echo $this->escape($item->item_title) ?></a></h3>

	<dl>
		<dt><strong>subtitle</strong></dt>
		<dd><?php echo $this->escape($item->item_author) ?></dd>

		<dt><strong>summary</strong></dt>
		<dd><?php echo $this->escape($item->item_summary) ?></dd>

		<dt><strong>description</strong></dt>
		<dd><?php echo $this->escape($item->item_description) ?></dd>

		<dt><strong>enclosure url</strong></dt>
		<dd><?php echo $this->escape($item->item_enclosure_url) ?></dd>

		<dt><strong>enclosure length</strong></dt>
		<dd><?php echo $this->escape($item->item_enclosure_length) ?></dd>

		<dt><strong>enclosure type</strong></dt>
		<dd><?php echo $this->escape($item->item_enclosure_type) ?></dd>

		<dt><strong>guid</strong></dt>
		<dd><?php echo $this->escape($item->item_guid) ?></dd>

		<dt><strong>published date</strong></dt>
		<dd><?php echo $this->escape($item->item_pubDate) ?></dd>

		<dt><strong>item duration</strong></dt>
		<dd><?php echo $this->escape($item->item_duration) ?></dd>

		<dt><strong>item keywords</strong></dt>
		<dd><?php echo $this->escape($item->item_keywords) ?></dd>

		<dt><strong>closed captioned</strong></dt>
		<?php if ($item->item_isClosedCaptioned): ?>
			<dd>yes</dd>
		<?php else: ?>
			<dd>no</dd>
		<?php endif ?>

		<dt><strong>created</strong></dt>
		<dd><?php echo $this->escape($item->item_created) ?></dd>


	</dl>
<?php endforeach ?>