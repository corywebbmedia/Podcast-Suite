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
        $options = PodcastHelper::getOptions();
        $this->s3 = new S3($options->get('amazons3_key'), $options->get('amazons3_secret'), PodcastHelper::getOptions()->get('amazons3_ssl'));
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
		
		$list = array();
		
		foreach ($folders as $folder)
		{
			$list[$folder] = false;
		}
        
        return $list;
    }
	
    public function getRoot()
	{
		$root = 'http';
		if (PodcastHelper::getOptions()->get('amazons3_ssl')) $root .= 's';
		$root .= '://bucket.s3.amazonaws.com';
		return $root;
	}
	
	public function putFile($folder)
	{
		jimport('podcast.storage.local');
		$uploader = new PodcastStorageLocal();
		$result = $uploader->putFile('');
		
		if ($result->result)
		{			
			if ($this->s3->putObjectFile(JPATH_ROOT.$result->enclosure_url, $folder, JFile::getName($result->enclosure_url), S3::ACL_PUBLIC_READ))
			{
				$result->enclosure_url = 'http'.(PodcastHelper::getOptions()->get('amazons3_ssl') ? 's' : '').'://'.$folder.'.s3.amazonaws.com/'.JFile::getName($result->enclosure_url);
				$result->storage_engine = 'amazons3';
			}
			else
			{
				$result->result = false;
				$result->message = 'Failed to upload to Amazon S3';
			}
			
			return $result;
		}
	}
}