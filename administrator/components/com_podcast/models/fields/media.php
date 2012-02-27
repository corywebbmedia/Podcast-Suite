<?php
defined( '_JEXEC' ) or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldMedia extends JFormFieldList
{
	protected $type = 'media';

	public function _getMediaTypes()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query->select('DISTINCT asset_enclosure_type')
			->from('#__podcast_assets')
			->where('asset_enclosure_type IS NOT NULL')
			->where("asset_enclosure_type != ''");

		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getOptions()
	{
		$types = $this->_getMediaTypes();

		$default = new StdClass;
		$default->text = 'Default';
		$default->value = '';

		$options = array();
		$options[] = $default;

		foreach ($types as $type) {
			$object = new StdClass;
			$object->text = $type->asset_enclosure_type;
			$object->value = $type->asset_enclosure_type;
			$options[] = $object;
        }

		return $options;
	}
}