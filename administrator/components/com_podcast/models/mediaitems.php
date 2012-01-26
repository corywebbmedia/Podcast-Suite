<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelMediaitems extends JModelList
{
	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$query->select('pm.*, pf.feed_title')
			->from('#__podcast_media AS pm')
			->join('LEFT', '#__podcast_feeds AS pf USING(feed_id)');

		return $query;
	}

	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as &$item) {
			if ($item->item_pubDate == '0000-00-00') {
				$item->item_pubDate = null;
			}

			if (strpos($item->item_enclosure_url, 'http') !== 0) {
				$item->item_enclosure_url = '../' . $item->item_enclosure_url;
			}
		}

		return $items;
	}
}