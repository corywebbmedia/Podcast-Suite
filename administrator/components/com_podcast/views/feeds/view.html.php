<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeeds extends JView
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
		JToolBarHelper::title(JText::_('COM_PODCAST_PODCAST_FEEDS_MANAGER'), 'feeds');

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
		$bar = JToolBar::getInstance('toolbar');
		$html = '<a class="toolbar" href="http://podcastsuite.com/support" target="_blank"><span class="icon-32-help"></span>'.JText::_('JTOOLBAR_HELP').'</a>';
		$bar->appendButton('Custom', $html, 'help');
	}
}