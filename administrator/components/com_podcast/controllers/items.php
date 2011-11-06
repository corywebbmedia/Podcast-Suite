<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');

class PodcastControllerItems extends JControllerAdmin
{
	public function getModel($name = 'Item', $prefix = 'PodcastModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}