<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class PodcastModelFeed extends JModelList
{
	public function getFeed()
	{
		$feed_id = JRequest::getInt('feed_id', 0);

		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->select('*')
			->from('#__podcast_feeds')
			->where("feed_id = '{$feed_id}'");

		$db->setQuery($query);
		$feed = $db->loadObject();

		$this->_seedCategories($feed);

		return $feed;
	}

	protected function getListQuery()
	{
		$query = parent::getListQuery();

		$feed_id = JRequest::getInt('feed_id', 0);

		$query->select('*')
			->from('#__podcast_media')
			->where("feed_id = '{$feed_id}'")
			->where("published = 1");

		return $query;
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