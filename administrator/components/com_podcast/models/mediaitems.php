<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelMediaitems extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('pm.*, pf.feed_title')
			->from('#__podcast_media AS pm')
			->join('LEFT', '#__podcast_feeds AS pf USING(feed_id)');

		return $query;
	}
}