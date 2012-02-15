<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controllerform');

class PodcastControllerEpisode extends JControllerForm
{
	protected $list_view = 'episodes';
    
    public function save()
    {
        JRequest::checkToken() or die('Invalid Token');
        
        $form = JRequest::getVar('jform');
        
        $assets = json_decode($form['item_assets']);
        $episode_id = $form['episode_id'];
        $removes = array();
        $matches = array();

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('*')->from('#__podcast_assets_map')->where('episode_id = '.$episode_id);
        $db->setQuery($query);
        $records = $db->loadObjectList();
        
        if (count($records))
        {
            foreach ($records as $record)
            {
                if (!in_array($record->asset_id, $assets))
                {
                    $removes[] = $record->asset_id;
                }
                else
                {
                    $matches[] = $record->asset_id;
                }
            }
        }
        
        $adds = array_diff($assets, $matches);
        
        if (count($adds))
        {
            foreach ($adds as $asset)
            {
                $row = null;
                $row->asset_id = $asset;
                $row->episode_id = $episode_id;
                $db->insertObject('#__podcast_assets_map', $row);
            }
        }
        
        if (count($removes))
        {
            foreach ($removes as $asset)
            {
                $query = $db->getQuery(true);
                $query->delete('#__podcast_assets_map')->where('asset_id = '.$asset)->where('episode_id = '.$episode_id);
                $db->setQuery($query);
                $db->query();
            }
        }
        
        parent::save();
    }
}