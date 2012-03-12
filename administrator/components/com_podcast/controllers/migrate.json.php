<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');

class PodcastControllerMigrate extends JController
{
	public function import_feeds()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		echo json_encode(array('message' => 'feeds imported'));
	}

	public function import_podcast_episodes()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		echo json_encode(array('message' => 'episodes imported'));
	}

	public function import_content_descriptions()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		echo json_encode(array('message' => 'content descriptions imported'));
	}

	public function import_files()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		echo json_encode(array('message' => 'files imported'));
	}

	public function translate_plugin_tags()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		echo json_encode(array('message' => 'plugin tags translated'));
	}
}