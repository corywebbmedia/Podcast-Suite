<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controllerform');

class PodcastControllerEpisode extends JControllerForm
{
	protected $list_view = 'episodes';
    
    public function save()
    {
        $form = JRequest::getVar('jform');
        
        print_r($form);
        
        die();
        parent::save();
    }
}