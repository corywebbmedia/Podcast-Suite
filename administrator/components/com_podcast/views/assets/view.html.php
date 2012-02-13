<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewAssets extends JView
{
	public function display($tpl = null)
	{
        $this->folders = $this->get('Folders');
        $this->items = $this->get('Items');
        $this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');
        $this->plugin = $this->get('Storage');
        
        JToolbarHelper::title(JText::_('COM_PODCAST_MEDIA'), 'media');
        
        $this->addToolbar();
        
		parent::display($tpl);
	}
    
    public function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_PODCAST_MEDIA_MANAGER'), 'media');
        
        $bar = JToolBar::getInstance('toolbar');
        $button = '<a class="toolbar" href="'.JRoute::_('index.php?option=com_podcast&view=assets&layout=upload').'"><span class="icon-32-upload"></span>'.JText::_('Upload').'</a>';
        $bar->appendButton('Custom', $button, 'upload');

        JToolBarHelper::divider();
        
        JToolBarHelper::deleteList('', 'assets.delete');
        
		JToolBarHelper::divider();

        $button = '<a class="toolbar" href="http://podcastsuite.com/support" target="_blank"><span class="icon-32-help"></span>'.JText::_('JTOOLBAR_HELP').'</a>';
        $bar->appendButton('Custom', $button, 'help');
	}
}