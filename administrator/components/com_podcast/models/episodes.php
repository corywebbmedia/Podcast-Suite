<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelEpisodes extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('pm.*, 
            pf.feed_title,
            pa.asset_enclosure_url AS item_enclosure_url, 
            pa.asset_enclosure_length AS item_enclosure_length, 
            pa.asset_duration AS item_duration,
            pa.asset_enclosure_type AS item_enclosure_type,
            pa.asset_closed_caption AS item_closed_caption')
			->from('#__podcast_episodes AS pm')
            ->join('LEFT', '#__podcast_assets AS pa USING(episode_id)')
			->join('LEFT', '#__podcast_feeds AS pf USING(feed_id)')
            ->group('pm.episode_id');
        
        // Filter by search
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('pm.item_title LIKE '.$search);
		}
        
        // Filter by folder
		$feed = $this->getState('filter.feed');
		if (!empty($feed)) {
			$query->where('pf.feed_id = '.$feed);
		}
        
        // Filter by published state
		$state = $this->getState('filter.state');
		if (!empty($state)) {
			$query->where('pm.published = ' . (int) $state);
		}

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as &$item) {
			if ($item->item_pubDate == '0000-00-00') {
				$item->item_pubDate = null;
			}
		}

		return $items;
	}
    
    protected function populateState($ordering = null, $direction = null)
	{
		// Load the filter search.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'search');
		$this->setState('filter.search', $search);
        
        // Load the filter folder
        $feed = $this->getUserStateFromRequest($this->context.'.filter.feed', 'filter_feed');
        $this->setState('filter.feed', $feed);
        
        // Load the filter state
        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		// List state information.
		parent::populateState('pm.item_title', 'asc');
	}
}