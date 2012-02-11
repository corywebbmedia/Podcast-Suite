<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');
jimport('joomla.event.dispatcher');

class PodcastControllerAsset extends JController
{
	public function upload()
    {
        JRequest::checkToken('get') or die;
        
        $model = $this->getModel('asset');
        
        $options = JComponentHelper::getParams('com_podcast');
        $type = $options->get('storage', 'default');
        
        JPluginHelper::importPlugin('podcast', $type);
        $dispatcher =& JDispatcher::getInstance();
        
        $result = $dispatcher->trigger('onFileStore');
        if (is_array($result))
        {
            $result = array_shift($result);
        }
        
        if ($result->result) {
            $db = JFactory::getDBO();
            $db->getQuery(true)->insert('#__podcast_assets')->columns('asset_enclosure_url', 'asset_enclosure_length', 'asset_enclosure_type')->values($result->enclosure_url, $result->enclosure_length, $result->enclosure_type)->query();
            if ($model->store($result))
            {
                print json_encode($result);
            }
        }
        
        JFactory::getApplication()->close();
    }
}
