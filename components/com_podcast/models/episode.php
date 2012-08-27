<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelEpisode extends JModel
{

	public function getItem($episode_id = null)
	{
		if (!$episode_id) {
			$episode_id = JRequest::getInt('episode_id', 0);
		}

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('tbl.*,
			f.feed_title')
				->from('#__podcast_episodes AS tbl')
				->join('LEFT', '#__podcast_feeds AS f USING (feed_id)')
				->where('tbl.episode_id = '.$episode_id)
				->where('tbl.published = 1')
				->limit(1);
		$db->setQuery($query);

		return $db->loadObject();
	}

	public function getAssets($episode = 0)
	{
		$episode = JRequest::getInt('episode_id', $episode);

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('tbl.*')
				->from('#__podcast_assets AS tbl')
				->join('LEFT', '#__podcast_assets_map AS m USING (podcast_asset_id)')
				->order('m.default DESC')
				->where('m.episode_id = '.$episode);
		$db->setQuery($query);

		$assets = $db->loadObjectList();
		$valid = array();

		foreach ($assets as $asset) {
			if ($asset->asset_enclosure_type == 'video/mp4') {
				$asset->asset_enclosure_type = 'video/m4v';
			}
			if ($asset->asset_enclosure_type == 'video/quicktime') {
				$asset->asset_enclosure_type = 'video/mov';
			}
			if ($asset->asset_enclosure_type == 'audio/mpeg') {
				$asset->asset_enclosure_type = 'audio/mp3';
			}
			$valid[] = $asset;
		}

		return $valid;
	}

	public function getAssetByID($podcast_asset_id)
	{
		JTable::addIncludePath(JPATH_BASE . '/administrator/components/com_podcast/tables');
		$table = JTable::getInstance('Asset', 'PodcastTable');
		$table->load($podcast_asset_id);

		if ($table->asset_enclosure_type == 'video/mp4') {
			$table->asset_enclosure_type = 'video/m4v';
		}
		if ($table->asset_enclosure_type == 'video/quicktime') {
			$table->asset_enclosure_type = 'video/mov';
		}
		if ($table->asset_enclosure_type == 'audio/mpeg') {
			$table->asset_enclosure_type = 'audio/mp3';
		}

		return $table;
	}
}