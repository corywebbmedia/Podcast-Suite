<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class PodcastModelAssets extends JModelList
{
    protected function getListQuery()
	{
		$db = JFactory::getDBO();
        $query = $db->getQuery(true);

		$query->select('tbl.*')
			->from('#__podcast_assets AS tbl');
        
        // Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('tbl.asset_enclosure_url LIKE '.$search);
		}

		return $query;
	}
    
    protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'search');
		$this->setState('filter.search', $search);

		// List state information.
		parent::populateState('tbl.asset_enclosure_url', 'asc');
	}
}