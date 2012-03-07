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
jimport('podcast.helper');

require JPATH_COMPONENT . '/scripthelper.php';

class PodcastViewEpisode extends JView
{
	protected $item;
	protected $assets;
	protected $asset;
	protected $storage;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->assets = $this->get('Assets');
		$this->asset = $this->assets[0];
		$this->storage = PodcastHelper::getStorage();

		if (!count($this->assets)) {
			print 'Error, no assets attached to this episode!';
		}

		if ($this->item->published == 0) {
			throw new Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		parent::display($tpl);
	}
}