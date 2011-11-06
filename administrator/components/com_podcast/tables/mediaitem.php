<?php
defined( '_JEXEC' ) or die;

class PodcastTableMediaitems extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_media', 'media_id', $db);
	}
}