<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

class PodcastTableEpisode extends JTable
{
	public function __construct(&$db)
	{
		parent::__construct('#__podcast_episodes', 'episode_id', $db);
	}
	
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		$db = JFactory::getDBO();
		$error = false;
		if (is_array($pks) && $state === 1)
		{
			for ($i = 0; $i < count($pks); $i++)
			{
				$episode_id = $pks[$i];
				$query = $db->getQuery(true);
				$query->select('episode_id')->from('#__podcast_assets_map')->where('episode_id = '.$episode_id);
				$db->setQuery($query)->query();
				if (!$db->getNumRows())
				{
					unset($pks[$i]);
					$error = true;
				}
			}
		}
		
		if ($error)
		{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_PODCAST_EPISODE_CANNOT_PUBLISH_NO_MEDIA'));
		}
		
		if (count($pks)) 
		{
			return parent::publish($pks, $state, $userId);
		}
		else
		{
			$e = new JException(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
			$this->setError($e);

			return false;
		}
	}

	public function check()
	{
		if (trim($this->alias) == '') {
			$this->alias = $this->episode_title;
		}

		$this->alias = JApplication::stringURLSafe($this->alias);

		if (trim(str_replace('-', '', $this->alias)) == '') {
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		// Backfill the GUID on new records
		if (!$this->episode_id) {
			$this->episode_guid = md5(microtime() . $this->episode_title . $this->episode_subtitle . $this->feed_id);
		}

		// backfill creation date on new records to today
		if (!$this->episode_created) {
			$this->episode_created = JFactory::getDate()->toSql();
		}

		// backfill publish date on new records to today
		if (!$this->episode_pubDate) {
			$this->episode_pubDate = JFactory::getDate()->toSql();
		}
		
		if ($this->episode_id)
		{
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);
			$query->select('episode_id')->from('#__podcast_assets_map')->where('episode_id = '.$this->episode_id);
			$db->setQuery($query)->query();
			if (!$db->getNumRows())
			{
				$this->published = 0;
			}
		}
		
		return true;
	}
}