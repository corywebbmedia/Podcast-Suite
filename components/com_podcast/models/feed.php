<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeed extends JModelList
{
	public function getFeed()
	{
		$feed_id = JRequest::getInt('feed_id', 0);

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select('*')
			->from('#__podcast_feeds')
			->where("feed_id = '{$feed_id}'");

		$db->setQuery($query);
		return $db->loadObject();
	}

	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$feed_id = JRequest::getInt('feed_id', 0);

		$query->select('*')
			->from('#__podcast_media')
			->where("feed_id = '{$feed_id}'")
			->where("published = 1");

		return $query;
	}
}