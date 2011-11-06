<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelItems extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('*')
			->from('#__podcast_items');

		return $query;
	}
}