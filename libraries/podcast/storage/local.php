<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 */

defined('_JEXEC') or die;

jimport('podcast.storage');
jimport('joomla.filesystem.folder');
jimport('joomla.base.tree');

class PodcastStorageLocal extends PodcastStorage
{
    protected $type = 'local';
    protected $tree = array();
    
    public function getAssetUrl($path)
    {
        // trim any preceding slashes
        $path = trim($path, '/\\');
        
        return JURI::root().$path;
    }
    
    public function getFolders($path = '', $tree = true)
    {
        if ($path == '') {
            $path = self::getOptions()->get('root', JPATH_ROOT.'/media/podcasts/');
        }
        
        $folders = $this->retrieveTree($path);
        
        return $folders;
    }
    
    public function retrieveTree($path)  {

        $dir = @opendir($path);
        
        if ($dir) {
            while (($element = readdir($dir)) !== false) {
                if (is_dir($path.'/'.$element) && $element != '.' && $element != '..') {
                    $array[$element] = $this->retrieveTree($path.'/'.$element);
                } 
            }
            closedir($dir);
        }

        return (isset($array) ? $array : false);
    }
    
}