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

        $delim = strstr(PHP_OS, "WIN") ? "\\" : "/";

        if ($dir=@opendir($path)) {

            while (($element=readdir($dir))!== false) {

                if (is_dir($path.$delim.$element) && $element!= "." && $element!= "..") {
                    /*$item = new stdClass();
                    $item->property = new stdClass();
                    $item->property->name = $element;
                    $item->children = $this->retrieveTree($path.$delim.$element);
                    if (!$item->children) unset($item->children);
                    $array[] = $item; */
                    $array[$element] = $this->retrieveTree($path.$delim.$element);
                } 

            }

            closedir($dir);

        }

        return (isset($array) ? $array : false);

    }
    
    // Recursive function to parse the folder tree into the right format
    public function addToTree($folders)
    {
        $tree = array();
        
        foreach ($folders as $folder)
        {
            if ($folder->isDir())
            {
                //$folder = new SplFileObject($folder->getRealPath());
                if ($folder->hasChildren())
                {
                    $tree[] = $this->addToTree($folder->getChildren());
                }
                else
                {
                    $node = new FoldersTreeNode();
                    $node->property->name = $folder->key();
                    $tree[] = $node;
                }
            }
        }
    }
}

class FoldersTreeNode 
{
    public $property = null;
    public $children = null;
}