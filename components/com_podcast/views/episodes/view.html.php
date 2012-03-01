<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.view');
jimport('podcast.asset');

class PodcastViewEpisodes extends JView
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');
		$this->assets = $this->get('Assets');
		$this->storage = PodcastAsset::getStorage();

		parent::display($tpl);
	}
}