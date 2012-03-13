<?php
defined( '_JEXEC' ) or die;

jimport( 'joomla.application.component.view');

class PodcastViewMigrate extends JView
{
	public function display($tpl = null)
	{
		$this->addToolbar();

		parent::display($tpl);
	}

	public function addToolbar()
	{
		JToolBarHelper::title('Migrate from Podcast Suite 1.5*');
	}
}