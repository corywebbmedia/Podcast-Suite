<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');

class PodcastControllerMigrate extends JController
{
	public function import_feeds()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();
		$model->import_feeds();

		echo json_encode(array('message' => 'feeds imported', 'status' => 'success'));
	}

	public function import_podcast_episodes()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		echo json_encode(array('message' => 'episodes imported', 'status' => 'success'));
	}

	public function import_content_descriptions()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		echo json_encode(array('message' => 'content descriptions imported', 'status' => 'success'));
	}

	public function import_files()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		echo json_encode(array('message' => 'files imported', 'status' => 'success'));
	}

	public function translate_plugin_tags()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		echo json_encode(array('message' => 'plugin tags translated', 'status' => 'success'));
	}

	protected function _getModelWithPath()
	{
		$joomla_path = JRequest::getVar('joomla_path', '');

		$model = $this->getModel('Migrate');
		$model->path = $joomla_path;

		return $model;
	}
}