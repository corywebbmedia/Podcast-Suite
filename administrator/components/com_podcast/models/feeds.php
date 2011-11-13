<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeeds extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		// TODO: get a count of the number of items in each feed and
		// return it along with the result set.
		$query->select('*')
			->from('#__podcast_feeds AS pf');

		return $query;
	}
}