<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root().'media/com_podcast/css/podcast.css');

?>

<div class="podcast_feed_left">
	<?php if ($this->params->get('show_title', '1') == '1') : ?>
		<h3 class="podcast_title"><?php echo $this->escape($this->feed->feed_title); ?></h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_subtitle', '1') == '1') : ?>
		<h5 class="podcast_subtitle"><?php echo $this->escape($this->feed->feed_subtitle); ?></h5>
	<?php endif; ?>
	<?php if ($this->params->get('show_summary', '1') == '1') : ?>
		<?php echo $this->escape($this->feed->feed_summary); ?>
	<?php endif; ?>
</div>

<div class="podcast_feed_right">
	<?php if ($this->params->get('show_subscribe', '1') == '1') : ?>
		<span class="podcast_subscribe"><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=feed&format=raw&feed_id='.$this->feed->feed_id) ?>"><?php echo JText::_('COM_PODCAST_FEED_SUBSCRIBE') ?></a></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_image', '1') == '1') : ?>
		<img src="<?php echo $this->feed->feed_image; ?>" />
	<?php endif; ?>
	<?php if ($this->params->get('show_episodes', '1') == '1') : ?>
		<span class="podcast_feed_episodes"><?php echo JText::_('COM_PODCAST_FEED_EPISODES') ?>: <?php echo $this->escape($this->feed->episodes); ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_author', '1') == '1') : ?>
		<span class="podcast_author"><?php echo JText::_('COM_PODCAST_FEED_AUTHOR'); ?>: <?php echo $this->escape($this->feed->feed_author) ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_keywords', '1') == '1') : ?>
		<span class="podcast_keywords"><?php echo JText::_('COM_PODCAST_FEED_KEYWORDS'); ?>: <?php echo $this->escape($this->feed->feed_keywords) ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_copyright', '1') == '1') : ?>
		<span class="podcast_copyright"><?php echo JText::_('COM_PODCAST_FEED_COPYRIGHT'); ?>: <?php echo $this->escape($this->feed->feed_copyright) ?></span>
	<?php endif; ?>
</div>

<div class="clear"></div>