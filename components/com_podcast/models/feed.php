<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeed extends JModelList
{
	protected $feed;

	public function getFeed()
	{
		if (!isset($this->feed)) {
			$feed_id = JRequest::getInt('feed_id', 0);

			$db = $this->getDbo();
			$query = $db->getQuery(true);

			$query->select('*')
				->from('#__podcast_feeds');

			if ($feed_id) {
				$query->where("feed_id = '{$feed_id}'");
			} else {
				$query->where("feed_default = '1'");
			}

			$db->setQuery($query);
			$feed = $db->loadObject();

			$this->_seedCategories($feed);

			$this->feed = $feed;
		}

		return $this->feed;
	}

	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$feed_id = $this->getFeed()->feed_id;

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
			->where("tbl.feed_id = '{$feed_id}'")
			->where("tbl.published = 1");

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as &$item) {
			if (strpos($item->item_enclosure_url, 'http') !== 0) {
				$item->item_enclosure_url = JURI::root() . $item->item_enclosure_url;
			}
		}

		return $items;
	}

	protected function _seedCategories(&$feed)
	{
		$categories = array();

		if (strlen($feed->feed_category1)) {
			$categories[] = $this->_getCategoryArray($feed->feed_category1);
		}

		if (strlen($feed->feed_category2)) {
			$categories[] = $this->_getCategoryArray($feed->feed_category2);
		}

		if (strlen($feed->feed_category3)) {
			$categories[] = $this->_getCategoryArray($feed->feed_category3);
		}

		$feed->categories = $categories;
	}

	public function _getCategoryArray($string)
	{
		$pieces = explode(' > ', $string);

		if (count($pieces) > 1) {
			return array($pieces[0] => $pieces[1]);
		}

		return array($pieces[0] => array());
	}
}