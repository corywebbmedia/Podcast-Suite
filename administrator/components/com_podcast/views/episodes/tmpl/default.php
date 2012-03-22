<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$feeds = array();
?>
<form action="<?php echo JRoute::_('index.php?option=com_podcast&view=episodes'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_PODCAST_SEARCH_EPISODES'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>

		<div class="filter-select fltrt">
			<select name="filter_feed" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_PODCAST_SELECT_FEED');?></option>
				<?php foreach ($this->filter_feeds as $feed) {
					$feeds[] = JHtml::_('select.option', (string) $feed->feed_id, (string) $feed->feed_title);
				} ?>
				<?php echo JHtml::_('select.options', $feeds, 'value', 'text', $this->state->get('filter.feed'), true);?>
			</select>
			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived' => false, 'trash' => false, 'all' => false)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
		</div>

	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'COM_PODCAST_EPISODE_TITLE', 'episode_title', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_PODCAST_LOCATION', 'asset_enclosure_url', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_PODCAST_FEED', 'feed_title', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JENABLED', 'published', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_PODCAST_PUBLISHED_DATE', 'episode_pubDate', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="6">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item): ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->episode_id); ?>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_podcast&task=episode.edit&episode_id='. $item->episode_id); ?>"><?php echo $this->escape($item->episode_title) ?></a>
				</td>
				<td>
					<a href="<?php echo $item->asset_enclosure_url ?>"><?php echo $this->escape($item->asset_enclosure_url) ?></a>
				</td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_podcast&task=feed.edit&feed_id='. $item->feed_id); ?>"><?php echo $this->escape($item->feed_title) ?></a>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'episodes.'); ?>
				</td>
				<td>
					<?php echo JHTML::_('date', $item->episode_pubDate) ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<div id="podcast_suite_link">
	<p><?php echo JText::_('COM_PODCAST_COPYRIGHT'); ?></p>
</div>