<?php
defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modeladmin');

class PodcastModelMediaitem extends JModelAdmin
{
	public function getTable($type = 'Mediaitem', $prefix = 'PodcastTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm('com_podcast.mediaitem', 'mediaitem', array('control' => 'jform', 'load_data' => $loadData));

		return $form;
	}

	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_podcast.edit.mediaitem.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
}