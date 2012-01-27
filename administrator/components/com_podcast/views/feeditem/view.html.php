<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeeditem extends JView
{
	protected $form;
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->form = $this->get('Form');

		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		if ($this->item->feed_item_id) {
			JToolBarHelper::title(JText::_('COM_PODCAST_FEED_ITEM_EDIT'));
		} else {
			JToolBarHelper::title(JText::_('COM_PODCAST_FEED_ITEM_ADD'));
		}

		JToolBarHelper::apply('feeditem.apply');
		JToolBarHelper::save('feeditem.save');
		JToolBarHelper::cancel('feeditem.cancel');
	}
}