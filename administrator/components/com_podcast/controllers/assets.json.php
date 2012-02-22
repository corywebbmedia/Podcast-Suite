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

		$query->select('SQL_CALC_FOUND_ROWS *')
			->from('#__podcast_assets')
			->where("enabled = '1'");

		$db->setQuery($query, $page * 10, 10);
        $db->query();
        
        $response = new stdClass();

        $response->items = $db->loadObjectList();
        
        $db->setQuery('SELECT FOUND_ROWS();');
        
        jimport('joomla.html.pagination');
        
        $pagination = new JPagination( $db->loadResult(), $page * 10, 10);
        $response->pagination->total = $pagination->{'pages.total'};
        $response->pagination->current = $pagination->{'pages.current'};
        $response->pagination->start = $pagination->{'pages.start'};
        $response->pagination->stop = $pagination->{'pages.stop'};
        $response->pagination->previous = ($pagination->{'pages.current'} > 1) ? $pagination->{'pages.current'} - 1 : 1;
        $response->pagination->next = ($pagination->{'pages.current'} < $pagination->{'pages.total'} - 1) ? $pagination->{'pages.current'} + 1 : $pagination->{'pages.total'};

		echo json_encode($response);
    }
}