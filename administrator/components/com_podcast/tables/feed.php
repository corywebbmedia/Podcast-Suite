<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

class PodcastTableFeed extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_feeds', 'feed_id', $db);
	}

	public function check()
	{
		if (trim($this->alias) == '') {
			$this->alias = $this->feed_title;
		}

		$this->alias = JApplication::stringURLSafe($this->alias);

		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		// backfill creation date on new records to today
		if (!$this->feed_created) {
			$this->feed_created = JFactory::getDate()->toSql();
		}

		return true;
	}
}