<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class PodcastModelAsset extends JModel
{
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
			'asset_enclosure_url' => $file->enclosure_url
		));

		$asset->store();

		return $asset->podcast_asset_id;
    }
}