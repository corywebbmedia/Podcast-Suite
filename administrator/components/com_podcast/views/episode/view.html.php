<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewEpisode extends JView
{
	protected $form;
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');

		$this->addToolbar();

		JRequest::setVar('hidemainmenu', true);

		parent::display($tpl);
	}

	public function addToolbar()
	{
		if (isset($this->item->episode_id)) {
			JToolBarHelper::title(JText::_('COM_PODCAST_EPISODE_EDIT'), 'podcasts');
		} else {
			JToolBarHelper::title(JText::_('COM_PODCAST_EPISODE_ADD'), 'podcasts');
		}

		JToolBarHelper::apply('episode.apply');
		JToolBarHelper::save('episode.save');
		JToolBarHelper::cancel('episode.cancel');
	}
}