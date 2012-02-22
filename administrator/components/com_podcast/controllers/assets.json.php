<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');

class PodcastControllerAssets extends JController
{
	public function list_episode_assets()
	{
		$episode_id = JRequest::getInt('episode_id', 0);

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('asset_id, asset_enclosure_url, asset_duration, `default` AS asset_default')
			->from('#__podcast_assets_map')
			->join('LEFT', '#__podcast_assets USING(asset_id)')
			->where("enabled = '1'")
			->where("episode_id = '{$episode_id}'");

		$db->setQuery($query);
		echo json_encode($db->loadObjectList());
	}
    
    public function list_available_assets()
    {
        $page = JRequest::getInt('page', 0);
        
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('*')
			->from('#__podcast_assets')
			->where("enabled = '1'");

		$db->setQuery($query, $page * 10, 10);
		echo json_encode($db->loadObjectList());
    }
}