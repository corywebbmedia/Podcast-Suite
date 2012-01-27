<?php
defined( '_JEXEC' ) or die;

class PodcastTableFeeditem extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_feed_items', 'feed_item_id', $db);
	}

	public function check()
	{
		if (trim($this->alias) == '') {
			$this->alias = $this->item_title;
		}

		$this->alias = JApplication::stringURLSafe($this->alias);

		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		// Backfill the GUID on new records
		if (!$this->feed_item_id) {
			$this->item_guid = sha1(time() . JURI::root() . $this->item_enclosure_url);
		}

		return true;
	}
}