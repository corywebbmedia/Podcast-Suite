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

<?php if ($this->params->get('show_feed', '1') == '1') : ?>
	<h2 class="podcast_feed"><?php echo $this->escape($this->items[0]->feed_title); ?></h2>
<?php endif; ?>
<?php if ($this->params->get('show_subscribe', '1') == '1') : ?>
	<span class="podcast_subscribe"><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=feed&format=raw&feed_id='.$this->items[0]->feed_id) ?>"><?php echo JText::_('COM_PODCAST_EPISODES_SUBSCRIBE') ?></a></span>
<?php endif; ?>
<div class="clear"></div>
<?php foreach ($this->items as $item) :
$asset = $this->assets[$item->episode_id][0];
?>

<div class="podcast_header_title">
	<?php if ($this->params->get('show_image', '1') == '1' && $item->episode_image) : ?>
		<img src="<?php echo JURI::base().$item->episode_image; ?>" class="podcast_episodes_image" />
	<?php endif; ?>
	<?php if ($this->params->get('show_title', '1') == '1') : ?>
		<h3 class="podcast_title"><a href="<?php echo JRoute::_('index.php?option=com_podcast&view=episode&episode_id='.$item->episode_id) ?>"><?php echo $this->escape($item->episode_title) ?></a></h3>
	<?php endif; ?>
	<?php if ($this->params->get('show_subtitle', '1') == '1') : ?>
		<h5 class="podcast_subtitle"><?php echo $this->escape($item->episode_subtitle) ?></h5>
	<?php endif; ?>
	<?php if ($this->params->get('show_keywords', '1') == '1') : ?>
		<span class="podcast_keywords"><?php echo $this->escape($item->episode_keywords) ?></span>
	<?php endif; ?>
</div>

<div class="podcast_header_meta">
	<?php if ($this->params->get('show_author', '1') == '1') : ?>
		<span class="podcast_author"><?php echo JText::_('COM_PODCAST_EPISODES_AUTHOR'); ?>: <?php echo $this->escape($item->episode_author) ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_date', '1') == '1') : ?>
		<span class="podcast_date"><?php echo JText::_('COM_PODCAST_EPISODES_DATE') ?>: <?php echo JHtml::_('date', strtotime($item->episode_pubDate), JText::_('DATE_FORMAT_LC1')); ?></span>
	<?php endif; ?>
	<?php if ($this->params->get('show_duration', '1') == '1') : ?>
		<span class="podcast_duration"><?php echo JText::_('COM_PODCAST_EPISODES_DURATION') ?>: <?php echo $this->escape($asset->asset_duration) ?></span>
	<?php endif; ?>
</div>

<hr class="clear" />

<?php endforeach; ?>

<?php if ($this->params->get('show_pagination', '1') == '1') : ?>
<div class="pagination">
	<p class="counter">
		<?php echo $this->pagination->getPagesCounter(); ?>
	</p>

	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php endif; ?>
