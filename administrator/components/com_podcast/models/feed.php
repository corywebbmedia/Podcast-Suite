<?php
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
}