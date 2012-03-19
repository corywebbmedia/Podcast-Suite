<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controllerform');

class PodcastControllerEpisode extends JControllerForm
{
	protected $list_view = 'episodes';
	
	public function postSaveHook($model, $validData)
	{
		$db = JFactory::getDBO();

		$assets = explode(',', JRequest::getString('asset_ids'));
		$default = JRequest::getInt('asset_default');
		$episode_id = $model->getItem()->episode_id;

		$query = $db->getQuery(true);
		$query->delete('#__podcast_assets_map')->where('episode_id = '.$episode_id);
		$db->setQuery($query);
		$db->query();

		$assets = array_unique($assets);

		foreach ($assets as $asset)
		{
			if ($asset > 0)
			{
				$row = null;
				$row->podcast_asset_id = $asset;
				$row->episode_id = $episode_id;
				$row->default = ($asset == $default) ? 1 : 0;
				$db->insertObject('#__podcast_assets_map', $row);
			}
		}

		return true;
	}
}