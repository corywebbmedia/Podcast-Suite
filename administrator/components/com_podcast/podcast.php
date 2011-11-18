<?php
defined( '_JEXEC' ) or die;

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_podcast/podcast.css');

jimport('joomla.application.component.controller');

$controller	= JController::getInstance('Podcast');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();