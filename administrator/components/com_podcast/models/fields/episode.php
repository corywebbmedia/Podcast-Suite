<?php
defined( '_JEXEC' ) or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldEpisode extends JFormFieldList
{
	protected function _getItems()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('episode_id AS `value`, episode_title AS `text`')
			->from('#__podcast_episodes');

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getOptions()
	{
		$feeds = $this->_getItems();

		array_unshift($feeds, JHtml::_('select.option', '', JText::_('COM_PODCAST_SELECT_EPISODE')));

		return $feeds;
	}
}