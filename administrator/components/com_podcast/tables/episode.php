<?php
defined( '_JEXEC' ) or die;

class PodcastTableEpisode extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_episodes', 'episode_id', $db);
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
		if (!$this->episode_id) {
			$this->item_guid = sha1(time() . JURI::root() . $this->item_enclosure_url);
		}

		// backfill creation date on new records to today
		if (!$this->item_created) {
			$this->item_created = JFactory::getDate()->toSql();
		}

		// backfill publish date on new records to today
		if (!$this->item_pubDate) {
			$this->item_pubDate = JFactory::getDate()->toSql();
		}

		return true;
	}
}