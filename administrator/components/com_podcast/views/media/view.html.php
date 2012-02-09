<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewMedia extends JView
{
	public function display($tpl = null)
	{
        $this->folders = $this->get('Folders');
        $this->files = $this->get('Files');
        
        JToolbarHelper::title(JText::_('COM_PODCAST_MEDIA'), 'media');
        
		parent::display($tpl);
	}
}