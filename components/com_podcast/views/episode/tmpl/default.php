<?php defined( '_JEXEC' ) or die; ?>
<h3><?php echo $this->escape($this->item->item_title) ?></h3>

<dl>
	<dt><strong>author</strong></dt>
	<dd><?php echo $this->escape($this->item->item_author) ?></dd>

	<dt><strong>subtitle</strong></dt>
	<dd><?php echo $this->escape($this->item->item_author) ?></dd>

	<dt><strong>summary</strong></dt>
	<dd><?php echo $this->escape($this->item->item_summary) ?></dd>

	<dt><strong>enclosure url</strong></dt>
	<dd><?php echo $this->escape($this->item->item_enclosure_url) ?></dd>

	<dt><strong>enclosure length</strong></dt>
	<dd><?php echo $this->escape($this->item->item_enclosure_length) ?></dd>

	<dt><strong>enclosure type</strong></dt>
	<dd><?php echo $this->escape($this->item->item_enclosure_type) ?></dd>

	<dt><strong>guid</strong></dt>
	<dd><?php echo $this->escape($this->item->item_guid) ?></dd>

	<dt><strong>published date</strong></dt>
	<dd><?php echo $this->escape($this->item->item_pubDate) ?></dd>

	<dt><strong>item duration</strong></dt>
	<dd><?php echo $this->escape($this->item->item_duration) ?></dd>

	<dt><strong>item keywords</strong></dt>
	<dd><?php echo $this->escape($this->item->item_keywords) ?></dd>

	<dt><strong>closed captioned</strong></dt>
	<?php if ($this->item->item_isClosedCaptioned): ?>
		<dd>yes</dd>
	<?php else: ?>
		<dd>no</dd>
	<?php endif ?>

	<dt><strong>created</strong></dt>
	<dd><?php echo $this->escape($this->item->item_created) ?></dd>

</dl>