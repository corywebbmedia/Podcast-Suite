<?php
defined( '_JEXEC' ) or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldStorage extends JFormFieldList
{
	protected $type = 'storage';

	public function getOptions()
	{
		$engines = JPluginHelper::getPlugin('podcast');
        $options = array();

		foreach ($engines as $engine) {
			$object = new StdClass;
			$object->text = $engine->name;
			$object->value = $engine->name;
			$options[] = $object;
        }

		return $options;
	}
}