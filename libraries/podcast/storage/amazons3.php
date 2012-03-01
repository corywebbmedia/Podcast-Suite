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
jimport('podcast.storage.amazons3.s3');

class PodcastStorageAmazons3 extends PodcastStorage
{
    protected $type = 'amazons3';
    protected $tree = array();
    protected $s3;
    
    public function __construct()
    {
        $options = PodcastAsset::getOptions();
        $this->s3 = new S3($options->get('amazons3_key'), $options->get('amazons3_secret'), false);
        var_dump(get_class_methods($this->s3));
    }
    
    public function getAssetUrl($path)
    {
        // trim any preceding slashes
        $path = trim($path, '/\\');
        
        return JURI::root().$path;
    }
    
    public function getFolders($path = '', $tree = true)
    {
        $folders = $this->s3->listBuckets();
        
        var_dump($folders);
        
        //$folders = $this->retrieveTree($path);
        
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