<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');

class PodcastControllerMigrate extends JController
{
	public function import_feeds()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		if ($model->import_feeds()) {
			$status = 'success';
		} else {
			$status = 'failed';
		}

		echo json_encode(array('message' => 'feeds imported', 'status' => $status));
	}

	public function import_podcast_assets()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		if ($model->import_podcast_assets()) {
			$status = 'success';
		} else {
			$status = 'failed';
		}

		echo json_encode(array('message' => 'assets imported', 'status' => $status));
	}

	public function import_podcast_episodes()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		if ($model->import_podcast_episodes()) {
			$status = 'success';
		} else {
			$status = 'failed';
		}

		echo json_encode(array('message' => 'episodes imported', 'status' => $status));
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