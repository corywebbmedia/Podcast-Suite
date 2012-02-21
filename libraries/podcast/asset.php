<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 */

defined('_JEXEC') or die;

class PodcastAsset
{
    protected static $storage = null;
    
    static public function getStorage()
    {
        if (!self::$storage) 
        {
            $options = JComponentHelper::getParams('com_podcast');
            $type = $options->get('storage', 'local');
            jimport('podcast.storage.'.$type);
            $class = 'PodcastStorage'.ucfirst($type);
            self::$storage = new $class();
        }
        return self::$storage;
    }
}