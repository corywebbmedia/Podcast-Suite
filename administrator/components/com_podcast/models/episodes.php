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

class PodcastModelEpisodes extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('tbl.*, f.feed_title, a.asset_enclosure_url')
				->select('a.asset_enclosure_length, a.asset_duration')
				->select('a.asset_enclosure_type, a.asset_closed_caption')
				->from('#__podcast_episodes AS tbl')
				->join('LEFT', '#__podcast_assets_map AS m ON tbl.episode_id = m.episode_id')
				->join('LEFT', '#__podcast_assets AS a ON a.podcast_asset_id = m.podcast_asset_id')
				->join('LEFT', '#__podcast_feeds AS f USING(feed_id)')
				->group('tbl.episode_id');

        // Filter by search
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$db = $this->getDbo();
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('tbl.episode_title LIKE '.$search);
		}

        // Filter by folder
		$feed = $this->getState('filter.feed');
		if (!empty($feed)) {
			$query->where('f.feed_id = '.$feed);
		}

        // Filter by published state
		$state = $this->getState('filter.state');
		if ($state != '') {
			$query->where('tbl.published = ' . (int) $state);
		}

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as &$item) {
			if ($item->episode_pubDate == '0000-00-00') {
				$item->episode_pubDate = null;
			}
		}

		return $items;
	}

    protected function populateState($ordering = null, $direction = null)
	{
		// Load the filter search.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

        // Load the filter folder
        $feed = $this->getUserStateFromRequest($this->context.'.filter.feed', 'filter_feed');
        $this->setState('filter.feed', $feed);

        // Load the filter state
        $state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		// List state information.
		parent::populateState('pm.episode_title', 'asc');
	}
}