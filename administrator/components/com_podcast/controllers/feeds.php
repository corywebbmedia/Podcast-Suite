<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controlleradmin');

class PodcastControllerFeeds extends JControllerAdmin
{
	protected $text_prefix = 'COM_PODCAST_FEEDS';

	public function getModel($name = 'Feed', $prefix = 'PodcastModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	public function setDefault()
	{
		JRequest::checkToken() or jexit( JText::_('JINVALID_TOKEN') );

		$cid = JRequest::getVar('cid', array(), '', 'array');
		$task = $this->getTask();

		if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
		} else {
			$model = $this->getModel();

			$id = (int) $cid[0];

			try {
				$model->setDefault($id);
				$this->setMessage(JText::_('COM_PODCAST_FEEDS_FEED_SET_DEFAULT'));
			} catch (Exception $e) {
				JError::raiseWarning(500, $e->getMessage());
			}
		}

		$this->setRedirect(JRoute::_('index.php?option=com_podcast&view=feeds', false));
	}
}