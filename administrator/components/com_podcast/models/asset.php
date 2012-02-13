<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class PodcastModelAsset extends JModel
{
    public function getPlugin()
    {
        $options = JComponentHelper::getParams('com_podcast');
        
        $type = $options->get('storage', 'default');
        
        JPluginHelper::importPlugin('podcast', $type);
        
        $dispatcher =& JDispatcher::getInstance();
        
        return $dispatcher;
    }
    
    public function store($file)
    {
        $db = JFactory::getDBO();
        $db->setQuery($db->getQuery(true)->select('*')->from('#__podcast_assets')->where('asset_enclosure_url = '.$db->quote($file->enclosure_url)));
        $existing = $db->loadRow();
        if ($existing)
        {
            
        }
        else 
        {
            $db->getQuery(true)->insert('#__podcast_assets')->columns('asset_enclosure_url', 'asset_enclosure_length', 'asset_enclosure_type')->values($file->enclosure_url, $file->enclosure_length, $file->enclosure_type);
        }
        
        return $db->insertid();
    }
}