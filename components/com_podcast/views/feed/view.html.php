<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeed extends JView
{
	protected $items;

	public function display($tpl = null)
	{
		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}