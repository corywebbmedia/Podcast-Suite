<?php
/**
 * @author      Joseph LeBlanc - Cory Webb Media
 * @link        www.corywebbmedia.com
 * @copyright   Copyright 2012 Cory Webb Media. All Rights Reserved.
 * @category    cwm_podcast
 * @package
 */
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modeladmin');

class PodcastModelFeed extends JModelAdmin
{
	public function getTable($type = 'Feed', $prefix = 'PodcastTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_podcast.feed', 'feed', array('control' => 'jform', 'load_data' => $loadData));

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_podcast.edit.feed.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	public function setDefault($id)
	{
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		$query->update('#__podcast_feeds')
			->set("feed_default = '1'")
			->set("published = '1'")
			->where("feed_id = '{$id}'");

		$db->setQuery($query);
		$db->query();

		$query = $db->getQuery(true);

		$query->update('#__podcast_feeds')
			->set("feed_default = '0'")
			->where("feed_id != '{$id}'");

		$db->setQuery($query);
		$db->query();
	}
}