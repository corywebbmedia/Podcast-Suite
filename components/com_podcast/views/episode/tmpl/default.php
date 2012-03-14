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

<div class="podcast_header_title">
	<?php if ($this->params->get('show_image', '1') == '1' && $this->item->episode_image) : ?>
		<img src="<?php echo JURI::base().$this->item->episode_image; ?>" class="podcast_episodes_image" />
	<?php endif; ?>
	<?php if ($this->params->get('show_title', '1') == '1') : ?>
		<h3 class="podcast_title"><?php echo $this->escape($this->item->episode_title) ?></h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_subtitle', '1') == '1') : ?>
		<h5 class="podcast_subtitle"><?php echo $this->escape($this->item->episode_subtitle) ?></h5>
	<?php endif; ?>
	<?php if ($this->params->get('show_feed', '1') == '1') : ?>
		<h5 class="podcast_feed"><?php echo JText::_('COM_PODCAST_EPISODE_SERIES') ?>: <?php echo $this->escape($this->item->feed_title); ?></h5>
	<?php endif; ?>
</div>

<div class="podcast_header_meta">
	<?php if ($this->params->get('show_author', '1') == '1') : ?>
		<span class="podcast_author"><?php echo JText::_('COM_PODCAST_EPISODE_AUTHOR'); ?>: <?php echo $this->escape($this->item->episode_author) ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_date', '1') == '1') : ?>
		<span class="podcast_date"><?php echo JText::_('COM_PODCAST_EPISODE_DATE') ?>: <?php echo JHtml::_('date', strtotime($this->item->episode_pubDate), JText::_('DATE_FORMAT_LC1')); ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_duration', '1') == '1') : ?>
		<span class="podcast_duration"><?php echo JText::_('COM_PODCAST_EPISODE_DURATION') ?>: <?php echo $this->escape($this->asset->asset_duration) ?></span>
	<?php endif; ?>
</div>

<div class="clear"></div>

<?php if ($this->params->get('show_media', '1') == '1') : ?>
<div class="podcast_media">
	<?php echo $this->loadTemplate($this->storage->getAssetType($this->asset->asset_enclosure_type)); ?>
</div>
<?php endif; ?>

<?php if ($this->params->get('show_summary', '1') == '1') : ?>
<div class="podcast_summary">
	<?php echo $this->escape($this->item->episode_summary) ?>
</div>
<?php endif; ?>

<?php if ($this->params->get('show_assets', '1') == '1' && count($this->assets) > 1) : array_shift($this->assets); ?>
<ul class="podcast_assets">
	<?php foreach ($this->assets as $asset) : ?>
	<li><?php echo $asset->asset_enclosure_url; ?></li>
	<?php endforeach ?>
</ul>
<?php endif; ?>