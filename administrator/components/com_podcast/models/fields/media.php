<?php
defined( '_JEXEC' ) or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldMedia extends JFormFieldList
{
	protected function _getItems()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('media_id AS `value`, item_title AS `text`')
			->from('#__podcast_media');

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getOptions()
	{
		$feeds = $this->_getItems();

		array_unshift($feeds, JHtml::_('select.option', '', '- Select Media Item -'));

		return $feeds;
	}
}