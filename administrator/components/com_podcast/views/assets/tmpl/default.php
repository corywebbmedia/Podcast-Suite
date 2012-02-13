<?php 
defined( '_JEXEC' ) or die;
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
JHtml::_('behavior.mootools');
?>

<div class="width-30 fltlft">
    <?php echo $this->loadTemplate('bins'); ?>
</div>

<div class="width-70 fltrt">
<form action="<?php echo JRoute::_('index.php?option=com_podcast&view=assets'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_PODCAST_SEARCH_EPISODES'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
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
					<?php echo JHtml::_('grid.sort', 'COM_PODCAST_ASSET_PATH', 'asset_enclosure_url', $listDirn, $listOrder); ?>
				</th>
				<th class="title">
					<?php echo JHtml::_('grid.sort', 'COM_PODCAST_ASSET_FILE', 'asset_enclosure_url', $listDirn, $listOrder); ?>
				</th>
                <th>Uses</th>
                <th>Status</th>
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
					<?php echo JHtml::_('grid.id', $i, $item->asset_id); ?>
				</td>
                <td>
                    <?php echo dirname($item->asset_enclosure_url); ?>
                </td>
				<td>
					<?php echo basename($item->asset_enclosure_url); ?>
				</td>
                <td>
                    <?php echo $item->episodes; ?>
                </td>
                <td class="jgrid">
                    <?php $state = array_shift($this->plugin->trigger('onFileVerify', $item->asset_enclosure_url)); ?>
                    <?php if ($state) : ?>
                    <span class="state publish"></span>
                    <?php else : ?>
                    <span class="state unpublish"></span>
                    <?php endif; ?>
                </td>
			</tr>
			<?php endforeach; ?>
           
		</tbody> 
        <?php if (empty($this->items)) : ?>
        <tr><td>No files</td></tr>
        <?php endif; ?>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
</div>

<div class="clr"></div>

<div id="podcast_suite_link">
	<p><a href="http://podcastsuite.com">Podcast Suite v2.0</a> | Copyright &copy; 2012 <a href="http://www.corywebbmedia.com">Cory Webb Media, LLC</a></p>
</div>