<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelEpisode extends JModel
{
	public function getItem()
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$episode_id = JRequest::getInt('episode_id', 0);

		$query->select('*')
			->from('#__podcast_episodes')
			->where("episode_id = '{$episode_id}'");

		$db->setQuery($query);
		return $db->loadObject();
	}
}