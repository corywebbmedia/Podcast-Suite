<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modeladmin');

class PodcastModelEpisode extends JModelAdmin
{
	public function getTable($type = 'Episode', $prefix = 'PodcastTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_podcast.episode', 'episode', array('control' => 'jform', 'load_data' => $loadData));

		return $form;
	}

    public function getItem($pk = null)
    {
		$pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');

		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('tbl.*, a.asset_enclosure_url, a.asset_enclosure_length')
				->select('a.asset_duration, a.asset_enclosure_type')
				->select('a.asset_closed_caption')
				->select('GROUP_CONCAT(m.podcast_asset_id separator ",") AS item_assets')
				->from('#__podcast_episodes AS tbl')
				->join('LEFT', '#__podcast_assets_map AS m ON tbl.episode_id = m.episode_id')
				->join('LEFT', '#__podcast_assets AS a ON m.podcast_asset_id = a.podcast_asset_id')
				->order('m.default')
				->where('tbl.episode_id = '.$pk)
				->group('tbl.episode_id')
				->limit(1);
        $db->setQuery($query);

        return $db->loadObject();
    }

    public function getAssets()
    {
		$item = $this->getItem();

		if ($item) {
			$db = JFactory::getDBO();
	        $query = $db->getQuery(true);
	        $query->select('tbl.*, m.*')
	                ->from('#__podcast_assets AS tbl')
	                ->join('LEFT', '#__podcast_assets_map AS m ON tbl.podcast_asset_id = m.podcast_asset_id');
	        $query->where('m.episode_id = '.$item->episode_id);
	        $db->setQuery($query);

	        return $db->loadObjectList();
		}

		return array();
    }

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_podcast.edit.episode.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
}