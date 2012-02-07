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