<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeeds extends JView
{
	public function display($tpl = null)
	{
		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_PODCAST_PODCAST_FEEDS_MANAGER'));

		JToolBarHelper::makeDefault('feeds.setDefault', 'COM_PODCAST_SET_DEFAULT_FEED');

		JToolBarHelper::divider();

		JToolBarHelper::publish('feeds.publish');
		JToolBarHelper::unpublish('feeds.unpublish');

		JToolBarHelper::divider();

		JToolBarHelper::deleteList('', 'feeds.delete');

		JToolBarHelper::divider();

		JToolBarHelper::editList('feed.edit');
		JToolBarHelper::addNew('feed.add');

		JToolBarHelper::divider();

		JToolBarHelper::preferences('com_podcast');
		JToolBarHelper::help('replace with custom button');
	}
}