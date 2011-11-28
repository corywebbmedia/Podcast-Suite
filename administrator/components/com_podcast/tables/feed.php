<?php
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

		if (!$this->feed_id) {
			$this->feed_created = date('Y-m-d H:i:s');
		}

		return true;
	}
}