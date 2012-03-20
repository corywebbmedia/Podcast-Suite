<?php
defined( '_JEXEC' ) or die;

jimport('joomla.filesystem.folder');

if (JFolder::exists(JPATH_ROOT.'/media/podcasts'))
{
	JFolder::delete(JPATH_ROOT.'/media/podcasts');
}