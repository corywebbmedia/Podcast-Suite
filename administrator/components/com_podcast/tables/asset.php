<?php
defined( '_JEXEC' ) or die;

class PodcastTableAsset extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_assets', 'asset_id', $db);
	}

}