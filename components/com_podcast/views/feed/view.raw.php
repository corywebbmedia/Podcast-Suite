<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.view');
jimport('podcast.helper');

class PodcastViewFeed extends JView
{
	protected $items;
	protected $feed;
	protected $storage;

	public function display($tpl = null)
	{
		$this->feed = $this->get('Feed');
		$this->storage = PodcastHelper::getStorage();

		if ($this->feed->published != 1) {
			throw new Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		$this->items = $this->get('Items');

		parent::display('xml');
	}
}