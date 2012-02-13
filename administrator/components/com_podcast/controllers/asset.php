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
            if ($model->store($result))
            {
                print json_encode($result);
            }
            else
            {
                // Couldn't save to database, but was uploaded
            }
        }
        
        JFactory::getApplication()->close();
    }
}
