<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewMediaitems extends JView
{
	public function display($tpl = null)
	{
		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_PODCAST_FEED_ITEMS_MANAGER'));

		JToolBarHelper::publish('mediaitems.publish');
		JToolBarHelper::unpublish('mediaitems.unpublish');

		JToolBarHelper::divider();

		JToolBarHelper::deleteList('', 'mediaitems.delete');

		JToolBarHelper::divider();

		JToolBarHelper::editList('mediaitem.edit');
		JToolBarHelper::addNew('mediaitem.add');

		JToolBarHelper::divider();

		JToolBarHelper::help('replace with custom button');
	}
}