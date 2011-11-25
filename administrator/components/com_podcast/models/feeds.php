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
			->join('LEFT', '#__podcast_media AS pm USING(feed_id)')
			->group('feed_id');

		return $query;
	}
}