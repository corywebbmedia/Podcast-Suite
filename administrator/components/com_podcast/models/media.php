<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelMedia extends JModel
{
	public function getPlugins()
    {
        return array('local');
    }
    
    public function getFolders($root = null)
    {
        if (is_null($root)) $root = JPATH_ROOT.'/media/podcasts/';
        return JFolder::folders($root);
    }
    
    public function getFiles($root = null)
    {
        if (is_null($root)) $root = JPATH_ROOT.'/media/podcasts/';
        return JFolder::files($root, '.', false, false, array('index.html'));
    }
}