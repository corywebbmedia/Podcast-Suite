<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class PodcastModelAssets extends JModelList
{
    protected function getListQuery()
	{
		$db = JFactory::getDBO();
        $query = $db->getQuery(true);

		$query->select('tbl.*, COUNT(m.asset_id) AS episodes')
                ->from('#__podcast_assets AS tbl')
                ->join('LEFT', '#__podcast_assets_map AS m ON tbl.asset_id = m.asset_id')
                ->group('tbl.asset_enclosure_url');

        // Filter by search
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('tbl.asset_enclosure_url LIKE '.$search);
		}

        // Filter by folder
		$folder = $this->getState('filter.folder');
		if (!empty($folder)) {
			$folder = $db->Quote('%'.$db->escape($folder, true).'%');
			$query->where('tbl.asset_enclosure_url LIKE '.$folder);
		}

		return $query;
	}

    public function getFolders()
    {
        $base = JRequest::getVar('filter_folder', false);
        $plugin = $this->getStorage();
        $folders = array_shift($plugin->trigger('onFolderList', $base));
        return $folders;
    }

    protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

        // Load the filter folder
        $folder = $this->getUserStateFromRequest($this->context.'.filter.folder', 'filter_folder');
        $this->setState('filter.folder', $folder);

		// List state information.
		parent::populateState('tbl.asset_enclosure_url', 'asc');
	}

    public function getStorage()
    {
        $options = JComponentHelper::getParams('com_podcast');
        $type = $options->get('storage', 'default');

        JPluginHelper::importPlugin('podcast', $type);
        $dispatcher =& JDispatcher::getInstance();

        return $dispatcher;
    }
}