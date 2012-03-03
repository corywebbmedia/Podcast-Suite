<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

class PodcastTableAsset extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_assets', 'podcast_asset_id', $db);
	}

}