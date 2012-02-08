<?php
defined( '_JEXEC' ) or die;

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_podcast/podcast.css');

jimport('joomla.application.component.controller');

$view = JRequest::getCmd('view');
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_EPISODES'), 'index.php?option=com_podcast', ($view == '') ? true : false);
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_FEEDS'), 'index.php?option=com_podcast&view=feeds', ($view == 'feeds') ? true : false);
JSubMenuHelper::addEntry(JText::_('COM_PODCAST_MEDIA'), 'index.php?option=com_podcast&view=media', ($view == 'media') ? true : false);

$controller	= JController::getInstance('Podcast');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();