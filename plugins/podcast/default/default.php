<?php

defined('_JEXEC') or die;

class PlgPodcastDefault
{
    public function getFiles($page = 1, $limit = 10)
    {
        return array(1,2,3,4,5);
    }
    
    public function getTotal()
    {
        return 5;
    }
}