<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');

class PodcastControllerFeeds extends JControllerAdmin
{
	public function getModel($name = 'Feed', $prefix = 'PodcastModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}