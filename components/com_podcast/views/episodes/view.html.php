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

class PodcastViewEpisodes extends JView
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->assets = $this->get('Assets');
		$this->storage = PodcastHelper::getStorage();

		parent::display($tpl);
	}
}