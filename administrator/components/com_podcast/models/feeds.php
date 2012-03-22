<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeeds extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'feed_title',
				'feed_summary',
				'item_count',
				'feed_created',
				'published',
				'feed_default'
			);
		}

		parent::__construct($config);
	}

	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('pf.*, count(pm.feed_id) as item_count')
			->from('#__podcast_feeds AS pf')
			->join('LEFT', '#__podcast_episodes AS pm USING(feed_id)')
			->group('feed_id');

        // Filter by search
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$db = $this->getDbo();
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('pf.feed_title LIKE '.$search);
		}

        // Filter by published state
		$state = $this->getState('filter.state');
		if ($state != '') {
			$query->where('pf.published = ' . (int) $state);
		}

		$orderCol = $this->getState('list.ordering');
		$orderDirn = $this->getState('list.direction');

		if ($orderCol != '') {
			$db = $this->getDbo();
			$query->order($db->getEscaped($orderCol.' '.$orderDirn));
		}

		return $query;
	}

    protected function populateState($ordering = null, $direction = null)
	{
		// Load the filter search.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

        // Load the filter state
        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		// List state information.
		parent::populateState('feed_title', 'asc');
	}
}