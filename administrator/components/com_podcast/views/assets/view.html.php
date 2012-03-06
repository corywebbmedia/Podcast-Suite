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

class PodcastViewAssets extends JView
{
	public function display($tpl = null)
	{
		$this->folders = $this->get('Folders');

		JToolbarHelper::title(JText::_('COM_PODCAST_MEDIA'), 'media');

		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		JToolBarHelper::title(JText::_('COM_PODCAST_MEDIA_MANAGER'), 'media');

		$bar = JToolBar::getInstance('toolbar');

		$button = '<a class="toolbar" href="#" id="upload_toolbar_button"><span class="icon-32-upload"></span>'.JText::_('Upload').'</a>';
		$bar->appendButton('Custom', $button, 'upload');

		JToolBarHelper::divider();

		JToolBarHelper::deleteList('', 'assets.delete');

		JToolBarHelper::divider();

		$button = '<a class="toolbar" href="http://podcastsuite.com/support" target="_blank"><span class="icon-32-help"></span>'.JText::_('JTOOLBAR_HELP').'</a>';
		$bar->appendButton('Custom', $button, 'help');
	}
}