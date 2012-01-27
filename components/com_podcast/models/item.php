<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelItem extends JModel
{
	public function getItem()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$feed_item_id = JRequest::getInt('feed_item_id', 0);

		$query->select('*')
			->from('#__podcast_feed_items')
			->where("feed_item_id = '{$feed_item_id}'");

		$db->setQuery($query);
		return $db->loadObject();
	}
}