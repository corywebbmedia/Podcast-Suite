<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeed extends JView
{
	protected $form;
	protected $item;

	public function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		if ($this->item->feed_id) {
			JToolBarHelper::title(JText::_('COM_PODCAST_FEED_ITEM_EDIT'));
		} else {
			JToolBarHelper::title(JText::_('COM_PODCAST_FEED_ITEM_ADD'));
		}

		JToolBarHelper::apply('feed.apply');
		JToolBarHelper::save('feed.save');
		JToolBarHelper::cancel('feed.cancel');
	}
}