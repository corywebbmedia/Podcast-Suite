<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeed extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$feed_id = JRequest::getInt('feed_id', 0);

		$query->select('*')
			->from('#__podcast_media')
			->where("feed_id = '{$feed_id}'");

		return $query;
	}
}