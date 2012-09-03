<?php

defined('_JEXEC') or die;

class ModPodcastHelper
{
	public function getPodcasts($params)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('tbl.*, f.feed_title, a.asset_enclosure_url')
				->from('#__podcast_episodes AS tbl')
				->join('LEFT', '#__podcast_assets_map AS m USING(episode_id)')
				->join('LEFT', '#__podcast_assets AS a USING(podcast_asset_id)')
				->join('LEFT', '#__podcast_feeds AS f USING(feed_id)')
				->group('tbl.episode_id');

		// Filter by folder
		$feed = $params->get('feed_id');
		if (!empty($feed)) {
			$query->where('f.feed_id = '.$feed);
		}

		$db->setQuery($query, 0, $params->get('limit', 5));

		return $db->loadObjectList();
	}
}
