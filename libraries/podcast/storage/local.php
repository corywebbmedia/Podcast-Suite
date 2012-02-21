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

class PodcastStorageLocal extends PodcastStorage
{
    protected $type = 'local';
    
    public function getAssetUrl($path)
    {
        // trim any preceding slashes
        $path = trim($path, '/\\');
        
        return JURI::root().$path;
    }
}