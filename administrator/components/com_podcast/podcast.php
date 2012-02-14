<?php
defined( '_JEXEC' ) or die;

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . '/media/com_podcast/css/admin.css');

jimport('joomla.application.component.controller');

$view = JRequest::getCmd('view', 'episodes');
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_EPISODES'), 'index.php?option=com_podcast', ($view == 'episodes') ? true : false);
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_FEEDS'), 'index.php?option=com_podcast&view=feeds', ($view == 'feeds') ? true : false);
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_MEDIA'), 'index.php?option=com_podcast&view=assets', ($view == 'assets') ? true : false);

$controller	= JController::getInstance('Podcast');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();