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
        
        if ($result->result)
        {
            $asset = $model->store($result);
            if (!$asset)
            {
                $result->result = false;
                $result->message = 'Could not store in assets table';
            }
            else
            {
                $result->asset_id = $asset;
            }
        }
        
        print json_encode($result);
        
        JFactory::getApplication()->close();
    }
}
