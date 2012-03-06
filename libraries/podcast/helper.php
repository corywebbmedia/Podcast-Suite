<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 */

defined('_JEXEC') or die;

class PodcastHelper
{
    protected static $storage = null;
    protected static $options = null;
    
    static public function getOptions()
    {
        if (!self::$options) 
        {
            self::$options = JComponentHelper::getParams('com_podcast');
        }
        return self::$options;
    }
    
    static public function getStorage()
    {
        if (!self::$storage) 
        {
            $type = self::getOptions()->get('storage', 'local');
            jimport('podcast.storage.'.$type);
            $class = 'PodcastStorage'.ucfirst($type);
            self::$storage = new $class();
        }
        return self::$storage;
    }
}