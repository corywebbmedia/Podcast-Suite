<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewEpisode extends JView
{
	protected $item;

	public function display($tpl = null)
	{
		$this->item = $this->get('Item');

		if ($this->item->published == 0) {
			throw new Exception(JText::_('JGLOBAL_RESOURCE_NOT_FOUND'), 404);
		}

		parent::display($tpl);
	}
}