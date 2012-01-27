<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeeditems extends JView
{
	protected $items;
	protected $state;
	protected $pagination;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$this->pagination = $this->get('Pagination');

		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_PODCAST_FEED_ITEMS_MANAGER'));

		JToolBarHelper::publish('feeditems.publish');
		JToolBarHelper::unpublish('feeditems.unpublish');

		JToolBarHelper::divider();

		JToolBarHelper::deleteList('', 'feeditems.delete');

		JToolBarHelper::divider();

		JToolBarHelper::editList('feeditem.edit');
		JToolBarHelper::addNew('feeditem.add');

		JToolBarHelper::divider();

		JToolBarHelper::help('replace with custom button');
	}
}