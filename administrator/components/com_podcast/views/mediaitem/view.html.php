<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewMediaitem extends JView
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
		if ($this->item->media_id) {
			JToolBarHelper::title(JText::_('COM_PODCAST_MEDIA_ITEM_EDIT'));
		} else {
			JToolBarHelper::title(JText::_('COM_PODCAST_MEDIA_ITEM_ADD'));
		}

		JToolBarHelper::apply('mediaitem.apply');
		JToolBarHelper::save('mediaitem.save');
		JToolBarHelper::cancel('mediaitem.cancel');
	}
}