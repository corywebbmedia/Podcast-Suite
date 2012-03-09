<?php
defined( '_JEXEC' ) or die;

class plgButtonPodcastepisode extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}
	
	function onDisplay($name, $asset, $author)
	{
		$user = JFactory::getUser();
		if ($user->authorise('core.manage', 'com_podcast'))
		{
			JHtml::_('behavior.modal');
			$button = new JObject;
			$button->set('modal', true);
			$button->set('link', 'index.php?option=com_podcast&amp;view=episodes&amp;tmpl=component&amp;layout=editor&editor='.$name);
			$button->set('text', JText::_('PLG_EDITORS-XTD_PODCASTEPISODE_BUTTON'));
			$button->set('name', 'blank');
			$button->set('options', "{handler: 'iframe', size: {x: 800, y: 500}}");
			return $button;
		}
				else
		{
			return false;
		}
	}
}
