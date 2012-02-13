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
        $query->select('tbl.*, 
            a.asset_enclosure_url AS item_enclosure_url, 
            a.asset_enclosure_length AS item_enclosure_length, 
            a.asset_duration AS item_duration,
            a.asset_enclosure_type AS item_enclosure_type,
            a.asset_closed_caption AS item_closed_caption,
            GROUP_CONCAT(a.asset_id separator ",") AS item_assets')
                ->from('#__podcast_episodes AS tbl')
                ->join('LEFT', '#__podcast_assets AS a ON tbl.episode_id = a.episode_id')
                ->order('a.default')
                ->where('tbl.episode_id = '.$pk)
                ->group('tbl.episode_id')
                ->limit(1);
        $db->setQuery($query);
                
        return $db->loadObject();
    }
    
    public function getAssets($pk = null)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('tbl.*')
                ->from('#__podcast_assets AS tbl');
        $db->setQuery($query);
        
        return $db->loadObjectList();
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