<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

class PodcastControllerAssets extends JControllerAdmin
{
	protected $text_prefix = 'COM_PODCAST_ASSETS';

	public function getModel($name = 'Asset', $prefix = 'PodcastModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	public function getAssets($ajax = true)
	{
		$model = $this->getModel('assets');
		$assets = $model->getItems();
		$total = $model->getTotal();
		$pagination = $model->getPagination();

		if ($ajax)
		{
			$response = new stdClass();
			$response->list = $assets;
			$response->pagination = $pagination;

			echo json_encode($response);

			JFactory::getApplication()->close();
		}
	}
}