<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelEpisode extends JModel
{

	public function getItem()
	{
		$episode_id = JRequest::getInt('episode_id', 0);

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('tbl.*,
			f.feed_title')
				->from('#__podcast_episodes AS tbl')
				->join('LEFT', '#__podcast_feeds AS f USING (feed_id)')
				->where('tbl.episode_id = '.$episode_id)
				->limit(1);
		$db->setQuery($query);

		return $db->loadObject();
	}

	public function getAssets($episode = 0)
	{
		$episode = JRequest::getInt('episode_id', $episode);

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('tbl.*')
				->from('#__podcast_assets AS tbl')
				->join('LEFT', '#__podcast_assets_map AS m USING (podcast_asset_id)')
				->where('m.episode_id = '.$episode);
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}