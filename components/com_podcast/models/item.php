<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelItem extends JModel
{
	public function getItem()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$media_id = JRequest::getInt('media_id', 0);

		$query->select('*')
			->from('#__podcast_media')
			->where("media_id = '{$media_id}'");

		$db->setQuery($query);
		return $db->loadObject();
	}
}