<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright ${date?date?string("yyyy")} Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 * @see         http://chrisjean.com/2009/02/14/generating-mime-type-in-php-is-not-magic/
 */
defined('_JEXEC') or die;

require_once(dirname(__FILE__).'/getid3/getid3.php');

class PodcastHelperGetid3 extends JObject
{
    public function getInstance()
    {
        static $instance;
        
        if (is_null($instance))
        {
            $instance = new getID3;
        }
        
        return $instance;
    }

}