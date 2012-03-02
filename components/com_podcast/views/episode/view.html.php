<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');
jimport('podcast.asset');

require JPATH_COMPONENT . '/helper.php';

class PodcastViewEpisode extends JView
{
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');
		$this->assets = $this->get('Assets');
		$this->storage = PodcastAsset::getStorage();

		if (!count($this->assets)) {
			print 'Error, no assets attached to this episode!';
		}

		if ($this->item->published == 0) {
			throw new Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		parent::display($tpl);
	}
}