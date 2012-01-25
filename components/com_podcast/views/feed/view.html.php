<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeed extends JView
{
	protected $items;

	public function display($tpl = null)
	{
		$valid = $this->get('IsValidFeed');

		if ($valid != 1) {
			throw new Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		$this->items = $this->get('Items');

		parent::display($tpl);
	}
}