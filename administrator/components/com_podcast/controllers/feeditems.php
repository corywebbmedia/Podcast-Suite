<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');

class PodcastControllerFeeditems extends JControllerAdmin
{
	public function getModel($name = 'Feeditem', $prefix = 'PodcastModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}
