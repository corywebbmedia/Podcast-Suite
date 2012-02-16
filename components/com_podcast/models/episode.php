<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.model');

class PodcastModelEpisode extends JModel
{

    public function getItem()
    {
        $episode_id = JRequest::getInt('episode_id', 0);

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('tbl.*,
            a.asset_enclosure_url AS item_enclosure_url,
            a.asset_enclosure_length AS item_enclosure_length,
            a.asset_duration AS item_duration,
            a.asset_enclosure_type AS item_enclosure_type,
            a.asset_closed_caption AS item_closed_caption')
                ->from('#__podcast_episodes AS tbl')
                ->join('LEFT', '#__podcast_assets_map AS m USING(episode_id)')
				->join('LEFT', '#__podcast_assets AS a USING(asset_id)')
                ->where('m.default = 1')
                ->where('tbl.episode_id = '.$episode_id)
                ->limit(1);
        $db->setQuery($query);

        return $db->loadObject();
    }

    public function getAssets($pk = null)
    {
        $episode_id = JRequest::getInt('episode_id', 0);

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('tbl.*')
                ->from('#__podcast_assets AS tbl')
                ->where('tbl.episode_id = '.$episode_id);
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}