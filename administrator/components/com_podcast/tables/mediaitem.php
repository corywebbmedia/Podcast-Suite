<?php
defined( '_JEXEC' ) or die;

class PodcastTableMediaitem extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_media', 'media_id', $db);
	}
}