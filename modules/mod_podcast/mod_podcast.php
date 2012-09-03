<?php

defined('_JEXEC') or die();

require_once('helper.php');

$helper = new ModPodcastHelper();

$items = $helper->getPodcasts($params);

require JModuleHelper::getLayoutPath('mod_podcast', $params->get('layout', 'default'));