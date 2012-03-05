<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_podcast')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . '/media/com_podcast/css/admin.css');

jimport('joomla.application.component.controller');

$view = JRequest::getCmd('view', 'episodes');
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_EPISODES'), 'index.php?option=com_podcast', ($view == 'episodes') ? true : false);
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_FEEDS'), 'index.php?option=com_podcast&view=feeds', ($view == 'feeds') ? true : false);
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_MEDIA'), 'index.php?option=com_podcast&view=assets', ($view == 'assets') ? true : false);

$controller = JController::getInstance('Podcast');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();