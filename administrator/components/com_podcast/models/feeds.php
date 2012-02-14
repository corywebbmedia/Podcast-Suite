<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeeds extends JModelList
{
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
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('pf.feed_title LIKE '.$search);
		}
        
        // Filter by published state
		$state = $this->getState('filter.state');
		if (!empty($state)) {
			$query->where('pf.published = ' . (int) $state);
		}

		return $query;
	}
    
    protected function populateState($ordering = null, $direction = null)
	{
		// Load the filter search.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'search');
		$this->setState('filter.search', $search);
        
        // Load the filter state
        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		// List state information.
		parent::populateState('pf.feed_title', 'asc');
	}
}