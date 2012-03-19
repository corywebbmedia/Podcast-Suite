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
	public function getListQuery()
	{
		$query = parent::getListQuery();
		
		$feed_id = JRequest::getInt('feed_id', 0);

		$query->select('tbl.*,
			f.feed_title')
				->from('#__podcast_episodes AS tbl')
				->join('LEFT', '#__podcast_feeds AS f USING (feed_id)')
				->where('tbl.published = 1');

		if ($feed_id) $query->where('tbl.feed_id = '.$feed_id);
				
		return $query;
	}

	public function getAssets($episode = 0)
	{
		$episodes = $this->getItems();
		$ids = array();
		$assets = array();

		foreach ($episodes as $episode)
		{
			$ids[] = $episode->episode_id;
		}

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('tbl.*, m.episode_id, m.default')
				->from('#__podcast_assets AS tbl')
				->join('LEFT', '#__podcast_assets_map AS m USING (podcast_asset_id)')
				->where('m.episode_id IN ('.implode(',', $ids).')');
		$db->setQuery($query);

		$items = $db->loadObjectList();

		foreach ($items as $item)
		{
			if (!isset($assets[$item->episode_id])) $assets[$item->episode_id] = array();

			if ($item->default) array_unshift($assets[$item->episode_id], $item);
			else array_push($assets[$item->episode_id], $item);
		}

		return $assets;
	}
}