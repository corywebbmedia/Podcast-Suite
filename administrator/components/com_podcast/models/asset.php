<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');
jimport('podcast.helper');

class PodcastModelAsset extends JModelAdmin
{
	public function getTable($type = 'Asset', $prefix = 'PodcastTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * We currently do not use JForm for assets; this is a stub.
	 */
	public function getForm($data = array(), $loadData = true)
	{
		return false;
	}

	public function getPlugin()
	{
		$options = JComponentHelper::getParams('com_podcast');

		$type = $options->get('storage', 'default');

		JPluginHelper::importPlugin('podcast', $type);

		$dispatcher =& JDispatcher::getInstance();

		return $dispatcher;
	}

    public function store($file)
    {
		$asset = JTable::getInstance('asset', 'PodcastTable');

		$asset->bind(array(
			'asset_enclosure_length' => $file->enclosure_length,
			'asset_enclosure_type' => $file->enclosure_type,
			'asset_duration' => $file->enclosure_duration,
			'asset_enclosure_url' => $file->enclosure_url,
			'storage_engine' => PodcastHelper::getOptions()->get('storage')
		));

		$asset->store();

		return $asset->podcast_asset_id;
    }
}