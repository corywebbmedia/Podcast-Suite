<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewFeed extends JView
{
	public function display($tpl = null)
	{
		$valid = $this->get('IsValidFeed');

		if ($valid != 1) {
			throw new Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		$this->items = $this->get('Items');

		// TODO: override this with XML output rather than the default output
		parent::display($tpl);
	}
}