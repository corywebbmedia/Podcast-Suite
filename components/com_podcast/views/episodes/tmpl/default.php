<?php 
defined( '_JEXEC' ) or die; 

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root().'media/com_podcast/css/podcast.css');

?>

<h2 class="podcast_feed"><?php echo $this->escape($this->items[0]->feed_title); ?></h2>
<span class="podcast_subscribe"><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=feed&format=raw&feed_id='.$this->items[0]->feed_id) ?>">Subscribe</a></span>

<?php foreach ($this->items as $item) : 
$asset = $this->assets[$item->episode_id][0];    
?>

<div class="podcast_header_title">
    <h3 class="podcast_title"><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=episode&episode_id='.$item->episode_id) ?>"><?php echo $this->escape($item->item_title) ?></a></h3>
    <h5 class="podcast_subtitle"><?php echo $this->escape($item->item_subtitle) ?></h5>
    <span class="podcast_keywords"><?php echo $this->escape($item->item_keywords) ?></span>
</div>

<div class="podcast_header_meta">
    <span class="podcast_author"><?php echo JText::_('COM_PODCAST_AUTHOR'); ?>: <?php echo $this->escape($item->item_author) ?></span>
    <span class="podcast_date">Date: <?php echo $this->escape($item->item_pubDate) ?></span>
    <span class="podcast_duration">Duration: <?php echo $this->escape($asset->asset_duration) ?></span>
</div>

<div class="clear"></div>

<?php endforeach; ?>