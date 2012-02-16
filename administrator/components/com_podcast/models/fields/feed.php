<?php
defined( '_JEXEC' ) or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldFeed extends JFormFieldList
{
	protected function _getFeeds()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('feed_id AS `value`, feed_title AS `text`')
			->from('#__podcast_feeds');

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getOptions()
	{
		$feeds = $this->_getFeeds();

		array_unshift($feeds, JHtml::_('select.option', '', JText::_('COM_PODCAST_SELECT_FEED')));

		return $feeds;
	}
}