<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

if (!file_exists(JPATH_ADMINISTRATOR . '/components/com_podcast')) {
	throw new Exception("Please install Podcast Suite before using the migrator.", 500);
}

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_podcast/tables');

jimport('joomla.application.component.controller');

$controller = JController::getInstance('Migratepodcast');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();