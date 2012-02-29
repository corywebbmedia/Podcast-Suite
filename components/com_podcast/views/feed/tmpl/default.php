<?php
defined( '_JEXEC' ) or die;

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root().'media/com_podcast/css/podcast.css');

?>

<div class="podcast_feed_left">
    <h3 class="podcast_title"><?php echo $this->escape($this->feed->feed_title); ?></h3>
    <h5 class="podcast_subtitle"><?php echo $this->escape($this->feed->feed_subtitle); ?></h5>
    <?php echo $this->escape($this->feed->feed_summary); ?>
</div>

<div class="podcast_feed_right">
    <span class="podcast_subscribe"><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=feed&format=raw&feed_id='.$this->feed->feed_id) ?>"><?php echo JText::_('COM_PODCAST_FEED_SUBSCRIBE') ?></a></span>
    <img src="<?php echo $this->feed->feed_image; ?>" />
    <span class="podcast_feed_episodes"><?php echo JText::_('COM_PODCAST_FEED_EPISODES') ?>: <?php echo $this->escape($this->feed->episodes); ?></span>
    <span class="podcast_author"><?php echo JText::_('COM_PODCAST_FEED_AUTHOR'); ?>: <?php echo $this->escape($this->feed->feed_author) ?></span>
    <span class="podcast_date"><?php echo JText::_('COM_PODCAST_FEED_KEYWORDS'); ?>: <?php echo $this->escape($this->feed->feed_keywords) ?></span>
    <span class="podcast_duration"><?php echo JText::_('COM_PODCAST_FEED_COPYRIGHT'); ?>: <?php echo $this->escape($this->feed->feed_copyright) ?></span>
</div>

<div class="clear"></div>