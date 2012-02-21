<?php

/**
 * @author      Jeremy Wilken - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package     
 */
defined('_JEXEC') or die;

abstract class PodcastStorage
{
    protected $type = null;
    protected $video_mime_types = array(
        'application/annodex',
        'application/mp4',
        'application/ogg',
        'application/vnd.rn-realmedia',
        'application/x-matroska',
    );
    protected $audio_mime_types = array();

    abstract public function getAssetUrl($path);

    public function getAssetExtension($file)
    {
        $info = pathinfo($file);
        return $info['extension'];
    }
    
    public function getAssetType($type)
    {   
        if (strpos($type, 'video') !== false || in_array($type, $this->video_mime_types)) return 'video';
        if (strpos($type, 'audio') !== false || in_array($type, $this->audio_mime_types)) return 'audio';
        else return 'attachment';
    }
    
    public function getSize($size)
    {
        if (!empty($size))
        {
            $s = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB');
            $e = floor(log($size) / log(1024));

            $output = sprintf('%.2f ' . $s[$e], ($size / pow(1024, floor($e))));

            return $output;
        }
    }
    
    public function getType()
    {
        return $this->type;
    }
}