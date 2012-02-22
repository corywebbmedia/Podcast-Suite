<?php 
defined( '_JEXEC' ) or die; 

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root().'media/com_podcast/css/podcast.css');

$this->asset = $this->assets[0];

?>

<div class="podcast_header_title">
    <h3 class="podcast_title"><?php echo $this->escape($this->item->item_title) ?></h3>
    <h5 class="podcast_subtitle"><?php echo $this->escape($this->item->item_subtitle) ?></h5>
    <h5 class="podcast_feed">Series: <?php echo $this->escape($this->item->feed_title); ?></h5>
</div>

<div class="podcast_header_meta">
    <span class="podcast_keywords"><?php echo $this->escape($this->item->item_keywords) ?></span>
    <span class="podcast_author"><?php echo JText::_('COM_PODCAST_AUTHOR'); ?>: <?php echo $this->escape($this->item->item_author) ?></span>
    <span class="podcast_date">Date: <?php echo $this->escape($this->item->item_pubDate) ?></span>
    <span class="podcast_duration">Duration: <?php echo $this->escape($this->asset->asset_duration) ?></span>
</div>

<div class="clear"></div>

<div class="podcast_media">
    <?php echo $this->loadTemplate($this->storage->getAssetType($this->asset->asset_enclosure_type)); ?>
</div>

<div class="podcast_summary">
    <?php echo $this->escape($this->item->item_summary) ?>
</div>

<?php if (count($this->assets) > 1) : ?>
<div class="podcast_assets">
    
</div>
<?php endif; ?>