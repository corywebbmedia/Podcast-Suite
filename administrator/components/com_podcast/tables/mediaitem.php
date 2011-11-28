<?php
defined( '_JEXEC' ) or die;

class PodcastTableMediaitem extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_media', 'media_id', $db);
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

		return true;
	}
}