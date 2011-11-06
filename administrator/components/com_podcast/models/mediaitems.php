<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelMediaitems extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('*')
			->from('#__podcast_media');

		return $query;
	}
}