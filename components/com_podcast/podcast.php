<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */

defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controller');

$controller	= JController::getInstance('Podcast');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();