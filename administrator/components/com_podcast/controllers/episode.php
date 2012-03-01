<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.controllerform');

class PodcastControllerEpisode extends JControllerForm
{
	protected $list_view = 'episodes';
	
	public function save()
	{
		JRequest::checkToken() or die('Invalid Token');
		
		$form = JRequest::getVar('jform');
		$db = JFactory::getDBO();
		
		$assets = explode(',', JRequest::getString('asset_ids'));
		$default = JRequest::getInt('asset_default');
		$episode_id = $form['episode_id'];
		
		$query = $db->getQuery(true);
		$query->delete('#__podcast_assets_map')->where('episode_id = '.$episode_id);
		$db->setQuery($query);
		$db->query();
		
		$assets = array_unique($assets);
		
		foreach ($assets as $asset)
		{
			$row = null;
			$row->podcast_asset_id = $asset;
			$row->episode_id = $episode_id;
			$row->default = ($asset == $default) ? 1 : 0;
			$db->insertObject('#__podcast_assets_map', $row);
		}

		parent::save();
	}
}