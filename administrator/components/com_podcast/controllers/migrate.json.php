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

		echo json_encode(array('message' => 'Feed imported.', 'status' => $status));
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

		echo json_encode(array('message' => 'Assets imported.', 'status' => $status));
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

		echo json_encode(array('message' => 'Episodes imported.', 'status' => $status));
	}

	public function import_file()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$file = JRequest::getVar('file', '');

		$model = $this->_getModelWithPath();

		if ($model->import_file($file)) {
			$status = 'success';
		} else {
			$status = 'failed';
		}

		echo json_encode(array('message' => "File {$file} imported.", 'status' => 'success'));
	}

	public function get_import_files()
	{
		$model = $this->_getModelWithPath();

		echo json_encode($model->import_file_list());
	}

	public function translate_plugin_tags()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$model = $this->_getModelWithPath();

		if ($model->translate_plugin_tags()) {
			$status = 'success';
		} else {
			$status = 'failed';
		}

		echo json_encode(array('message' => 'Plugin tags translated.', 'status' => $status));
	}

	protected function _getModelWithPath()
	{
		$joomla_path = JRequest::getVar('joomla_path', '');

		$model = $this->getModel('Migrate');
		$model->path = $joomla_path;

		return $model;
	}
}