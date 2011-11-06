<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modeladmin');

class PodcastModelItem extends JModelAdmin
{
	public function getTable($type = 'Item', $prefix = 'PodcastTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_podcast.item', 'item', array('control' => 'jform', 'load_data' => $loadData));

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_podcast.edit.item.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
}